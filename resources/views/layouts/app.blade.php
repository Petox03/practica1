<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Aplicación')</title>
    @vite('resources/css/app.css')
</head>

<body>
    <header class="w-full">
        <div class="navbar bg-base-100 shadow-sm">
            <div class="navbar-start">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </div>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                        <li><a href="{{ route('index') }}">Inicio</a></li>
                    </ul>
                </div>
            </div>
            <div class="navbar-center">
                <a href="{{ route('index') }}" class="btn btn-ghost text-xl">Drogas</a>
            </div>
            <div class="navbar-end">
                
            </div>
        </div>
    </header>

    <main class="p-12 relative">
        @yield('content')
    </main>


</body>

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
@vite('resources/js/app.js')
@stack('js')

</html>
