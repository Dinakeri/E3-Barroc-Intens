<?php

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

    Route::view('dashboards.finance', 'dashboards.finance')->name('dashboards.finance');
    Route::view('dashboards.contracts', 'finance.contracts')->name('dashboards.contracts');
    Route::view('dashboards.invoices', 'finance.invoices')->name('dashboards.invoices');
    Route::view('dashboards.maintenance', 'dashboards.maintenance')->name('dashboards.maintenance');
    Route::view('dashboards.sales', 'dashboards.sales')->name('dashboards.sales');
    Route::view('sales.newCustomer', 'sales.newCustomer')->name('sales.newCustomer');

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
