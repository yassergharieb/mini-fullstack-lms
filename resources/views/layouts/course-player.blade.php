<!DOCTYPE html>
<html lang="en">
<head>
    @include('components.head')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <style>
        .sidebar-lesson {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: var(--transition-fast);
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid transparent;
        }

        .sidebar-lesson:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-lesson.active {
            background: rgba(99, 102, 241, 0.1);
            border-color: var(--primary-color);
        }

        .sidebar-lesson.completed {
            color: var(--secondary-color);
        }

        .progress-container {
            height: 6px;
            background: var(--border-color);
            border-radius: 999px;
            overflow: hidden;
            margin: 1.5rem 0;
        }

        .progress-bar {
            height: 100%;
            background: var(--primary-color);
            width: 45%;
            transition: width 0.5s ease;
        }

        .video-player-container {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 ratio */
            height: 0;
            border-radius: 1rem;
            overflow: hidden;
            background: #000;
        }

        .video-player-container iframe,
        .video-player-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body style="overflow: hidden;">
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <div style="display: flex; align-items: center; gap: 2rem;">
                <a href="{{ url('/') }}" class="logo">LMS.Premium</a>
                <span style="color: var(--text-muted); font-size: 0.9rem; border-left: 1px solid var(--border-color); padding-left: 1.5rem;">
                    @yield('course-title')
                </span>
            </div>
            <div class="nav-links">
                <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-outline" style="padding: 0.5rem 1rem;">Exit Course</a>
            </div>
        </div>
    </nav>

    <div style="display: flex; height: calc(100vh - 70px);">
        @yield('content')
    </div>

    @include('components.scripts')
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.playerInstances = Plyr.setup('.player');
        });
    </script>
    @stack('scripts')
</body>
</html>
