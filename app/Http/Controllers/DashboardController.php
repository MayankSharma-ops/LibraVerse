<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Borrowing;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $currentBorrowings = Borrowing::with('resource.category')
            ->where('user_id', $user->id)
            ->whereNull('returned_at')
            ->get();

        $history = Borrowing::with('resource.category')
            ->where('user_id', $user->id)
            ->whereNotNull('returned_at')
            ->latest('returned_at')
            ->take(10)
            ->get();

        $stats = [
            'total_borrowed' => Borrowing::where('user_id', $user->id)->count(),
            'currently_reading' => $currentBorrowings->count(),
            'books_returned' => Borrowing::where('user_id', $user->id)->whereNotNull('returned_at')->count(),
            'overdue' => $currentBorrowings->where('due_at', '<', now())->count(),
        ];

        // Fetch user's category distribution for the pie chart
        $categoryStats = Borrowing::where('user_id', $user->id)
            ->join('resources', 'borrowings.resource_id', '=', 'resources.id')
            ->join('categories', 'resources.category_id', '=', 'categories.id')
            ->select('categories.name', 'categories.color', \DB::raw('count(*) as count'))
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->get();

        // Fetch user's weekly reading activity
        $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $readingActivity = array_fill_keys($daysOfWeek, 0);
        $rawActivity = Borrowing::where('user_id', $user->id)
            ->select(\DB::raw("strftime('%w', borrowed_at) as day"), \DB::raw('count(*) as count'))
            ->groupBy('day')
            ->get();

        foreach ($rawActivity as $activity) {
            $dayIndex = (int)$activity->day;
            if (isset($daysOfWeek[$dayIndex])) {
                $readingActivity[$daysOfWeek[$dayIndex]] = $activity->count;
            }
        }

        $recommended = Resource::with('category')
            ->orderByDesc('rating')
            ->take(6)
            ->get();

        return view('dashboard', compact('currentBorrowings', 'history', 'stats', 'recommended', 'categoryStats', 'readingActivity'));
    }
}
