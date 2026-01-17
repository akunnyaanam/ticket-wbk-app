<div class="relative">
    {{-- 1. HERO SECTION --}}
    {{-- Perbaikan: Hapus bg-zinc-950, ganti jadi transparan/adaptif agar ikut Layout --}}
    <div class="relative pt-20 pb-20 lg:pt-32 lg:pb-32 overflow-hidden isolate">

        {{-- C. KONTEN UTAMA --}}
        <div class="relative max-w-7xl mx-auto px-6 text-center">

            {{-- Badge --}}
            <div class="mb-8 flex justify-center">
                <div class="relative rounded-full px-3 py-1 text-sm leading-6 text-zinc-600 dark:text-zinc-400 ring-1 ring-zinc-900/10 dark:ring-white/10 hover:ring-zinc-900/20 dark:hover:ring-white/20 transition cursor-default bg-white/50 dark:bg-white/5 backdrop-blur-sm">
                    Platform tiket event termudah. <span class="font-semibold text-blue-600 dark:text-blue-400">Versi 2.0</span>
                </div>
            </div>

            {{-- Headline: Warna teks adaptif (Hitam di Light, Putih di Dark) --}}
            <h1 class="text-4xl md:text-6xl font-black tracking-tight text-zinc-900 dark:text-white mb-6">
                Amankan <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-500">Tiketmu</span> Sekarang.
            </h1>

            <p class="text-lg md:text-xl text-zinc-600 dark:text-zinc-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                BengTix hadir untuk mempermudah hidupmu. Beli tiket konser, seminar, dan event seru lainnya tanpa ribet, auto asik.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4 items-center">
                 {{-- Button Utama: Hitam di Light, Putih di Dark --}}
                 <a href="#event-list" class="group relative inline-flex items-center gap-2 px-8 py-3.5 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-blue-400 dark:text-blue-600">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v10.586l3.293-3.293a1 1 0 111.414 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 111.414-1.414L9 14.586V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Cari Tiket
                 </a>

                 {{-- Button Secondary --}}
                 <a href="#" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition">
                    Pelajari Cara Kerja <span aria-hidden="true">→</span>
                 </a>
            </div>
        </div>

    </div>

    {{-- 2. MAIN CONTENT --}}
    <div id="event-list" class="max-w-7xl mx-auto px-6 py-12 min-h-screen">
        {{-- Header & Filter --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-6">
            <div class="text-left w-full md:w-auto">
                <h2 class="text-2xl md:text-3xl font-black italic uppercase text-zinc-900 dark:text-white mb-1">
                    Event Terbaru
                </h2>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm md:text-base">
                    Jangan sampai kehabisan tiket favoritmu
                </p>
            </div>

            <div class="flex flex-wrap gap-2 justify-center md:justify-end w-full md:w-auto">
                <button
                    wire:click="$set('kategori', '')"
                    class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200 border {{ $this->kategori == '' ? 'bg-zinc-900 text-white border-zinc-900 dark:bg-white dark:text-zinc-900' : 'bg-white text-zinc-600 border-zinc-200 hover:border-zinc-300 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700' }}"
                >
                    Semua
                </button>
                @foreach($categories as $cat)
                    <button
                        wire:click="$set('kategori', {{ $cat->id }})"
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200 border {{ $this->kategori == $cat->id ? 'bg-zinc-900 text-white border-zinc-900 dark:bg-white dark:text-zinc-900' : 'bg-white text-zinc-600 border-zinc-200 hover:border-zinc-300 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700' }}"
                    >
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- 3. EVENT GRID --}}
        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($events as $event)
                    <div class="flex flex-col h-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 group relative">
                        {{-- Image Wrapper --}}
                        <div class="relative h-48 bg-zinc-100 dark:bg-zinc-800 overflow-hidden cursor-pointer" wire:click="showEvent({{ $event->id }})">
                            @php
                                $imagePath = $event->image_path;
                                if (!$imagePath) {
                                    $imageUrl = asset('assets/images/default-event.jpg');
                                } elseif (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                    $imageUrl = $imagePath;
                                } else {
                                    $imageUrl = asset('storage/' . $imagePath);
                                }
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-white/90 text-zinc-900 shadow-sm backdrop-blur-sm dark:bg-zinc-900/90 dark:text-white">
                                    {{ $event->category->name ?? 'Event' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2 line-clamp-2 leading-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors cursor-pointer" wire:click="showEvent({{ $event->id }})">
                                {{ $event->title }}
                            </h3>
                            <div class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-zinc-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($event->datetime)->translatedFormat('d F Y, H:i') }}</span>
                            </div>

                            <div class="mt-auto space-y-4">
                                <div class="flex items-start gap-2 text-sm text-zinc-600 dark:text-zinc-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-zinc-400 mt-0.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <span class="line-clamp-1">{{ $event->location }}</span>
                                </div>
                                <div class="w-full border-t border-dashed border-zinc-200 dark:border-zinc-700"></div>
                                <div class="flex justify-between items-center">
                                    <div class="flex flex-col">
                                        <span class="text-xs text-zinc-400 font-medium uppercase">Mulai dari</span>
                                        <span class="font-bold text-lg text-blue-600 dark:text-blue-400">
                                            Rp {{ number_format($event->tickets->min('price') ?? 0, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    {{-- TOMBOL ACTION: Membuka Modal --}}
                                    <button wire:click="showEvent({{ $event->id }})" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 text-sm font-medium rounded-lg shadow-sm hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-colors duration-200">
                                        Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="bg-zinc-100 dark:bg-zinc-800 p-6 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 text-zinc-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Tidak ada event ditemukan</h3>
                <p class="text-zinc-500 max-w-md mx-auto mb-6">Sepertinya belum ada event untuk kategori ini.</p>
                <button wire:click="$set('kategori', '')" class="inline-flex items-center px-4 py-2 text-sm font-medium text-zinc-900 dark:text-zinc-100 bg-transparent hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors duration-200">
                    Reset Filter
                </button>
            </div>
        @endif
    </div>

        @if($selectedEvent)
            @teleport('body')
                <div class="fixed inset-0 z-[999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">

                    <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

                    <div class="flex min-h-full items-start justify-center p-4 text-center sm:items-center sm:p-0">

                        <div class="relative transform overflow-hidden rounded-3xl text-left shadow-2xl transition-all w-full sm:max-w-4xl my-8
                                    bg-white/80 dark:bg-zinc-900/80 backdrop-blur-2xl
                                    ring-1 ring-zinc-900/5 dark:ring-white/10">

                            <button wire:click="closeModal" class="absolute top-4 right-4 z-30 p-2.5 rounded-full bg-black/40 text-white hover:bg-black/60 backdrop-blur-md transition-all focus:outline-none group">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <div class="flex flex-col">

                                <div class="relative w-full h-72 sm:h-96 bg-zinc-200 dark:bg-zinc-800">
                                    @php
                                        $modalImg = $selectedEvent->image_path;
                                        if (!$modalImg) {
                                            $modalImgUrl = asset('assets/images/default-event.jpg');
                                        } elseif (filter_var($modalImg, FILTER_VALIDATE_URL)) {
                                            $modalImgUrl = $modalImg;
                                        } else {
                                            $modalImgUrl = asset('storage/' . $modalImg);
                                        }
                                    @endphp
                                    <img src="{{ $modalImgUrl }}" alt="{{ $selectedEvent->title }}" class="w-full h-full object-cover">

                                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-900/90 via-zinc-900/40 to-transparent"></div>

                                    <div class="absolute bottom-0 left-0 w-full p-6 sm:p-10 text-white z-10">
                                        <div class="flex items-center gap-3 mb-3 opacity-90">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-500/80 backdrop-blur-md border border-blue-400/30 text-white shadow-sm">
                                                {{ $selectedEvent->category->name }}
                                            </span>
                                            <span class="flex items-center gap-1.5 text-sm font-medium bg-black/30 px-3 py-1 rounded-full backdrop-blur-md border border-white/10">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($selectedEvent->datetime)->translatedFormat('d F Y, H:i') }}
                                            </span>
                                        </div>

                                        <h2 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight drop-shadow-lg max-w-3xl">
                                            {{ $selectedEvent->title }}
                                        </h2>
                                    </div>
                                </div>

                                <div class="p-6 sm:p-10 grid grid-cols-1 lg:grid-cols-3 gap-8 sm:gap-12">

                                    <div class="lg:col-span-2 space-y-8">

                                        <div class="flex items-start gap-4 p-5 rounded-2xl bg-white/50 dark:bg-zinc-800/50 border border-zinc-200/50 dark:border-zinc-700/50">
                                            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl text-blue-600 dark:text-blue-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-500 mb-1">Lokasi Event</h4>
                                                <p class="text-lg font-medium text-zinc-900 dark:text-zinc-100 leading-snug">
                                                    {{ $selectedEvent->location }}
                                                </p>
                                            </div>
                                        </div>

                                        <div>
                                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                                                Tentang Event
                                                <span class="h-px flex-1 bg-zinc-200 dark:bg-zinc-700"></span>
                                            </h3>
                                            <div class="prose prose-lg prose-zinc dark:prose-invert max-w-none text-zinc-600 dark:text-zinc-300 leading-relaxed">
                                                {{ $selectedEvent->description ?? 'Tidak ada deskripsi detail untuk event ini.' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="lg:col-span-1">
                                        <div class="bg-white/60 dark:bg-zinc-800/40 rounded-2xl p-6 border border-zinc-200/50 dark:border-zinc-700/50 shadow-sm sticky top-6">
                                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-6">Pilih Tiket</h3>

                                            <div class="space-y-4">
                                                @foreach($selectedEvent->tickets as $tiket)
                                                    <div class="group relative p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 hover:border-blue-500 dark:hover:border-blue-500 hover:shadow-md transition-all cursor-pointer">

                                                        {{-- Link Full Cover --}}
                                                        <a href="{{ route('orders.create', $selectedEvent->id) }}" class="absolute inset-0 z-10"></a>

                                                        <div class="flex justify-between items-start mb-2">
                                                            <span class="font-bold text-zinc-900 dark:text-white group-hover:text-blue-600 transition-colors">
                                                                {{ $tiket->name }}
                                                            </span>
                                                            <span class="font-black text-blue-600 dark:text-blue-400">
                                                                {{ number_format($tiket->price, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                        <p class="text-xs text-zinc-500 leading-relaxed">
                                                            {{ $tiket->description }}
                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="mt-6 pt-6 border-t border-zinc-200/50 dark:border-zinc-700/50">
                                                <a href="{{ route('orders.create', $selectedEvent->id) }}" class="flex w-full items-center justify-center rounded-xl bg-zinc-900 dark:bg-white px-6 py-3.5 text-sm font-bold text-white dark:text-zinc-900 shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                                                    Beli Tiket Sekarang
                                                </a>
                                                <p class="text-center text-xs text-zinc-400 mt-3">
                                                    Transaksi aman & instan via BengTix
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endteleport
        @endif
