<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        if (!Auth::user() || Auth::user()->role !== 'super_admin') {
            abort(403, 'Unauthorized access.');
        }

        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_categories' => Category::count(),
            'total_complaints' => Complaint::count(),
            'pending_complaints' => Complaint::where('status', 'pending')->count(),
        ];

        $recentComplaints = Complaint::with(['student', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $categories = Category::withCount('complaints')->get();
        $admins = User::with('category')->where('role', 'admin')->get();

        return view('superadmin.dashboard', compact('stats', 'recentComplaints', 'categories', 'admins'));
    }

      public function createAdmin(Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'super_admin') {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'category_id' => 'required|exists:categories,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', 'Admin berhasil dibuat!');
    }

    public function createCategory(Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'super_admin') {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function allComplaints()
    {
        if (!Auth::user() || Auth::user()->role !== 'super_admin') {
            abort(403, 'Unauthorized access.');
        }

        $complaints = Complaint::with(['student', 'category', 'feedback.admin'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('superadmin.complaints', compact('complaints'));
    }

    public function deleteAdmin(User $admin)
    {
        if (!Auth::user() || Auth::user()->role !== 'super_admin') {
            abort(403, 'Unauthorized access.');
        }

        if ($admin->role !== 'admin') {
            abort(404);
        }

        $admin->delete();
        return redirect()->route('superadmin.dashboard')->with('success', 'Admin berhasil dihapus!');
    }
}
