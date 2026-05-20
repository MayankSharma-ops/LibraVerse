@extends('layouts.app')

@section('title', 'Dashboard — LibraVerse Archives')

@section('content')
<section class="dashboard-section" style="padding-top: 140px; min-height: 100vh; position: relative; z-index: 10;">
    <div class="container">
        <!-- Dashboard Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 50px;">
            <div>
                <h1 style="font-family: var(--font-serif); font-size: 44px; color: var(--accent-gold); margin-bottom: 5px;">Cognitive Lab</h1>
                <p style="color: var(--text-secondary);">Manage checkouts, view statistics, and review research progress</p>
            </div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="font-size: 14px; color: var(--text-secondary);">Session: Active</span>
                <div style="width: 10px; height: 10px; border-radius: 50%; background: var(--accent-emerald); box-shadow: 0 0 10px var(--accent-emerald);"></div>
            </div>
        </div>

        <!-- Numeric Counters Grid -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; margin-bottom: 50px;">
            <div class="glass-panel stat-widget-card" style="padding: 30px; border-radius: 12px; position: relative; overflow: hidden; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Total Borrowed</span>
                <span class="stat-counter" data-target="{{ $stats['total_borrowed'] }}" style="font-size: 40px; font-weight: 800; font-family: var(--font-mono); color: var(--accent-gold);">0</span>
            </div>
            <div class="glass-panel stat-widget-card" style="padding: 30px; border-radius: 12px; position: relative; overflow: hidden; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Currently Reading</span>
                <span class="stat-counter" data-target="{{ $stats['currently_reading'] }}" style="font-size: 40px; font-weight: 800; font-family: var(--font-mono); color: var(--accent-gold);">0</span>
            </div>
            <div class="glass-panel stat-widget-card" style="padding: 30px; border-radius: 12px; position: relative; overflow: hidden; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Returned Volumes</span>
                <span class="stat-counter" data-target="{{ $stats['books_returned'] }}" style="font-size: 40px; font-weight: 800; font-family: var(--font-mono); color: var(--accent-gold);">0</span>
            </div>
            <div class="glass-panel stat-widget-card" style="padding: 30px; border-radius: 12px; position: relative; overflow: hidden; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Overdue Volumes</span>
                <span class="stat-counter" data-target="{{ $stats['overdue'] }}" style="font-size: 40px; font-weight: 800; font-family: var(--font-mono); color: var(--accent-gold);">0</span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="margin-bottom: 40px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error" style="margin-bottom: 40px;">
                {{ session('error') }}
            </div>
        @endif

        <!-- Charts and Progress Section -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 60px;">
            <!-- Reading Activity Bar Chart -->
            <div class="glass-panel" style="padding: 40px; border-radius: 12px;">
                <h3 style="font-family: var(--font-serif); font-size: 20px; color: var(--accent-gold); margin-bottom: 25px;">Reading Activity</h3>
                <div style="display: flex; align-items: flex-end; justify-content: space-between; height: 180px; padding: 0 10px; border-left: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
                    @php
                        $maxActivity = max(1, count($readingActivity) > 0 ? max($readingActivity) : 1);
                    @endphp
                    @foreach($readingActivity as $day => $count)
                        @php
                            $heightPercent = round(($count / $maxActivity) * 100);
                        @endphp
                        <div style="display: flex; flex-direction: column; align-items: center; width: 40px;">
                            <div class="chart-bar" data-height="{{ $heightPercent }}%" style="width: 100%; background: linear-gradient(to top, var(--accent-gold), rgba(234,179,8,0.3)); border-radius: 4px 4px 0 0; height: 0%;"></div>
                            <span style="font-size: 10px; color: var(--text-secondary); margin-top: 8px;">{{ $day }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Subject Distribution Pie Chart -->
            <div class="glass-panel" style="padding: 40px; border-radius: 12px; display: flex; flex-direction: column; justify-content: space-between;">
                <h3 style="font-family: var(--font-serif); font-size: 20px; color: var(--accent-gold); margin-bottom: 25px;">Knowledge Domain Focus</h3>
                
                <div style="display: flex; align-items: center; gap: 40px; justify-content: center;">
                    <!-- SVG Pie Chart -->
                    <svg width="150" height="150" viewBox="0 0 36 36" style="transform: rotate(-90deg);" id="pie-chart-svg">
                        <!-- Circle background -->
                        <circle cx="18" cy="18" r="15.915" fill="transparent" stroke="rgba(255,255,255,0.05)" stroke-width="4"></circle>
                        @php
                            $totalCount = $categoryStats->sum('count');
                            $accumulatedPercentage = 0;
                        @endphp
                        @foreach($categoryStats as $index => $cat)
                            @php
                                $percentage = $totalCount > 0 ? round(($cat->count / $totalCount) * 100) : 0;
                                $dashoffset = -$accumulatedPercentage;
                                $accumulatedPercentage += $percentage;
                            @endphp
                            <circle cx="18" cy="18" r="15.915" fill="transparent" stroke="{{ $cat->color ?? 'var(--accent-gold)' }}" stroke-width="4" stroke-dasharray="0 100" stroke-dashoffset="{{ $dashoffset }}" class="pie-segment" data-percent="{{ $percentage }}" id="pie-segment-{{ $index + 1 }}"></circle>
                        @endforeach
                    </svg>
                    
                    <!-- Legends -->
                    <div style="display: flex; flex-direction: column; gap: 15px; font-size: 13px;">
                        @forelse($categoryStats as $cat)
                            @php
                                $percentage = $totalCount > 0 ? round(($cat->count / $totalCount) * 100) : 0;
                            @endphp
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 12px; height: 12px; background: {{ $cat->color ?? 'var(--accent-gold)' }}; border-radius: 3px;"></div>
                                <span>{{ $cat->name }} ({{ $percentage }}%)</span>
                            </div>
                        @empty
                            <span style="color: var(--text-secondary);">No checkout data.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Currently Borrowed Grid -->
        <div style="margin-bottom: 50px;">
            <h3 style="font-family: var(--font-serif); font-size: 24px; color: var(--text-primary); margin-bottom: 25px;">Currently Reading</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
                @forelse($currentBorrowings as $borrow)
                    <div class="glass-panel dashboard-book-item" style="padding: 25px; border-radius: 12px; display: flex; gap: 20px; align-items: center; position: relative; overflow: hidden;">
                        <div style="width: 60px; height: 85px; background: linear-gradient(135deg, {{ $borrow->resource->category->color ?? '#eab308' }}, #0f172a); border-radius: 4px; box-shadow: 2px 5px 10px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; font-size: 24px; color: white;">
                            {{ $borrow->resource->category->icon ?? '📖' }}
                        </div>
                        <div style="flex: 1; z-index: 2;">
                            <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 5px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 160px;" title="{{ $borrow->resource->title }}">{{ $borrow->resource->title }}</h4>
                            <p style="font-size: 12px; color: var(--text-secondary); margin-bottom: 12px;">
                                @if($borrow->due_at->isPast())
                                    <span style="color: #f87171; font-weight: 600;">Overdue by {{ $borrow->due_at->diffForHumans(null, true) }}</span>
                                @else
                                    Due in {{ $borrow->due_at->diffForHumans(null, true) }}
                                @endif
                            </p>
                            <form action="{{ route('borrowings.return', $borrow->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-btn" style="padding: 8px 16px; font-size: 11px; border-radius: 4px; cursor: pointer; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block;">Return Volume</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="glass-panel" style="padding: 40px; border-radius: 12px; text-align: center; grid-column: 1 / -1; color: var(--text-secondary);">
                        No volumes currently checked out. <a href="{{ route('search') }}" style="color: var(--accent-gold); text-decoration: none; font-weight: 600;">Browse catalog</a> to check out a resource.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Borrow History -->
        <div style="margin-bottom: 60px;">
            <h3 style="font-family: var(--font-serif); font-size: 24px; color: var(--text-primary); margin-bottom: 25px;">Borrowing History</h3>
            <div class="glass-panel" style="padding: 30px; border-radius: 12px; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border-color); color: var(--text-secondary);">
                            <th style="padding: 12px 16px;">Resource Title</th>
                            <th style="padding: 12px 16px;">Author</th>
                            <th style="padding: 12px 16px;">Borrowed Date</th>
                            <th style="padding: 12px 16px;">Returned Date</th>
                            <th style="padding: 12px 16px; text-align: right;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $item)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);">
                                <td style="padding: 16px; font-weight: 600; color: var(--text-primary);">{{ $item->resource->title }}</td>
                                <td style="padding: 16px; color: var(--text-secondary);">{{ $item->resource->author }}</td>
                                <td style="padding: 16px; color: var(--text-secondary);">{{ $item->borrowed_at->format('M d, Y') }}</td>
                                <td style="padding: 16px; color: var(--text-secondary);">{{ $item->returned_at->format('M d, Y') }}</td>
                                <td style="padding: 16px; text-align: right; color: var(--accent-emerald); font-weight: 600;">Returned</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 24px; text-align: center; color: var(--text-secondary);">No previous checkouts recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Custom recommendations -->
        <div>
            <h3 style="font-family: var(--font-serif); font-size: 24px; color: var(--text-primary); margin-bottom: 25px;">Synthesized For You</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 30px;">
                @foreach($recommended as $res)
                    <div class="glass-panel result-card" style="padding: 20px; border-radius: 12px; cursor: pointer; text-decoration: none; color: inherit; display: flex; flex-direction: column; justify-content: space-between;" onclick="window.location.href='{{ route('resource.show', $res->id) }}'">
                        <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 15px;">
                            <div style="width: 90px; height: 130px; background: linear-gradient(135deg, {{ $res->category->color }}, #0f172a); border-radius: 4px; box-shadow: 2px 5px 10px rgba(0,0,0,0.3); margin-bottom: 15px; display: flex; align-items: center; justify-content: center; font-size: 32px; color: white;">📖</div>
                            <h4 style="font-size: 14px; font-weight: 700; text-align: center; margin-bottom: 5px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width: 100%;">{{ $res->title }}</h4>
                            <p style="font-size: 12px; color: var(--text-secondary); text-align: center;">{{ $res->author }}</p>
                        </div>
                        <div style="border-top: 1px solid var(--border-color); padding-top: 10px; font-size: 11px; color: var(--accent-gold); text-align: center; font-weight: 600;">
                            ★ {{ number_format($res->rating, 1) }} Matches Preferences
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<style>
/* Continuous widget float animation */
.stat-widget-card {
    transition: transform 0.3s;
}
.stat-widget-card:hover {
    transform: translateY(-5px);
}
</style>
@endsection
