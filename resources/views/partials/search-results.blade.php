@forelse($resources as $res)
    <div class="result-card glass-panel" data-id="{{ $res->id }}" style="padding: 20px; display: flex; flex-direction: column; justify-content: space-between; border-radius: 12px; transition: transform 0.3s, box-shadow 0.3s; position: relative; overflow: hidden; cursor: pointer; text-decoration: none; color: inherit;" onclick="window.location.href='{{ route('resource.show', $res->id) }}'">
        <div class="card-glow"></div>
        
        <!-- Book Cover Visual -->
        <div class="card-cover-container" style="perspective: 1000px; width: 100%; height: 200px; margin-bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="card-cover-3d" style="width: 120px; height: 170px; transform-style: preserve-3d; transform: rotateY(-15deg); transition: transform 0.5s ease-out; position: relative; box-shadow: 5px 10px 20px rgba(0,0,0,0.4);">
                <!-- Front Cover -->
                <div style="position: absolute; width: 100%; height: 100%; border-radius: 2px 6px 6px 2px; background: linear-gradient(135deg, {{ $res->category->color ?? '#6366f1' }}, #0f172a); border: 1px solid rgba(255,255,255,0.15); display: flex; flex-direction: column; justify-content: space-between; padding: 15px; color: white; backface-visibility: hidden; z-index: 2;">
                    <div style="font-size: 8px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8;">{{ $res->type }}</div>
                    <div style="font-family: var(--font-serif); font-size: 13px; font-weight: 700; line-height: 1.3; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{{ $res->title }}</div>
                    <div style="font-size: 10px; opacity: 0.9; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">{{ $res->author }}</div>
                </div>
                <!-- Pages edge -->
                <div style="position: absolute; right: -4px; top: 2%; width: 6px; height: 96%; background: #e2e8f0; transform: rotateY(90deg) translateZ(118px); border-radius: 0 2px 2px 0;"></div>
                <!-- Spine -->
                <div style="position: absolute; left: -3px; top: 0; width: 6px; height: 100%; background: #0f172a; transform: rotateY(-90deg) translateZ(3px);"></div>
                <!-- Back Cover -->
                <div style="position: absolute; width: 100%; height: 100%; border-radius: 6px 2px 2px 6px; background: #0f172a; transform: translateZ(-6px); z-index: 1;"></div>
            </div>
        </div>

        <!-- Info details -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span class="category-tag" style="font-size: 10px; padding: 4px 8px; border-radius: 4px; background: rgba(255,255,255,0.05); border: 1px solid var(--border-color); color: var(--text-secondary);">
                    {{ $res->category->name }}
                </span>
                <span style="font-family: var(--font-mono); font-size: 12px; color: var(--accent-gold);">★ {{ number_format($res->rating, 1) }}</span>
            </div>
            
            <h3 class="card-title" style="font-size: 16px; font-weight: 700; margin-bottom: 5px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; color: var(--text-primary);">
                {{ $res->title }}
            </h3>
            <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 15px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                by {{ $res->author }}
            </p>

            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); padding-top: 12px; font-size: 12px;">
                <span style="color: var(--text-secondary);">Year: {{ $res->published_year }}</span>
                @if($res->available_copies > 0)
                    <span style="color: var(--accent-emerald); font-weight: 600; display: flex; align-items: center; gap: 4px;">● Available</span>
                @else
                    <span style="color: #ef4444; font-weight: 600; display: flex; align-items: center; gap: 4px;">● Borrowed</span>
                @endif
            </div>
        </div>
    </div>
@empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 50px; color: var(--text-secondary);">
        <p style="font-size: 18px; margin-bottom: 10px;">No records located in the database</p>
        <p style="font-size: 14px;">Try modifying your search criteria or keywords</p>
    </div>
@endforelse

<style>
/* 3D Card Hover Effects */
.result-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
    border-color: rgba(234, 179, 8, 0.2);
}
.result-card:hover .card-cover-3d {
    transform: rotateY(-5deg) rotateX(10deg) scale(1.05) !important;
}
</style>
