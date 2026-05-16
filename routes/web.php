<?php

use App\Http\Controllers\TaxController;
use App\Http\Middleware\ValidateIncomeInput;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('calculate.show');
});

Route::get('/calculate', [TaxController::class, 'show'])->name('calculate.show');

Route::post('/calculate', [TaxController::class, 'calculate'])
    ->middleware(ValidateIncomeInput::class)
    ->name('calculate.submit');
