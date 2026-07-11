<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SpvController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role->name;
        
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect('/' . $role . '/dashboard');
    }
    return redirect('/login');
});

// MODIFIKASI: Rute Dashboard Utama Dialihkan Otomatis Sesuai Role
Route::get('/dashboard', function () {
    if (Auth::check()) {
        $role = Auth::user()->role->name;
        
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect('/' . $role . '/dashboard');
    }
    return redirect('/login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 1. KELOMPOK ROUTE STAFF
Route::middleware(['auth', 'role:staff'])->name('staff.')->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'index'])->name('dashboard');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('create');
    Route::post('/staff/store', [StaffController::class, 'store'])->name('store');
});

// 2. KELOMPOK ROUTE SUPERVISOR (SPV)
Route::middleware(['auth', 'role:spv'])->name('spv.')->group(function () {
    Route::get('/spv/dashboard', [SpvController::class, 'index'])->name('dashboard');
    Route::post('/spv/submission/{id}/process', [SpvController::class, 'process'])->name('process');
    Route::get('/spv/history', [SpvController::class, 'history'])->name('history');
});

// 3. KELOMPOK ROUTE MANAGER
Route::middleware(['auth', 'role:manager'])->name('manager.')->group(function () {
    Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('dashboard');
    Route::post('/manager/submission/{id}/process', [ManagerController::class, 'process'])->name('process');
    Route::get('/manager/history', [ManagerController::class, 'history'])->name('history');
});

// 4. KELOMPOK ROUTE DIREKTUR
Route::middleware(['auth', 'role:direktur'])->name('direktur.')->group(function () {
    Route::get('/direktur/dashboard', [DirectorController::class, 'index'])->name('dashboard');
    Route::post('/direktur/submission/{id}/process', [DirectorController::class, 'process'])->name('process');
    Route::get('/direktur/history', [DirectorController::class, 'history'])->name('history');
});

// 5. KELOMPOK ROUTE FINANCE
Route::middleware(['auth', 'role:finance'])->name('finance.')->group(function () {
    Route::get('/finance/dashboard', [FinanceController::class, 'index'])->name('dashboard');
    Route::post('/finance/submission/{id}/pay', [FinanceController::class, 'pay'])->name('pay');
    Route::get('/finance/history', [FinanceController::class, 'history'])->name('history');
    Route::get('/finance/export-transaksi', [FinanceController::class, 'export'])->name('export');
});

// 6. KELOMPOK ROUTE ADMIN (Hanya bisa dibuka jika login dengan role:admin)
Route::middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // Dashboard Utama Admin
    Route::get('/admin/dashboard', [AdminUserController::class, 'dashboard'])->name('dashboard');

    // 1. CRUD Users
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/admin/users/store', [AdminUserController::class, 'store'])->name('users.store');
    Route::delete('/admin/users/{id}/delete', [AdminUserController::class, 'destroy'])->name('users.delete');

    // 2. CRUD Kategori
    Route::post('/admin/categories/store', [AdminUserController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/admin/categories/{id}/delete', [AdminUserController::class, 'destroyCategory'])->name('categories.delete');

    // 3. CRUD Plafon Budget
    Route::post('/admin/budgets/store', [AdminUserController::class, 'storeBudget'])->name('budgets.store');
    Route::delete('/admin/budgets/{id}/delete', [AdminUserController::class, 'destroyBudget'])->name('budgets.delete');
});

require __DIR__.'/auth.php';