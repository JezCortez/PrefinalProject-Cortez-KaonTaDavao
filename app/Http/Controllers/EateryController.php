<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEateryRequest;
use App\Http\Requests\UpdateEateryRequest;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EateryController extends Controller
{
    public function index(Request $request)
    {
        $eateries = Eatery::query()
            ->with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            // q is grouped so the OR does not break the other filters
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%' . $request->input('q') . '%';

                $query->where(function ($inner) use ($term) {
                    $inner->where('name', 'like', $term)
                        ->orWhere('specialty', 'like', $term);
                });
            })
            ->when($request->filled('district'), function ($query) use ($request) {
                $query->where('district_id', $request->input('district'));
            })
            ->when($request->filled('feature'), function ($query) use ($request) {
                $query->whereHas('features', function ($inner) use ($request) {
                    $inner->where('name', $request->input('feature'));
                });
            })
            ->orderBy('name')
            ->paginate(6)
            ->withQueryString();

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.index', compact('eateries', 'districts', 'features'));
    }

    public function create()
    {
        // new Eatery with is_open on so the checkbox starts ticked
        $eatery = new Eatery(['is_open' => true]);
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.create', compact('eatery', 'districts', 'features'));
    }

    public function store(StoreEateryRequest $request)
    {
        $data = $request->validated();

        $eateryData = Arr::only($data, ['district_id', 'name', 'address', 'price_range', 'specialty']);
        $eateryData['slug'] = Str::slug($data['name']);
        $eateryData['is_open'] = (bool) ($data['is_open'] ?? false);

        $eatery = Eatery::create($eateryData);

        $eatery->permit()->create([
            'permit_no' => $data['permit_no'],
            'expires_on' => $data['expires_on'],
        ]);

        $eatery->features()->sync($data['features']);

        return redirect()->route('eateries.show', $eatery)->with('status', 'Eatery added.');
    }

    public function show(Eatery $eatery)
    {
        $eatery->load([
            'district',
            'features',
            'permit',
            'dishes',
            'reviews' => function ($query) {
                $query->with('user')->latest()->latest('id');
            },
        ]);

        $users = User::orderBy('name')->get();
        $average = $eatery->reviews->avg('rating');

        return view('eateries.show', compact('eatery', 'users', 'average'));
    }

    public function edit(Eatery $eatery)
    {
        $eatery->load(['permit', 'features']);

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.edit', compact('eatery', 'districts', 'features'));
    }

    public function update(UpdateEateryRequest $request, Eatery $eatery)
    {
        $data = $request->validated();

        $eateryData = Arr::only($data, ['district_id', 'name', 'address', 'price_range', 'specialty']);
        $eateryData['slug'] = Str::slug($data['name']);
        $eateryData['is_open'] = (bool) ($data['is_open'] ?? false);

        $eatery->update($eateryData);

        // the eatery already has a permit, so this just updates it
        $eatery->permit()->updateOrCreate([], [
            'permit_no' => $data['permit_no'],
            'expires_on' => $data['expires_on'],
        ]);

        $eatery->features()->sync($data['features']);

        return redirect()->route('eateries.show', $eatery)->with('status', 'Eatery updated.');
    }

    public function destroy(Eatery $eatery)
    {
        // remove the children first, all through the relationships
        DB::transaction(function () use ($eatery) {
            $eatery->reviews()->delete();
            $eatery->dishes()->delete();
            $eatery->permit()->delete();
            $eatery->features()->detach();
            $eatery->delete();
        });

        return redirect()->route('eateries.index')->with('status', 'Eatery deleted.');
    }
}
