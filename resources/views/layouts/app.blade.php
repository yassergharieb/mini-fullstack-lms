<!DOCTYPE html>
<html lang="en">
<head>
    @include('components.head')
</head>
<body x-data="{ darkMode: true }" 
      x-init="darkMode = JSON.parse(localStorage.getItem('darkMode')) ?? true; $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
      x-bind:class="{ 'light': !darkMode }"
      @yield('body-style')>
    @include('components.navbar')

    <div class="container" style="margin-top: 1rem;">
        @if(session('success'))
            <div class="glass-card" style="padding: 1rem; border-left: 4px solid var(--primary-color); margin-bottom: 1rem; background: rgba(0, 255, 136, 0.1);">
                <p style="color: var(--primary-color); font-weight: 600;">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="glass-card" style="padding: 1rem; border-left: 4px solid #ff4d4d; margin-bottom: 1rem; background: rgba(255, 77, 77, 0.1);">
                <p style="color: #ff4d4d; font-weight: 600;">{{ session('error') }}</p>
            </div>
        @endif
    </div>

    <main @yield('main-style')>
        @yield('content')
    </main>

    @include('components.scripts')
</body>
</html>
