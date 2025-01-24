<?php

namespace Database\Seeders;

use App\Models\Ledger;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 10 ledger
        Ledger::factory(10)->create();
    }
}
