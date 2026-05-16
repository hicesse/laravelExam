<?php

namespace Tests\Feature;

use Database\Seeders\TaxRateSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaxCalculationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TaxRateSeeder::class);
    }

    /** GET /calculate returns 200 with the form. */
    public function test_calculate_form_is_accessible(): void
    {
        $response = $this->get(route('calculate.show'));

        $response->assertStatus(200);
        $response->assertSee('Kalkulator Pajak');
    }

    /** Valid income in 0.50% bracket (5,650,000–5,950,000): tax = 29,000. */
    public function test_valid_income_calculates_correct_tax(): void
    {
        $response = $this->post(route('calculate.submit'), ['income' => '5800000']);

        $response->assertStatus(200);
        $response->assertSee('29.000');
        $response->assertSee('0.50%');
    }

    /** Income of 0 — not positive, ctype_digit('0') passes but value check catches it. */
    public function test_zero_income_fails_validation(): void
    {
        $response = $this->post(route('calculate.submit'), ['income' => '0']);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** Negative income: ctype_digit rejects the leading minus sign. */
    public function test_negative_income_fails_validation(): void
    {
        $response = $this->post(route('calculate.submit'), ['income' => '-5000']);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** Pure letters must be rejected. */
    public function test_text_income_fails_validation(): void
    {
        $response = $this->post(route('calculate.submit'), ['income' => 'abc']);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** Mixed alphanumeric like "12abc" must be rejected. */
    public function test_mixed_alphanumeric_income_fails_validation(): void
    {
        $response = $this->post(route('calculate.submit'), ['income' => '12abc']);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** Decimal value like "1.5" must be rejected. */
    public function test_decimal_income_fails_validation(): void
    {
        $response = $this->post(route('calculate.submit'), ['income' => '1.5']);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** Empty income field should redirect back with error. */
    public function test_empty_income_fails_validation(): void
    {
        $response = $this->post(route('calculate.submit'), ['income' => '']);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** Value above max (1000000000000 > 999999999999) must be rejected. */
    public function test_income_above_max_fails_validation(): void
    {
        $response = $this->post(route('calculate.submit'), ['income' => '1000000000000']);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** Exactly at max value (999999999999) must pass validation. */
    public function test_income_at_max_value_passes_validation(): void
    {
        $response = $this->post(route('calculate.submit'), ['income' => '999999999999']);

        $response->assertStatus(200);
    }

    /** Income below the first threshold (e.g. 1,000,000) should produce 0% tax. */
    public function test_income_below_threshold_has_zero_tax(): void
    {
        $response = $this->post(route('calculate.submit'), ['income' => '1000000']);

        $response->assertStatus(200);
        $response->assertSee('0.00%');
        $response->assertSee('Rp 0');
    }

    /** Income in highest bracket (e.g. 30,000,000) should apply 30% rate. */
    public function test_income_in_highest_bracket_applies_30_percent(): void
    {
        $income   = 30_000_000;
        $expected = $income * 0.30;

        $response = $this->post(route('calculate.submit'), ['income' => (string) $income]);

        $response->assertStatus(200);
        $response->assertSee('30.00%');
        $response->assertSee(number_format($expected, 0, ',', '.'));
    }
}
