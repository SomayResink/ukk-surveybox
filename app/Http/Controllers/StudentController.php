<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Complaint;  // ← Pastikan ini ada!
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function dashboard()
    {
        if (!Auth::user() || Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized access.');
        }

        $userId = Auth::id();

        $statusCounts = Complaint::where('student_id', $userId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $categoryCounts = Complaint::where('student_id', $userId)
            ->select('category_id', DB::raw('count(*) as total'))
            ->with('category')
            ->groupBy('category_id')
            ->get();

        $stats = [
            'total' => Complaint::where('student_id', $userId)->count(),
            'pending' => Complaint::where('student_id', $userId)->where('status', 'pending')->count(),
            'processed' => Complaint::where('student_id', $userId)->where('status', 'processed')->count(),
            'resolved' => Complaint::where('student_id', $userId)->where('status', 'resolved')->count(),
            'rejected' => Complaint::where('student_id', $userId)->where('status', 'rejected')->count(),
        ];

        $recentComplaints = Complaint::with(['category', 'feedback'])
            ->where('student_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $categories = Category::all();

        return view('student.dashboard', compact('stats', 'statusCounts', 'categoryCounts', 'recentComplaints', 'categories'));
    }

    public function history()
    {
        if (!Auth::user() || Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized access.');
        }

        $complaints = Complaint::with(['category', 'feedback'])
            ->where('student_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.history', compact('complaints'));
    }

   public function storeComplaint(Request $request)
{
    try {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'location' => 'nullable|string|max:100',
        ]);

        Complaint::create([
            'student_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'content' => $request->content,
            'location' => $request->location,
            'status' => 'pending',
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Aspirasi berhasil dikirim!');

    } catch (\Exception $e) {
        // Tampilkan error detail
        return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
    }
}
}
