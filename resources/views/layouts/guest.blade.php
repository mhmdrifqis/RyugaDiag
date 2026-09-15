<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RyugaDiag') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 overflow-hidden selection:bg-accent selection:text-white">
        <!-- Background Image with Overlay -->
        <div class="fixed inset-0 z-0">
            <!-- Nanti URL ini bisa Anda ganti dengan direktori gambar lokal Anda, misalnya asset('images/bmw-bg.jpg') -->
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat transform scale-105" 
                 style="background-image: url('https://4kwallpapers.com/images/walls/thumbs_3t/4207.jpeg'); filter: brightness(0.9);">
            </div>
            <!-- Dark overlay for better contrast & readability -->
            <div class="absolute inset-0 bg-[#1a252f]/70"></div>
        </div>

        <div class="relative z-10 min-h-screen flex items-center justify-center px-6">
            <div class="w-full max-w-[420px] flex flex-col items-center">
                <!-- Brand Logo -->
                <div class="mb-10 flex flex-col items-center gap-4 animate-fade-in-down text-center">
                    <img src="{{ asset('image/ryugadiag_logo.jpg') }}" alt="RyugaDiag Logo" class="w-20 h-20 rounded-2xl shadow-[0_4px_15px_rgba(0,0,0,0.5)] border border-white/20 object-cover">
                    <div>
                        <h1 class="text-4xl font-bold text-white tracking-wide drop-shadow-md mt-2">RyugaDiag</h1>
                        <p class="text-accent text-sm font-semibold tracking-wider uppercase mt-1">Sistem Pakar BMW Seri 3</p>
                    </div>
                </div>

                <!-- Glassmorphism Form Container -->
                <div class="w-full px-8 py-10 backdrop-blur-md bg-white/10 border border-white/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.36)] rounded-3xl relative overflow-hidden group transition-all duration-500 hover:bg-white/15 hover:border-white/30 hover:shadow-[0_8px_32px_0_rgba(0,0,0,0.5)]">
                    
                    <!-- Decorative Light Reflection -->
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-white/20 rounded-full blur-3xl pointer-events-none group-hover:bg-white/30 transition-all duration-500"></div>

                    {{ $slot }}
                </div>
                
                <div class="mt-8 text-white/40 text-xs text-left ml-2 font-medium">
                    &copy; {{ date('Y') }} RyugaDiag. All rights reserved.
                </div>
            </div>
        </div>
    </body>
</html>
