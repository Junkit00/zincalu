@extends('layouts.app')

@section('content')


<div class="grid grid-cols-2 gap-10">

    <!-- LEFT: PART IMAGE -->
    <div class="w-full h-[400px] bg-gray-200 rounded overflow-hidden flex items-center justify-center">
        @if($part->part_image && file_exists(public_path('uploads/parts/images/' . $part->part_image)))
            <img src="{{ asset('uploads/parts/images/' . $part->part_image) }}"
                 alt="{{ $part->part_name }}"
                 class="h-full object-contain">
        @else
            <span class="text-gray-400">No Image Available</span>
        @endif
    </div>

    <!-- RIGHT: PART DETAILS -->
    <div class="space-y-4">

        <!-- BASIC INFO -->
         <h2 class="font-bold text-lg mb-3 text-decoration: underline">Part Detail</h2>
        <div>
            <p><strong>Part Name:</strong> {{ $part->part_name }}</p>
            <p><strong>Customer:</strong> {{ $part->customer ?? '—' }}</p>
            <p><strong>Material:</strong> {{ $part->material ?? '—' }}</p>
            <p><strong>Avg Output / Day:</strong> {{ $part->avg_output_per_day ?? '—' }}</p>
        </div>

        <!-- PROCESS TAGS -->
        <div>
            <strong>Process:</strong>
            <div class="flex flex-wrap gap-2 mt-2">
                @foreach($part->processes as $index => $process)
                    <button
                        type="button"
                        class="process-tab px-3 py-1 text-xs rounded border
                            {{ $index === 0 ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700' }}"
                        data-process-id="{{ $process->id }}">
                        {{ $process->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- PROCESS TABLE -->
        <div class="mt-4">
            <table class="w-full border text-sm">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="border p-2 w-[10%]">Department</th>
                        <th class="border p-2 w-[10%]">Section</th>
                        <th class="border p-2 w-[15%]">Machine / Line</th>
                        <th class="border p-2 w-[15%]">Operator</th>
                        <th class="border p-2 w-[10%]">MCT</th>
                        <th class="border p-2 w-[10%]">CT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($part->processes as $index => $process)
                        <tr class="process-row {{ $index !== 0 ? 'hidden' : '' }}"
                            data-process-id="{{ $process->id }}">
                            <td class="border p-2 text-center">
                                {{ $process->pivot->department ?? '—' }}
                            </td>
                            <td class="border p-2 text-center">
                                {{ $process->pivot->section ?? '—' }}
                            </td>
                            <td class="border p-2 text-center">
                                {{ $process->pivot->machine_line ?? '—' }}
                            </td>
                            <td class="border p-2 text-center">
                                {{ $process->pivot->operator ?? '—' }}
                            </td>
                            <td class="border p-2 text-center">
                                {{ $process->pivot->mct ?? '—' }}
                            </td>
                            <td class="border p-2 text-center">
                                {{ $process->pivot->ct ?? '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- PDF SECTION -->
        <div class="mt-6">
            <h3 class="font-semibold mb-2">PDFs</h3>

            @foreach($part->processes as $index => $process)
                <div class="process-pdf {{ $index !== 0 ? 'hidden' : '' }}"
                    data-process-id="{{ $process->id }}">

                    <div class="flex gap-3 flex-wrap">
                        @if($process->pivot->qal)
                            <a href="{{ asset('uploads/parts/qal/' . $process->pivot->qal) }}"
                            target="_blank"
                            class="px-3 py-1 bg-blue-500 text-white rounded text-sm">
                                QAL
                            </a>
                        @endif

                        @if($process->pivot->work_layout)
                            <a href="{{ asset('uploads/parts/work_layout/' . $process->pivot->work_layout) }}"
                            target="_blank"
                            class="px-3 py-1 bg-blue-500 text-white rounded text-sm">
                                Work Layout
                            </a>
                        @endif

                        @if($process->pivot->work_instruction)
                            <a href="{{ asset('uploads/parts/work_instruction/' . $process->pivot->work_instruction) }}"
                            target="_blank"
                            class="px-3 py-1 bg-blue-500 text-white rounded text-sm">
                                Work Instruction
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- PART DOCUMENTS -->
        <hr class="my-6">

        <h3 class="font-semibold text-lg mb-3">Part Documents</h3>

        <div class="grid grid-cols-3 gap-4">

            @php
                $docs = [
                    'drawing' => 'Drawing',
                    'inspection_gauge' => 'Inspection Gauge',
                    'machine_setup_parameter' => 'Machine Setup Parameter',
                    'operation_jig' => 'Operation Jig',
                    'operation_sheet' => 'Operation Sheet',
                    'process_standard_sheet' => 'Process Standard Sheet',
                    'program_list' => 'Program List',
                    'project_status' => 'Project Status',
                    'tooling' => 'Tooling',
                ];
            @endphp

            @foreach($docs as $field => $label)
                <div class="border rounded p-3 bg-gray-50">
                    <p class="font-semibold text-sm mb-2">{{ $label }}</p>

                    @if($part->$field)
                        <a href="{{ asset("uploads/parts/$field/".$part->$field) }}"
                        target="_blank"
                        class="text-blue-600 underline text-sm">
                            View {{ $label }}
                        </a>
                    @else
                        <span class="text-gray-400 text-sm italic">
                            Not uploaded
                        </span>
                    @endif
                </div>
            @endforeach

        </div>
    </div>
</div>

<script>
    const tabs = document.querySelectorAll('.process-tab');
    const rows = document.querySelectorAll('.process-row');
    const pdfs = document.querySelectorAll('.process-pdf');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const id = tab.dataset.processId;

            // Toggle active tab
            tabs.forEach(t => {
                t.classList.remove('bg-green-500', 'text-white');
                t.classList.add('bg-gray-100', 'text-gray-700');
            });
            tab.classList.add('bg-green-500', 'text-white');
            tab.classList.remove('bg-gray-100', 'text-gray-700');

            // Show selected row
            rows.forEach(row => {
                row.classList.toggle('hidden', row.dataset.processId !== id);
            });

            // Show selected PDFs
            pdfs.forEach(pdf => {
                pdf.classList.toggle('hidden', pdf.dataset.processId !== id);
            });
        });
    });
</script>

@endsection