@extends('layouts.app')

@section('content')

<!-- SEARCH BAR -->
<div class="mb-6">
    <h2 class="text-xl font-semibold mb-3">Search</h2>

    <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-3 gap-4">

        <input type="text" name="part_name" class="border p-2 rounded" 
               placeholder="Part Name" value="{{ request('part_name') }}">

        <input list="customer-list" name="customer" class="border p-2 rounded" 
               placeholder="Customer" value="{{ request('customer') }}">
        <datalist id="customer-list">
            @foreach($customers as $customer)
                <option value="{{ $customer }}"></option>
            @endforeach
        </datalist>

        <button type="submit" class="bg-black text-white px-4 py-2 rounded">Search</button>
    </form>
</div>

<!-- PART GRID -->
<div class="grid grid-cols-4 gap-6 mt-6">

    @foreach($parts as $part)
    <a href="{{ route('parts.show', $part->id) }}" class="bg-white shadow p-4 rounded hover:scale-[1.02] transition">
        <div class="w-full aspect-square bg-gray-200 rounded mb-3">
            @if($part->part_image)
                <img src="{{ asset('uploads/parts/images/' . $part->part_image) }}" 
                     alt="{{ $part->part_name }}" class="w-full h-full object-cover rounded">
            @endif
        </div>
        <p class="text-center font-semibold">{{ $part->part_name }}</p>
    </a>
    @endforeach

</div>

@endsection
