@extends('layouts.mobile-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm"><a class="text-white" href="javascript:;">Home</a></li>
            <li class="text-sm pl-2 text-white before:content-['/']"><a class="text-white"
                    href="{{ route('company.app.teachers.index') }}">Teachers</a></li>
            <li class="text-sm pl-2 font-bold text-white before:content-['/']">{{ isset($teacher) ? 'Edit' : 'Create' }}
                Teacher</li>
        </ol>
        <h6 class="mb-0 font-bold text-white">{{ isset($teacher) ? 'Edit' : 'Create' }} Teacher</h6>
    </nav>
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="bg-white p-4 rounded-lg shadow mb-4 flex justify-between items-center">
            <h6 class="font-bold">{{ isset($teacher) ? 'Edit' : 'Create' }} Teacher</h6>
            <a href="{{ route('company.app.teachers.index') }}" class="bg-emerald-500/50 text-white px-3 py-2 rounded">
                <span class="bi bi-arrow-left me-2"></span>Back</a>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow">
            @php
                $isEdit = isset($teacher);
                $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

                $timeList = [];
                for ($h = 6; $h <= 22; $h++) {
                    foreach (['00', '30'] as $m) {
                        $timeList[] = sprintf('%02d:%s', $h, $m);
                    }
                }
            @endphp

            <form
                action="{{ $isEdit ? route('company.app.teachers.update', $teacher->id) : route('company.app.teachers.store') }}"
                method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-medium">Thumbnail</label>
                        <input type="file" name="thumb" class="mt-2 block w-full" accept="image/*"
                            onchange="previewThumb(event)">
                        @error('thumb')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror

                        @if ($isEdit && $teacher->thumbnail_url)
                            <img id="thumbPreview" src="{{ $teacher->thumbnail_url }}" class="w-28 mt-3 rounded"
                                style="max-width: 100px !important;">
                        @else
                            <img id="thumbPreview" class="hidden w-28 mt-3 rounded" style="max-width: 100px !important;">
                        @endif
                    </div>

                    <div>
                        <label class="font-medium">Main Image</label>
                        <input type="file" name="main" class="mt-2 block w-full" accept="image/*"
                            onchange="previewMain(event)">
                        @error('main')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror

                        @if ($isEdit && $teacher->main_image_url)
                            <img id="mainPreview" src="{{ $teacher->main_image_url }}" class="w-28 mt-3 rounded"
                                style="max-width: 100px !important;">
                        @else
                            <img id="mainPreview" class="hidden w-28 mt-3 rounded" style="max-width: 100px !important;">
                        @endif
                    </div>

                    <div>
                        <label class="font-medium">Name</label>
                        <input type="text" name="name" value="{{ old('name', $teacher->name ?? '') }}"
                            class="pl-3 text-sm w-full rounded-lg border border-gray-300 py-2">
                        @error('name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="font-medium">Qualifications</label>
                        <input type="text" name="qualifications"
                            value="{{ old('qualifications', $teacher->qualifications ?? '') }}"
                            class="pl-3 text-sm w-full rounded-lg border border-gray-300 py-2">
                        @error('qualifications')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="md:col-span-2">
                    <label class="font-medium">Bio</label>
                    <textarea name="bio" class="pl-3 text-sm w-full rounded-lg border border-gray-300 py-2" rows="4">{{ old('bio', $teacher->bio ?? '') }}</textarea>
                    @error('bio')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-medium mb-2">Speaking Languages</label>
                    <br>
                    @foreach ($languages as $kry => $lang)
                        <label class="font-medium me-2">
                            <input type="checkbox" class="border me-3" id="languages_{{ $kry }}"
                                name="languages[]" value="{{ $lang }}" @checked(in_array($lang, old('languages', $teacher->speaking_languages ?? [])))>
                            {{ $lang }}</label>
                    @endforeach
                    @error('languages')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="font-medium">Price per Hour</label>
                        <input type="number" step="0.01" name="price_per_hour"
                            value="{{ old('price_per_hour', $teacher->price_per_hour ?? '') }}"
                            class="pl-3 text-sm w-full rounded-lg border border-gray-300 py-2">
                        @error('price_per_hour')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="font-medium">Experience (years)</label>
                        <input type="number" name="experience" value="{{ old('experience', $teacher->year_exp ?? '') }}"
                            class="pl-3 text-sm w-full rounded-lg border border-gray-300 py-2">
                        @error('experience')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="font-medium">
                            <input type="checkbox" class="border pe-3" id="commissionToggle" name="is_commission"
                                value="1" @checked(old('is_commission', $teacher->commission_enabled ?? false))> Commission</label>
                        <div id="commissionBox"
                            class="{{ old('is_commission', $teacher->commission_enabled ?? false) ? '' : 'hidden' }}">
                            <label class="font-medium">Commission Percentage (%)</label>
                            <input type="number" name="commission_percentage"
                                value="{{ old('commission_percentage', $teacher->commission_percent ?? '') }}"
                                class="pl-3 text-sm w-full rounded-lg border border-gray-300 py-2">
                            @error('commission_percentage')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>



                    <div>
                        <label class="font-medium">Demo link</label>
                        <input type="url" name="demo_link"
                            value="{{ old('demo_link', $teacher->demo_class_link ?? '') }}"
                            class="pl-3 text-sm w-full rounded-lg border border-gray-300 py-2">
                        @error('demo_link')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>



                </div>
                <div>
                    <label class="font-medium">Certificates (Select Multi Select)</label>

                    <!-- File Input -->
                    <input type="file" name="certificates[]" multiple accept="image/*,application/pdf"
                        class="mt-2 block" onchange="previewCertificates(event)">

                    @error('certificates.*')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror

                    <!-- Live Preview Container -->
                    <div id="certificatePreview" class="grid grid-cols-4 gap-3 mt-3"></div>

                    <!-- Existing Uploaded Certificates (On Edit Page) -->
                    @if ($isEdit && $teacher->teacherCertificates)
                        <div class="grid grid-cols-4 gap-3 mt-3">
                            @foreach ($teacher->teacherCertificates as $c)
                                <div class="relative group">
                                    <div id="certificate_{{ $c->id }}">
                                        <img src="{{ asset('storage/' . $c->file_url) }}"
                                            class="w-24 h-24 rounded-lg object-cover shadow">

                                        <!-- Remove checkbox -->
                                        <button type="button" onclick="toggleRemove({{ $c->id }},this)"
                                            class="absolute top-1 right-1 bg-red-600 text-white text-xs rounded px-1 shadow  group-hover:block">
                                            X
                                        </button>

                                    </div>
                                    <input type="checkbox" name="remove_certificates[]" value="{{ $c->file_id }}"
                                        id="remove-checkbox_{{ $c->id }}" class="hidden">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>



                {{-- SUBJECTS + RATES --}}
                <div>
                    <label class="font-medium">Subjects & Hourly Rates</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">

                        @php
                            $selectedSubjects = (array) old('subjects', $isEdit ? $teacher->subjects ?? [] : []);
                            $existingRates = $existingRates ?? [];
                        @endphp


                        @foreach ($subjects as $key => $sub)
                            @php
                                $subId = $sub->id;
                                // Force array to avoid "Cannot access offset" error
                                $slab = (array) old("rates.$subId", [
                                    'rate_below_10' => $existingRates[$subId]['rate_0_10'] ?? '',
                                    'rate_10_30' => $existingRates[$subId]['rate_10_30'] ?? '',
                                    'rate_30_plus' => $existingRates[$subId]['rate_30_plus'] ?? '',
                                ]);
                            @endphp

                            <div class="border p-3 rounded-lg">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="subjects[]" value="{{ $sub->id }}"
                                        class="subjectCheck border" data-id="{{ $subId }}"
                                        @checked(in_array($subId, $selectedSubjects))>
                                    {{ $sub->name }}
                                </label>

                                <div id="slab{{ $subId }}"
                                    class="mt-3 {{ in_array($subId, $selectedSubjects) ? '' : 'hidden' }}">

                                    <label class="text-sm block">Below 10 Hours</label>
                                    <input type="number" class="input mt-1 border"
                                        name="rates[{{ $subId }}][rate_below_10]"
                                        value="{{ $slab['rate_below_10'] }}">

                                    <label class="text-sm block mt-2">10 - 30 Hours</label>
                                    <input type="number" class="input mt-1 border"
                                        name="rates[{{ $subId }}][rate_10_30]" value="{{ $slab['rate_10_30'] }}">

                                    <label class="text-sm block mt-2">30+ Hours</label>
                                    <input type="number" class="input mt-1 border"
                                        name="rates[{{ $subId }}][rate_30_plus]"
                                        value="{{ $slab['rate_30_plus'] }}">
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- TIME SLOTS --}}
                <div>
                    <h3 class="text-lg font-semibold mb-3">Available Time Slots</h3>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach ($days as $day)
                            @php
                                if ($isEdit) {
                                    $slots = is_string($teacher->time_slots)
                                        ? json_decode($teacher->time_slots, true)
                                        : $teacher->time_slots ?? [];
                                }

                                $oldDaySlots = old('time_slots.' . $day, $slots[$day] ?? []);
                            @endphp
                            <div class="border rounded-lg p-1 mb-2">
                                <h6 class="font-medium mb-1">{{ $day }}</h6>
                                <div id="slotBox_{{ $day }}">
                                    @foreach ($oldDaySlots as $idx => $slot)
                                        <div class="flex gap-3 mb-2 items-center slotRow">
                                            <select name="time_slots[{{ $day }}][{{ $idx }}][from]"
                                                class="border">
                                                @foreach ($timeList as $t)
                                                    <option value="{{ $t }}" @selected($slot['from'] == $t)>
                                                        {{ $t }}</option>
                                                @endforeach
                                            </select>
                                            <span>to</span>
                                            <select name="time_slots[{{ $day }}][{{ $idx }}][to]"
                                                class="border">
                                                @foreach ($timeList as $t)
                                                    <option value="{{ $t }}" @selected($slot['to'] == $t)>
                                                        {{ $t }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button"
                                                class="px-2  btn-sm bg-red-600 text-white rounded removeSlotBtn">X</button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button"
                                    class="mt-2 px-2 btm-sm py-1 bg-blue-300 text-white float-right text-sm rounded-3 addSlotBtn"
                                    data-day="{{ $day }}">+ Add Slot</button>
                            </div>
                        @endforeach
                    </div>
                </div>


                <div>
                    <div class="flex items-center gap-3">
                        <label class="font-medium">
                            <input type="checkbox" class="border pe-3" name="is_top" value="1"
                                @checked(old('is_top', $teacher->include_top_teachers ?? false))> Include in Top</label>
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-3">
                        <label class="font-medium">
                            <input type="checkbox" class="border pe-3" name="published" value="1"
                                @checked(old('published', $teacher->published ?? false))> Publish</label>
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="flex justify-center">
                    <button
                        class="bg-emerald-500/50 text-white px-6 py-2 rounded-lg">{{ $isEdit ? 'Update Teacher' : 'Create Teacher' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // preview helpers
        function previewThumb(e) {
            const out = document.getElementById('thumbPreview');
            out.src = URL.createObjectURL(e.target.files[0]);
            out.classList.remove('hidden');
        }

        function previewMain(e) {
            const out = document.getElementById('mainPreview');
            out.src = URL.createObjectURL(e.target.files[0]);
            out.classList.remove('hidden');
        }

        function previewCertificates(e) {
            const box = document.getElementById('certificatePreview');
            box.innerHTML = '';
            Array.from(e.target.files).forEach(f => {
                let img = document.createElement('img');
                img.src = URL.createObjectURL(f);
                img.className = 'w-20 h-20 rounded object-cover';
                box.appendChild(img);
            });
        }

        // commission toggle
        document.getElementById('commissionToggle')?.addEventListener('change', function() {
            document.getElementById('commissionBox').classList.toggle('hidden', !this.checked);
        });

        // subject show/hide slabs
        document.querySelectorAll('.subjectCheck').forEach(chk => {
            chk.addEventListener('change', function() {
                const id = this.dataset.id;
                const el = document.getElementById('slab' + id);
                if (this.checked) el.classList.remove('hidden');
                else el.classList.add('hidden');
            });
        });

        // add / remove time slots
        document.querySelectorAll('.addSlotBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                const day = this.dataset.day;
                const box = document.getElementById('slotBox_' + day);
                const index = box.querySelectorAll('.slotRow').length;
                let row = document.createElement('div');
                row.className = 'flex gap-3 mb-2 items-center slotRow';
                row.innerHTML = `
                <select name="time_slots[${day}][${index}][from]" class="border">@foreach ($timeList as $t)<option value="{{ $t }}">{{ $t }}</option>@endforeach</select>
                <span>to</span>
                <select name="time_slots[${day}][${index}][to]" class="border">@foreach ($timeList as $t)<option value="{{ $t }}">{{ $t }}</option>@endforeach</select>
                <button type="button" class="px-2  bg-red-600 text-white rounded removeSlotBtn">X</button>
            `;
                box.appendChild(row);
                row.querySelector('.removeSlotBtn').addEventListener('click', () => row.remove());
            });
        });
        document.querySelectorAll('.removeSlotBtn').forEach(btn => btn.addEventListener('click', function() {
            this.closest('.slotRow').remove();
        }));
    </script>

    <script>
        function previewCertificates(event) {
            let previewBox = document.getElementById('certificatePreview');
            previewBox.innerHTML = '';

            Array.from(event.target.files).forEach((file, index) => {
                let reader = new FileReader();

                reader.onload = function(e) {
                    let card = document.createElement('div');
                    card.classList.add('relative', 'group');

                    card.innerHTML = `
                    <div class="relative">
                        <img src="${e.target.result}" class="w-24 h-24 rounded-lg object-cover shadow">
                        <button type="button" class="absolute top-1 right-1 bg-red-600 text-white text-xs rounded px-1 shadow hidden group-hover:block" onclick="removePreview(this, ${index})">X</button>
                    </div>
                `;

                    previewBox.appendChild(card);
                };

                reader.readAsDataURL(file);
            });
        }

        // Remove from preview (only frontend)
        function removePreview(btn, index) {
            let previewBox = document.getElementById('certificatePreview');
            previewBox.children[index].remove();
        }

        // For edit mode deletion toggle
        function toggleRemove(id, btn) {

            document.getElementById('certificate_' + id).remove();

            let checkbox = document.getElementById('remove-checkbox_'+id)
            checkbox.checked = !checkbox.checked;


        }
    </script>
@endpush
