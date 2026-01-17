<div class="py-12 bg-zinc-50 dark:bg-zinc-950 min-h-screen">
    <div class="max-w-5xl mx-auto px-6">

        {{-- Breadcrumb / Back --}}
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-zinc-800 dark:hover:text-white mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Home
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left Column: Event Details --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-zinc-900 rounded-2xl p-6 border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <div class="flex gap-6">
                        {{-- Event Image Thumbnail --}}
                        <div class="w-24 h-24 sm:w-32 sm:h-32 flex-shrink-0 bg-zinc-200 dark:bg-zinc-800 rounded-xl overflow-hidden">
                             @php
                                $img = $event->image_path;
                                $url = (!$img) ? asset('assets/images/default-event.jpg') : (filter_var($img, FILTER_VALIDATE_URL) ? $img : asset('storage/' . $img));
                            @endphp
                            <img src="{{ $url }}" class="w-full h-full object-cover">
                        </div>

                        <div>
                            <span class="inline-block px-2.5 py-1 rounded-md text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 mb-2">
                                {{ $event->category->name }}
                            </span>
                            <h1 class="text-2xl font-black text-zinc-900 dark:text-white mb-2 leading-tight">
                                {{ $event->title }}
                            </h1>
                            <p class="text-zinc-500 text-sm flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                                </svg>
                                {{ \Carbon\Carbon::parse($event->datetime)->translatedFormat('d F Y, H:i') }}
                            </p>
                            <p class="text-zinc-500 text-sm flex items-center gap-2 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                {{ $event->location }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Ticket Selection --}}
                <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/50">
                        <h3 class="font-bold text-zinc-900 dark:text-white">Pilih Tiket</h3>
                    </div>

                    <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach($event->tickets as $ticket)
                            <div class="p-6 flex flex-col sm:flex-row justify-between items-center gap-4 {{ $ticket->stock == 0 ? 'opacity-50 grayscale' : '' }}">
                                <div class="flex-1">
                                    <div class="font-bold text-lg text-zinc-900 dark:text-white">{{ $ticket->type }}</div>
                                    <div class="text-sm text-zinc-500 mb-1">Stok: {{ $ticket->stock }}</div>
                                    <div class="font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($ticket->price, 0, ',', '.') }}</div>
                                </div>

                                <div>
                                    @if($ticket->stock > 0)
                                        <div class="flex items-center border border-zinc-300 dark:border-zinc-700 rounded-lg overflow-hidden">
                                            {{-- Minus Button --}}
                                            <button
                                                wire:click="$set('quantities.{{ $ticket->id }}', {{ max(0, ($quantities[$ticket->id] ?? 0) - 1) }})"
                                                class="px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-300 transition"
                                            >
                                                -
                                            </button>

                                            {{-- Input Display --}}
                                            <input
                                                type="number"
                                                wire:model.live="quantities.{{ $ticket->id }}"
                                                class="w-12 text-center border-none bg-transparent text-zinc-900 dark:text-white focus:ring-0 p-0"
                                                min="0"
                                                max="{{ $ticket->stock }}"
                                            >

                                            {{-- Plus Button --}}
                                            <button
                                                wire:click="$set('quantities.{{ $ticket->id }}', {{ min($ticket->stock, ($quantities[$ticket->id] ?? 0) + 1) }})"
                                                class="px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-300 transition"
                                            >
                                                +
                                            </button>
                                        </div>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-600 rounded-md text-xs font-bold uppercase">Habis</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Column: Order Summary (Sticky) --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-lg p-6">
                        <h3 class="font-bold text-lg text-zinc-900 dark:text-white mb-4">Ringkasan Pesanan</h3>

                        {{-- List of selected tickets --}}
                        <div class="space-y-3 mb-6">
                            @php $hasItem = false; @endphp
                            @foreach($event->tickets as $ticket)
                                @if(($quantities[$ticket->id] ?? 0) > 0)
                                    @php $hasItem = true; @endphp
                                    <div class="flex justify-between text-sm">
                                        <span class="text-zinc-600 dark:text-zinc-400">{{ $quantities[$ticket->id] }}x {{ $ticket->type }}</span>
                                        <span class="font-medium text-zinc-900 dark:text-white">
                                            Rp {{ number_format($ticket->price * $quantities[$ticket->id], 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endif
                            @endforeach

                            @if(!$hasItem)
                                <p class="text-sm text-zinc-400 italic">Belum ada tiket dipilih.</p>
                            @endif
                        </div>

                        <div class="border-t border-dashed border-zinc-200 dark:border-zinc-700 pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-zinc-900 dark:text-white">Total Bayar</span>
                                <span class="font-black text-xl text-blue-600 dark:text-blue-400">
                                    Rp {{ number_format($this->total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- Error Message --}}
                        @error('global')
                            <div class="mb-4 p-3 bg-red-50 text-red-600 text-sm rounded-lg">
                                {{ $message }}
                            </div>
                        @enderror

                        <button
                            wire:click="checkout"
                            wire:loading.attr="disabled"
                            class="w-full py-3.5 rounded-xl bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center gap-2"
                        >
                            <span wire:loading.remove>Bayar Sekarang</span>
                            <span wire:loading>Memproses...</span>
                        </button>

                        <p class="text-xs text-center text-zinc-400 mt-4">
                            Dengan melanjutkan, Anda menyetujui S&K BengTix.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
