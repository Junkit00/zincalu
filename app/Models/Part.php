<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_name', 
        'part_image', 
        'machine_line', 
        'operator', 
        'customer',
        'material', 
        'department', 
        'section', 
        'mct', 
        'ct', 
        'avg_output_per_day',
        'main_reject_reason', 
        'qal', 
        'work_layout', 
        'work_instruction',
    ];
}
