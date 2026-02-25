<!DOCTYPE html>
<html lang="en">
<head>
    @include('components.head')
</head>
<body>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: radial-gradient(circle at top right, #1e293b, #0f172a); padding: 2rem 0;">
        @yield('content')
    </div>

    @include('components.scripts')
</body>
</html>
