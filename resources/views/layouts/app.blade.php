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

    <main @yield('main-style')>
        @yield('content')
    </main>

    @include('components.scripts')
</body>
</html>
