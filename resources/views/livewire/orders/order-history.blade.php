<div class="flex h-full w-full flex-1 flex-col gap-4">
    <div class="h-px w-full bg-zinc-200 dark:bg-zinc-700 md:hidden"></div>

    <div class="mx-auto w-full max-w-5xl px-4 py-6 md:px-6 lg:px-8">
        <header class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white tracking-tight">
                        Riwayat Pembelian
                    </h1>

                    <p class="mt-2 text-base text-zinc-500 dark:text-zinc-400">
                        @if(auth()->user()->role === \App\Enums\UserRole::ADMIN)
                            Memantau seluruh transaksi pembelian tiket dari semua pengguna.
                        @else
                            Daftar tiket event yang telah Anda beli. Tunjukkan ini saat check-in.
                        @endif
                    </p>
                </div>

                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Ke Beranda
                </a>
            </div>
        </header>

        {{-- FILTER BAR (Baru) --}}
                <div class="mb-6 p-4 bg-zinc-50 dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 flex flex-col md:flex-row items-center gap-4">

                    {{-- Label --}}
                    <div class="text-sm font-medium text-zinc-600 dark:text-zinc-400 whitespace-nowrap">
                        Filter Tanggal:
                    </div>

                    <div class="flex flex-1 flex-col sm:flex-row gap-3 w-full">
                        {{-- Input Start Date --}}
                        <div class="relative w-full">
                            <input
                                type="date"
                                wire:model.live="startDate"
                                class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-zinc-400">
                                <span class="text-xs">Dari</span>
                            </div>
                        </div>

                        {{-- Input End Date --}}
                        <div class="relative w-full">
                            <input
                                type="date"
                                wire:model.live="endDate"
                                class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-zinc-400">
                                <span class="text-xs">Sampai</span>
                            </div>
                        </div>
                    </div>

                    @if($startDate || $endDate)
                        <button
                            wire:click="$set('startDate', ''); $set('endDate', '')"
                            class="text-sm text-red-600 hover:text-red-800 font-medium whitespace-nowrap hover:underline transition"
                        >
                            Reset Filter
                        </button>
                    @endif
                </div>

        <div class="space-y-6">
            @forelse($orders as $order)
                <div class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden shadow-sm">

                    <div class="p-6 bg-zinc-50/50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700 flex flex-col md:flex-row justify-between md:items-start gap-4">
                        <div class="flex gap-4">
                            <div class="h-16 w-16 flex-shrink-0 bg-zinc-200 dark:bg-zinc-700 rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-600">
                                @php
                                    $img = $order->event->image_path;
                                    $url = (!$img) ? asset('assets/images/default-event.jpg') : (filter_var($img, FILTER_VALIDATE_URL) ? $img : asset('storage/' . $img));
                                @endphp
                                <img src="{{ $url }}" class="w-full h-full object-cover">
                            </div>

                            <div>
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-white leading-tight">
                                    {{ $order->event->title }}
                                </h3>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 flex flex-col sm:flex-row gap-1 sm:gap-4">
                                    <span class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($order->event->datetime)->format('d M Y, H:i') }}
                                    </span>
                                    <span class="hidden sm:inline text-zinc-300 dark:text-zinc-600">|</span>
                                    <span class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        {{ $order->event->location }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="text-left md:text-right flex flex-col items-start md:items-end">
                            <span class="inline-flex items-center rounded-md bg-zinc-100 dark:bg-zinc-700 px-2 py-1 text-xs font-medium text-zinc-600 dark:text-zinc-300 ring-1 ring-inset ring-zinc-500/10">
                                Order #{{ $order->id }}
                            </span>
                            <div class="text-xs text-zinc-500 mt-1">
                                {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }} WIB
                            </div>
                            @if(auth()->user()->role === \App\Enums\UserRole::ADMIN)
                                <div class="text-xs font-bold text-blue-600 mt-1 bg-blue-50 px-2 py-0.5 rounded">
                                    User: {{ $order->user->name }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="p-0">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-zinc-500 uppercase bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-100 dark:border-zinc-700">
                                    <tr>
                                        <th class="px-6 py-3 font-medium">Tipe Tiket</th>
                                        <th class="px-6 py-3 text-center font-medium">Qty</th>
                                        <th class="px-6 py-3 text-right font-medium">Harga Satuan</th>
                                        <th class="px-6 py-3 text-right font-medium">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                                    @foreach($order->orderDetails as $detail)
                                        <tr>
                                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                                {{ $detail->ticket->type ?? 'Tiket Dihapus' }}
                                            </td>
                                            <td class="px-6 py-4 text-center text-zinc-600 dark:text-zinc-400">
                                                x{{ $detail->quantity }}
                                            </td>
                                            <td class="px-6 py-4 text-right text-zinc-500 dark:text-zinc-400">
                                                Rp {{ number_format($detail->ticket->price ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 text-right font-bold text-zinc-900 dark:text-zinc-200">
                                                Rp {{ number_format($detail->sub_total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
                        <div class="text-sm text-zinc-500 flex items-center gap-2">
                            Status:
                            <span class="inline-flex items-center gap-1 text-green-600 dark:text-green-400 font-bold bg-green-50 dark:bg-green-900/20 px-2 py-0.5 rounded-full text-xs">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-3">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd" />
                                </svg>
                                Lunas
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Bayar:</span>
                            <span class="text-xl font-black text-blue-600 dark:text-blue-400">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white dark:bg-zinc-900 rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700">
                    <div class="mx-auto w-16 h-16 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-zinc-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v4.086c0 .621.504 1.125 1.125 1.125s1.125.504 1.125 1.125V12.75c0 .621.504 1.125 1.125 1.125s1.125.504 1.125 1.125V18.75c0 .621.504 1.125 1.125 1.125S5.25 21 7.5 21h9c2.25 0 4.125-1.875 4.125-4.125V12.75c0-.621.504-1.125 1.125-1.125s1.125-.504 1.125-1.125V12.75c0-.621-.504-1.125-1.125-1.125S20.625 11.25 20.625 10.125V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Belum ada riwayat pembelian</h3>
                    <p class="text-zinc-500 mb-6 max-w-sm mx-auto">Anda belum membeli tiket event apapun. Yuk cari event seru sekarang!</p>

                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold rounded-lg hover:bg-zinc-700 dark:hover:bg-zinc-200 transition">
                        Cari Event Sekarang
                    </a>
                </div>
            @endforelse

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
