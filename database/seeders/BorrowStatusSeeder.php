<?php

namespace Database\Seeders;

use App\Models\BorrowStatus;
use Illuminate\Database\Seeder;

class BorrowStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BorrowStatus::create([
            'name' => 'Borrowing'
        ]);

        BorrowStatus::create([
            'name' => 'Returned'
        ]);
    }
}
