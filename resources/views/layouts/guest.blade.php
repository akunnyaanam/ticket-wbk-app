<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    @include('partials.head') {{-- Pastikan fluxStyles / meta tags ada di sini --}}
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 font-sans antialiased selection:bg-blue-500 selection:text-white">

    {{-- A. BACKGROUND GRID (Adaptif Light/Dark) --}}
    {{-- Kita buat grid ini pudar di bagian bawah (mask-image) agar menyatu dengan konten --}}
    <div class="absolute inset-0 -z-10 h-full w-full [mask-image:linear-gradient(to_bottom,white_50%,transparent_100%)]">
        {{-- Grid Pattern: Abu-abu gelap di Light Mode, Putih transparan di Dark Mode --}}
        <div class="absolute h-full w-full bg-[linear-gradient(to_right,#00000008_1px,transparent_1px),linear-gradient(to_bottom,#00000008_1px,transparent_1px)] dark:bg-[linear-gradient(to_right,#ffffff08_1px,transparent_1px),linear-gradient(to_bottom,#ffffff08_1px,transparent_1px)] bg-[size:24px_24px]"></div>
    </div>

    {{-- B. GLOW EFFECT (Aurora) --}}
    {{-- Opacity dikurangi sedikit di light mode agar tidak terlalu silau --}}
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 dark:opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>


    {{-- 2. MOBILE SIDEBAR --}}
    <flux:sidebar stashable sticky class="lg:hidden border-r border-zinc-200 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md dark:border-zinc-800">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <flux:brand href="{{ route('home') }}" class="px-2 mb-4">
            <div class="bg-white p-1.5 rounded-xl shadow-sm border border-zinc-200">
                <img src="{{ asset('assets/images/logo.svg') }}" class="h-8 w-auto" alt="BengTix">
            </div>
        </flux:brand>

        <div class="px-2 mb-4">
            <form action="{{ route('home') }}" method="GET">
                <flux:input name="search" icon="magnifying-glass" placeholder="Cari Event..." value="{{ request('search') }}" class="bg-white dark:bg-zinc-800" />
            </form>
        </div>

        <flux:navlist>
            <flux:navlist.item href="{{ route('home') }}" icon="home" :current="request()->routeIs('home')">Home</flux:navlist.item>
            @auth
                <flux:navlist.item href="{{ route('dashboard') }}" icon="layout-grid">Dashboard</flux:navlist.item>
                <flux:navlist.item href="{{ route('profile.edit') }}" icon="cog">Settings</flux:navlist.item>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:navlist.item as="button" type="submit" icon="arrow-right-start-on-rectangle">Log Out</flux:navlist.item>
                </form>
            @else
                <flux:navlist.item href="{{ route('login') }}" icon="arrow-right-end-on-rectangle">Login</flux:navlist.item>
                <flux:navlist.item href="{{ route('register') }}" icon="user-plus">Register</flux:navlist.item>
            @endauth
        </flux:navlist>
    </flux:sidebar>

    {{-- 3. DESKTOP NAVBAR (Sticky & Glass Effect) --}}
    {{-- sticky top-0 z-40 backdrop-blur-md: Kunci efek kaca --}}
    <flux:header container class="sticky top-0 z-40 w-full border-b border-zinc-200/50 dark:border-white/10 bg-white/70 dark:bg-zinc-950/70 backdrop-blur-md transition-all duration-300">

        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <a href="{{ route('home') }}" class="flex items-center gap-2 mr-8 group">
            <div class="h-10 px-2 flex items-center justify-center bg-white rounded-lg shadow-sm border border-zinc-200 transition group-hover:scale-105 group-hover:shadow-md">
                <img src="{{ asset('assets/images/logo.svg') }}" class="h-6 w-auto" alt="BengTix">
            </div>
        </a>

        <div class="hidden lg:block w-full max-w-md">
            <form action="{{ route('home') }}" method="GET">
                {{-- Input dibuat agak transparan agar menyatu --}}
                <flux:input
                    name="search"
                    icon="magnifying-glass"
                    placeholder="Cari Event..."
                    value="{{ request('search') }}"
                    class="w-full bg-zinc-50/50 dark:bg-white/5 border-zinc-200 dark:border-white/10 focus:bg-white dark:focus:bg-zinc-900 transition-colors"
                />
            </form>
        </div>

        <flux:spacer />

        <flux:navbar class="hidden lg:flex gap-2">
            @auth
                <flux:navbar.item :href="route('dashboard')" icon="layout-grid">Dashboard</flux:navbar.item>
                <flux:dropdown position="bottom" align="end">
                    <flux:profile
                        class="cursor-pointer"
                        :avatar="auth()->user()->avatar_url ?? null"
                        :initials="auth()->user()->initials()"
                        :name="auth()->user()->name"
                    />
                    <flux:menu>
                        <flux:menu.item :href="route('profile.edit')" icon="cog">Settings</flux:menu.item>
                        <flux:menu.separator />
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                                Log Out
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            @else
                <flux:button :href="route('login')" variant="ghost" class="font-semibold">Masuk</flux:button>
                <flux:button :href="route('register')" variant="filled">Daftar</flux:button>
            @endauth
        </flux:navbar>
    </flux:header>

    {{-- 4. MAIN CONTENT --}}
    <main class="flex-1 w-full relative z-0">
        {{ $slot }}
    </main>

    {{-- 5. FOOTER --}}
    <footer class="relative z-10 border-t border-zinc-200 dark:border-zinc-800 bg-white/50 dark:bg-zinc-950/50 backdrop-blur-sm py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-6 text-center lg:text-left flex flex-col lg:flex-row justify-between items-center gap-6">
            <div>
                <div class="inline-block bg-white p-2 rounded-xl shadow-sm border border-zinc-200 mb-2">
                    <img src="{{ asset('assets/images/logo.svg') }}" class="h-6 w-auto" alt="BengTix">
                </div>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">© {{ date('Y') }} BengTix. Platform tiket masa kini.</p>
            </div>

            <div class="flex gap-6 text-sm font-medium text-zinc-600 dark:text-zinc-400">
                <a href="#" class="hover:text-zinc-900 dark:hover:text-white transition">Tentang Kami</a>
                <a href="#" class="hover:text-zinc-900 dark:hover:text-white transition">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-zinc-900 dark:hover:text-white transition">Bantuan</a>
            </div>
        </div>
    </footer>

    {{-- D. GLOW EFFECT BAWAH --}}
    <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
        <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 dark:opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>
    @livewire('notifications')
    @livewireScripts
    @filamentScripts
    @fluxScripts
    @vite('resources/js/app.js')
</body>
</html>
