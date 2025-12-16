@extends('layouts.app')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold">
        Customer: {{ $customer }}
    </h1>

    <a href="{{ route('customers.index') }}"
       class="text-sm text-blue-600 underline">
        ← Back to Customers
    </a>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

    @forelse($parts as $part)
        <a href="{{ route('parts.show', $part->id) }}"
           class="bg-white shadow rounded p-4 hover:scale-[1.02] transition">

            <!-- Part Image -->
            <div class="h-40 bg-gray-200 rounded mb-3 flex items-center justify-center overflow-hidden">
                @if($part->part_image)
                    <img src="{{ asset('uploads/parts/images/' . $part->part_image) }}"
                         class="h-full object-contain">
                @else
                    <span class="text-gray-400 text-sm">No Image</span>
                @endif
            </div>

            <!-- Part Name -->
            <p class="text-center font-semibold">
                {{ $part->part_name }}
            </p>

        </a>
    @empty
        <p class="text-gray-500">No parts found for this customer.</p>
    @endforelse

</div>

@endsection
