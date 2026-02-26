@extends('layouts.app')

@section('title', $course->name . ' | Premium LMS')

@push('styles')
<style>
    .course-hero {
        background-color: var(--bg-card);
        padding: 4rem 0;
        border-bottom: 1px solid var(--border-color);
        position: relative;
    }

    .course-hero-content {
        max-width: 800px;
    }

    .course-floating-card {
        position: absolute;
        top: 2rem;
        right: 1.5rem;
        width: 360px;
        z-index: 10;
    }

    .curriculum-item {
        padding: 1rem;
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition-fast);
    }

    .curriculum-item:hover {
        background: rgba(255,255,255,0.05);
        border-color: var(--primary-color);
    }

    .lesson-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-dark);
        border-radius: 50%;
        color: var(--primary-color);
    }

    @media (max-width: 1100px) {
        .course-floating-card {
            position: relative;
            top: 0;
            right: 0;
            width: 100%;
            margin-top: 2rem;
        }
        .course-hero {
            padding: 2rem 0;
        }
    }
</style>
@endpush

@section('content')
<div class="course-hero">
    <div class="container" style="position: relative;">
        <div class="course-hero-content">
            <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1.5rem;">
                <span class="course-badge" style="margin-bottom: 0;">{{ $course->level->name }}</span>
                <span style="color: var(--text-muted); font-size: 0.9rem;">Updated {{ $course->updated_at->format('M Y') }}</span>
            </div>
            
            <h1 style="font-size: 2.5rem; font-weight: 800; line-height: 1.2; margin-bottom: 1.5rem;">{{ $course->name }}</h1>
            
            <p style="font-size: 1.1rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 2rem;">
                {{ $course->description }}
            </p>
            
            {{-- Removed static ratings and student counts as they are not in the DB --}}

            
            <div style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: var(--text-muted);">Created by</span>
                <a href="#" style="color: var(--primary-color); font-weight: 600; text-decoration: underline;">{{ $course->creator->name }}</a>
            </div>
        </div>

        <!-- Floating Purchase Card -->
        <div class="course-floating-card glass-card">
            <img src="{{ $course->cover_image }}" alt="{{ $course->name }}" style="width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: 1rem 1rem 0 0;">
            <div style="padding: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                    <span style="font-size: 2rem; font-weight: 800;">${{ number_format($course->price, 2) }}</span>
                </div>

                <div style="display: grid; gap: 0.75rem;">
                    @auth
                        @if($isEnrolled)
                            <a href="{{ route('courses.play', $course->slug) }}" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">Continue Learning</a>
                        @else
                            <form action="{{ route('courses.enroll', $course->slug) }}" method="GET">
                                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">Enroll Now</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">Enroll Now</a>
                    @endauth
                    <button class="btn btn-outline" style="width: 100%; justify-content: center; padding: 1rem;">Add to Cart</button>
                </div>

                <div style="margin-top: 1.5rem; font-size: 0.85rem; color: var(--text-muted); text-align: center;">
                    30-Day Money-Back Guarantee
                </div>

                <div style="margin-top: 2rem;">
                    <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 1rem;">This course includes:</h4>
                    <ul style="display: grid; gap: 0.5rem;">
                        <li style="display: flex; align-items: center; gap: 0.75rem;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12H2M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
                            <span>{{ count($lessons) }} on-demand lessons</span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding: 4rem 1.5rem;">
    <div style="max-width: 800px;">
        <!-- Course Content -->
        <section style="margin-bottom: 4rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 2rem;">Course Content</h2>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; color: var(--text-muted); font-size: 0.9rem;">
                <div>
                    {{ count($lessons) }} lessons • {{ floor($lessons->sum('duration') / 60) }}h {{ $lessons->sum('duration') % 60 }}m total length
                </div>

                <button style="background: none; border: none; color: var(--primary-color); font-weight: 600; cursor: pointer;">Expand all sections</button>
            </div>

            <div class="curriculum-list">
                @foreach($lessons as $lesson)
                    @php
                        $canView = auth()->check() || $lesson->is_free_preview;
                    @endphp
                    <a href="{{ $canView ? route('courses.play', [$course->slug, $lesson->slug]) : '#' }}" 
                       style="text-decoration: none; color: inherit; display: block;"
                       @if(!$canView) onclick="alert('Please enroll to view this lesson.'); return false;" @endif>
                        <div class="curriculum-item">
                            <div class="lesson-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <h4 style="font-weight: 600;">{{ $lesson->title }}</h4>
                                    <span style="font-size: 0.85rem; color: var(--text-muted);">{{ floor($lesson->duration / 60) }}:{{ str_pad($lesson->duration % 60, 2, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                @if($lesson->is_free_preview)
                                    <span style="font-size: 0.8rem; color: var(--primary-color); text-decoration: underline;">Free Preview</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Removed static requirements section --}}


        <!-- Description -->
        <section>
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1.5rem;">Description</h2>
            <div style="color: var(--text-muted); line-height: 1.8;">
                {!! $course->description !!}
            </div>
        </section>
    </div>
</div>
@endsection
