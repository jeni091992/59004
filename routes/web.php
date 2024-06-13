<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('home');

use App\Http\Controllers\AdminAuthController;

// Admin Registration Routes
Route::get('/admin/register', [AdminAuthController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register']);

use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

use App\Http\Controllers\Auth\LogoutController;

// Define custom logout route
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');


// If you have any routes that should be accessible only to authenticated users, you can protect them using middleware. 
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

use App\Http\Controllers\AgentsController;

Route::get('/agents', [AgentsController::class, 'index'])->middleware(['auth'])->name('agents.index');
Route::get('/agents/create', [AgentsController::class, 'create'])->middleware(['auth'])->name('agents.create');
Route::post('/agents', [AgentsController::class, 'store'])->middleware(['auth'])->name('agents.store');
Route::get('/agents/{agent}/edit', [AgentsController::class, 'edit'])->middleware(['auth'])->name('agents.edit');
Route::put('/agents/{agent}', [AgentsController::class, 'update'])->middleware(['auth'])->name('agents.update');
Route::delete('/agents/{agent}', [AgentsController::class, 'destroy'])->middleware(['auth'])->name('agents.destroy');

use App\Http\Controllers\LeadsController;

Route::get('/leads', [LeadsController::class, 'index'])->middleware(['auth'])->name('leads.index');
Route::get('/leads/create', [LeadsController::class, 'create'])->middleware(['auth'])->name('leads.create');
Route::post('/leads', [LeadsController::class, 'store'])->middleware(['auth'])->name('leads.store');
Route::get('/leads/{lead}/edit', [LeadsController::class, 'edit'])->middleware(['auth'])->name('leads.edit');
Route::put('/leads/{lead}', [LeadsController::class, 'update'])->middleware(['auth'])->name('leads.update');
Route::delete('/leads/{lead}', [LeadsController::class, 'destroy'])->middleware(['auth'])->name('leads.destroy');
Route::post('/leads/{lead}/convert', [LeadsController::class, 'convertToDeal'])->name('leads.convert');

use App\Http\Controllers\DealController;

Route::resource('deals', DealController::class);
Route::get('/deals', [DealController::class, 'index'])->name('deals.index');
