<?php

namespace App\Http\Controllers;

use App\Models\Resource;

class ResourceController extends Controller
{
    public function show(Resource $resource)
    {
        $resource->increment('views');
        $resource->load(['category', 'reviews.user']);

        $related = Resource::where('category_id', $resource->category_id)
            ->where('id', '!=', $resource->id)
            ->take(4)
            ->get();

        return view('resources.show', compact('resource', 'related'));
    }
}
