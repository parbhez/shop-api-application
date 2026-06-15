<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Medicine API</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Outfit', 'sans-serif'],
                        },
                        animation: {
                            'blob': 'blob 7s infinite',
                            'fade-in': 'fadeIn 1s ease-out forwards',
                            'slide-up': 'slideUp 0.8s ease-out forwards',
                        },
                        keyframes: {
                            blob: {
                                '0%': { transform: 'translate(0px, 0px) scale(1)' },
                                '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                                '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                                '100%': { transform: 'translate(0px, 0px) scale(1)' },
                            },
                            fadeIn: {
                                '0%': { opacity: '0' },
                                '100%': { opacity: '1' },
                            },
                            slideUp: {
                                '0%': { opacity: '0', transform: 'translateY(20px)' },
                                '100%': { opacity: '1', transform: 'translateY(0)' },
                            }
                        }
                    }
                }
            }
        </script>
    @endif
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
            overflow-x: hidden;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);
        }
        .text-gradient {
            background: linear-gradient(to right, #38bdf8, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="antialiased min-h-screen relative selection:bg-indigo-500/30 selection:text-indigo-200">

    <!-- Background Elements -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-600/20 rounded-full mix-blend-screen filter blur-[100px] opacity-70 animate-blob"></div>
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-purple-600/20 rounded-full mix-blend-screen filter blur-[100px] opacity-70 animate-blob" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-32 left-1/2 w-96 h-96 bg-cyan-600/20 rounded-full mix-blend-screen filter blur-[100px] opacity-70 animate-blob" style="animation-delay: 4s;"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjQiPgo8cmVjdCB3aWR0aD0iNCIgaGVpZ2h0PSI0IiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuMDUiLz4KPC9zdmc+')] opacity-20"></div>
    </div>

    <!-- Navigation -->
    <nav class="w-full flex items-center justify-between px-6 py-6 md:px-12 lg:px-24 animate-fade-in">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-400 to-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <span class="font-bold text-xl tracking-tight text-white">MediAPI</span>
        </div>
        
        <div class="flex gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2 text-sm font-medium rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors border border-white/5">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-medium rounded-full bg-transparent hover:bg-white/5 text-slate-300 hover:text-white transition-colors">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium rounded-full bg-indigo-500 hover:bg-indigo-600 text-white transition-colors shadow-lg shadow-indigo-500/25">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 md:px-12 lg:px-24 pt-20 pb-32 flex flex-col items-center text-center relative z-10">
        
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card mb-8 animate-slide-up" style="animation-delay: 0.1s;">
            <span class="flex h-2 w-2 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-sm font-medium text-slate-300">API v1.0 is now live</span>
        </div>

        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 animate-slide-up" style="animation-delay: 0.2s;">
            The modern <br class="hidden md:block">
            <span class="text-gradient">Medicine API</span>
        </h1>
        
        <p class="max-w-2xl text-lg md:text-xl text-slate-400 mb-10 animate-slide-up" style="animation-delay: 0.3s;">
            A fast, secure, and beautifully documented RESTful API for managing medical data, prescriptions, and pharmaceutical inventory. Built with Laravel.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 mb-20 animate-slide-up" style="animation-delay: 0.4s;">
            <a href="#" class="px-8 py-3.5 text-base font-semibold rounded-full bg-white text-slate-900 hover:bg-slate-100 transition-all hover:scale-105 shadow-[0_0_40px_rgba(255,255,255,0.3)]">
                Explore Endpoints
            </a>
            <a href="https://laravel.com/docs" target="_blank" class="px-8 py-3.5 text-base font-semibold rounded-full glass-card text-white hover:bg-white/10 transition-all flex items-center justify-center gap-2">
                <span>View Documentation</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full text-left animate-slide-up" style="animation-delay: 0.5s;">
            
            <!-- Card 1 -->
            <div class="glass-card p-8 rounded-2xl relative group overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="w-12 h-12 rounded-xl bg-cyan-500/20 flex items-center justify-center mb-6 border border-cyan-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">Lightning Search</h3>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Instantly query thousands of medicines, categories, and generic names with optimized indexing.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="glass-card p-8 rounded-2xl relative group overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="w-12 h-12 rounded-xl bg-indigo-500/20 flex items-center justify-center mb-6 border border-indigo-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">Secure Auth</h3>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Enterprise-grade authentication with Laravel Sanctum. Issue tokens safely for your front-end apps.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="glass-card p-8 rounded-2xl relative group overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center mb-6 border border-purple-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">Developer First</h3>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Clean JSON responses, standard HTTP status codes, and comprehensive error handling built-in.
                </p>
            </div>
            
        </div>
        
    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-white/5 py-8 mt-auto relative z-10">
        <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-24 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-slate-500 text-sm">
                &copy; {{ date('Y') }} Medicine API. Built with Laravel v{{ app()->version() }}.
            </p>
            <div class="flex items-center gap-4">
                <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.8)]"></div>
                <span class="text-slate-400 text-sm">All systems operational</span>
            </div>
        </div>
    </footer>

</body>
</html>
