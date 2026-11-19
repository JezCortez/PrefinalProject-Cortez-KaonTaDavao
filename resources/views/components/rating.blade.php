@props(['value'])

@php
    // round to the nearest whole star
    $filled = (int) round($value);
@endphp

<span class="text-amber-500" aria-label="{{ $filled }} out of 5 stars">{{ str_repeat('★', $filled) }}<span class="text-stone-300">{{ str_repeat('☆', 5 - $filled) }}</span></span>
