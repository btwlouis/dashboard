<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\LogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class, 'show']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'create']);
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::group(['middleware' => ['auth', 'is.admin']], function () {
    
    // use controller
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');  
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // user routes
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    
    Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/tickets', [TicketController::class, 'index'])->name('ticket.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('ticket.show');

    // edit ticket
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('ticket.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('ticket.update');

    Route::post('/tickets/{ticket}', [TicketController::class, 'sendDiscordMessage'])->name('ticket.send');

    // delete ticket
    Route::post('/tickets/{ticket}/close', [TicketController::class, 'destroy'])->name('ticket.destroy');

    // template routes

    Route::resource('templates', TemplateController::class);

    // logs 
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');


});