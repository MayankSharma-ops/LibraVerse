@extends('layouts.app')

@section('title', 'Admin Console — LibraVerse Archives')

@section('content')
<section style="padding-top: 140px; min-height: 100vh; position: relative; z-index: 10; padding-bottom: 80px;">
    <div class="container">
        <!-- Title and Welcome -->
        <div style="margin-bottom: 50px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="font-family: var(--font-serif); font-size: 42px; font-weight: 800; color: var(--accent-gold); margin-bottom: 10px;">Archive Administrator Console</h1>
                <p style="color: var(--text-secondary); font-size: 15px;">Monitor central catalog metrics, issue listings, and transaction sequences.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="margin-bottom: 40px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Analytics Stats Widgets -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; margin-bottom: 50px;">
            <div class="glass-panel admin-stat-card" style="padding: 30px; border-radius: 12px; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Registered Researchers</span>
                <span class="stat-counter" data-target="{{ $totalUsers }}" style="font-size: 40px; font-weight: 800; font-family: var(--font-mono); color: var(--accent-gold);">0</span>
            </div>
            <div class="glass-panel admin-stat-card" style="padding: 30px; border-radius: 12px; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Total Archival Volumes</span>
                <span class="stat-counter" data-target="{{ $totalVolumes }}" style="font-size: 40px; font-weight: 800; font-family: var(--font-mono); color: var(--accent-gold);">0</span>
            </div>
            <div class="glass-panel admin-stat-card" style="padding: 30px; border-radius: 12px; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Active Loans</span>
                <span class="stat-counter" data-target="{{ $activeLoans }}" style="font-size: 40px; font-weight: 800; font-family: var(--font-mono); color: var(--accent-gold);">0</span>
            </div>
            <div class="glass-panel admin-stat-card" style="padding: 30px; border-radius: 12px; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Overdue Loans</span>
                <span class="stat-counter" data-target="{{ $overdueLoans }}" style="font-size: 40px; font-weight: 800; font-family: var(--font-mono); color: #f87171;">0</span>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 450px 1fr; gap: 40px; align-items: start;">
            <!-- Left Column: Catalog Book Form -->
            <div class="glass-panel" style="padding: 40px; border-radius: 16px; position: relative; overflow: hidden;">
                <div class="card-glow" style="opacity: 1; --x: 50%; --y: 0%;"></div>
                
                <h3 style="font-family: var(--font-serif); font-size: 24px; color: var(--accent-gold); margin-bottom: 8px;">Catalog New Volume</h3>
                <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 30px;">Input credentials to index a new intellectual resource.</p>

                @if ($errors->any())
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('admin.resources.store') }}" method="POST" autocomplete="off">
                    @csrf
                    
                    <div class="form-group">
                        <label for="title" class="form-label">Volume Title</label>
                        <input type="text" name="title" id="title" class="form-input" required placeholder="e.g. Introduction to Algorithms">
                    </div>

                    <div class="form-group">
                        <label for="author" class="form-label">Author / Creator</label>
                        <input type="text" name="author" id="author" class="form-input" required placeholder="e.g. Thomas H. Cormen">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-input" required style="background-color: #0d1121;">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="type" class="form-label">Document Type</label>
                            <select name="type" id="type" class="form-input" required style="background-color: #0d1121;">
                                <option value="book">Book</option>
                                <option value="journal">Journal</option>
                                <option value="ebook">E-Book</option>
                                <option value="research_paper">Research Paper</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label for="total_copies" class="form-label">Total Copies</label>
                            <input type="number" name="total_copies" id="total_copies" class="form-input" min="1" required value="1">
                        </div>

                        <div class="form-group">
                            <label for="pages" class="form-label">Page Count</label>
                            <input type="number" name="pages" id="pages" class="form-input" min="1" placeholder="e.g. 1200">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="isbn" class="form-label">ISBN Reference</label>
                        <input type="text" name="isbn" id="isbn" class="form-input" placeholder="e.g. 978-0262033848">
                    </div>

                    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label for="publisher" class="form-label">Publisher</label>
                            <input type="text" name="publisher" id="publisher" class="form-input" placeholder="e.g. MIT Press">
                        </div>

                        <div class="form-group">
                            <label for="published_year" class="form-label">Year</label>
                            <input type="number" name="published_year" id="published_year" class="form-input" min="1000" max="{{ date('Y') + 5 }}" placeholder="2009">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 30px;">
                        <label for="description" class="form-label">Abstract Description</label>
                        <textarea name="description" id="description" class="form-input" rows="3" placeholder="Brief summary of content, themes and research value..."></textarea>
                    </div>

                    <button type="submit" class="nav-btn" style="width: 100%; padding: 14px; font-size: 14px; text-align: center; display: block; border-radius: 6px;">
                        Commit to Archives
                    </button>
                </form>
            </div>

            <!-- Right Column: Top borrowed & Activity log -->
            <div style="display: flex; flex-direction: column; gap: 40px;">
                <!-- Top Borrowed Volumes -->
                <div class="glass-panel" style="padding: 40px; border-radius: 16px;">
                    <h3 style="font-family: var(--font-serif); font-size: 24px; color: var(--accent-gold); margin-bottom: 25px;">Top Borrowed Volumes</h3>
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        @forelse($topResources as $res)
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.03);">
                                <div>
                                    <h4 style="font-size: 15px; font-weight: 700; color: var(--text-primary);">{{ $res->title }}</h4>
                                    <span style="font-size: 12px; color: var(--text-secondary);">by {{ $res->author }} — {{ $res->category->name }}</span>
                                </div>
                                <span style="font-size: 13px; font-weight: 700; color: var(--accent-gold); background: rgba(234,179,8,0.1); padding: 4px 10px; border-radius: 4px;">{{ $res->borrow_count }} Loans</span>
                            </div>
                        @empty
                            <div style="text-align: center; color: var(--text-secondary); padding: 20px;">No borrow transactions indexed yet.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Transactions Feed -->
                <div class="glass-panel" style="padding: 40px; border-radius: 16px;">
                    <h3 style="font-family: var(--font-serif); font-size: 24px; color: var(--accent-gold); margin-bottom: 25px;">Archival Activity Stream</h3>
                    <div style="display: flex; flex-direction: column; gap: 20px; max-height: 400px; overflow-y: auto; padding-right: 10px;">
                        @forelse($recentTransactions as $tx)
                            <div style="display: flex; gap: 15px; align-items: start; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.02);">
                                <div style="font-size: 20px; width: 35px; height: 35px; background: rgba(255,255,255,0.03); display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                    {{ $tx->returned_at ? '📥' : '📤' }}
                                </div>
                                <div style="flex: 1;">
                                    <p style="font-size: 13px; color: var(--text-primary); margin-bottom: 4px;">
                                        <strong>{{ $tx->user->name }}</strong> 
                                        {{ $tx->returned_at ? 'returned' : 'borrowed' }} 
                                        <strong>{{ $tx->resource->title }}</strong>
                                    </p>
                                    <span style="font-size: 11px; color: var(--text-secondary);">
                                        {{ ($tx->returned_at ?? $tx->borrowed_at)->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; color: var(--text-secondary); padding: 20px;">No archival activity logged.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Stagger animate admin cards
    if (window.gsap) {
        window.gsap.fromTo('.admin-stat-card', 
            { y: 30, opacity: 0 }, 
            { y: 0, opacity: 1, duration: 0.6, ease: 'power2.out', stagger: 0.15 }
        );

        // Count up stats using GSAP
        document.querySelectorAll('.stat-counter').forEach(counter => {
            const target = parseInt(counter.dataset.target || '0', 10);
            const obj = { val: 0 };
            window.gsap.to(obj, {
                val: target,
                duration: 2,
                ease: 'power2.out',
                delay: 0.4,
                onUpdate: () => {
                    counter.textContent = Math.round(obj.val);
                }
            });
        });
    }
});
</script>
@endsection
