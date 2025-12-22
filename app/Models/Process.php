<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Part;

class Process extends Model
{
    protected $fillable = ['name'];

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'part_processes')
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
