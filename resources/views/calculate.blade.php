<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Hitung pajak penghasilan karyawan PT. XYZ secara otomatis berdasarkan tabel tarif pajak yang berlaku.">
    <title>Kalkulator Pajak Penghasilan — PT. XYZ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 flex items-center justify-center p-4">

    <div class="w-full max-w-lg">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-500/20 border border-blue-400/30 mb-4">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Kalkulator Pajak</h1>
            <p class="mt-1 text-slate-400 text-sm">PT. XYZ — Hitung pajak penghasilan karyawan</p>
        </div>

        {{-- Card --}}
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl shadow-2xl p-8">

            {{-- Validation / session error --}}
            @if (session('error'))
                <div id="error-alert"
                     class="flex items-start gap-3 mb-6 bg-red-500/15 border border-red-400/40 text-red-300 rounded-xl px-4 py-3 text-sm">
                    <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Form --}}
            <form id="tax-form" action="{{ route('calculate.submit') }}" method="POST" novalidate>
                @csrf

                <div class="mb-6">
                    <label for="income" class="block text-sm font-medium text-slate-300 mb-2">
                        Penghasilan Bruto (Rp)
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-4 flex items-center text-slate-400 text-sm font-medium pointer-events-none">
                            Rp
                        </span>
                        <input
                            id="income"
                            type="text"
                            name="income"
                            value="{{ old('income') }}"
                            placeholder="Contoh: 8000000"
                            maxlength="12"
                            inputmode="numeric"
                            autocomplete="off"
                            class="w-full bg-white/5 border border-white/15 text-white placeholder-slate-500 rounded-xl py-3 pl-10 pr-4
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        >
                    </div>
                </div>

                <button
                    id="submit-btn"
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-semibold rounded-xl py-3 px-6
                           transition duration-200 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-transparent">
                    Hitung Pajak
                </button>
            </form>

            {{-- Front-end validation --}}
            <script>
            (function () {
                const form    = document.getElementById('tax-form');
                const input   = document.getElementById('income');
                const MAX     = 999999999999;

                /**
                 * Show an inline error without a page reload.
                 * Reuses the same #error-alert element if present, or creates one.
                 */
                function showError(message) {
                    let alert = document.getElementById('error-alert');

                    if (! alert) {
                        alert = document.createElement('div');
                        alert.id = 'error-alert';
                        alert.className = 'flex items-start gap-3 mb-6 bg-red-500/15 border border-red-400/40 text-red-300 rounded-xl px-4 py-3 text-sm';
                        alert.innerHTML = '<svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" /></svg><span id="error-msg"></span>';
                        form.parentNode.insertBefore(alert, form);
                    }

                    document.getElementById('error-msg').textContent = message;
                    alert.classList.remove('hidden');
                    input.focus();
                }

                function clearError() {
                    const alert = document.getElementById('error-alert');
                    if (alert) { alert.classList.add('hidden'); }
                }

                form.addEventListener('submit', function (e) {
                    const raw = input.value.trim();

                    if (raw === '') {
                        e.preventDefault();
                        showError('Penghasilan tidak boleh kosong.');
                        return;
                    }

                    // Must be digits only — no letters, no dots, no minus
                    if (! /^\d+$/.test(raw)) {
                        e.preventDefault();
                        showError('Penghasilan harus berupa bilangan bulat positif (hanya angka, tanpa huruf atau desimal).');
                        return;
                    }

                    const value = parseInt(raw, 10);

                    if (value <= 0) {
                        e.preventDefault();
                        showError('Penghasilan harus lebih dari 0.');
                        return;
                    }

                    if (value > MAX) {
                        e.preventDefault();
                        showError('Penghasilan tidak boleh melebihi 999.999.999.999.');
                        return;
                    }

                    clearError();
                });

                // Clear inline error as user types
                input.addEventListener('input', clearError);
            })();
            </script>

            {{-- Result --}}
            @isset($taxAmount)
                <div id="result-card"
                     class="mt-8 rounded-2xl border border-blue-400/30 bg-blue-500/10 overflow-hidden">
                    <div class="px-6 py-4 border-b border-blue-400/20">
                        <h2 class="text-sm font-semibold text-blue-300 uppercase tracking-widest">Hasil Perhitungan</h2>
                    </div>

                    <div class="px-6 py-5 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 text-sm">Penghasilan</span>
                            <span class="text-white font-medium">
                                Rp {{ number_format($income, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 text-sm">Tarif Pajak</span>
                            <span class="text-white font-medium">
                                {{ number_format($percentage, 2) }}%
                            </span>
                        </div>

                        <div class="h-px bg-white/10"></div>

                        <div class="flex justify-between items-center">
                            <span class="text-slate-300 font-semibold">Pajak Terutang</span>
                            <span class="text-2xl font-bold text-blue-300">
                                Rp {{ number_format($taxAmount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endisset

        </div>

        <p class="mt-6 text-center text-xs text-slate-600">
            Berdasarkan tabel tarif PPh yang berlaku &mdash; PT. XYZ &copy; {{ date('Y') }}
        </p>
    </div>

</body>
</html>
