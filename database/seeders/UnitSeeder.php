<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unit = [
                'الوحدة الأولى',
                'الوحدة الثانية',
                'الوحدة الثالثة',
                'الوحدة الرابعة',
                'الوحدة الخامسة',
                'الوحدة السادسة',
                'الوحدة السابعة',
                'الوحدة الثامنة',
                'الوحدة التاسعة',
                'الوحدة العاشرة',
                

        ];
        foreach ($unit as $name) {
            \App\Models\Unit::create([
                'title' => $name,
            ]);
        }
    }
}
