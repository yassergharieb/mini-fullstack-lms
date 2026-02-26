@extends('layouts.app')

@section('title', 'My Courses | Premium LMS')

@section('content')
    <div class="container" style="padding: 2rem 1.5rem;">
        <div class="course-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="font-size: 2rem; font-weight: 800;">My Enrolled Courses</h1>
            <div style="color: var(--text-muted); font-size: 0.9rem;">{{ count($courses) }} courses found</div>
        </div>

        <!-- Dashboard Stats Widgets -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            <div class="glass-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
                <div style="width: 50px; height: 50px; background: rgba(99, 102, 241, 0.1); border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: var(--primary-color);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                </div>
                <div>
                    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">Total Courses</div>
                    <div style="font-size: 1.5rem; font-weight: 800;">{{ $totalCourses }}</div>
                </div>
            </div>

            <div class="glass-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
                <div style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.1); border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: #10b981;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <div>
                    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">Lessons Completed</div>
                    <div style="font-size: 1.5rem; font-weight: 800;">{{ $completedLessonsCount }}</div>
                </div>
            </div>

            <div class="glass-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
                <div style="width: 50px; height: 50px; background: rgba(245, 158, 11, 0.1); border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: #f59e0b;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div>
                    <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">Avg. Completion</div>
                    <div style="font-size: 1.5rem; font-weight: 800;">{{ $avgProgress }}%</div>
                </div>
            </div>
        </div>

        <div class="course-grid" id="course-grid">
            @forelse($courses as $course)
                @include('components.course-card', [
                    'cover_image' => $course->cover_image,
                    'level' => $course->level->name,
                    'name' => $course->name,
                    'description' => Str::limit($course->description, 80),
                    'price' => 'Enrolled',
                    'slug' => $course->slug,
                    'style' => 'animation-delay: ' . ($loop->index * 0.1) . 's;'
                ])
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 5rem 1rem; background: var(--glass-bg); border-radius: 1.5rem; border: 1px dashed var(--border-color);">
                    <div style="font-size: 3rem; margin-bottom: 1.5rem;">📚</div>
                    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">You aren't enrolled in any courses yet</h2>
                    <p style="color: var(--text-muted); margin-bottom: 2rem;">Start your learning journey today by exploring our catalog.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary" style="padding: 0.75rem 2rem;">Explore Courses</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
