<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateIncomeInput
{
    /**
     * Handle an incoming request.
     *
     * Rules: non-empty, positive integer only (no letters, no decimals, no negatives),
     * maximum value 999999999999.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $income = $request->input('income');

        if ($income === null || trim((string) $income) === '') {
            return redirect()->back()->withInput()
                ->with('error', 'Penghasilan tidak boleh kosong.');
        }

        // Must consist of digits only — rejects letters, decimals (1.5), negatives (-5), spaces
        if (! ctype_digit((string) $income)) {
            return redirect()->back()->withInput()
                ->with('error', 'Penghasilan harus berupa bilangan bulat positif (hanya angka, tanpa huruf atau desimal).');
        }

        if ((int) $income <= 0) {
            return redirect()->back()->withInput()
                ->with('error', 'Penghasilan harus lebih dari 0.');
        }

        return $next($request);
    }
}
