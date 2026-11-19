@extends('layouts.app')

@section('content')
@php
    $total = $user->reviews->count();
@endphp

<h1 class="text-2xl font-semibold tracking-tight">{{ $user->name }}</h1>
<p class="mb-6 mt-1 text-sm text-stone-500">{{ $total }} {{ $total === 1 ? 'review' : 'reviews' }} written</p>

<div class="space-y-3">
    @forelse ($user->reviews as $review)
        <div class="rounded-lg border bg-white p-4 text-sm">
            <p>
                <a href="{{ route('eateries.show', $review->eatery) }}" class="font-medium hover:underline">{{ $review->eatery->name }}</a>
                <x-rating :value="$review->rating" />
            </p>
            <p class="mt-2">{{ $review->body }}</p>
        </div>
    @empty
        <p class="text-stone-500">No reviews written yet.</p>
    @endforelse
</div>
@endsection
