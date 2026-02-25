@extends('layouts.course-player')

@section('title', 'Course Player | Premium LMS')
@section('course-title', 'Full-Stack Web Development Mastery')

@section('content')
    <!-- Lessons Sidebar -->
    <aside class="glass-card"
           style="width: 350px; border-radius: 0; border-top: none; border-bottom: none; border-left: none; overflow-y: auto; padding: 1.5rem;">
        <div style="margin-bottom: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem;">Course Progress</h3>
            <div class="progress-container">
                <div class="progress-bar" id="course-progress"></div>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted);">
                <span>45% Complete</span>
                <span>12/28 Lessons</span>
            </div>
        </div>

        <div class="sidebar-section">
            <h4 style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-bottom: 1rem;">
                Section 1: Introduction</h4>
            @include('components.lesson-item', [
                'status' => 'active',
                'home' => '01',
                'title' => 'Welcome to the Course',
                'type' => 'Video',
                'duration' => '5:20'
            ])
            @include('components.lesson-item', [
                'status' => 'completed',
                'home' => '02',
                'title' => 'Environment Setup',
                'type' => 'Video',
                'duration' => '12:45'
            ])
        </div>

        <div class="sidebar-section" style="margin-top: 2rem;">
            <h4 style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-bottom: 1rem;">
                Section 2: Frontend Fundamentals</h4>
            @include('components.lesson-item', [
                'home' => '03',
                'title' => 'HTML5 Best Practices',
                'type' => 'Video',
                'duration' => '18:30'
            ])
            @include('components.lesson-item', [
                'home' => '04',
                'title' => 'Modern CSS & Layouts',
                'type' => 'Video',
                'duration' => '25:10'
            ])
        </div>
    </aside>

    <!-- Player Area -->
    <main style="flex: 1; padding: 2rem; overflow-y: auto; background: #0b0f1a;">
        <div style="max-width: 1000px; margin: 0 auto;">
            <div class="video-player-container glass-card">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; background: linear-gradient(135deg, #1e293b, #0f172a);">
                    <div style="width: 80px; height: 80px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transform: translate3d(0, 0, 0); transition: 0.3s ease;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                    <p style="margin-top: 1rem; font-weight: 600; color: var(--text-muted);">Click to start lesson</p>
                </div>
            </div>

            <div style="margin-top: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h1 style="font-size: 1.75rem; font-weight: 800;">Welcome to the Course</h1>
                    <div style="display: flex; gap: 1rem;">
                        <button class="btn btn-outline" style="padding: 0.5rem 1rem;">← Previous</button>
                        <button class="btn btn-primary" style="padding: 0.5rem 1rem;">Next Lesson →</button>
                    </div>
                </div>

                <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">Lesson Description</h2>
                    <p style="color: var(--text-muted); line-height: 1.8;">
                        In this introductory lesson, we will explore the course roadmap and what you can expect to
                        learn. We will go through the projects we'll build and the technologies we'll master, including
                        React, Node.js, and MongoDB.
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
                            <a href="#" style="color: var(--primary-color);">Course_Syllabus.pdf</a>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.75rem;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 style="color: var(--primary-color);">
                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                            </svg>
                            <a href="#" style="color: var(--primary-color);">Setup_Guide_Link</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
@endsection
