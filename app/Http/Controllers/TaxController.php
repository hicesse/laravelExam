<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TaxController extends Controller
{
    /**
     * Display the tax calculation form.
     */
    public function show(): View
    {
        return view('calculate');
    }

    /**
     * Process the submitted income and return the calculated tax.
     *
     * Income validation is handled upstream by ValidateIncomeInput middleware.
     * This method uses Query Builder to look up the correct tax bracket.
     */
    public function calculate(Request $request): View
    {
        $income = (float) $request->input('income');

        /** @var object{percentage: string}|null $taxRate */
        $taxRate = DB::table('tax_rates')
            ->where('income_from', '<=', $income)
            ->where('income_to', '>=', $income)
            ->first();

        $percentage = $taxRate ? (float) $taxRate->percentage : 0.0;
        $taxAmount  = $income * ($percentage / 100);

        return view('calculate', [
            'income'     => $income,
            'percentage' => $percentage,
            'taxAmount'  => $taxAmount,
        ]);
    }
}
