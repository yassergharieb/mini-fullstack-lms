<nav class="navbar">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
        <a href="{{ url('/') }}" class="logo">LMS.Premium</a>
        <div class="nav-links">
            <a href="{{ url('/') }}" class="nav-link">Home</a>
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
