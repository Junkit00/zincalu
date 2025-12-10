<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PartController extends Controller
{
    // Public index (dashboard) with search/filter
    public function index(Request $request)
    {
        $query = Part::query();

        if ($request->filled('part_name')) {
            $query->where('part_name', 'like', '%' . $request->part_name . '%');
        }

        if ($request->filled('customer')) {
            $query->where('customer', 'like', '%' . $request->customer . '%');
        }

        $parts = $query->get();
        $customers = Part::select('customer')->distinct()->pluck('customer');

        return view('parts.index', compact('parts', 'customers'));
    }

    // Public show
    public function show($id)
    {
        $part = Part::findOrFail($id);
        return view('parts.show', compact('part'));
    }

    /* -----------------------
       Manage (CRUD) methods
       ----------------------- */

    // Manage listing (same display as index but with action buttons)
    public function manage(Request $request)
    {
        $query = Part::query();

        if ($request->filled('part_name')) {
            $query->where('part_name', 'like', '%' . $request->part_name . '%');
        }

        if ($request->filled('customer')) {
            $query->where('customer', 'like', '%' . $request->customer . '%');
        }

        $parts = $query->get();
        $customers = Part::select('customer')->distinct()->pluck('customer');

        return view('parts.manage', compact('parts', 'customers'));
    }

    // Show create form
    public function create()
    {
        return view('parts.create');
    }

    // Store new part (with uploaded files)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'part_name' => 'required|string|max:255',
            'customer' => 'nullable|string|max:255',
            'machine_line' => 'nullable|string|max:255',
            'operator' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'section' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'mct' => 'nullable|numeric',
            'ct' => 'nullable|numeric',
            'avg_output_per_day' => 'nullable|numeric',
            'main_reject_reason' => 'nullable|string|max:1000',

            'part_image' => 'nullable|image|max:5120', // 5MB
            'qal' => 'nullable|file|mimes:pdf|max:10240',
            'work_layout' => 'nullable|file|mimes:pdf|max:10240',
            'work_instruction' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Create part instance
        $part = new Part();
        $part->part_name = $validated['part_name'];
        $part->customer = $validated['customer'] ?? null;
        $part->machine_line = $validated['machine_line'] ?? null;
        $part->operator = $validated['operator'] ?? null;
        $part->department = $validated['department'] ?? null;
        $part->section = $validated['section'] ?? null;
        $part->material = $validated['material'] ?? null;
        $part->mct = $validated['mct'] ?? null;
        $part->ct = $validated['ct'] ?? null;
        $part->avg_output_per_day = $validated['avg_output_per_day'] ?? null;
        $part->main_reject_reason = $validated['main_reject_reason'] ?? null;

        // Helper to store a file in public/uploads/parts/<folder>
        $storeFile = function ($file, $folder) {
            if (!$file) return null;
            $orig = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $name = pathinfo($orig, PATHINFO_FILENAME);
            $safe = Str::slug($name) . '_' . time() . '.' . $ext;
            $destination = public_path("uploads/parts/{$folder}/");
            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $safe);
            return $safe;
        };

        // Store files if uploaded
        $part->part_image = $storeFile($request->file('part_image'), 'images');
        $part->qal = $storeFile($request->file('qal'), 'qal');
        $part->work_layout = $storeFile($request->file('work_layout'), 'work_layout');
        $part->work_instruction = $storeFile($request->file('work_instruction'), 'work_instruction');

        $part->save();

        return redirect()->route('parts.manage')->with('success', 'Part created successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $part = Part::findOrFail($id);
        return view('parts.edit', compact('part'));
    }

    // Update part (handle file replacements)
    public function update(Request $request, $id)
    {
        $part = Part::findOrFail($id);

        $validated = $request->validate([
            'part_name' => 'required|string|max:255',
            'customer' => 'nullable|string|max:255',
            'machine_line' => 'nullable|string|max:255',
            'operator' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'section' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'mct' => 'nullable|numeric',
            'ct' => 'nullable|numeric',
            'avg_output_per_day' => 'nullable|numeric',
            'main_reject_reason' => 'nullable|string|max:1000',

            'part_image' => 'nullable|image|max:5120',
            'qal' => 'nullable|file|mimes:pdf|max:10240',
            'work_layout' => 'nullable|file|mimes:pdf|max:10240',
            'work_instruction' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $part->part_name = $validated['part_name'];
        $part->customer = $validated['customer'] ?? null;
        $part->machine_line = $validated['machine_line'] ?? null;
        $part->operator = $validated['operator'] ?? null;
        $part->department = $validated['department'] ?? null;
        $part->section = $validated['section'] ?? null;
        $part->material = $validated['material'] ?? null;
        $part->mct = $validated['mct'] ?? null;
        $part->ct = $validated['ct'] ?? null;
        $part->avg_output_per_day = $validated['avg_output_per_day'] ?? null;
        $part->main_reject_reason = $validated['main_reject_reason'] ?? null;

        // File storing function (same logic as store)
        $storeFile = function ($file, $folder) {
            if (!$file) return null;
            $orig = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $name = pathinfo($orig, PATHINFO_FILENAME);
            $safe = Str::slug($name) . '_' . time() . '.' . $ext;
            $destination = public_path("uploads/parts/{$folder}/");
            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $safe);
            return $safe;
        };

        // Replace files if a new upload exists; delete old ones
        if ($request->hasFile('part_image')) {
            if ($part->part_image && File::exists(public_path('uploads/parts/images/' . $part->part_image))) {
                File::delete(public_path('uploads/parts/images/' . $part->part_image));
            }
            $part->part_image = $storeFile($request->file('part_image'), 'images');
        }

        if ($request->hasFile('qal')) {
            if ($part->qal && File::exists(public_path('uploads/parts/qal/' . $part->qal))) {
                File::delete(public_path('uploads/parts/qal/' . $part->qal));
            }
            $part->qal = $storeFile($request->file('qal'), 'qal');
        }

        if ($request->hasFile('work_layout')) {
            if ($part->work_layout && File::exists(public_path('uploads/parts/work_layout/' . $part->work_layout))) {
                File::delete(public_path('uploads/parts/work_layout/' . $part->work_layout));
            }
            $part->work_layout = $storeFile($request->file('work_layout'), 'work_layout');
        }

        if ($request->hasFile('work_instruction')) {
            if ($part->work_instruction && File::exists(public_path('uploads/parts/work_instruction/' . $part->work_instruction))) {
                File::delete(public_path('uploads/parts/work_instruction/' . $part->work_instruction));
            }
            $part->work_instruction = $storeFile($request->file('work_instruction'), 'work_instruction');
        }

        $part->save();

        return redirect()->route('parts.manage')->with('success', 'Part updated successfully.');
    }

    // Delete part and related files
    public function destroy($id)
    {
        $part = Part::findOrFail($id);

        // delete files if exist
        if ($part->part_image && File::exists(public_path('uploads/parts/images/' . $part->part_image))) {
            File::delete(public_path('uploads/parts/images/' . $part->part_image));
        }
        if ($part->qal && File::exists(public_path('uploads/parts/qal/' . $part->qal))) {
            File::delete(public_path('uploads/parts/qal/' . $part->qal));
        }
        if ($part->work_layout && File::exists(public_path('uploads/parts/work_layout/' . $part->work_layout))) {
            File::delete(public_path('uploads/parts/work_layout/' . $part->work_layout));
        }
        if ($part->work_instruction && File::exists(public_path('uploads/parts/work_instruction/' . $part->work_instruction))) {
            File::delete(public_path('uploads/parts/work_instruction/' . $part->work_instruction));
        }

        $part->delete();

        return redirect()->route('parts.manage')->with('success', 'Part deleted successfully.');
    }
}
