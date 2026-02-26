@extends('layouts.course-player')

@section('title', 'Playing: ' . ($currentLesson->title ?? 'Course') . ' | Premium LMS')
@section('course-title', $course->name)

@section('content')
<div x-data="coursePlayer({
    lessonId: '{{ $currentLesson->id }}',
    updateUrl: '{{ route('lessons.progress.update') }}',
    csrf: '{{ csrf_token() }}',
    initialProgress: {{ $percentage }},
    completedCount: {{ $completedCount }},
    totalLessons: {{ $course->lessons->count() }}
})" class="course-player-wrapper" style="display: flex; width: 100%; height: 100%;">
    
    <!-- Lesson Completion Celebration Modal -->
    <template x-if="showModal">
        <div class="modal-overlay" style="position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(8px); z-index: 1000; display: flex; align-items: center; justify-content: center;" x-transition>
            <div class="glass-card" style="max-width: 400px; width: 90%; padding: 2.5rem; text-align: center; border-color: var(--primary-color);">
                <div style="width: 80px; height: 80px; background: rgba(16, 185, 129, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #10b981;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">Lesson Completed!</h2>
                <p style="color: var(--text-muted); margin-bottom: 2rem;">Great job! You've successfully finished this lesson. Ready for the next one?</p>
                <div style="display: grid; gap: 0.75rem;">
                    @if($nextLesson)
                        <a href="{{ route('courses.play', [$course->slug, $nextLesson->slug]) }}" class="btn btn-primary" style="justify-content: center;">Next Lesson</a>
                    @endif
                    <button @click="showModal = false" class="btn btn-outline" style="justify-content: center;">Stay Here</button>
                </div>
            </div>
        </div>
    </template>

    <!-- Manual Completion Confirmation Modal -->
    <template x-if="showConfirmModal">
        <div class="modal-overlay" style="position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(8px); z-index: 1000; display: flex; align-items: center; justify-content: center;" x-transition>
            <div class="glass-card" style="max-width: 400px; width: 90%; padding: 2.5rem; text-align: center; border-color: var(--primary-color);">
                <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">Finish Lesson?</h2>
                <p style="color: var(--text-muted); margin-bottom: 2rem;">Are you sure you want to mark this lesson as completed? You can always come back to watch it again.</p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <button @click="markAsCompleted()" class="btn btn-primary" style="justify-content: center;">Yes, Complete</button>
                    <button @click="showConfirmModal = false" class="btn btn-outline" style="justify-content: center;">Cancel</button>
                </div>
            </div>
        </div>
    </template>

    <!-- Lessons Sidebar -->
    <aside class="glass-card"
           style="width: 350px; border-radius: 0; border-top: none; border-bottom: none; border-left: none; overflow-y: auto; padding: 1.5rem;">
        <div style="margin-bottom: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem;">Course Progress</h3>
            <div class="progress-container">
                <div class="progress-bar" :style="{ width: progress + '%' }"></div>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted);">
                <span x-text="Math.round(progress) + '% Complete'"></span>
                <span x-text="completedLessons + '/' + totalLessons + ' Lessons'"></span>
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
    <main style="flex: 1; padding: 2rem; overflow-y: auto;" :style="{ background: darkMode ? '#0b0f1a' : '#f1f5f9' }">
        <div style="max-width: 1000px; margin: 0 auto;">
            <div class="video-player-container glass-card" x-ref="playerContainer">
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
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <button 
                            @click="showConfirmModal = true" 
                            class="btn btn-outline" 
                            style="color: var(--secondary-color); border-color: var(--secondary-color);"
                            x-show="!isCompleted"
                        >
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Mark as Complete
                        </button>
                        
                        <div class="badge" x-show="isCompleted" style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Completed
                        </div>

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
</div>
@endsection

@push('scripts')
<script>
    function coursePlayer(config) {
        return {
            progress: config.initialProgress,
            completedLessons: config.completedCount,
            totalLessons: config.totalLessons,
            isCompleted: {{ auth()->user()->lessonProgress()->where('lesson_id', $currentLesson->id)->whereNotNull('completed_at')->exists() ? 'true' : 'false' }},
            showModal: false,
            showConfirmModal: false,
            lastUpdateTime: 0,
            player: null,

            init() {
                this.initPlayer();
            },

            initPlayer() {
                const checkPlayers = setInterval(() => {
                    if (window.playerInstances && window.playerInstances.length > 0) {
                        this.player = window.playerInstances[0];
                        clearInterval(checkPlayers);
                        this.setupEvents();
                    }
                }, 100);
            },

            setupEvents() {
                this.player.on('timeupdate', () => {
                    const currentTime = Math.floor(this.player.currentTime);
                    if (currentTime - this.lastUpdateTime >= 10 || (this.player.percentage >= 95 && !this.isCompleted)) {
                        this.updateProgress(currentTime);
                        this.lastUpdateTime = currentTime;
                    }
                });
            },

            async markAsCompleted() {
                this.showConfirmModal = false;
                await this.updateProgress(Math.floor(this.player.duration || 0), true);
            },

            async updateProgress(seconds, forceComplete = false) {
                try {
                    const response = await fetch(config.updateUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': config.csrf
                        },
                        body: JSON.stringify({
                            lesson_id: config.lessonId,
                            watch_seconds: seconds,
                            force_complete: forceComplete
                        })
                    });
                    
                    const data = await response.json();
                    if (data.status === 'success') {
                        this.progress = data.progress;
                        if (data.completed && !this.isCompleted) {
                            this.isCompleted = true;
                            this.completedLessons++;
                            this.showModal = true;
                        }
                    }
                } catch (error) {
                    console.error('Error updating progress:', error);
                }
            }
        }
    }
</script>
@endpush
