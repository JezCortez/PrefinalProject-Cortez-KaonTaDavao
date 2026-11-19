@props(['eatery'])

@php
    $pesos = ['budget' => '₱', 'mid' => '₱₱', 'splurge' => '₱₱₱'];
@endphp

<article class="flex flex-col rounded-lg border bg-white p-4">
    <div class="flex items-start justify-between gap-2">
        <h2 class="font-medium">
            <a href="{{ route('eateries.show', $eatery) }}" class="hover:underline">{{ $eatery->name }}</a>
        </h2>

        @unless ($eatery->is_open)
            <span class="rounded bg-red-100 px-1.5 py-0.5 text-xs text-red-700">Closed</span>
        @endunless
    </div>

    <p class="mt-1 text-sm text-stone-500">
        <a href="{{ route('districts.show', $eatery->district) }}" class="hover:underline">{{ $eatery->district->name }}</a>
        · {{ $pesos[$eatery->price_range] ?? '' }}
    </p>

    @if ($eatery->specialty)
        <p class="mt-1 text-sm">{{ $eatery->specialty }}</p>
    @endif

    <div class="mt-3 flex flex-wrap gap-1">
        @foreach ($eatery->features as $feature)
            <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
               class="rounded-full border px-2 py-0.5 text-xs text-stone-600 hover:bg-stone-50">{{ $feature->name }}</a>
        @endforeach
    </div>

    <p class="mt-3 text-sm">
        @if ($eatery->reviews_count > 0)
            <x-rating :value="$eatery->reviews_avg_rating" />
            <span class="text-stone-600">{{ number_format($eatery->reviews_avg_rating, 1) }} ★ ({{ $eatery->reviews_count }} {{ $eatery->reviews_count === 1 ? 'review' : 'reviews' }})</span>
        @else
            <span class="text-stone-500">No reviews yet</span>
        @endif
    </p>
</article>
