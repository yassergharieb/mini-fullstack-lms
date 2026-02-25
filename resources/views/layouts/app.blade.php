<!DOCTYPE html>
<html lang="en">
<head>
    @include('components.head')
</head>
<body @yield('body-style')>
    @include('components.navbar')

    <main @yield('main-style')>
        @yield('content')
    </main>

    @include('components.scripts')
</body>
</html>
