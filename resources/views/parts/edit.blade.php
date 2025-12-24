@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-xl font-semibold mb-4">Edit Part</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('parts.update', $part->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- PART INFO --}}
        <h3 class="font-semibold text-lg mb-3">Part Information</h3>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="font-semibold">Part Name</label>
                <input type="text" name="part_name" class="border p-2 rounded w-full"
                       value="{{ old('part_name', $part->part_name) }}" required>
            </div>

            <div>
                <label class="font-semibold">Customer</label>
                <input type="text" name="customer" class="border p-2 rounded w-full"
                       value="{{ old('customer', $part->customer) }}">
            </div>

            <div>
                <label class="font-semibold">Material</label>
                <input type="text" name="material" class="border p-2 rounded w-full"
                       value="{{ old('material', $part->material) }}">
            </div>

            <div>
                <label class="font-semibold">Avg Output / Day</label>
                <input type="number" name="avg_output_per_day" class="border p-2 rounded w-full"
                       value="{{ old('avg_output_per_day', $part->avg_output_per_day) }}">
            </div>

            <div class="col-span-2">
                <label class="font-semibold">Part Image</label>
                @if($part->part_image)
                    <img src="{{ asset('uploads/parts/images/' . $part->part_image) }}"
                         class="w-40 h-40 object-cover rounded mb-2">
                @endif
                <input type="file" name="part_image" class="border p-2 rounded w-full">
            </div>
        </div>

        <hr class="my-6">

        {{-- PROCESS SECTION --}}
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-semibold text-lg">Process Flow</h3>
            <button type="button" id="add-process"
                    class="px-3 py-1 bg-green-600 text-white rounded text-sm">
                + Add Process
            </button>
        </div>

        <div id="process-container" class="space-y-4">

            {{-- EXISTING PROCESSES --}}
            @foreach($part->processes as $index => $process)
                <div class="process-row border rounded p-4 bg-gray-50">

                    <input type="hidden" name="processes[]" value="{{ $process->id }}">

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="font-semibold">Process</label>
                            <input type="text" class="border p-2 rounded w-full bg-gray-100"
                                   value="{{ $process->name }}" readonly>
                        </div>

                        <div>
                            <label class="font-semibold">Department</label>
                            <input type="text" name="departments[]"
                                class="border p-2 rounded w-full"
                                value="{{ $process->pivot->department }}">
                        </div>

                        <div>
                            <label class="font-semibold">Section</label>
                            <input type="text" name="sections[]"
                                class="border p-2 rounded w-full"
                                value="{{ $process->pivot->section }}">
                        </div>


                        <div>
                            <label class="font-semibold">Machine / Line</label>
                            <input type="text" name="machine_lines[]"
                                class="border p-2 rounded w-full"
                                value="{{ $process->pivot->machine_line }}">
                        </div>

                        <div>
                            <label class="font-semibold">Operator</label>
                            <input type="text" name="operators[]"
                                class="border p-2 rounded w-full"
                                value="{{ $process->pivot->operator }}">
                        </div>

                        <div>
                            <label class="font-semibold">MCT</label>
                            <input type="number" name="mcts[]"
                                class="border p-2 rounded w-full"
                                value="{{ $process->pivot->mct }}">
                        </div>

                        <div>
                            <label class="font-semibold">CT</label>
                            <input type="number" name="cts[]"
                                class="border p-2 rounded w-full"
                                value="{{ $process->pivot->ct }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 mt-3">
                        <div>
                            <label class="font-semibold">QAL (PDF)</label>

                            @if($process->pivot->qal)
                                <a href="{{ asset('uploads/parts/qal/' . $process->pivot->qal) }}"
                                target="_blank"
                                class="block text-blue-600 underline text-sm mb-1">
                                    Existing QAL
                                </a>
                            @endif

                            <input type="file" name="qals[]" accept="application/pdf"
                                class="border p-2 rounded w-full">
                        </div>

                        <div>
                            <label class="font-semibold">Work Layout (PDF)</label>

                            @if($process->pivot->work_layout)
                                <a href="{{ asset('uploads/parts/work_layout/' . $process->pivot->work_layout) }}"
                                target="_blank"
                                class="block text-blue-600 underline text-sm mb-1">
                                    Existing Layout
                                </a>
                            @endif

                            <input type="file" name="work_layouts[]" accept="application/pdf"
                                class="border p-2 rounded w-full">
                        </div>

                        <div>
                            <label class="font-semibold">Work Instruction (PDF)</label>

                            @if($process->pivot->work_instruction)
                                <a href="{{ asset('uploads/parts/work_instruction/' . $process->pivot->work_instruction) }}"
                                target="_blank"
                                class="block text-blue-600 underline text-sm mb-1">
                                    Existing Instruction
                                </a>
                            @endif

                            <input type="file" name="work_instructions[]" accept="application/pdf"
                                class="border p-2 rounded w-full">
                        </div>
                    </div>

                    <div class="text-right mt-3">
                        <button type="button" class="remove-process text-red-600 text-sm underline">
                            Remove Process
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <hr class="my-6">

        <div class="flex gap-3">
            <button type="submit" class="bg-black text-white px-5 py-2 rounded">
                Save Changes
            </button>
            <a href="{{ route('parts.manage') }}" class="border px-5 py-2 rounded">
                Cancel
            </a>
        </div>
    </form>
</div>

{{-- TEMPLATE FOR NEW PROCESS --}}
<template id="process-template">
    <div class="process-row border rounded p-4 bg-gray-50">

        <div class="grid grid-cols-3 gap-3">
            <select name="processes[]" class="border p-2 rounded" required>
                <option value="">-- Select Process --</option>
                @foreach($allProcesses as $proc)
                    <option value="{{ $proc->id }}">{{ $proc->name }}</option>
                @endforeach
            </select>

            <input type="text" name="departments[]" class="border p-2 rounded" placeholder="Department">
            <input type="text" name="sections[]" class="border p-2 rounded" placeholder="Section">
            <input type="text" name="machine_lines[]" class="border p-2 rounded" placeholder="Machine / Line">
            <input type="text" name="operators[]" class="border p-2 rounded" placeholder="Operator">
            <input type="number" name="mcts[]" class="border p-2 rounded" placeholder="MCT">
            <input type="number" name="cts[]" class="border p-2 rounded" placeholder="CT">
        </div>

        <div class="grid grid-cols-3 gap-3 mt-3">
            <input type="file" name="qals[]" accept="application/pdf">
            <input type="file" name="work_layouts[]" accept="application/pdf">
            <input type="file" name="work_instructions[]" accept="application/pdf">
        </div>

        <div class="text-right mt-3">
            <button type="button" class="remove-process text-red-600 text-sm underline">
                Remove Process
            </button>
        </div>
    </div>
</template>

{{-- JS --}}
<script>
    const addBtn = document.getElementById('add-process');
    const container = document.getElementById('process-container');
    const template = document.getElementById('process-template');

    addBtn.addEventListener('click', () => {
        container.appendChild(template.content.cloneNode(true));
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-process')) {
            const rows = document.querySelectorAll('.process-row');
            if (rows.length > 1) {
                e.target.closest('.process-row').remove();
            }
        }
    });
</script>

@endsection
