@extends('layouts.app')

@section('content')
<h1 class="mb-6 text-2xl font-semibold tracking-tight">Eateries</h1>

<form method="GET" action="{{ route('eateries.index') }}" class="mb-6 flex flex-col gap-2 md:flex-row">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or specialty"
           class="w-full rounded border bg-white p-2 text-sm md:flex-1">

    <select name="district" class="rounded border bg-white p-2 text-sm">
        <option value="">All districts</option>
        @foreach ($districts as $district)
            <option value="{{ $district->id }}" @selected(request('district') == $district->id)>{{ $district->name }}</option>
        @endforeach
    </select>

    <select name="feature" class="rounded border bg-white p-2 text-sm">
        <option value="">All features</option>
        @foreach ($features as $feature)
            <option value="{{ $feature->name }}" @selected(request('feature') === $feature->name)>{{ $feature->name }}</option>
        @endforeach
    </select>

    <button class="rounded bg-emerald-600 px-4 py-2 text-sm text-white hover:bg-emerald-700">Filter</button>
</form>

<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
    @forelse ($eateries as $eatery)
        <x-eatery-card :eatery="$eatery" />
    @empty
        <p class="text-stone-500 md:col-span-2 lg:col-span-3">No eateries match your filters.</p>
    @endforelse
</div>

<div class="mt-6">{{ $eateries->links() }}</div>
@endsection
