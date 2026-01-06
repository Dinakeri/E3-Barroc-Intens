<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public string $search = "";
    public string $status = "";
    public string $sortField = 'created_at';
    public string $sortDirection = "asc";

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = "";
        $this->status = "";
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $orders = Order::with(['orderItems.product', 'customer'])->whereHas('orderItems')
            ->when($this->search, function ($query) {
                $query->whereHas('orderItems.product', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('customer', function ($q2) {
                    $q2->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        return view('livewire.orders', compact('orders'));
    }
}
