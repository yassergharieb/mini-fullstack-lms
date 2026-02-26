@extends('layouts.course-player')

@section('title', 'Playing: ' . ($currentLesson->title ?? 'Course') . ' | Premium LMS')
@section('course-title', $course->name)

@section('content')
    <!-- Lessons Sidebar -->
    <aside class="glass-card"
           style="width: 350px; border-radius: 0; border-top: none; border-bottom: none; border-left: none; overflow-y: auto; padding: 1.5rem;">
        <div style="margin-bottom: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem;">Course Progress</h3>
            <div class="progress-container">
                @php
                    $completedCount = 0; // Placeholder for real progress logic
                    $totalLessons = $course->lessons->count();
                    $percentage = $totalLessons > 0 ? ($completedCount / $totalLessons) * 100 : 0;
                @endphp
                <div class="progress-bar" id="course-progress" style="width: {{ $percentage }}%;"></div>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted);">
                <span>{{ round($percentage) }}% Complete</span>
                <span>{{ $completedCount }}/{{ $totalLessons }} Lessons</span>
            </div>
        </div>

        <div class="sidebar-section">
            <h4 style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-bottom: 1rem;">
                Curriculum</h4>
            @foreach($course->lessons as $lesson)
                @include('components.lesson-item', [
                    'status' => ($currentLesson && $lesson->id === $currentLesson->id) ? 'active' : '',
                    'index' => str_pad($loop->iteration, 2, '0', STR_PAD_LEFT),
                    'title' => $lesson->title,
                    'type' => 'Video',
                    'duration' => floor($lesson->duration / 60) . ':' . str_pad($lesson->duration % 60, 2, '0', STR_PAD_LEFT)
                ])
            @endforeach
        </div>
    </aside>

    <!-- Player Area -->
    <main style="flex: 1; padding: 2rem; overflow-y: auto; background: #0b0f1a;">
        <div style="max-width: 1000px; margin: 0 auto;">
            <div class="video-player-container glass-card">
                @if($currentLesson && $currentLesson->video_url)
                    <iframe src="{{ $currentLesson->video_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @else
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; background: linear-gradient(135deg, #1e293b, #0f172a);">
                        <div style="width: 80px; height: 80px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transform: translate3d(0, 0, 0); transition: 0.3s ease;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                        <p style="margin-top: 1rem; font-weight: 600; color: var(--text-muted);">Select a lesson to start</p>
                    </div>
                @endif
            </div>

            <div style="margin-top: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h1 style="font-size: 1.75rem; font-weight: 800;">{{ $currentLesson->title ?? 'Welcome' }}</h1>
                    <div style="display: flex; gap: 1rem;">
                        <button class="btn btn-outline" style="padding: 0.5rem 1rem;">← Previous</button>
                        <button class="btn btn-primary" style="padding: 0.5rem 1rem;">Next Lesson →</button>
                    </div>
                </div>

                <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">Lesson Description</h2>
                    <p style="color: var(--text-muted); line-height: 1.8;">
                        {{ $currentLesson->description ?? 'No description available for this lesson.' }}
                    </p>
                </div>

                <div style="margin-top: 2rem; background: var(--glass-bg); padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--glass-border);">
                    <h4 style="margin-bottom: 1rem;">Resources for this lesson</h4>
                    <ul style="display: grid; gap: 0.75rem;">
                        <li style="display: flex; align-items: center; gap: 0.75rem;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 style="color: var(--primary-color);">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            <a href="#" style="color: var(--primary-color);">Download Notes (PDF)</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
@endsection
