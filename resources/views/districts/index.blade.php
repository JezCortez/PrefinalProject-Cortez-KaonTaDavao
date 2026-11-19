@extends('layouts.app')

@section('content')
<h1 class="mb-6 text-2xl font-semibold tracking-tight">Districts</h1>

<ul class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($districts as $district)
        <li>
            <a href="{{ route('districts.show', $district) }}" class="block rounded-lg border bg-white p-4 hover:bg-stone-50">
                <span class="font-medium">{{ $district->name }}</span>
                <span class="block text-sm text-stone-500">{{ $district->eateries_count }} {{ $district->eateries_count === 1 ? 'eatery' : 'eateries' }}</span>
            </a>
        </li>
    @endforeach
</ul>
@endsection
