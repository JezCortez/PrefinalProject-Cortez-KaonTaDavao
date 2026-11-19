@extends('layouts.app')

@section('content')
@php
    $pesos = ['budget' => '₱', 'mid' => '₱₱', 'splurge' => '₱₱₱'];
    $reviewTotal = $eatery->reviews->count();
@endphp

<div class="mb-6 flex flex-wrap items-start justify-between gap-3">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight">
            {{ $eatery->name }}
            @unless ($eatery->is_open)
                <span class="ml-2 rounded bg-red-100 px-1.5 py-0.5 align-middle text-xs font-normal text-red-700">Closed</span>
            @endunless
        </h1>
        <p class="mt-1 text-sm text-stone-500">
            <a href="{{ route('districts.show', $eatery->district) }}" class="hover:underline">{{ $eatery->district->name }}</a>
            · {{ $eatery->address }} · {{ $pesos[$eatery->price_range] ?? '' }}
        </p>
        @if ($eatery->specialty)
            <p class="mt-1 text-sm">Specialty: {{ $eatery->specialty }}</p>
        @endif
    </div>

    <div class="flex gap-2">
        <a href="{{ route('eateries.edit', $eatery) }}" class="rounded border bg-white px-3 py-1.5 text-sm hover:bg-stone-50">Edit</a>
        <form method="POST" action="{{ route('eateries.destroy', $eatery) }}">
            @csrf
            @method('DELETE')
            <button class="rounded border border-red-300 bg-white px-3 py-1.5 text-sm text-red-700 hover:bg-red-50">Delete</button>
        </form>
    </div>
</div>

<div class="mb-6 flex flex-wrap gap-1">
    @foreach ($eatery->features as $feature)
        <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
           class="rounded-full border px-2 py-0.5 text-xs text-stone-600 hover:bg-stone-50">{{ $feature->name }}</a>
    @endforeach
</div>

<p class="mb-6 text-sm">
    @if ($reviewTotal > 0)
        <x-rating :value="$average" />
        <span class="text-stone-600">{{ number_format($average, 1) }} ★ ({{ $reviewTotal }} {{ $reviewTotal === 1 ? 'review' : 'reviews' }})</span>
    @else
        <span class="text-stone-500">No reviews yet</span>
    @endif
</p>

@if ($eatery->permit)
    <section class="mb-8 rounded-lg border bg-white p-4 text-sm">
        <h2 class="mb-1 font-medium">Business permit</h2>
        <p>Permit no. {{ $eatery->permit->permit_no }}</p>
        <p>
            Expires {{ $eatery->permit->expires_on->format('M d, Y') }}
            @if ($eatery->permit->isExpired())
                <span class="ml-1 font-medium text-red-600">Permit expired</span>
            @endif
        </p>
    </section>
@endif

<section class="mb-8">
    <h2 class="mb-3 font-medium">Dishes</h2>
    <ul class="divide-y rounded-lg border bg-white text-sm">
        @forelse ($eatery->dishes as $dish)
            <li class="flex items-center justify-between px-4 py-2">
                <span>
                    {{ $dish->name }}
                    @if ($dish->is_bestseller)
                        <span class="ml-1 rounded bg-amber-100 px-1.5 py-0.5 text-xs text-amber-800">Bestseller</span>
                    @endif
                </span>
                <span>₱{{ number_format($dish->price, 2) }}</span>
            </li>
        @empty
            <li class="px-4 py-2 text-stone-500">No dishes listed yet.</li>
        @endforelse
    </ul>
</section>

<section>
    <h2 class="mb-3 font-medium">Reviews</h2>

    @if ($eatery->is_open)
        @include('partials.errors')

        <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="mb-6 space-y-3 rounded-lg border bg-white p-4">
            @csrf

            <div>
                <label for="user_id" class="mb-1 block text-sm font-medium">Reviewer</label>
                <select id="user_id" name="user_id" class="w-full rounded border bg-white p-2 text-sm sm:w-auto">
                    <option value="">Choose a reviewer</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="rating" class="mb-1 block text-sm font-medium">Rating</label>
                <select id="rating" name="rating" class="rounded border bg-white p-2 text-sm">
                    <option value="">Pick stars</option>
                    @for ($star = 1; $star <= 5; $star++)
                        <option value="{{ $star }}" @selected(old('rating') == $star)>{{ $star }}</option>
                    @endfor
                </select>
                @error('rating') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="body" class="mb-1 block text-sm font-medium">Your review</label>
                <textarea id="body" name="body" rows="3" class="w-full rounded border p-2 text-sm">{{ old('body') }}</textarea>
                @error('body') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button class="rounded bg-emerald-600 px-4 py-2 text-sm text-white hover:bg-emerald-700">Post review</button>
        </form>
    @else
        <p class="mb-6 rounded-lg border bg-white p-4 text-sm text-stone-600">This eatery is closed. Reviews are paused.</p>
    @endif

    <div class="space-y-3">
        @forelse ($eatery->reviews as $review)
            <div class="rounded-lg border bg-white p-4 text-sm">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <p>
                        <a href="{{ route('reviewers.show', $review->user) }}" class="font-medium hover:underline">{{ $review->user->name }}</a>
                        <x-rating :value="$review->rating" />
                        <span class="text-xs text-stone-500">{{ $review->created_at->format('M d, Y') }}</span>
                    </p>
                    <form method="POST" action="{{ route('reviews.destroy', $review) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-xs text-red-700 underline">Delete</button>
                    </form>
                </div>
                <p class="mt-2">{{ $review->body }}</p>
            </div>
        @empty
            <p class="text-sm text-stone-500">No reviews yet.</p>
        @endforelse
    </div>
</section>
@endsection
