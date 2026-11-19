@extends('layouts.app')

@section('content')
<h1 class="mb-4 text-2xl font-semibold tracking-tight">Add Eatery</h1>

<form method="POST" action="{{ route('eateries.store') }}" class="space-y-4 rounded-lg border bg-white p-6">
    @csrf
    @include('eateries._form')

    <button class="rounded bg-emerald-600 px-4 py-2 text-sm text-white hover:bg-emerald-700">Save eatery</button>
</form>
@endsection
