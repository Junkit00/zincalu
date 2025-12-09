@extends('layouts.app')

@section('content')

<div class="flex gap-10">

    <!-- Left side image -->
    <div class="w-1/2">
        <div class="w-full aspect-video bg-gray-200 rounded mb-4"></div>

        <div class="flex justify-between mt-2">
            <p class="font-semibold">Short description / purpose</p>
            <p class="font-semibold">Main Reject Reason</p>
        </div>
    </div>

    <!-- Right side details -->
    <div class="w-1/2 space-y-3">

        <h1 class="text-2xl font-bold">{{ $part->part_name }}</h1>

        <span class="bg-green-200 text-green-800 px-3 py-1 rounded text-sm">
            {{ $part->department }}
        </span>

        <p class="font-semibold">
            {{ $part->machine_line }} + {{ $part->operator }}
        </p>

        <div class="grid grid-cols-2 text-gray-700 mt-4">
            <div>
                <p>Material: <strong>{{ $part->material }}</strong></p>
                <p>MCT: <strong>{{ $part->mct }}</strong></p>
                <p>CT: <strong>{{ $part->ct }}</strong></p>
            </div>

            <div>
                <p>Avg O/P: <strong>{{ $part->avg_output_per_day }}</strong></p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="font-semibold">Label</label>
                <select class="border p-2 rounded w-full">
                    <option>Value</option>
                </select>
            </div>

            <div>
                <label class="font-semibold">Label</label>
                <select class="border p-2 rounded w-full">
                    <option>Value</option>
                </select>
            </div>
        </div>

        <!-- Button -->
        <button class="w-full bg-black text-white py-2 rounded mt-4">
            Button
        </button>

        <!-- PDFs -->
        <div class="mt-6 space-y-2">
            <a href="{{ route('pdf.download', $part->qal) }}" class="underline">QAL PDF</a><br>
            <a href="{{ route('pdf.download', $part->work_layout) }}" class="underline">Work Layout</a><br>
            <a href="{{ route('pdf.download', $part->work_instruction) }}" class="underline">Work Instruction</a>
        </div>

    </div>
</div>

@endsection
