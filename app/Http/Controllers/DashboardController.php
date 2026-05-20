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
        if (!Auth::check()) {
            $user = User::first() ?? User::create([
                'name' => 'Library Admin',
                'email' => 'admin@library.com',
                'password' => bcrypt('password'),
            ]);
            Auth::login($user);
        } else {
            $user = Auth::user();
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

        $recommended = Resource::with('category')
            ->orderByDesc('rating')
            ->take(6)
            ->get();

        return view('dashboard', compact('currentBorrowings', 'history', 'stats', 'recommended'));
    }
}
