<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Handle tasks routes
Route::resource('/tasks', TaskController::class);
Route::get('/tasks/{task}/done', [TaskController::class, 'done'])->name('tasks.done');
Route::get('/tasks/{task}/pending', [TaskController::class, 'pending'])->name('tasks.pending');

// Handle employees routes
Route::resource('/employees', EmployeeController::class);

// Handle departments routes
Route::resource('/departments', DepartmentController::class);

// Handle roles routes
Route::resource('/roles', RoleController::class);

// Handle presences routes
Route::resource('/presences', PresenceController::class);

// Handle payrolls routes
Route::resource('/payrolls', PayrollController::class);

// Handle leaves requests routes
Route::resource('/leave-requests', LeaveRequestController::class);
Route::get('/leave-requests/{leaveRequest}/confirm', [LeaveRequestController::class, 'confirm'])->name('leave-requests.confirm');
Route::get('/leave-requests/{leaveRequest}/reject', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
