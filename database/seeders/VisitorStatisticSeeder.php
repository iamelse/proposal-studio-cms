<?php

namespace Database\Seeders;

use App\Models\VisitorStatistic;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitorStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = Carbon::now()->subDays(6);

        for ($i = 0; $i < 7; $i++) {
            VisitorStatistic::updateOrCreate(
                ['date' => $startDate->toDateString()],
                ['visitors' => rand(1000, 3000)]
            );
            $startDate->addDay();
        }
    }
}
