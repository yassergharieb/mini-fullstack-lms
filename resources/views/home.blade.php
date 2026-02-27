@extends('layouts.app')

@section('title', 'Course Catalog | Premium LMS')

@section('content')
    <div class="container" style="display: flex; gap: 2rem;">
        <!-- Filters Sidebar -->
        @include('components.sidebar-filter')

        <!-- Course List Section -->
        <section style="flex: 1;">
            <div class="course-header" style="margin-top: 2rem; display: flex; justify-content: space-between; align-items: center;">
                <h1 style="font-size: 2rem; font-weight: 800;">Explore Courses</h1>
                <div style="color: var(--text-muted); font-size: 0.9rem;">Showing {{ $courses->total() }} results</div>
            </div>

            <div class="course-grid" id="course-grid">
                @forelse($courses as $course)
                    @php
                        $isEnrolled = in_array($course->id, $enrolledCourseIds ?? []);
                    @endphp
                    @include('components.course-card', [
                        'cover_image' => $course->cover_image,
                        'level' => $course->level->name,
                        'name' => $course->name,
                        'description' => Str::limit(strip_tags($course->description), 80),
                        'price' => $isEnrolled ? 'Enrolled' : ($course->price > 0 ? '$' . number_format($course->price, 2) : 'Free'),
                        'slug' => $course->slug,
                        'style' => 'animation-delay: ' . ($loop->index * 0.1) . 's;'
                    ])
                @empty
                    <p style="color: var(--text-muted); grid-column: 1 / -1; text-align: center; padding: 3rem;">No courses found.</p>
                @endforelse
            </div>

            <div style="margin: 2rem 0;">
                {{ $courses->links() }}
            </div>
        </section>
    </div>
@endsection

