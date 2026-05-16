<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Truncates old data and bulk-inserts all tax brackets.
     */
    public function run(): void
    {
        DB::table('tax_rates')->truncate();

        DB::table('tax_rates')->insert([
            ['income_from' => 0,          'income_to' => 5400000,       'percentage' => 0.00,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 5400000,    'income_to' => 5650000,       'percentage' => 0.25,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 5650000,    'income_to' => 5950000,       'percentage' => 0.50,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 5950000,    'income_to' => 6300000,       'percentage' => 0.75,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 6300000,    'income_to' => 6750000,       'percentage' => 1.00,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 6750000,    'income_to' => 7500000,       'percentage' => 1.25,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 7500000,    'income_to' => 8550000,       'percentage' => 1.50,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 8550000,    'income_to' => 9650000,       'percentage' => 1.75,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 9650000,    'income_to' => 10050000,      'percentage' => 2.00,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 10050000,   'income_to' => 10350000,      'percentage' => 2.25,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 10350000,   'income_to' => 10700000,      'percentage' => 2.50,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 10700000,   'income_to' => 11050000,      'percentage' => 3.00,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 11050000,   'income_to' => 11600000,      'percentage' => 3.50,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 11600000,   'income_to' => 12500000,      'percentage' => 4.00,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 12500000,   'income_to' => 13750000,      'percentage' => 5.00,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 13750000,   'income_to' => 15100000,      'percentage' => 6.00,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 15100000,   'income_to' => 16950000,      'percentage' => 7.00,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 16950000,   'income_to' => 19750000,      'percentage' => 8.00,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 19750000,   'income_to' => 24150000,      'percentage' => 9.00,  'created_at' => now(), 'updated_at' => now()],
            ['income_from' => 24150000,   'income_to' => 999999999999,  'percentage' => 30.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
