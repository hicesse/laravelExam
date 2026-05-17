<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Hitung pajak penghasilan karyawan PT. XYZ secara otomatis berdasarkan tabel tarif pajak yang berlaku.">
    <title>Kalkulator Pajak Penghasilan — PT. XYZ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900 flex flex-col">

    {{-- Top bar --}}
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-2xl px-4 py-3 flex items-center gap-3">
            <div class="flex items-center justify-center w-8 h-8 rounded bg-blue-600">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="text-sm font-semibold text-slate-700 tracking-wide">PT. XYZ</span>
            <span class="text-slate-300 text-sm">|</span>
            <span class="text-sm text-slate-500">Sistem Penggajian</span>
        </div>
    </header>

    {{-- Main content --}}
    <main class="flex-1 flex items-start justify-center px-4 py-10 sm:py-16">
        <div class="w-full max-w-lg">

            {{-- Page heading --}}
            <div class="mb-8">
                <p class="text-xs font-semibold uppercase tracking-widest text-blue-600 mb-1">Modul Perpajakan</p>
                <h1 class="text-2xl font-bold text-slate-900 leading-snug">Kalkulator Pajak Penghasilan</h1>
                <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                    Hitung estimasi pajak penghasilan karyawan berdasarkan tarif PPh yang berlaku di PT. XYZ.
                    Masukkan penghasilan bruto bulanan untuk melihat hasilnya.
                </p>
            </div>

            {{-- Main card --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                {{-- Card header --}}
                <div class="border-b border-slate-100 px-6 py-4">
                    <h2 class="text-sm font-semibold text-slate-700">Form Perhitungan</h2>
                </div>

                <div class="px-6 py-6 space-y-6">

                    {{-- Validation / session error --}}
                    @if (session('error'))
                    <div id="error-alert"
                        class="flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    @endif

                    {{-- Form --}}
                    <form id="tax-form" action="{{ route('calculate.submit') }}" method="POST" novalidate>
                        @csrf

                        <div class="mb-5">
                            <label for="income" class="block text-sm font-medium text-slate-700 mb-1.5">
                                Penghasilan Bruto
                            </label>
                            <div class="flex rounded-lg border border-slate-300 overflow-hidden focus-within:ring-2 focus-within:ring-blue-600 focus-within:border-blue-600 transition">
                                <span class="inline-flex items-center px-3 bg-slate-100 border-r border-slate-300 text-sm font-medium text-slate-500 select-none">
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
                                    class="flex-1 bg-white text-slate-900 placeholder-slate-400 text-sm py-2.5 px-3 focus:outline-none">
                            </div>
                            <p class="mt-1.5 text-xs text-slate-400">Masukkan angka tanpa titik, koma, atau simbol.</p>
                        </div>

                        <button
                            id="submit-btn"
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold rounded-lg py-2.5 px-6
                                   transition duration-150 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Hitung Pajak
                        </button>
                    </form>

                    {{-- Front-end validation --}}
                    <script>
                        (function() {
                            const form = document.getElementById('tax-form');
                            const input = document.getElementById('income');
                            const MAX = 999999999999;

                            /**
                             * Show an inline error without a page reload.
                             * Reuses the same #error-alert element if present, or creates one.
                             */
                            function showError(message) {
                                let alert = document.getElementById('error-alert');

                                if (!alert) {
                                    alert = document.createElement('div');
                                    alert.id = 'error-alert';
                                    alert.className = 'flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700';
                                    alert.innerHTML = '<svg class="w-4 h-4 mt-0.5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" /></svg><span id="error-msg"></span>';
                                    form.parentNode.insertBefore(alert, form);
                                }

                                document.getElementById('error-msg').textContent = message;
                                alert.classList.remove('hidden');
                                input.focus();
                            }

                            function clearError() {
                                const alert = document.getElementById('error-alert');
                                if (alert) {
                                    alert.classList.add('hidden');
                                }
                            }

                            form.addEventListener('submit', function(e) {
                                const raw = input.value.trim();

                                if (raw === '') {
                                    e.preventDefault();
                                    showError('Penghasilan tidak boleh kosong.');
                                    return;
                                }

                                // Must be digits only — no letters, no dots, no minus
                                if (!/^\d+$/.test(raw)) {
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
                    <div id="result-card" class="rounded-lg border border-slate-200 bg-slate-50 overflow-hidden">
                        <div class="border-b border-slate-200 px-5 py-3">
                            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-widest">Hasil Perhitungan</h3>
                        </div>
                        <div class="px-5 py-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-500">Penghasilan</span>
                                <span class="text-sm font-medium text-slate-800">
                                    Rp {{ number_format($income, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-500">Tarif Pajak</span>
                                <span class="text-sm font-medium text-slate-800">
                                    {{ number_format($percentage, 2) }}%
                                </span>
                            </div>

                            <div class="h-px bg-slate-200"></div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm font-semibold text-slate-700">Pajak Terutang</span>
                                <span class="text-xl font-bold text-blue-700">
                                    Rp {{ number_format($taxAmount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endisset

                </div>
            </div>

            {{-- Footer note --}}
            <p class="mt-5 text-center text-xs text-slate-400">
                Berdasarkan tabel tarif PPh yang berlaku &mdash; PT. XYZ &copy; hicesse
            </p>

        </div>
    </main>

</body>

</html>