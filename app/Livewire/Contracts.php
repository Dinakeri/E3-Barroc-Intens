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
    public ?Contract $selectedContract = null;
    public bool $showDeleteModal = false;
    public bool $showEditModal = false;


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

    public function openEditModal(Contract $contract)
    {
        $this->selectedContract = $contract;
        $this->showEditModal = true;
    }

    public function openDeleteModal(Contract $contract)
    {
        $this->selectedContract = $contract;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->selectedContract = null;
        $this->showDeleteModal = false;
    }

    public function closeEditModal()
    {
        $this->selectedContract = null;
        $this->showEditModal = false;
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
