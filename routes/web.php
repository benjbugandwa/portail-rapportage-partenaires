<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

use App\Livewire\Admin\Users\UserList;
use App\Livewire\Admin\Secteurs\SecteurList;
use App\Livewire\Reporting\Activites\ActiviteList;
use App\Livewire\Dashboard\DashboardStats;
use App\Livewire\Documents\DocumentList;

Route::get('/', function () {
    return view('welcome'); // Login view normally
})->name('login');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    Route::get('/complete-profile', \App\Livewire\Auth\CompleteProfile::class)->name('complete-profile');

    Route::middleware(['profile.complete'])->group(function () {
        Route::get('/dashboard', DashboardStats::class)->name('dashboard');
        Route::get('/activites', ActiviteList::class)->name('activites');
        Route::get('/documents', DocumentList::class)->name('documents');

        Route::middleware(['role:Admin'])->group(function () {
            Route::get('/utilisateurs', UserList::class)->name('utilisateurs');
            Route::get('/secteurs', SecteurList::class)->name('secteurs');
        });
    });
});
