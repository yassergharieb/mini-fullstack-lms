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
                    $totalLessons = $course->lessons->count();
                @endphp
                <div class="progress-bar" id="course-progress-bar" style="width: {{ $percentage }}%;"></div>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted);">
                <span id="progress-percentage">{{ round($percentage) }}% Complete</span>
                <span id="progress-count">{{ $completedCount }}/{{ $totalLessons }} Lessons</span>
            </div>
        </div>

        <div class="sidebar-section">
            <h4 style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-bottom: 1rem;">
                Curriculum</h4>
            @foreach($course->lessons as $lesson)
                @php
                    $isCompleted = auth()->user()->lessonProgress()->where('lesson_id', $lesson->id)->whereNotNull('completed_at')->exists();
                @endphp
                <a href="{{ route('courses.play', [$course->slug, $lesson->slug]) }}" style="text-decoration: none; color: inherit; display: block;">
                    @include('components.lesson-item', [
                        'status' => ($currentLesson && $lesson->id === $currentLesson->id) ? 'active' : ($isCompleted ? 'completed' : ''),
                        'index' => str_pad($loop->iteration, 2, '0', STR_PAD_LEFT),
                        'title' => $lesson->title,
                        'type' => 'Video',
                        'duration' => floor($lesson->duration / 60) . ':' . str_pad($lesson->duration % 60, 2, '0', STR_PAD_LEFT)
                    ])
                </a>
            @endforeach
        </div>
    </aside>

    <!-- Player Area -->
    <main style="flex: 1; padding: 2rem; overflow-y: auto; background: #0b0f1a;">
        <div style="max-width: 1000px; margin: 0 auto;">
            <div class="video-player-container glass-card">
                @if($currentLesson && $currentLesson->video_url)
                    <div class="player" data-plyr-provider="vimeo" data-plyr-embed-id="{{ $currentLesson->video_url }}"></div>
                @else
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; background: linear-gradient(135deg, #1e293b, #0f172a);">
                        <p style="margin-top: 1rem; font-weight: 600; color: var(--text-muted);">Select a lesson to start</p>
                    </div>
                @endif
            </div>

            <div style="margin-top: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h1 style="font-size: 1.75rem; font-weight: 800;">{{ $currentLesson->title ?? 'Welcome' }}</h1>
                    <div style="display: flex; gap: 1rem;">
                        @if($previousLesson)
                            <a href="{{ route('courses.play', [$course->slug, $previousLesson->slug]) }}" class="btn btn-outline" style="padding: 0.5rem 1rem;">← Previous</a>
                        @else
                            <button class="btn btn-outline" style="padding: 0.5rem 1rem; opacity: 0.5; cursor: not-allowed;" disabled>← Previous</button>
                        @endif

                        @if($nextLesson)
                            <a href="{{ route('courses.play', [$course->slug, $nextLesson->slug]) }}" class="btn btn-primary" style="padding: 0.5rem 1rem;">Next Lesson →</a>
                        @else
                            <button class="btn btn-primary" style="padding: 0.5rem 1rem; opacity: 0.5; cursor: not-allowed;" disabled>Next Lesson →</button>
                        @endif
                    </div>
                </div>

                <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">Lesson Description</h2>
                    <p style="color: var(--text-muted); line-height: 1.8;">
                        {{ $currentLesson->description ?? 'No description available for this lesson.' }}
                    </p>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let lastUpdateTime = 0;
        let isCompleted = false;
        const lessonId = "{{ $currentLesson->id }}";
        const updateUrl = "{{ route('lessons.progress.update') }}";

        const checkPlayers = setInterval(() => {
            if (window.playerInstances && window.playerInstances.length > 0) {
                const player = window.playerInstances[0];
                clearInterval(checkPlayers);

                player.on('timeupdate', event => {
                    const currentTime = Math.floor(player.currentTime);
                    
                    // Update every 10 seconds or if near completion
                    if (currentTime - lastUpdateTime >= 10 || (player.percentage >= 95 && !isCompleted)) {
                        updateProgress(currentTime);
                        lastUpdateTime = currentTime;
                    }
                });
            }
        }, 100);

        function updateProgress(seconds) {
            fetch(updateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    lesson_id: lessonId,
                    watch_seconds: seconds
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    if (data.completed && !isCompleted) {
                        isCompleted = true;
                        // Refresh sidebar or show celebration
                        document.getElementById('progress-percentage').innerText = data.progress + '% Complete';
                        document.getElementById('course-progress-bar').style.width = data.progress + '%';
                    }
                }
            })
            .catch(error => console.error('Error updating progress:', error));
        }
    });
</script>
@endpush
