@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Customers</h1>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

    @forelse($customers as $customer)
        <a href="{{ route('customers.part', $customer) }}"
           class="bg-white shadow rounded p-4 text-center hover:scale-[1.02] transition">

            <div class="text-xl font-semibold">
                {{ $customer }}
            </div>

        </a>
    @empty
        <p class="text-gray-500">No customers found.</p>
    @endforelse

</div>

@endsection
