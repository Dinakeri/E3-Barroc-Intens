<?php

use App\Http\Controllers\CustomerController;
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
    Route::get('dashboards/contracts', function () {
        $contracts = \App\Models\Contract::orderBy('created_at', 'desc')->get();

        // Preload any customers that match contract.customer by name and their quote
        $names = $contracts->pluck('customer')->filter()->unique()->values();
        $customers = \App\Models\Customer::whereIn('name', $names)->with('quote')->get()->keyBy('name');

        return view('finance.contracts', compact('contracts', 'customers'));
    })->name('dashboards.contracts');
    Route::get('invoices/create', [\App\Http\Controllers\InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('invoices', [\App\Http\Controllers\InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('invoices', [\App\Http\Controllers\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/{invoice}/pdf', [\App\Http\Controllers\InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
    Route::get('test-invoice', [\App\Http\Controllers\InvoiceController::class, 'testPdf'])->name('invoices.test');
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
    // end finance

<<<<<<< Updated upstream
    // start maintenance
    Route::get('dashboards/maintenance', [App\Http\Controllers\maintenanceController::class, 'index'])->name('dashboards.maintenance');
    Route::get('maintenance/repairs', [App\Http\Controllers\maintenanceController::class, 'repairs'])->name('maintenance.repairs');
    // end maintenance
    Route::view('dashboards/sales', 'dashboards.sales')->name('dashboards.sales');
=======
// start maintenance
    Route::get('dashboards/maintenance', [App\Http\Controllers\maintenanceController::class, 'index'])->name('dashboards.maintenance');
    Route::get('maintenance/repairs', [App\Http\Controllers\maintenanceController::class, 'repairs'])->name('maintenance.repairs');
    Route::post('maintenance/repairs/schedule', [App\Http\Controllers\maintenanceController::class, 'scheduleRepair'])->name('maintenance.repairs.schedule');
    Route::get('maintenance/calendar', [App\Http\Controllers\maintenanceController::class, 'calendar'])->name('maintenance.calendar');
    Route::get('dashboards/calendar', [App\Http\Controllers\maintenanceController::class, 'calendar'])->name('dashboards.calendar');
// end maintenance
    Route::view('dashboards.sales', 'dashboards.sales')->name('dashboards.sales');
>>>>>>> Stashed changes
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::view('customers/create', 'customers.create')->name('customers.create');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');

    Route::get('/quotes/pdf/{customer_id}', [QuoteController::class, 'generatePdf'])->name('quotes.generate');

    // start sales
    Route::view('sales/products', 'sales/products');
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
