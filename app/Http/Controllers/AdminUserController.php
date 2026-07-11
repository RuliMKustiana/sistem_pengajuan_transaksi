<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Halaman Dashboard Beranda Admin
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalCategories = Category::count();
        $totalBudgetAllocated = Budget::where('fiscal_year', now()->format('Y'))->sum('amount');

        return view('admin.dashboard', compact('totalUsers', 'totalCategories', 'totalBudgetAllocated'));
    }

    // ==========================================
    // 1. LOGIKA MANAGEMENT USER
    // ==========================================
    public function index()
    {
        $users = User::with('role')->get();
        $roles = Role::all();
        $categories = Category::all();

        // Ambil budget anggaran beserta nama kategorinya
        $budgets = Budget::with('category')->where('fiscal_year', now()->format('Y'))->get();

        return view('admin.index', compact('users', 'roles', 'categories', 'budgets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id'  => 'required|exists:roles,id',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->id === \Illuminate\Support\Facades\Auth::id()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }

    // ==========================================
    // 2. LOGIKA MANAGEMENT KATEGORI
    // ==========================================
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }

    // ==========================================
    // 3. LOGIKA MANAGEMENT PLAFON BUDGET
    // ==========================================
    public function storeBudget(Request $request)
    {
        // 1. Validasi input dari form Admin
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount'      => 'required|numeric|min:0',
        ]);

        $fiscalYear = date('Y'); // Mengambil tahun aktif saat ini (2026)

        // 2. Cek apakah kategori tersebut sudah punya budget di tahun ini
        $budget = Budget::where('category_id', $request->category_id)
            ->where('fiscal_year', $fiscalYear)
            ->first();

        if ($budget) {
            // Jika sudah ada, update nilainya
            $budget->amount = $request->amount;
            $budget->balance = $request->amount; 
            $budget->save();
        } else {
            // Jika belum ada, buat data alokasi baru
            Budget::create([
                'category_id' => $request->category_id,
                'amount'      => $request->amount,
                'balance'     => $request->amount, 
                'fiscal_year' => $fiscalYear,
            ]);
        }

        return redirect()->back()->with('success', 'Plafon Anggaran berhasil dialokasikan!');
    }

    public function destroyBudget($id)
    {
        $budget = Budget::findOrFail($id);
        $budget->delete();
        return redirect()->back()->with('success', 'Alokasi anggaran berhasil dihapus!');
    }
}
