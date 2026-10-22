@if($payments->count())
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="divide-y divide-slate-50">
            @foreach($payments as $p)
                <div class="group flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 gap-3 sm:gap-0 hover:bg-slate-50/50 transition-all duration-300">
                    <div class="flex items-center gap-4 sm:gap-5 w-full sm:w-auto">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 shrink-0 bg-red-50 rounded-xl sm:rounded-2xl flex items-center justify-center text-red-700 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-black text-slate-800 tracking-tight">#{{ $p->id }}</span>
                                @if($p->order)
                                    <span class="text-[10px] font-black bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md uppercase">{{ $p->order->invoice }}</span>
                                @endif
                            </div>
                            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-0.5">
                                {{ $p->created_at->format('d M Y • H:i') }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end gap-4 sm:gap-8 w-full sm:w-auto mt-2 sm:mt-0 pt-3 sm:pt-0 border-t border-slate-50 sm:border-0">
                        <div class="text-left sm:text-right">
                            <div class="text-[10px] sm:text-sm text-slate-400 font-bold uppercase tracking-widest leading-none mb-1">Total</div>
                            <div class="text-xl font-black text-slate-900 tracking-tighter">
                                <span class="text-xs text-red-700 mr-0.5">Rp</span>{{ number_format($p->amount,0,',','.') }}
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('payments.show', $p) }}" class="p-2 sm:p-2.5 text-xs sm:text-sm font-bold text-slate-400 hover:text-red-700 hover:bg-red-50 rounded-xl transition-all" title="Detail">Detail</a>
                            <form action="{{ route('payments.destroy', $p) }}" method="POST" class="inline-block m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 sm:p-2.5 text-xs sm:text-sm font-bold text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" title="Hapus">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($payments, 'hasPages') && $payments->hasPages())
            <div class="p-6 bg-slate-50/50 border-t border-slate-100">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
@else
    <div class="py-20 flex flex-col items-center justify-center text-center">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="1.5"/></svg>
        </div>
        <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Data Kosong</h3>
        <p class="text-slate-400 text-sm font-medium">Belum ada catatan pembayaran yang ditemukan.</p>
    </div>
@endif
