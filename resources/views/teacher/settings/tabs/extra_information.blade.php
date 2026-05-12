@php
    $languages = ['English', 'Hindi', 'Tamil', 'Malayalam', 'Kannada', 'Telugu'];
    $selected = $teacher->speaking_languages ?? [];
@endphp
{{-- EXTRA INFORMATION TAB --}}
<div class="mb-6 flex justify-between items-center">

    <div>
        <h3 class="text-2xl font-black text-slate-800 dark:text-white">
            Extra Information
        </h3>

        <p class="text-slate-500 text-sm">
            Academic & profile additional details
        </p>
    </div>

    <button onclick="toggleModal('extraModal')"
        class="px-5 py-2 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold">

        <i class="bi bi-pencil"></i> Edit

    </button>

</div>

{{-- VIEW --}}
<div class="grid md:grid-cols-2 gap-3">
    {{--  --}}
    <x-info label="Qualification" :value="$teacher->qualifications ?? '-'" />

    <div class="md:col-span-2">

        <label class="font-bold text-sm">Speaking Languages</label>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-2">

            @foreach ($languages as $lang)
                <label class="flex items-center gap-2 bg-slate-100 dark:bg-slate-700 p-2 rounded-lg">

                    <input type="checkbox" disabled class="border" value="{{ $lang }}"
                        {{ in_array($lang, $selected) ? 'checked' : '' }}>

                    <span>{{ $lang }}</span>

                </label>
            @endforeach

        </div>

    </div>

    <x-info label="Price Per Hour" :value="'₹' . number_format($teacher->price_per_hour ?? 0, 2)" />

    <x-info label="Total Experience" :value="$teacher->year_exp ?? 0 . ' Years'" />


    <div class="md:col-span-2">

        <x-info label="Bio" :value="$teacher->bio ?? '-'" />

    </div>

</div>




<!-- EXTRA MODAL -->
<div id="extraModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-[#050708] w-1/2 dark:bg-slate-800 w-full  rounded-2xl shadow-xl p-6">
        <div class="flex justify-between items-center mb-4">

            <h2 class="text-xl font-black text-slate-800 dark:text-white">
                Edit Extra Information
            </h2>

            <button onclick="toggleModal('extraModal')" class="text-red-500 text-2xl font-bold">×</button>

        </div>

        <form method="POST" action="{{ route('teacher.settings.extra.update') }}">
            @csrf

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label>Qualifications <br>( use comma ',' more than Qualifications )</label>

                    <input name="qualifications" value="{{ $teacher->qualifications }}" placeholder="Qualification"
                        class="input">
                </div>



                <div class="md:col-span-2">

                    <label class="font-bold text-sm">Speaking Languages</label>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-2">

                        @foreach ($languages as $lang)
                            <label class="flex items-center gap-2 bg-slate-100 dark:bg-slate-700 p-2 rounded-lg">

                                <input type="checkbox" name="speaking_languages[]" value="{{ $lang }}"
                                    {{ in_array($lang, $selected) ? 'checked' : '' }}>

                                <span>{{ $lang }}</span>

                            </label>
                        @endforeach

                    </div>

                </div>
                <div>
                    <label>Price per Hour</label>
                    <input type="number" name="price_per_hour" value="{{ $teacher->price_per_hour }}"
                        placeholder="Price Per Hour" class="input">
                </div>
                <div>
                    <label>Total year Experice</label>
                    <input type="number" name="year_exp" value="{{ $teacher->year_exp }}"
                        placeholder="Total Experience" class="input">
                </div>


            </div>
 <div class="w-full">
                    <label>Bio</label>
                    <textarea name="bio" rows="4" placeholder="Bio" class="input md:col-span-2">{{ $teacher->bio }}</textarea>
                </div>

            <div class="flex justify-end mt-6 gap-3">

                <button type="button" onclick="toggleModal('extraModal')"
                    class="px-5 py-2 bg-slate-200 rounded-xl font-bold">

                    Cancel

                </button>

                <button class="px-5 py-2 bg-blue-500 text-white rounded-xl font-bold">

                    Save Changes

                </button>

            </div>

        </form>

    </div>

</div>
