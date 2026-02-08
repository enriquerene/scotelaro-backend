<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-700 dark:to-blue-800 rounded-xl p-6 text-white shadow-lg">
        <h2 class="text-2xl font-bold mb-2">Bem-vindo, {{ auth()->user()->name }}!</h2>
        <p class="text-blue-100">{{ now()->format('l, d \d\e F') }}</p>
    </div>

    <!-- Subscription Status -->
    @if($subscriptionActive)
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="font-semibold text-green-900 dark:text-green-100">Inscrição Ativa</p>
                    <p class="text-sm text-green-700 dark:text-green-300">Seu plano está ativo e você pode participar das aulas</p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-semibold text-yellow-900 dark:text-yellow-100">Sem Inscrição Ativa</p>
                        <p class="text-sm text-yellow-700 dark:text-yellow-300">Complete seu cadastro para começar</p>
                    </div>
                </div>
                <a href="#" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition font-medium">
                    Inscrever-se
                </a>
            </div>
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
        <div class="bg-white dark:bg-slate-900 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Turmas Inscritas</p>
            <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $enrollmentCount }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Próximas</p>
            <p class="text-3xl font-bold text-slate-900 dark:text-white">3</p>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Presença</p>
            <p class="text-3xl font-bold text-slate-900 dark:text-white">85%</p>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-lg p-4 border border-slate-200 dark:border-slate-800">
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Faixa</p>
            <p class="text-3xl font-bold text-slate-900 dark:text-white">Blue</p>
        </div>
    </div>

    <!-- Upcoming Classes -->
    @if($upcomingClasses->count() > 0)
        <div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Próximas Aulas</h3>
            <div class="space-y-3">
                @foreach($upcomingClasses as $enrollment)
                    <div class="bg-white dark:bg-slate-900 rounded-lg p-4 border border-slate-200 dark:border-slate-800 hover:border-blue-400 dark:hover:border-blue-600 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="font-semibold text-slate-900 dark:text-white">{{ $enrollment->gymClass->name }}</h4>
                                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $enrollment->gymClass->modality->name }}</p>
                                @if($enrollment->gymClass->instructor)
                                    <p class="text-sm text-slate-500 dark:text-slate-500">Com {{ $enrollment->gymClass->instructor->name }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-medium">
                                    Inscrito
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
