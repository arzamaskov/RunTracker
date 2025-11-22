<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RunTracker — Бегайте умнее. Растите стабильнее</title>
    <meta name="description"
        content="RunTracker — минималистичное приложение для учёта тренировок и аналитики бега. Готовьтесь к марафону осознанно.">

    <meta property="og:title" content="RunTracker — Бегайте умнее. Растите стабильнее">
    <meta property="og:description" content="Минималистичное приложение для учёта тренировок и аналитики бега">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('og/42k-cover.png') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="theme-color" content="#0ea5e9">

    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="manifest" href="/site.webmanifest" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/landing.js'])
</head>

<body class="antialiased bg-slate-50 text-slate-900 font-sans selection:bg-blue-500 selection:text-white">

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 mt-20 mx-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 mt-20 mx-4">
            {{ session('success') }}
        </div>
    @endif

    <header
        class="fixed top-0 left-0 right-0 z-50 backdrop-blur bg-white/80 supports-[backdrop-filter]:bg-white/80 border-b border-slate-200/50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="/"
                        class="text-xl font-semibold text-slate-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded">
                        RunTracker
                    </a>

                    <nav class="hidden md:flex space-x-2" aria-label="Главная навигация">
                        <a href="#features"
                            class="text-sm text-slate-700 hover:text-slate-900 transition px-3 py-2 rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">Возможности</a>
                        <a href="#how"
                            class="text-sm text-slate-700 hover:text-slate-900 transition px-3 py-2 rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">Как
                            работает</a>
                        <a href="#faq"
                            class="text-sm text-slate-700 hover:text-slate-900 transition px-3 py-2 rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">FAQ</a>
                    </nav>
                </div>

                <div class="flex items-center space-x-3">
                    @auth
                        <a href="#dashboard"
                            class="text-sm text-slate-700 hover:text-slate-900 transition px-3 py-2 rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            Кабинет
                        </a>
                        <form method="POST" action="" class="inline"
                            onsubmit="return confirm('Вы уверены, что хотите выйти?')">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                                Выйти
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 bg-slate-100 text-slate-800 text-sm rounded-lg hover:bg-slate-200 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            Вход
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            Регистрация
                        </a>
                    @endauth

                    <!-- Mobile menu button -->
                    <button id="menu-toggle"
                        class="md:hidden inline-flex items-center justify-center p-2 rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 text-slate-700 hover:text-slate-900"
                        aria-label="Открыть меню" aria-controls="mobile-menu" aria-expanded="false">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            aria-hidden="true" focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile nav -->
        <div id="mobile-menu" class="md:hidden hidden border-t border-slate-200/50 bg-white/90 backdrop-blur">
            <div class="max-w-6xl mx-auto px-4 py-3">
                <nav class="flex flex-col space-y-1" aria-label="Главная навигация (моб.)">
                    <a href="#features"
                        class="px-3 py-2 rounded text-slate-700 hover:text-slate-900 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Возможности</a>
                    <a href="#how"
                        class="px-3 py-2 rounded text-slate-700 hover:text-slate-900 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">Как
                        работает</a>
                    <a href="#faq"
                        class="px-3 py-2 rounded text-slate-700 hover:text-slate-900 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">FAQ</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="pt-16">
        @yield('content')
    </main>

    <footer class="bg-slate-50 border-t border-slate-200">
        <div class="max-w-6xl mx-auto px-4 py-12">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <div class="text-lg font-semibold text-slate-900 mb-2">RunTracker</div>
                    <p class="text-sm text-slate-600">
                        Бегайте умнее. Растите стабильнее
                    </p>
                </div>

                <div>
                    <div class="text-sm font-medium text-slate-900 mb-2">Технологии</div>
                    <p class="text-sm text-slate-600">
                        Laravel • Livewire • Tailwind CSS
                    </p>
                </div>

                <div>
                    <div class="text-sm font-medium text-slate-900 mb-2">Правовая информация</div>
                    <div class="flex flex-col space-y-1">
                        <a href="#privacy" class="text-sm text-slate-600 hover:text-slate-900 transition">Политика
                            конфиденциальности</a>
                        <a href="#terms" class="text-sm text-slate-600 hover:text-slate-900 transition">Условия
                            использования</a>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-200 text-center">
                <p class="text-sm text-slate-500">
                    © {{ date('Y') }} RunTracker. Все права защищены.
                </p>
            </div>
        </div>
    </footer>

    {{-- Скрипты вынесены в resources/js/app.js и подключаются через @vite --}}
</body>

</html>