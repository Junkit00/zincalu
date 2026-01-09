<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Process;

class Part extends Model
{
    protected $fillable = [
        'part_name',
        'customer',
        'material',
        'avg_output_per_day',
        'part_image',
        'drawing',
        'inspection_gauge',
        'machine_setup_parameter',
        'operation_jig',
        'operation_sheet',
        'process_standard_sheet',
        'program_list',
        'project_status',
        'tooling',
    ];

    public function processes()
    {
        return $this->belongsToMany(Process::class, 'part_processes')
            ->withPivot([
                'department',
                'section',
                'machine_line',
                'operator',
                'mct',
                'ct',
                'qal',
                'work_layout',
                'work_instruction',
            ])
            ->withTimestamps();
    }
}
