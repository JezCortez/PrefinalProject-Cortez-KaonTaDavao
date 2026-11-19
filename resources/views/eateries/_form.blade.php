@php
    // on create there is no saved permit or features yet
    $permit = $eatery->exists ? $eatery->permit : null;
    $chosenFeatures = old('features', $eatery->exists ? $eatery->features->pluck('id')->all() : []);
@endphp

@include('partials.errors')

<div>
    <label for="name" class="mb-1 block text-sm font-medium">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name', $eatery->name) }}" class="w-full rounded border p-2 text-sm">
    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="district_id" class="mb-1 block text-sm font-medium">District</label>
    <select id="district_id" name="district_id" class="w-full rounded border bg-white p-2 text-sm sm:w-auto">
        <option value="">Choose a district</option>
        @foreach ($districts as $district)
            <option value="{{ $district->id }}" @selected(old('district_id', $eatery->district_id) == $district->id)>{{ $district->name }}</option>
        @endforeach
    </select>
    @error('district_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="address" class="mb-1 block text-sm font-medium">Address</label>
    <input id="address" type="text" name="address" value="{{ old('address', $eatery->address) }}" class="w-full rounded border p-2 text-sm">
    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="price_range" class="mb-1 block text-sm font-medium">Price range</label>
    <select id="price_range" name="price_range" class="rounded border bg-white p-2 text-sm">
        <option value="">Choose one</option>
        @foreach (['budget' => '₱ Budget', 'mid' => '₱₱ Mid', 'splurge' => '₱₱₱ Splurge'] as $value => $label)
            <option value="{{ $value }}" @selected(old('price_range', $eatery->price_range) === $value)>{{ $label }}</option>
        @endforeach
    </select>
    @error('price_range') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="specialty" class="mb-1 block text-sm font-medium">Specialty (optional)</label>
    <input id="specialty" type="text" name="specialty" value="{{ old('specialty', $eatery->specialty) }}" class="w-full rounded border p-2 text-sm">
    @error('specialty') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    {{-- the hidden 0 makes an unticked box send false, so old() remembers it --}}
    <input type="hidden" name="is_open" value="0">
    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_open" value="1" @checked(old('is_open', $eatery->is_open))>
        Open for business
    </label>
    @error('is_open') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <p class="mb-1 text-sm font-medium">Features</p>
    <div class="flex flex-wrap gap-4 text-sm">
        @foreach ($features as $feature)
            <label class="flex items-center gap-1">
                <input type="checkbox" name="features[]" value="{{ $feature->id }}" @checked(in_array($feature->id, $chosenFeatures))>
                {{ $feature->name }}
            </label>
        @endforeach
    </div>
    @error('features') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    @error('features.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="permit_no" class="mb-1 block text-sm font-medium">Permit number</label>
    <input id="permit_no" type="text" name="permit_no" value="{{ old('permit_no', $permit?->permit_no) }}" placeholder="DVO-2026-0415" class="w-full rounded border p-2 text-sm sm:w-64">
    @error('permit_no') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="expires_on" class="mb-1 block text-sm font-medium">Permit expires on</label>
    <input id="expires_on" type="date" name="expires_on" value="{{ old('expires_on', $permit?->expires_on?->format('Y-m-d')) }}" class="rounded border p-2 text-sm">
    @error('expires_on') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>
