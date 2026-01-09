<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Process;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Process::insert([
            ['id' => 1, 'name' => 'Die Casting'],
            ['id' => 2, 'name' => 'Shotblast'],
            ['id' => 3, 'name' => 'Buffing'],
            ['id' => 4, 'name' => 'Deburring'],
            ['id' => 5, 'name' => 'Powder Coating'],
            ['id' => 6, 'name' => 'Loading'],
            ['id' => 7, 'name' => 'Machining'],
            ['id' => 8, 'name' => 'Gauge Checking'],
            ['id' => 9, 'name' => 'Assembly'],
            ['id' => 10, 'name' => 'Packing'],
            ['id' => 11, 'name' => 'Rework'],
        ]);
    }
}
