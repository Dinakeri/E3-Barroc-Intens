<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceCustomers extends Component
{
    use WithPagination;

    public ?Customer $selectedCustomer = null;
    public bool $showModal = false;
    public string $search = "";
    public string $status = "";
    public bool $onlyWithPdf = false;
    public string $sortField = "created_at";
    public string $sortDirection = "asc";

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'onlyWithPdf' => ['except' => false],
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
        $customers = Customer::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
                    ->orWhere('plaats', 'like', '%' . $this->search . '%');
            })
            ->when($this->onlyWithPdf, function ($query) {
                $query->whereHas('quote', function ($q) {
                    $q->whereNotNull('url');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.invoice-customers', [
            'customers' => $customers,
        ]);
    }

    public function showCustomerDetails(Customer $customer)
    {
        $this->selectedCustomer = $customer;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedCustomer = null;
    }

    public function generateQuote($customer_id)
    {
        return redirect()->route('quotes.generate', $customer_id);
    }
}
