<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;

class PartController extends Controller
{
    public function index()
    {
        $parts = Part::all();
        return view('parts.index', compact('parts'));
    }

    public function show($id)
    {
        $part = Part::findOrFail($id);
        return view('parts.show', compact('part'));
    }
}
