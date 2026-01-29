<?php

namespace App\Livewire;

use App\Models\Contract;
use Livewire\Component;
use Livewire\WithPagination;

class Contracts extends Component
{
    use WithPagination;

    public string $search = "";
    public string $status = "";
    public string $sortDirection = "asc";
    public string $sortField = "created_at";


    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->status = '';
        $this->resetPage();
    }

    public function render()
    {
        $contracts = Contract::with(['customer'])
            ->when($this->search, function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        return view('livewire.contracts', compact('contracts'));
    }
}
