<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredResources = Resource::with('category')
            ->orderByDesc('rating')
            ->take(8)
            ->get();

        $categories = Category::withCount('resources')->get();

        $stats = [
            'total_books' => Resource::where('type', 'book')->count(),
            'total_journals' => Resource::where('type', 'journal')->count(),
            'total_ebooks' => Resource::where('type', 'ebook')->count(),
            'total_papers' => Resource::where('type', 'research_paper')->count(),
            'total_resources' => Resource::count(),
        ];

        return view('home', compact('featuredResources', 'categories', 'stats'));
    }
}
