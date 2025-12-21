@extends('layouts.layout')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">

    <h2 class="text-xl font-bold mb-4">Referral Settings</h2>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('company.referral.update') }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-6">

            <div>
                <label class="font-semibold">Reward Per Join</label>
                <input type="number" name="reward_per_join"
                    value="{{ old('reward_per_join', $settings->reward_per_join) }}"
                    class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="font-semibold">Bonus On First Class</label>
                <input type="number" name="bonus_on_first_class"
                    value="{{ old('bonus_on_first_class', $settings->bonus_on_first_class) }}"
                    class="w-full border px-3 py-2 rounded">
            </div>

            <div class="col-span-2">
                <label class="font-semibold">How It Works Title</label>
                <input type="text" name="how_it_works"
                    value="{{ old('how_it_works', $settings->how_it_works) }}"
                    class="w-full border px-3 py-2 rounded">
            </div>

            <div class="col-span-2">
                <label class="font-semibold">How It Works Description</label>
                <textarea name="how_it_works_description"
                    class="w-full border px-3 py-2 rounded"
                    rows="3">{{ old('how_it_works_description', $settings->how_it_works_description) }}</textarea>
            </div>

            <div class="col-span-2">
                <label class="font-semibold">Badge Title</label>
                <input type="text" name="badge_title"
                    value="{{ old('badge_title', $settings->badge_title) }}"
                    class="w-full border px-3 py-2 rounded">
            </div>

            <div class="col-span-2">
                <label class="font-semibold">Badge Description</label>
                <textarea name="badge_description"
                    class="w-full border px-3 py-2 rounded"
                    rows="3">{{ old('badge_description', $settings->badge_description) }}</textarea>
            </div>

            <div class="col-span-2">
                <label class="font-semibold">Share Link Description</label>
                <textarea name="share_link_description"
                    class="w-full border px-3 py-2 rounded"
                    rows="3">{{ old('share_link_description', $settings->share_link_description) }}</textarea>
            </div>

        </div>

        <button class="bg-blue-600 text-white px-6 py-2 rounded mt-4">Save Settings</button>
    </form>
</div>
@endsection
