@extends('layouts.app')

@section('content')

<!-- SEARCH BAR -->
<div class="mb-6">
    <h2 class="text-xl font-semibold mb-3">Search</h2>

    <div class="grid grid-cols-3 gap-4">

        <select class="border p-2 rounded">
            <option>A - Z</option>
            <option>Z - A</option>
        </select>

        <input type="text" class="border p-2 rounded" placeholder="Part Name">

        <select class="border p-2 rounded">
            <option>Customer</option>
            <option>Customer A</option>
            <option>Customer B</option>
        </select>
    </div>
</div>

<!-- PART GRID -->
<div class="grid grid-cols-4 gap-6 mt-6">

    @foreach($parts as $part)
    <a href="{{ route('parts.show', $part->id) }}" class="bg-white shadow p-4 rounded hover:scale-[1.02] transition">
        <div class="w-full aspect-square bg-gray-200 rounded mb-3"></div>
        <p class="text-center font-semibold">{{ $part->part_name }}</p>
    </a>
    @endforeach

</div>

@endsection
