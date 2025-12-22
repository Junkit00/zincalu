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
            <div class="flex flex-wrap gap-2 mt-1">
                @forelse($part->processes as $process)
                    <span class="px-2 py-1 text-xxs rounded bg-green-100 text-green-700">
                        {{ $process->name }}
                    </span>
                @empty
                    <span class="text-gray-400">N/A</span>
                @endforelse
            </div>
        </div>

        <!-- PROCESS TABLE -->
        <div class="mt-4">
            <table class="w-full border-2 border-black-100 text-sm table-auto">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="border-2 border-black-100 p-2 text-left w-[20%]">Process</th>
                        <th class="border-2 border-black-100 p-2 w-[15%]">Machine / Line</th>
                        <th class="border-2 border-black-100 p-2 w-[15%]">Operator</th>
                        <th class="border-2 border-black-100 p-2 w-[10%]">MCT</th>
                        <th class="border-2 border-black-100 p-2 w-[10%]">CT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($part->processes as $process)
                        <tr>
                            <td class="border-2 border-black-100 p-2 font-semibold">
                                {{ $process->name }}
                            </td>
                            <td class="border-2 border-black-100 p-2">
                                {{ $process->pivot->machine_line ?? '—' }}
                            </td>
                            <td class="border-2 border-black-100 p-2">
                                {{ $process->pivot->operator ?? '—' }}
                            </td>
                            <td class="border-2 border-black-100 p-2 text-center">
                                {{ $process->pivot->mct ?? '—' }}
                            </td>
                            <td class="border-2 border-black-400 p-2 text-center">
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

            @foreach($part->processes as $process)
                <div class="mb-4 border rounded p-3">

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

    </div>
</div>

@endsection
