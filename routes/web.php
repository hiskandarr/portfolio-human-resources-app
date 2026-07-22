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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['role:HR,Developer,Sales']);
    Route::get('/dashboard/chart-presence', [DashboardController::class, 'chartPresence']);

    // Handle tasks routes
    Route::resource('/tasks', TaskController::class)->middleware(['role:HR,Developer,Sales']);
    Route::get('/tasks/{task}/done', [TaskController::class, 'done'])->name('tasks.done')->middleware(['role:HR,Developer,Sales']);
    Route::get('/tasks/{task}/pending', [TaskController::class, 'pending'])->name('tasks.pending')->middleware(['role:HR,Developer,Sales']);

    // Handle employees routes
    Route::resource('/employees', EmployeeController::class)->middleware(['role:HR']);

    // Handle departments routes
    Route::resource('/departments', DepartmentController::class)->middleware(['role:HR']);

    // Handle roles routes
    Route::resource('/roles', RoleController::class)->middleware(['role:HR']);

    // Handle presences routes
    Route::resource('/presences', PresenceController::class)->middleware(['role:HR,Developer,Sales']);

    // Handle payrolls routes
    Route::resource('/payrolls', PayrollController::class)->middleware(['role:HR,Developer,Sales']);

    // Handle leaves requests routes
    Route::resource('/leave-requests', LeaveRequestController::class)->middleware(['role:HR,Developer,Sales']);
    Route::get('/leave-requests/{leaveRequest}/confirm', [LeaveRequestController::class, 'confirm'])->name('leave-requests.confirm')->middleware(['role:HR']);
    Route::get('/leave-requests/{leaveRequest}/reject', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject')->middleware(['role:HR']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
