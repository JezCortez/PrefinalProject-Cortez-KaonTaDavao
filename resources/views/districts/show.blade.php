@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold tracking-tight">{{ $district->name }}</h1>
<p class="mb-6 mt-1 text-sm text-stone-500">{{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }} in {{ $district->name }}</p>

<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
    @forelse ($district->eateries as $eatery)
        <x-eatery-card :eatery="$eatery" />
    @empty
        <p class="text-stone-500 md:col-span-2 lg:col-span-3">No eateries in this district yet.</p>
    @endforelse
</div>
@endsection
