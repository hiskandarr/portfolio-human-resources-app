<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $presences = [];

        for ($i = 0; $i < 10; $i++) {
            $randomMonth = rand(1, 12);
            $randomDay = rand(1, 28);
            $date = Carbon::create(2025, $randomMonth, $randomDay);
            $checkInHour = rand(8, 10);
            $checkOutHour = rand(16, 18);

            $presences[] = [
                'employee_id' => rand(1, 2),
                'check_in' => $date->copy()->setTime($checkInHour, 0, 0)->toDateTimeString(),
                'check_out' => $date->copy()->setTime($checkOutHour, 0, 0)->toDateTimeString(),
                'date' => $date->toDateString(),
                'status' => 'present',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('presences')->insert($presences);
    }
}
