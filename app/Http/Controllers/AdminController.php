<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Admin Analytics Dashboard
     */
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalVolumes = Resource::sum('total_copies');
        $activeLoans = Borrowing::whereNull('returned_at')->count();
        $overdueLoans = Borrowing::whereNull('returned_at')->where('due_at', '<', now())->count();

        // Top borrowed resources
        $topResources = Resource::with('category')
            ->select('resources.*')
            ->join('borrowings', 'resources.id', '=', 'borrowings.resource_id')
            ->selectRaw('count(borrowings.id) as borrow_count')
            ->groupBy('resources.id')
            ->orderByDesc('borrow_count')
            ->take(5)
            ->get();

        // All categories for the book creation dropdown
        $categories = Category::all();

        // Recent borrowing transactions
        $recentTransactions = Borrowing::with(['user', 'resource'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalVolumes',
            'activeLoans',
            'overdueLoans',
            'topResources',
            'categories',
            'recentTransactions'
        ));
    }

    /**
     * Store a new cataloged resource
     */
    public function storeResource(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|string|in:book,journal,ebook,research_paper',
            'total_copies' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'isbn' => 'nullable|string|max:50',
            'publisher' => 'nullable|string|max:255',
            'published_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 5),
            'pages' => 'nullable|integer|min:1',
        ]);

        // Auto-assign available_copies same as total_copies on creation
        $validated['available_copies'] = $validated['total_copies'];
        $validated['rating'] = 5.0; // Default rating
        $validated['views'] = 0;
        $validated['type'] = strtolower($validated['type']);

        Resource::create($validated);

        return redirect()->route('admin.dashboard')->with('success', sprintf('"%s" has been successfully cataloged into the library archives.', $validated['title']));
    }
}
