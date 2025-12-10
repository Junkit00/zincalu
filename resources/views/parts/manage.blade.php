@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Manage Parts</h2>
    <a href="{{ route('parts.create') }}" class="bg-black text-white px-4 py-2 rounded">Create New Part</a>
</div>

<!-- SEARCH BAR -->
<div class="mb-6">
    <form method="GET" action="{{ route('parts.manage') }}" class="grid grid-cols-4 gap-4">
        <input type="text" name="part_name" class="border p-2 rounded" placeholder="Part Name" value="{{ request('part_name') }}">
        <input list="customer-list" name="customer" class="border p-2 rounded" placeholder="Customer" value="{{ request('customer') }}">
        <datalist id="customer-list">
            @foreach($customers as $customer)
                <option value="{{ $customer }}"></option>
            @endforeach
        </datalist>
        <div class="flex gap-2">
            <button type="submit" class="bg-black text-white px-4 py-2 rounded">Search</button>
            <a href="{{ route('parts.manage') }}" class="border px-4 py-2 rounded">Reset</a>
        </div>
    </form>
</div>

<!-- PART GRID -->
<div class="grid grid-cols-4 gap-6 mt-6">

    @foreach($parts as $part)
    <div class="bg-white shadow p-4 rounded hover:scale-[1.02] transition relative">
        <a href="{{ route('parts.show', $part->id) }}">
            <div class="w-full aspect-square bg-gray-200 rounded mb-3 overflow-hidden">
                @if($part->part_image && file_exists(public_path('uploads/parts/images/' . $part->part_image)))
                    <img src="{{ asset('uploads/parts/images/' . $part->part_image) }}" alt="{{ $part->part_name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">No image</div>
                @endif
            </div>
        </a>

        <p class="text-center font-semibold mb-2">{{ $part->part_name }}</p>

        <div class="flex justify-between gap-2">
            <a href="{{ route('parts.edit', $part->id) }}" class="w-1/2 text-center border px-2 py-1 rounded">Edit</a>

            <form action="{{ route('parts.destroy', $part->id) }}" method="POST" onsubmit="return confirm('Delete this part?');" class="w-1/2">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 text-white px-2 py-1 rounded">Delete</button>
            </form>
        </div>
    </div>
    @endforeach

</div>

@endsection
