<nav class="navbar">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
        <a href="{{ url('/') }}" class="logo">LMS.Premium</a>
        <div class="nav-links">
            <a href="{{ url('/') }}" class="nav-link">Home</a>
            <button @click="darkMode = !darkMode" class="btn btn-outline" style="padding: 0.5rem; border-radius: 999px; width: 40px; height: 40px; justify-content: center; margin-right: 1rem; border-color: var(--border-color);">
                <template x-if="darkMode">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                </template>
                <template x-if="!darkMode">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </template>
            </button>
            @auth
                <a href="{{ route('courses.index') }}" class="nav-link">My Courses</a>
                <span style="color: var(--text-muted); font-size: 0.9rem;">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="cursor: pointer;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Join Now</a>
            @endauth
        </div>
    </div>
</nav>
