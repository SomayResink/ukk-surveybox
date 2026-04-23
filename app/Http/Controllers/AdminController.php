<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        $categoryId = Auth::user()->category_id;

        // Query dengan filter
        $query = Complaint::with(['student', 'feedback'])
            ->where('category_id', $categoryId);

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('student', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('nis', 'like', "%{$search}%");
                  });
            });
        }

        $complaints = $query->orderBy('created_at', 'desc')->paginate(10);

        // Stats
        $stats = [
            'total' => Complaint::where('category_id', $categoryId)->count(),
            'pending' => Complaint::where('category_id', $categoryId)->where('status', 'pending')->count(),
            'processed' => Complaint::where('category_id', $categoryId)->where('status', 'processed')->count(),
            'resolved' => Complaint::where('category_id', $categoryId)->where('status', 'resolved')->count(),
            'rejected' => Complaint::where('category_id', $categoryId)->where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard', compact('complaints', 'stats'));
    }

    public function history(Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        $categoryId = Auth::user()->category_id;

        // Query feedback yang sudah diberikan
        $query = Feedback::with(['complaint.student', 'complaint.category'])
            ->where('admin_id', Auth::id())
            ->whereHas('complaint', function($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->whereHas('complaint', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('complaint', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('student', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('nis', 'like', "%{$search}%");
                  });
            });
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->paginate(15);

        // Stats untuk history
        $stats = [
            'total' => Feedback::where('admin_id', Auth::id())->count(),
            'this_week' => Feedback::where('admin_id', Auth::id())
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'this_month' => Feedback::where('admin_id', Auth::id())
                ->whereMonth('created_at', now()->month)
                ->count(),
        ];

        return view('admin.history', compact('feedbacks', 'stats'));
    }

    public function showComplaint(Complaint $complaint)
    {
        // Check access
        if ($complaint->category_id !== Auth::user()->category_id) {
            abort(403);
        }

        $complaint->load(['student', 'feedback']);

        return response()->json([
            'success' => true,
            'data' => $complaint
        ]);
    }

    public function sendFeedback(Request $request, Complaint $complaint)
    {
        if ($complaint->category_id !== Auth::user()->category_id) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string',
            'status' => 'required|in:pending,processed,resolved,rejected',
        ]);

        DB::transaction(function () use ($request, $complaint) {
            $complaint->update(['status' => $request->status]);

            Feedback::updateOrCreate(
                ['complaint_id' => $complaint->id],
                [
                    'admin_id' => Auth::id(),
                    'message' => $request->message,
                ]
            );
        });

        return redirect()->route('admin.dashboard')->with('success', 'Feedback berhasil dikirim!');
    }
}
