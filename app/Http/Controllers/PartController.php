<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\Process;
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

        $sortOrder = $request->get('sort_order', 'asc'); // default ascending
        $query->orderBy('part_name', $sortOrder);

        $parts = $query->get();
        $customers = Part::select('customer')->distinct()->pluck('customer');

        return view('parts.index', compact('parts', 'customers'));
    }

    // Public show
    public function show($id)
    {
        // Eager load processes so we can access them in the view
        $part = Part::with('processes')->findOrFail($id);

        return view('parts.show', compact('part'));
    }

  
    // Advanced CRUD
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

    // Store new part (with uploaded files and multiple processes)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'part_name' => ['required', 'string', 'max:255'],
            'customer' => ['required', 'string', 'max:255'],
            'material' => ['required', 'string', 'max:255'],
            'avg_output_per_day' => 'nullable|numeric',
            'part_image' => 'required|image|max:5120',

            // PART-LEVEL DOCUMENTS
            'drawing' => 'nullable|file|mimes:pdf|max:51200',
            'inspection_gauge' => 'nullable|file|mimes:pdf|max:51200',
            'machine_setup_parameter' => 'nullable|file|mimes:pdf|max:51200',
            'operation_jig' => 'nullable|file|mimes:pdf|max:51200',
            'operation_sheet' => 'nullable|file|mimes:pdf|max:51200',
            'process_standard_sheet' => 'nullable|file|mimes:pdf|max:51200',
            'program_list' => 'nullable|file|mimes:pdf|max:51200',
            'project_status' => 'nullable|file|mimes:pdf|max:51200',
            'tooling' => 'nullable|file|mimes:pdf|max:51200',


            // Process-related fields
            'processes.*' => 'required|in:1,2,3,4,5,6',
            'departments' => 'required|array',
            'sections' => 'required|array',
            'machine_lines' => 'required|array',
            'operators' => 'required|array',
            'mcts' => 'nullable|array',
            'cts' => 'nullable|array',
            'qals' => 'nullable|array',
            'work_layouts' => 'nullable|array',
            'work_instructions' => 'nullable|array',
        ]);

        // Convert certain fields to uppercase
        $validated['part_name'] = strtoupper($validated['part_name']);
        $validated['customer'] = strtoupper($validated['customer']);
        $validated['material'] = strtoupper($validated['material']);

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

        // Create part
        $part = Part::create([
            'part_name' => $validated['part_name'],
            'customer' => $validated['customer'],
            'material' => $validated['material'],
            'avg_output_per_day' => $validated['avg_output_per_day'] ?? null,
            'part_image' => $storeFile($request->file('part_image'), 'images'),
        ]);

        $partDocs = [
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

        foreach ($partDocs as $doc) {
            if ($request->hasFile($doc)) {
                $part->$doc = $storeFile($request->file($doc), $doc);
            }
        }

        $part->save();

        // Save multiple processes with pivot files
        foreach ($validated['processes'] as $index => $processId) {
            $part->processes()->attach($processId, [
                'department' => strtoupper($validated['departments'][$index] ?? ''),
                'section' => strtoupper($validated['sections'][$index] ?? ''),
                'machine_line' => strtoupper($validated['machine_lines'][$index] ?? ''),
                'operator' => strtoupper($validated['operators'][$index] ?? ''),
                'mct' => $validated['mcts'][$index] ?? null,
                'ct' => $validated['cts'][$index] ?? null,
                'qal' => $storeFile($request->file('qals')[$index] ?? null, 'qal'),
                'work_layout' => $storeFile($request->file('work_layouts')[$index] ?? null, 'work_layout'),
                'work_instruction' => $storeFile($request->file('work_instructions')[$index] ?? null, 'work_instruction'),
            ]);
        }

        return redirect()->route('parts.manage')->with('success', 'Part created successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $part = Part::with('processes')->findOrFail($id);
        $allProcesses = Process::all();

        return view('parts.edit', compact('part', 'allProcesses'));
    }


    // Update part (handle file replacements)
    public function update(Request $request, $id)
    {
        $part = Part::with('processes')->findOrFail($id);

        $validated = $request->validate([
            // PART
            'part_name' => ['required', 'string', 'max:255'],
            'customer' => ['nullable', 'string', 'max:255'],
            'material' => ['nullable', 'string', 'max:255'],
            'avg_output_per_day' => ['nullable', 'numeric'],
            'part_image' => ['nullable', 'image', 'max:5120'],

            // PART-LEVEL DOCUMENTS
            'drawing' => 'nullable|file|mimes:pdf|max:10240',
            'inspection_gauge' => 'nullable|file|mimes:pdf|max:10240',
            'machine_setup_parameter' => 'nullable|file|mimes:pdf|max:10240',
            'operation_jig' => 'nullable|file|mimes:pdf|max:10240',
            'operation_sheet' => 'nullable|file|mimes:pdf|max:10240',
            'process_standard_sheet' => 'nullable|file|mimes:pdf|max:10240',
            'program_list' => 'nullable|file|mimes:pdf|max:10240',
            'project_status' => 'nullable|file|mimes:pdf|max:10240',
            'tooling' => 'nullable|file|mimes:pdf|max:10240',

            // PROCESS
            'processes' => ['required', 'array'],
            'processes.*' => ['exists:processes,id'],

            'departments' => ['array'],
            'sections' => ['array'],
            'machine_lines' => ['array'],
            'operators' => ['array'],
            'mcts' => ['array'],
            'cts' => ['array'],

            'qals.*' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'work_layouts.*' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'work_instructions.*' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        // Update
        $part->update([
            'part_name' => strtoupper($validated['part_name']),
            'customer' => isset($validated['customer']) ? strtoupper($validated['customer']) : null,
            'material' => isset($validated['material']) ? strtoupper($validated['material']) : null,
            'avg_output_per_day' => $validated['avg_output_per_day'] ?? null,
        ]);


        // File Helper
        $storeFile = function ($file, $folder) {
            if (!$file) return null;

            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = $file->getClientOriginalExtension();

            $safe = \Str::slug($name) . '_' . time() . '.' . $ext;
            $path = public_path("uploads/parts/{$folder}");

            if (!\File::exists($path)) {
                \File::makeDirectory($path, 0755, true);
            }

            $file->move($path, $safe);
            return $safe;
        };

        $partDocs = [
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

        foreach ($partDocs as $doc) {
            if ($request->hasFile($doc)) {

                if ($part->$doc && File::exists(public_path("uploads/parts/$doc/".$part->$doc))) {
                    File::delete(public_path("uploads/parts/$doc/".$part->$doc));
                }

                $part->$doc = $storeFile($request->file($doc), $doc);
            }
        }

        $part->save();

        // Image
        if ($request->hasFile('part_image')) {
            if ($part->part_image && file_exists(public_path('uploads/parts/images/' . $part->part_image))) {
                unlink(public_path('uploads/parts/images/' . $part->part_image));
            }
            $part->part_image = $storeFile($request->file('part_image'), 'images');
            $part->save();
        }

        // Sync Process
        $syncData = [];

        foreach ($validated['processes'] as $index => $processId) {

            $existing = $part->processes->firstWhere('id', $processId);

            $syncData[$processId] = [
                'department' => strtoupper($validated['departments'][$index] ?? ''),
                'section' => strtoupper($validated['sections'][$index] ?? ''),
                'machine_line' => strtoupper($validated['machine_lines'][$index] ?? ''),
                'operator' => strtoupper($validated['operators'][$index] ?? ''),
                'mct' => $validated['mcts'][$index] ?? null,
                'ct' => $validated['cts'][$index] ?? null,

                // keep old files unless replaced
                'qal' => $existing?->pivot->qal,
                'work_layout' => $existing?->pivot->work_layout,
                'work_instruction' => $existing?->pivot->work_instruction,
            ];

            // QAL
            if ($request->hasFile("qals.$index")) {
                if ($existing?->pivot->qal) {
                    @unlink(public_path('uploads/parts/qal/' . $existing->pivot->qal));
                }
                $syncData[$processId]['qal'] =
                    $storeFile($request->file("qals.$index"), 'qal');
            }

            // WORK LAYOUT
            if ($request->hasFile("work_layouts.$index")) {
                if ($existing?->pivot->work_layout) {
                    @unlink(public_path('uploads/parts/work_layout/' . $existing->pivot->work_layout));
                }
                $syncData[$processId]['work_layout'] =
                    $storeFile($request->file("work_layouts.$index"), 'work_layout');
            }

            // WORK INSTRUCTION
            if ($request->hasFile("work_instructions.$index")) {
                if ($existing?->pivot->work_instruction) {
                    @unlink(public_path('uploads/parts/work_instruction/' . $existing->pivot->work_instruction));
                }
                $syncData[$processId]['work_instruction'] =
                    $storeFile($request->file("work_instructions.$index"), 'work_instruction');
            }
        }

        $part->processes()->sync($syncData);

        return redirect()->route('parts.manage')->with('success', 'Part updated successfully.');
    }


    // Delete part and related files
    public function destroy($id)
    {
        $part = Part::with('processes')->findOrFail($id);

        if ($part->part_image && File::exists(public_path('uploads/parts/images/' . $part->part_image))) {
            File::delete(public_path('uploads/parts/images/' . $part->part_image));
        }

        foreach ($part->processes as $process) {

            $pivot = $process->pivot;

            if ($pivot->qal && File::exists(public_path('uploads/parts/qal/' . $pivot->qal))) {
                File::delete(public_path('uploads/parts/qal/' . $pivot->qal));
            }

            if ($pivot->work_layout && File::exists(public_path('uploads/parts/work_layout/' . $pivot->work_layout))) {
                File::delete(public_path('uploads/parts/work_layout/' . $pivot->work_layout));
            }

            if ($pivot->work_instruction && File::exists(public_path('uploads/parts/work_instruction/' . $pivot->work_instruction))) {
                File::delete(public_path('uploads/parts/work_instruction/' . $pivot->work_instruction));
            }
        }

        $partDocs = [
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

        foreach ($partDocs as $doc) {
            if ($part->$doc && File::exists(public_path("uploads/parts/$doc/".$part->$doc))) {
                File::delete(public_path("uploads/parts/$doc/".$part->$doc));
            }
        }
        
        $part->processes()->detach();
        $part->delete();

        return redirect()->route('parts.manage')->with('success', 'Part deleted successfully.');
    }
}
