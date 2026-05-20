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
                <span style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Borrowed Volumes</span>
                <span class="stat-counter" data-target="14" style="font-size: 40px; font-weight: 800; font-family: var(--font-mono); color: var(--accent-gold);">0</span>
            </div>
            <div class="glass-panel stat-widget-card" style="padding: 30px; border-radius: 12px; position: relative; overflow: hidden; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Research Hours</span>
                <span class="stat-counter" data-target="184" style="font-size: 40px; font-weight: 800; font-family: var(--font-mono); color: var(--accent-gold);">0</span>
            </div>
            <div class="glass-panel stat-widget-card" style="padding: 30px; border-radius: 12px; position: relative; overflow: hidden; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Current Citations</span>
                <span class="stat-counter" data-target="42" style="font-size: 40px; font-weight: 800; font-family: var(--font-mono); color: var(--accent-gold);">0</span>
            </div>
            <div class="glass-panel stat-widget-card" style="padding: 30px; border-radius: 12px; position: relative; overflow: hidden; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Saved Searches</span>
                <span class="stat-counter" data-target="7" style="font-size: 40px; font-weight: 800; font-family: var(--font-mono); color: var(--accent-gold);">0</span>
            </div>
        </div>

        <!-- Charts and Progress Section -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 60px;">
            <!-- Reading Activity Bar Chart -->
            <div class="glass-panel" style="padding: 40px; border-radius: 12px;">
                <h3 style="font-family: var(--font-serif); font-size: 20px; color: var(--accent-gold); margin-bottom: 25px;">Reading Activity</h3>
                <div style="display: flex; align-items: flex-end; justify-content: space-between; height: 180px; padding: 0 10px; border-left: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
                    <!-- We will animate these height grow using GSAP -->
                    <div style="display: flex; flex-direction: column; align-items: center; width: 40px;">
                        <div class="chart-bar" data-height="60%" style="width: 100%; background: linear-gradient(to top, var(--accent-gold), rgba(234,179,8,0.3)); border-radius: 4px 4px 0 0; height: 0%;"></div>
                        <span style="font-size: 10px; color: var(--text-secondary); margin-top: 8px;">Mon</span>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; width: 40px;">
                        <div class="chart-bar" data-height="90%" style="width: 100%; background: linear-gradient(to top, var(--accent-gold), rgba(234,179,8,0.3)); border-radius: 4px 4px 0 0; height: 0%;"></div>
                        <span style="font-size: 10px; color: var(--text-secondary); margin-top: 8px;">Tue</span>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; width: 40px;">
                        <div class="chart-bar" data-height="40%" style="width: 100%; background: linear-gradient(to top, var(--accent-gold), rgba(234,179,8,0.3)); border-radius: 4px 4px 0 0; height: 0%;"></div>
                        <span style="font-size: 10px; color: var(--text-secondary); margin-top: 8px;">Wed</span>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; width: 40px;">
                        <div class="chart-bar" data-height="75%" style="width: 100%; background: linear-gradient(to top, var(--accent-gold), rgba(234,179,8,0.3)); border-radius: 4px 4px 0 0; height: 0%;"></div>
                        <span style="font-size: 10px; color: var(--text-secondary); margin-top: 8px;">Thu</span>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; width: 40px;">
                        <div class="chart-bar" data-height="85%" style="width: 100%; background: linear-gradient(to top, var(--accent-gold), rgba(234,179,8,0.3)); border-radius: 4px 4px 0 0; height: 0%;"></div>
                        <span style="font-size: 10px; color: var(--text-secondary); margin-top: 8px;">Fri</span>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; width: 40px;">
                        <div class="chart-bar" data-height="30%" style="width: 100%; background: linear-gradient(to top, var(--accent-gold), rgba(234,179,8,0.3)); border-radius: 4px 4px 0 0; height: 0%;"></div>
                        <span style="font-size: 10px; color: var(--text-secondary); margin-top: 8px;">Sat</span>
                    </div>
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
                        <!-- CS: 45% (dasharray: 45 55) -->
                        <circle cx="18" cy="18" r="15.915" fill="transparent" stroke="var(--accent-gold)" stroke-width="4" stroke-dasharray="0 100" stroke-dashoffset="0" class="pie-segment" data-percent="45" id="pie-segment-1"></circle>
                        <!-- Math: 30% (dasharray: 30 70, offset: -45) -->
                        <circle cx="18" cy="18" r="15.915" fill="transparent" stroke="#3b82f6" stroke-width="4" stroke-dasharray="0 100" stroke-dashoffset="-45" class="pie-segment" data-percent="30" id="pie-segment-2"></circle>
                        <!-- Physics: 25% (dasharray: 25 75, offset: -75) -->
                        <circle cx="18" cy="18" r="15.915" fill="transparent" stroke="#10b981" stroke-width="4" stroke-dasharray="0 100" stroke-dashoffset="-75" class="pie-segment" data-percent="25" id="pie-segment-3"></circle>
                    </svg>
                    
                    <!-- Legends -->
                    <div style="display: flex; flex-direction: column; gap: 15px; font-size: 13px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 12px; height: 12px; background: var(--accent-gold); border-radius: 3px;"></div>
                            <span>Computer Science (45%)</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 12px; height: 12px; background: #3b82f6; border-radius: 3px;"></div>
                            <span>Mathematics (30%)</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 12px; height: 12px; background: #10b981; border-radius: 3px;"></div>
                            <span>Physics (25%)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Currently Borrowed Grid -->
        <div style="margin-bottom: 50px;">
            <h3 style="font-family: var(--font-serif); font-size: 24px; color: var(--text-primary); margin-bottom: 25px;">Currently Reading</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
                <!-- Simulated list -->
                <div class="glass-panel dashboard-book-item" style="padding: 25px; border-radius: 12px; display: flex; gap: 20px; align-items: center; position: relative; overflow: hidden; cursor: pointer;">
                    <div style="width: 60px; height: 85px; background: linear-gradient(135deg, var(--accent-gold), #0f172a); border-radius: 4px; box-shadow: 2px 5px 10px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; font-size: 24px; color: white;">💻</div>
                    <div style="flex: 1;">
                        <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 5px;">Clean Code</h4>
                        <p style="font-size: 12px; color: var(--text-secondary); margin-bottom: 10px;">Due: 4 days remaining</p>
                        <div style="width: 100%; height: 4px; background: rgba(255,255,255,0.08); border-radius: 2px; overflow: hidden;">
                            <div style="width: 75%; height: 100%; background: var(--accent-gold); border-radius: 2px;"></div>
                        </div>
                    </div>
                </div>

                <div class="glass-panel dashboard-book-item" style="padding: 25px; border-radius: 12px; display: flex; gap: 20px; align-items: center; position: relative; overflow: hidden; cursor: pointer;">
                    <div style="width: 60px; height: 85px; background: linear-gradient(135deg, #3b82f6, #0f172a); border-radius: 4px; box-shadow: 2px 5px 10px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; font-size: 24px; color: white;">📐</div>
                    <div style="flex: 1;">
                        <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 5px;">Linear Algebra</h4>
                        <p style="font-size: 12px; color: var(--text-secondary); margin-bottom: 10px;">Due: 11 days remaining</p>
                        <div style="width: 100%; height: 4px; background: rgba(255,255,255,0.08); border-radius: 2px; overflow: hidden;">
                            <div style="width: 30%; height: 100%; background: #3b82f6; border-radius: 2px;"></div>
                        </div>
                    </div>
                </div>
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
