<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Blog')</title>

        <meta name="description" content="@yield('meta', 'Articles lunaires et heureux sur ce blog merveilleux')">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @yield('scripts')

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        @yield('style')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <header class="fixed top-0 left-0 w-full space-x-1 sm:h-12 bg-white flex items-center sm:space-x-5 sm:pl-8 flex-wrap">
                <span class="text-blue-800 inline-block mr-8">Mon Super Blog</span>
                <a href="/">Accueil</a>
                <a href="{{ route('posts.index') }}">Les posts</a>
                @auth
                    <a href="{{ route('users.edit', Auth::user()) }}">Profil</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" href="{{ route('logout') }}">Déconnexion</button>
                    </form>
                    @if(Auth::user()->role === \App\Enums\UserRole::Admin)
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}">Connexion</a>
                @endauth
            </header>


            <!-- Page Content -->
            <main class="mt-14 mx-2 sm:mx-8">
                @yield('content')
            </main>
        </div>
    </body>
</html>