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

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold">Part Name</label>
                <input type="text" name="part_name" class="border p-2 rounded w-full" value="{{ old('part_name', $part->part_name) }}" required>
            </div>

            <div>
                <label class="block font-semibold">Customer</label>
                <input type="text" name="customer" class="border p-2 rounded w-full" value="{{ old('customer', $part->customer) }}">
            </div>

            <div>
                <label class="block font-semibold">Machine Line</label>
                <input type="text" name="machine_line" class="border p-2 rounded w-full" value="{{ old('machine_line', $part->machine_line) }}">
            </div>

            <div>
                <label class="block font-semibold">Operator</label>
                <input type="text" name="operator" class="border p-2 rounded w-full" value="{{ old('operator', $part->operator) }}">
            </div>

            <div>
                <label class="block font-semibold">Department</label>
                <input type="text" name="department" class="border p-2 rounded w-full" value="{{ old('department', $part->department) }}">
            </div>

            <div>
                <label class="block font-semibold">Section</label>
                <input type="text" name="section" class="border p-2 rounded w-full" value="{{ old('section', $part->section) }}">
            </div>

            <div>
                <label class="block font-semibold">Material</label>
                <input type="text" name="material" class="border p-2 rounded w-full" value="{{ old('material', $part->material) }}">
            </div>

            <div>
                <label class="block font-semibold">MCT</label>
                <input type="number" name="mct" class="border p-2 rounded w-full" value="{{ old('mct', $part->mct) }}">
            </div>

            <div>
                <label class="block font-semibold">CT</label>
                <input type="number" name="ct" class="border p-2 rounded w-full" value="{{ old('ct', $part->ct) }}">
            </div>

            <div>
                <label class="block font-semibold">Avg Output per Day</label>
                <input type="number" name="avg_output_per_day" class="border p-2 rounded w-full" value="{{ old('avg_output_per_day', $part->avg_output_per_day) }}">
            </div>

            <div>
                <label class="block font-semibold">Main Reject Reason</label>
                <input type="text" name="main_reject_reason" class="border p-2 rounded w-full" value="{{ old('main_reject_reason', $part->main_reject_reason) }}">
            </div>
        </div>

        <hr class="my-4">

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold">Part Image (jpg/png)</label>
                @if($part->part_image && file_exists(public_path('uploads/parts/images/' . $part->part_image)))
                    <div class="mb-2">
                        <img src="{{ asset('uploads/parts/images/' . $part->part_image) }}" class="w-40 h-40 object-cover rounded shadow">
                    </div>
                @endif
                <input type="file" name="part_image" accept="image/*" class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold">QAL (PDF)</label>
                @if($part->qal && file_exists(public_path('uploads/parts/qal/' . $part->qal)))
                    <div class="mb-2">
                        <a href="{{ asset('uploads/parts/qal/' . $part->qal) }}" download class="underline text-blue-600">{{ $part->qal }}</a>
                    </div>
                @endif
                <input type="file" name="qal" accept="application/pdf" class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold">Work Layout (PDF)</label>
                @if($part->work_layout && file_exists(public_path('uploads/parts/work_layout/' . $part->work_layout)))
                    <div class="mb-2">
                        <a href="{{ asset('uploads/parts/work_layout/' . $part->work_layout) }}" download class="underline text-blue-600">{{ $part->work_layout }}</a>
                    </div>
                @endif
                <input type="file" name="work_layout" accept="application/pdf" class="border p-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold">Work Instruction (PDF)</label>
                @if($part->work_instruction && file_exists(public_path('uploads/parts/work_instruction/' . $part->work_instruction)))
                    <div class="mb-2">
                        <a href="{{ asset('uploads/parts/work_instruction/' . $part->work_instruction) }}" download class="underline text-blue-600">{{ $part->work_instruction }}</a>
                    </div>
                @endif
                <input type="file" name="work_instruction" accept="application/pdf" class="border p-2 rounded w-full">
            </div>
        </div>

        <div class="mt-6 flex gap-2">
            <button type="submit" class="bg-black text-white px-4 py-2 rounded">Save Changes</button>
            <a href="{{ route('parts.manage') }}" class="border px-4 py-2 rounded">Cancel</a>
        </div>
    </form>
</div>

@endsection
