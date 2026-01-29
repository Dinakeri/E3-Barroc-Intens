<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public ?array $selectedProduct = null;
    public ?Product $productToDelete = null;
    public bool $showDeleteModal = false;
    public bool $showDetailsModal = false;
    public string $search = "";
    public string $status = "";
    public string $sortField = "name";
    public string $sortDirection = "asc";

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->status = '';
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete(int $productId): void
    {
        $this->productToDelete = Product::findOrFail($productId);
        $this->showDeleteModal = true;
    }

    public function showProductDetails(int $productId): void
    {
        $this->selectedProduct = Product::findOrFail($productId)->toArray();
        $this->showDetailsModal = true;
    }

    public function closeDetails(): void
    {
        $this->showDetailsModal = false;
        $this->selectedProduct = null;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->productToDelete = null;
    }

    public function deleteProduct(): void
    {
        if (!$this->productToDelete) {
            return;
        }

        if ($this->selectedProduct && ($this->selectedProduct['id'] ?? null) === $this->productToDelete->id) {
            $this->closeDetails();
        }

        $this->productToDelete->delete();
        $this->showDeleteModal = false;
        $this->productToDelete = null;

        $this->resetPage();
        session()->flash('success', 'Product succesvol verwijderd');
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('type', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(20);

        return view('livewire.products', [
            'products' => $products,
        ]);
    }
}
