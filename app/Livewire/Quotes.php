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

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
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
            $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
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
