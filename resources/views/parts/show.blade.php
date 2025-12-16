@extends('layouts.app')

@section('content')

<div class="grid grid-cols-2 gap-10">

    <!-- Left: Part Image -->
    <div class="w-full h-[400px] bg-gray-200 rounded mb-4 overflow-hidden flex items-center justify-center">
        @if($part->part_image && file_exists(public_path('uploads/parts/images/' . $part->part_image)))
            <img src="{{ asset('uploads/parts/images/' . $part->part_image) }}" 
                alt="{{ $part->part_name }}" class="h-full object-contain">
        @else
            <span class="text-gray-400">No Image Available</span>
        @endif
    </div>

    <!-- Right: Details + PDFs -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold mb-2">Part Details</h2>
        <div class="mt-2 text-gray-700 space-y-1">
            <p><strong>Name:</strong> {{ $part->part_name }}</p>
            <p><strong>Customer:</strong> {{ $part->customer }}</p>
            <p><strong>Material:</strong> {{ $part->material }}</p>
            <p><strong>Department:</strong> {{ $part->department }}</p>
            <p><strong>Section:</strong> {{ $part->section }}</p>
            <p><strong>Machine/Line:</strong> {{ $part->machine_line }}</p>
            <p><strong>Operator:</strong> {{ $part->operator }}</p>
            <p><strong>MCT:</strong> {{ $part->mct }}</p>
            <p><strong>CT:</strong> {{ $part->ct }}</p>
            <p><strong>Avg Output per Day:</strong> {{ $part->avg_output_per_day }}</p>
            <p><strong>Main Reject Reason:</strong> {{ $part->main_reject_reason }}</p>
        </div>

        <div class="space-y-4 mt-6">
            <h2 class="text-xl font-bold mb-2">PDF Documents</h2>

            @if($part->qal && file_exists(public_path('uploads/parts/qal/' . $part->qal)))
                <div class="flex items-center gap-2">
                    <a href="{{ asset('uploads/parts/qal/' . $part->qal) }}" target="_blank" 
                    class="px-3 py-1 bg-blue-500 text-white rounded text-sm">Preview QAL</a>
                    <a href="{{ asset('uploads/parts/qal/' . $part->qal) }}" download 
                    class="px-3 py-1 bg-gray-200 rounded text-sm">Download QAL</a>
                </div>
            @endif

            @if($part->work_layout && file_exists(public_path('uploads/parts/work_layout/' . $part->work_layout)))
                <div class="flex items-center gap-2">
                    <a href="{{ asset('uploads/parts/work_layout/' . $part->work_layout) }}" target="_blank" 
                    class="px-3 py-1 bg-blue-500 text-white rounded text-sm">Preview Layout</a>
                    <a href="{{ asset('uploads/parts/work_layout/' . $part->work_layout) }}" download 
                    class="px-3 py-1 bg-gray-200 rounded text-sm">Download Layout</a>
                </div>
            @endif

            @if($part->work_instruction && file_exists(public_path('uploads/parts/work_instruction/' . $part->work_instruction)))
                <div class="flex items-center gap-2">
                    <a href="{{ asset('uploads/parts/work_instruction/' . $part->work_instruction) }}" target="_blank" 
                    class="px-3 py-1 bg-blue-500 text-white rounded text-sm">Preview Instruction</a>
                    <a href="{{ asset('uploads/parts/work_instruction/' . $part->work_instruction) }}" download 
                    class="px-3 py-1 bg-gray-200 rounded text-sm">Download Instruction</a>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
