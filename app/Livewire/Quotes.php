<?php

namespace App\Livewire;

use App\Models\Quote;
use Livewire\Component;
use Livewire\WithPagination;

class Quotes extends Component
{
    use WithPagination;

    public string $search = "";
    public string $status = "";
    public string $sortField = "created_at";
    public string $sortDirection = "asc";
    public ?Quote $selectedQuote = null;
    public bool $showDeleteModal = false;
    public bool $showEditModal = false;


    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public array $statuses = [];

    public function mount()
    {
        foreach (Quote::pluck('status', 'id') as $id => $status) {
            $this->statuses[$id] = $status;
        }
    }

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

    public function updateStatus($quoteId)
    {
        Quote::findOrFail($quoteId)->update([
            'status' => $this->statuses[$quoteId],
        ]);
    }

    public function statusColor($status)
    {
        return match ($status) {
            'draft' => 'zinc',
            'sent' => 'blue',
            'approved' => 'green',
            'rejected' => 'red',
            default => 'zinc',
        };
    }

    public function openDeleteModal($quoteId)
    {
        $this->selectedQuote = Quote::findOrFail($quoteId);
        $this->showDeleteModal = true;
    }

    public function openEditModal($quoteId)
    {
        $this->selectedQuote = Quote::findOrFail($quoteId);
        $this->showEditModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->selectedQuote = null;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->selectedQuote = null;
    }



    public function render()
    {
        $quotes = Quote::query()
            ->when($this->search, function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })

            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $statuses = Quote::select('status')->distinct()->pluck('status');
        return view('livewire.quotes', [
            'quotes' => $quotes,
            'statuses' => $statuses,
        ]);
    }
}



