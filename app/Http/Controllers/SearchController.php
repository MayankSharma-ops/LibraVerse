<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $recentResources = Resource::with('category')->latest()->take(12)->get();
        return view('search', compact('categories', 'recentResources'));
    }

    public function search(Request $request)
    {
        $query = Resource::with('category');

        if ($request->filled('q')) {
            $query->search($request->q);
        }

        if ($request->filled('type')) {
            $query->ofType($request->type);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('year_from')) {
            $query->where('published_year', '>=', $request->year_from);
        }

        if ($request->filled('year_to')) {
            $query->where('published_year', '<=', $request->year_to);
        }

        if ($request->filled('availability') && $request->availability === 'available') {
            $query->available();
        }

        $sort = $request->get('sort', 'relevance');
        match ($sort) {
            'title' => $query->orderBy('title'),
            'year' => $query->orderByDesc('published_year'),
            'rating' => $query->orderByDesc('rating'),
            default => $query->orderByDesc('views'),
        };

        $resources = $query->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.search-results', compact('resources'))->render(),
                'total' => $resources->total(),
                'hasMore' => $resources->hasMorePages(),
            ]);
        }

        $categories = Category::all();
        return view('search', compact('resources', 'categories'));
    }
}
