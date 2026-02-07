<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Seu Progresso</h2>

        @if($graduations->count() > 0)
            <div class="space-y-4">
                @foreach($graduations as $graduation)
                    <div class="bg-white dark:bg-slate-900 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <h3 class="font-bold text-slate-900 dark:text-white">{{ $graduation->modality->name }}</h3>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Faixa: <strong>{{ $graduation->rank }}</strong></p>
                            </div>
                            <div class="text-right">
                                @if($graduation->achieved_at)
                                    <p class="text-xs text-slate-500 dark:text-slate-500">
                                        {{ $graduation->achieved_at->format('d/m/Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-lg p-8 text-center">
                <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <p class="text-slate-600 dark:text-slate-400">Nenhum progresso registrado ainda</p>
            </div>
        @endif
    </div>
</div>
