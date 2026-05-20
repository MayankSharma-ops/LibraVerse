<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    /**
     * Borrow a resource
     */
    public function borrow(Request $request, Resource $resource)
    {
        $user = Auth::user();

        // 1. Check if already borrowed
        $alreadyBorrowed = Borrowing::where('user_id', $user->id)
            ->where('resource_id', $resource->id)
            ->whereNull('returned_at')
            ->exists();

        if ($alreadyBorrowed) {
            return redirect()->back()->with('error', 'You are already borrowing this volume.');
        }

        // 2. Check availability
        if ($resource->available_copies <= 0) {
            return redirect()->back()->with('error', 'No physical copies of this volume are currently available in the archives.');
        }

        // 3. Perform borrowing inside database transaction
        DB::transaction(function () use ($user, $resource) {
            // Create Borrowing record
            Borrowing::create([
                'user_id' => $user->id,
                'resource_id' => $resource->id,
                'borrowed_at' => now(),
                'due_at' => now()->addDays(14),
            ]);

            // Decrement available copies
            $resource->decrement('available_copies');
        });

        return redirect()->route('dashboard')->with('success', sprintf('"%s" has been successfully checked out from the archives.', $resource->title));
    }

    /**
     * Return a borrowed resource
     */
    public function returnResource(Request $request, Borrowing $borrowing)
    {
        $user = Auth::user();

        // Ensure ownership
        if ($borrowing->user_id !== $user->id) {
            abort(403, 'Unauthorized returning action.');
        }

        // Ensure it is not already returned
        if ($borrowing->returned_at !== null) {
            return redirect()->back()->with('error', 'This volume has already been returned.');
        }

        // Perform return inside transaction
        DB::transaction(function () use ($borrowing) {
            $borrowing->update([
                'returned_at' => now()
            ]);

            $borrowing->resource->increment('available_copies');
        });

        return redirect()->route('dashboard')->with('success', sprintf('"%s" has been safely returned to the archives.', $borrowing->resource->title));
    }
}
