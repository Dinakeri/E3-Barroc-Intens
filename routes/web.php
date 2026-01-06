<?php

use App\Http\Controllers\BkrController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    // start finance

    Route::view('dashboards/finance', 'dashboards.finance')->name('dashboards.finance');
    Route::get('invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
    Route::get('test-invoice', [InvoiceController::class, 'testPdf'])->name('invoices.test');
    Route::get('dashboards/invoices', function () {
        $customers = \App\Models\Customer::orderBy('name')->get();
        return view('finance.invoices', compact('customers'));
    })->name('dashboards.invoices');
    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
    // Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
    Route::get('/bkr/customers',[BkrController::class, 'index'])->name('bkr.customers');
    Route::post('bkr/check', [BkrController::class, 'performBkrCheck'])->name('bkr.check');

    Route::get('contracts', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
    // end finance

    // start maintenance
    Route::get('dashboards/maintenance', [App\Http\Controllers\maintenanceController::class, 'index'])->name('dashboards.maintenance');
    Route::get('maintenance/repairs', [App\Http\Controllers\maintenanceController::class, 'repairs'])->name('maintenance.repairs');
    Route::post('maintenance/repairs/schedule', [App\Http\Controllers\maintenanceController::class, 'scheduleRepair'])->name('maintenance.repairs.schedule');
    Route::get('maintenance/calendar', [App\Http\Controllers\maintenanceController::class, 'calendar'])->name('maintenance.calendar');
    Route::get('dashboards/calendar', [App\Http\Controllers\maintenanceController::class, 'calendar'])->name('dashboards.calendar');
    // end maintenance

    Route::view('dashboards/sales', 'dashboards.sales')->name('dashboards.sales');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::view('customers/create', 'customers.create')->name('customers.create');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::get('/quotes/pdf/{customer_id}', [QuoteController::class, 'generatePdf'])->name('quotes.generate');
    Route::get('/offertes/{offerte}/accept', [QuoteController::class, 'accept'])->name('offertes.accept');
    Route::get('/offertes/{offerte}/reject', [QuoteController::class, 'reject'])->name('offertes.reject');

    // start sales
    Route::view('sales/products', 'sales/products')->name('products');
    Route::get('/sales/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/sales/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/sales/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::post('/sales/orders/create',  [OrderController::class, 'store'])->name('orders.store');
    Route::get('/sales/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/sales/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/sales/orders/{order}', [OrderController::class, 'delete'])->name('orders.delete');
    // end sales

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
