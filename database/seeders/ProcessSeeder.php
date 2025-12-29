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
            ['id' => 3, 'name' => 'Deburring'],
            ['id' => 4, 'name' => 'Powder Coating'],
            ['id' => 5, 'name' => 'Machining'],
            ['id' => 6, 'name' => 'Packing'],
        ]);
    }
}
