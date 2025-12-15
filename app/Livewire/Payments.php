<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

use function Laravel\Prompts\search;

class Payments extends Component
{
    use WithPagination;
    protected $listeners = ['showCustomerDetails'];

    public ?Customer $selectedcustomer = null;
    public string $search = "";
    public string $status = "";
    public bool $showModal = false;
    public string $sortDirection = "asc";
    public string $sortField = "created_at";


    public function showCustomerDetails(Customer $customer)
    {
        $this->selectedcustomer = $customer;
        $this->showModal = true;
    }

    // Reset Livewire paginator when the search term is updated
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->status = '';
        $this->resetPage();
    }

    public function render()
    {
        $payments = Payment::with(['invoice.customer'])
            ->when($this->search, function ($query) {
                $query->where('invoice_id', 'like', '%' . $this->search . '%')
                ->orWhereHas('invoice.customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        return view('livewire.payments', compact('payments'));
    }
}
