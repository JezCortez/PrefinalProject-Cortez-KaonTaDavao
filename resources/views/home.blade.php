@extends('layouts.app')

@section('content')
<h1 class="mb-6 text-2xl font-semibold tracking-tight">Kaon na ta, Davao!</h1>

<div class="mb-10 grid gap-4 sm:grid-cols-3">
    <div class="rounded-lg border bg-white p-4">
        <p class="text-xs uppercase tracking-wide text-stone-500">Eateries</p>
        <p class="mt-1 text-3xl font-semibold">{{ $eateryCount }}</p>
    </div>
    <div class="rounded-lg border bg-white p-4">
        <p class="text-xs uppercase tracking-wide text-stone-500">Districts</p>
        <p class="mt-1 text-3xl font-semibold">{{ $districtCount }}</p>
    </div>
    <div class="rounded-lg border bg-white p-4">
        <p class="text-xs uppercase tracking-wide text-stone-500">Reviews</p>
        <p class="mt-1 text-3xl font-semibold">{{ $reviewCount }}</p>
    </div>
</div>

<h2 class="mb-4 text-lg font-medium">Top Rated</h2>

<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
    @forelse ($topRated as $eatery)
        <x-eatery-card :eatery="$eatery" />
    @empty
        <p class="text-stone-500 md:col-span-2 lg:col-span-3">No reviews yet.</p>
    @endforelse
</div>
@endsection
