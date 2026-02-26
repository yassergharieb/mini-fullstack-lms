@extends('layouts.app')

@section('title', 'My Courses | Premium LMS')

@section('content')
    <div class="container" style="padding: 2rem 1.5rem;">
        <div class="course-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="font-size: 2rem; font-weight: 800;">My Enrolled Courses</h1>
            <div style="color: var(--text-muted); font-size: 0.9rem;">{{ count($courses) }} courses found</div>
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
