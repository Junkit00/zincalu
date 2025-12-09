<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('parts')->insert([
            [
                'part_name' => 'Part A',
                'part_image' => 'images/part_a.jpg',
                'machine_line' => 'Line 1',
                'operator' => 'John Doe',
                'customer' => 'Customer X',
                'material' => 'Steel',
                'department' => 'Assembly',
                'section' => 'Section 1',
                'mct' => 2.5,
                'ct' => 3.0,
                'avg_output_per_day' => 100,
                'main_reject_reason' => 'Surface defect',
                'qal' => 'pdfs/qal_part_a.pdf',
                'work_layout' => 'pdfs/layout_part_a.pdf',
                'work_instruction' => 'pdfs/instruction_part_a.pdf',
            ],
            [
                'part_name' => 'Part B',
                'part_image' => 'images/part_b.jpg',
                'machine_line' => 'Line 2',
                'operator' => 'Jane Smith',
                'customer' => 'Customer Y',
                'material' => 'Aluminium',
                'department' => 'Fabrication',
                'section' => 'Section 2',
                'mct' => 1.8,
                'ct' => 2.0,
                'avg_output_per_day' => 150,
                'main_reject_reason' => 'Dimension error',
                'qal' => 'pdfs/qal_part_b.pdf',
                'work_layout' => 'pdfs/layout_part_b.pdf',
                'work_instruction' => 'pdfs/instruction_part_b.pdf',
            ]
        ]);
    }
}
