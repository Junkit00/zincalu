@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-4 rounded shadow">

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2 class="text-xl font-semibold mb-6">Create New Part</h2>

    <form action="{{ route('parts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Part Information --}}
        <h3 class="font-semibold text-lg mb-3">Part Information</h3>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="font-semibold">Part Name</label>
                <input type="text" name="part_name" class="border p-2 rounded w-full" required>
            </div>

            <div>
                <label class="font-semibold">Customer</label>
                <input type="text" name="customer" class="border p-2 rounded w-full" required>
            </div>

            <div>
                <label class="font-semibold">Material</label>
                <input type="text" name="material" class="border p-2 rounded w-full" required>
            </div>

            <div>
                <label class="font-semibold">Avg Output (Day)</label>
                <input type="number" name="avg_output_per_day" class="border p-2 rounded w-full">
            </div>

            <div class="col-span-2">
                <label class="font-semibold">Part Image</label>
                <input type="file" name="part_image" class="border p-2 rounded w-full" required>
            </div>
        </div>

        <hr class="my-6">

        <h3 class="font-semibold text-lg mb-3">Part Documents</h3>

        <div class="grid grid-cols-3 gap-4">

            <div>
                <label class="font-semibold">Drawing (PDF)</label>
                <input type="file" name="drawing" accept="application/pdf"
                    class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="font-semibold">Inspection Gauge</label>
                <input type="file" name="inspection_gauge" accept="application/pdf"
                    class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="font-semibold">Machine Setup Parameter</label>
                <input type="file" name="machine_setup_parameter" accept="application/pdf"
                    class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="font-semibold">Operation Jig</label>
                <input type="file" name="operation_jig" accept="application/pdf"
                    class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="font-semibold">Operation Sheet</label>
                <input type="file" name="operation_sheet" accept="application/pdf"
                    class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="font-semibold">Process Standard Sheet</label>
                <input type="file" name="process_standard_sheet" accept="application/pdf"
                    class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="font-semibold">Program List</label>
                <input type="file" name="program_list" accept="application/pdf"
                    class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="font-semibold">Project Status</label>
                <input type="file" name="project_status" accept="application/pdf"
                    class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="font-semibold">Tooling</label>
                <input type="file" name="tooling" accept="application/pdf"
                    class="border p-2 rounded w-full">
            </div>

        </div>


        <hr class="my-6">

        {{-- Process Section --}}
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-semibold text-lg">Process Flow</h3>
            <button type="button" id="add-process" class="px-3 py-1 border rounded bg-gray-100">+ Add Process</button>
        </div>

        <div id="process-container" class="space-y-4">

            {{-- NEW PROCESSES --}}
                <div class="process-row border rounded p-4 bg-gray-50">

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="font-semibold">Process</label>
                            <select name="processes[]" class="process-select border p-2 rounded w-full" required>
                                <option value="">Select Process</option>
                                <option value="1">Die Casting</option>
                                <option value="2">Shotblast</option>
                                <option value="3">Deburring</option>
                                <option value="4">Powder Coating</option>
                                <option value="5">Machining</option>
                                <option value="6">Packing</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-semibold">Department</label>
                            <input type="text" name="departments[]"
                                class="border p-2 rounded w-full">
                        </div>

                        <div>
                            <label class="font-semibold">Section</label>
                            <input type="text" name="sections[]"
                                class="border p-2 rounded w-full">
                        </div>


                        <div>
                            <label class="font-semibold">Machine / Line</label>
                            <input type="text" name="machine_lines[]"
                                class="border p-2 rounded w-full">
                        </div>

                        <div>
                            <label class="font-semibold">Operator</label>
                            <input type="text" name="operators[]"
                                class="border p-2 rounded w-full">
                        </div>

                        <div>
                            <label class="font-semibold">MCT</label>
                            <input type="number" name="mcts[]"
                                class="border p-2 rounded w-full">
                        </div>

                        <div>
                            <label class="font-semibold">CT</label>
                            <input type="number" name="cts[]"
                                class="border p-2 rounded w-full">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 mt-3">
                        <div>
                            <label class="font-semibold">QAL (PDF)</label>
                            <input type="file" name="qals[]" accept="application/pdf"
                                class="border p-2 rounded w-full">
                        </div>

                        <div>
                            <label class="font-semibold">Work Layout (PDF)</label>
                            <input type="file" name="work_layouts[]" accept="application/pdf"
                                class="border p-2 rounded w-full">
                        </div>

                        <div>
                            <label class="font-semibold">Work Instruction (PDF)</label>
                            <input type="file" name="work_instructions[]" accept="application/pdf"
                                class="border p-2 rounded w-full">
                        </div>
                    </div>

                    <div class="text-right mt-3">
                        <button type="button" class="remove-process text-red-600 text-sm">Remove Process</button>
                    </div>
                </div>
        </div>

        <hr class="my-6">

        <div class="flex gap-3">
            <button type="submit" class="bg-black text-white px-5 py-2 rounded">Create Part</button>
            <a href="{{ route('parts.manage') }}" class="border px-5 py-2 rounded">Cancel</a>
        </div>
    </form>
</div>

<script>
    // Add/Remove Process
    document.getElementById('add-process').addEventListener('click', () => {
        const container = document.getElementById('process-container');
        const row = document.querySelector('.process-row').cloneNode(true);
        row.querySelectorAll('input, select').forEach(el => el.value = '');
        container.appendChild(row);
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
