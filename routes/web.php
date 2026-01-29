<?php

use App\Http\Controllers\BkrController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\maintenanceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuoteController;
use App\Mail\QuoteSentMail;
use App\Models\Quote;
use Illuminate\Support\Facades\Mail;
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

    // Finance routes - only finance and admin roles
    Route::middleware('role:finance,admin')->group(function () {
        Route::view('dashboards/finance', 'dashboards.finance')->name('dashboards.finance');
        Route::get('dashboards/contracts', function () {
            $contracts = \App\Models\Contract::orderBy('created_at', 'desc')->get();

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
    Route::get('/bkr/customers', [BkrController::class, 'index'])->name('bkr.customers');
    Route::post('bkr/check', [BkrController::class, 'performBkrCheck'])->name('bkr.check');

    Route::get('contracts', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
    Route::get('/contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');
    // end finance

    // start maintenance
    Route::get('dashboards/maintenance', [MaintenanceController::class, 'index'])->name('dashboards.maintenance');
    Route::get('maintenance/repairs', [MaintenanceController::class, 'repairs'])->name('maintenance.repairs');
    Route::post('maintenance/repairs/schedule', [MaintenanceController::class, 'scheduleRepair'])->name('maintenance.repairs.schedule');
    Route::get('maintenance/calendar', [MaintenanceController::class, 'calendar'])->name('maintenance.calendar');
    Route::get('dashboards/calendar', [MaintenanceController::class, 'calendar'])->name('dashboards.calendar');
    // end maintenance

    Route::view('dashboards/sales', 'dashboards.sales')->name('dashboards.sales');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::view('customers/create', 'customers.create')->name('customers.create');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes.index');
    Route::patch('/quotes/{quote}/status', [QuoteController::class, 'updateStatus'])->name('quotes.update-status');
    Route::post('/quotes/{quote}/send', [QuoteController::class, 'send'])->name('quotes.send');
    Route::get('/quotes/pdf/{customer_id}', [QuoteController::class, 'generatePdf'])->name('quotes.generate');
    Route::get('/quotes/{quote}/preview', [QuoteController::class, 'preview'])->name('quotes.preview');
    Route::get('/quotes/{quote}/approve', [QuoteController::class, 'approve'])->name('quotes.approve')->middleware('signed');
    Route::get('/quotes/{quote}/reject', [QuoteController::class, 'reject'])->name('quotes.reject')->middleware('signed');
    Route::get('/preview/quote-mail', function () {
        $quote = Quote::with('customer')->orderByDesc('id')->firstOrFail();

        return new QuoteSentMail($quote)->render();
    });
    Route::get('/test-mail', function () {
        $quote = Quote::first();

        Mail::to('kwadjoeric0201@gmail.com')
            ->send(new QuoteSentMail($quote));

        return 'Mail sent';
    });


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


