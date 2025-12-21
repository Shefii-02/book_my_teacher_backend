@extends('layouts.mobile-layout')

@section('nav-options')
    <nav>
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-neutral-900 text-sm"><a class="text-white" href="javascript:;">Home</a></li>
            <li class="text-sm pl-2 text-white before:content-['/']"><a class="text-white"
                    href="{{ route('company.teachers.index') }}">Teachers</a></li>
            <li class="text-sm pl-2 font-bold text-white before:content-['/']">{{ isset($teacher) ? 'Edit' : 'Create' }}
                Teacher</li>
        </ol>
        <h6 class="mb-0 font-bold text-white">{{ isset($teacher) ? 'Edit' : 'Create' }} Teacher</h6>
    </nav>
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="bg-white p-4 rounded-lg shadow mb-4 flex justify-between items-center">
            <h3 class="font-bold">{{ isset($teacher) ? 'Edit' : 'Create' }} Teacher</h3>
            <a href="{{ route('company.teachers.index') }}" class="bg-emerald-500 text-white px-3 py-2 rounded">Back</a>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow">
            <form method="POST"
                action="{{ isset($teacher) ? route('company.teachers.update', $teacher->id) : route('company.teachers.store') }}"
                enctype="multipart/form-data">
                @csrf
                @if (isset($teacher))
                    @method('PUT')
                @endif

                <div class="grid md:grid-cols-2 gap-6">

                    {{-- Thumb --}}
                    <div>
                        <label class="block mb-2 font-medium">Thumb Image</label>
                        <img id="thumbPreview"
                            src="{{ old('thumb_preview', isset($teacher) && $teacher->thumb ? asset('storage/' . $teacher->thumb) : '') }}"
                            class="w-28 h-28 rounded object-cover mb-2 border">
                        <input type="file" id="thumbInput" name="thumb" accept="image/*" class="w-full">
                        @error('thumb')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Main --}}
                    <div>
                        <label class="block mb-2 font-medium">Main Image</label>
                        <img id="mainPreview"
                            src="{{ old('main_preview', isset($teacher) && $teacher->main ? asset('storage/' . $teacher->main) : '') }}"
                            class="w-28 h-28 rounded object-cover mb-2 border">
                        <input type="file" id="mainInput" name="main" accept="image/*" class="w-full">
                        @error('main')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Name --}}
                    <div>
                        <label class="block mb-2 font-medium">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $teacher->name ?? '') }}"
                            class="w-full border rounded p-2">
                        @error('name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Qualifications --}}
                    <div>
                        <label class="block mb-2 font-medium">Qualifications</label>
                        <input type="text" name="qualifications"
                            value="{{ old('qualifications', $teacher->qualifications ?? '') }}"
                            class="w-full border rounded p-2">
                        @error('qualifications')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Languages --}}
                    <div>
                        <label class="block mb-2 font-medium">Speaking Languages</label>
                        <select name="speaking_languages[]" multiple class="w-full border rounded p-2">
                            @foreach ($languages as $lang)
                                <option value="{{ $lang }}" @if (in_array($lang, old('speaking_languages', $teacher->speaking_languages ?? []))) selected @endif>
                                    {{ $lang }}</option>
                            @endforeach
                        </select>
                        @error('speaking_languages')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label class="block mb-2 font-medium">Price Per Hour (₹)</label>
                        <input type="number" step="0.01" name="price_per_hour"
                            value="{{ old('price_per_hour', $teacher->price_per_hour ?? '') }}"
                            class="w-full border rounded p-2">
                        @error('price_per_hour')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Years --}}
                    <div>
                        <label class="block mb-2 font-medium">Years of Experience</label>
                        <input type="number" name="year_exp" value="{{ old('year_exp', $teacher->year_exp ?? '') }}"
                            class="w-full border rounded p-2">
                        @error('year_exp')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Demo Link --}}
                    <div>
                        <label class="block mb-2 font-medium">Demo Class Link</label>
                        <input type="url" name="demo_class_link"
                            value="{{ old('demo_class_link', $teacher->demo_class_link ?? '') }}"
                            class="w-full border rounded p-2">
                        @error('demo_class_link')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bio (full width) --}}
                    <div class="md:col-span-2">
                        <label class="block mb-2 font-medium">Bio</label>
                        <textarea name="bio" rows="4" class="w-full border rounded p-3">{{ old('bio', $teacher->bio ?? '') }}</textarea>
                        @error('bio')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Commission toggle --}}
                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="commissionEnable" name="commission_enabled" value="1"
                            @if (old('commission_enabled', $teacher->commission_enabled ?? false)) checked @endif>
                        <span class="ml-2 font-medium">Enable Commission</span>
                    </label>
                </div>

                <div id="commissionBox" class="mt-3"
                    style="display: {{ old('commission_enabled', $teacher->commission_enabled ?? false) ? 'block' : 'none' }}">
                    <label class="block mb-2 font-medium">Commission Percentage (%)</label>
                    <input type="number" name="commission_percent"
                        value="{{ old('commission_percent', $teacher->commission_percent ?? '') }}"
                        class="w-40 border rounded p-2">
                    @error('commission_percent')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Include top teachers --}}
                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="include_top_teachers" value="1"
                            @if (old('include_top_teachers', $teacher->include_top_teachers ?? false)) checked @endif>
                        <span class="ml-2 font-medium">Include in Top Teachers</span>
                    </label>
                </div>

                {{-- Subjects + rate tiers --}}
                <div class="mt-6">
                    <label class="block mb-2 font-medium">Subjects & Hourly Rate Tiers</label>

                    <div x-data="subjectRatesComponent(@json($subjects->map(fn($s) => ['id' => $s->id, 'title' => $s->title])->values()->all() ?? []), @json(old('subjects', $teacher->subjects ?? [])), @json($existingRates ?? []))">
                        <template x-for="subject in subjects" :key="subject.id">
                            <div class="border rounded p-3 mb-3">
                                <label class="flex items-center gap-3">
                                    <input type="checkbox" :value="subject.id" :name="`subjects[]`"
                                        x-model="selectedSubjects">
                                    <span class="font-medium" x-text="subject.title"></span>
                                </label>

                                <div x-show="selectedSubjects.includes(subject.id.toString()) || selectedSubjects.includes(subject.id)"
                                    class="mt-3 bg-gray-50 p-3 rounded">
                                    <div class="grid grid-cols-3 gap-3">
                                        <div>
                                            <label class="text-xs">0 - 10 hrs</label>
                                            <input type="number" step="0.01" :name="`rates[${subject.id}][rate_0_10]`"
                                                class="w-full border rounded p-2"
                                                x-bind:value="(existingRates[subject.id] && existingRates[subject.id].rate_0_10) ?
                                                existingRates[subject.id].rate_0_10: ''">
                                        </div>
                                        <div>
                                            <label class="text-xs">10 - 30 hrs</label>
                                            <input type="number" step="0.01"
                                                :name="`rates[${subject.id}][rate_10_30]`"
                                                class="w-full border rounded p-2"
                                                x-bind:value="(existingRates[subject.id] && existingRates[subject.id].rate_10_30) ?
                                                existingRates[subject.id].rate_10_30: ''">
                                        </div>
                                        <div>
                                            <label class="text-xs">30+ hrs</label>
                                            <input type="number" step="0.01"
                                                :name="`rates[${subject.id}][rate_30_plus]`"
                                                class="w-full border rounded p-2"
                                                x-bind:value="(existingRates[subject.id] && existingRates[subject.id].rate_30_plus) ?
                                                existingRates[subject.id].rate_30_plus: ''">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    @error('subjects')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Certificates multi upload and preview --}}
                <div class="mt-6">
                    <label class="block mb-2 font-medium">Certificates (multiple)</label>
                    <input type="file" id="certificatesInput" name="certificates[]" multiple class="w-full">

                    <div id="certGrid" class="mt-3 flex flex-wrap gap-3">
                        {{-- existing certificates from server --}}
                        @if (isset($teacher) && is_array($teacher->certificates))
                            @foreach ($teacher->certificates as $cert)
                                <div class="relative" data-file="{{ $cert }}">
                                    <img src="{{ asset('storage/' . $cert) }}"
                                        class="w-20 h-20 object-cover rounded border">
                                    <button type="button"
                                        class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-6 h-6 text-xs flex items-center justify-center remove-cert-btn"
                                        data-file="{{ $cert }}">×</button>
                                    <input type="hidden" name="existing_certificates[]" value="{{ $cert }}">
                                </div>
                            @endforeach
                        @endif
                    </div>

                    @error('certificates.*')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Time slots (Mon-Sun) --}}
                <div class="mt-6">
                    <label class="block mb-2 font-medium">Weekly Time Slots (simple text input; you can later convert to
                        range picker)</label>

                    @php $days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']; @endphp
                    <div class="grid md:grid-cols-2 gap-3">
                        @foreach ($days as $d)
                            <div>
                                <label class="block text-sm font-medium">{{ $d }}</label>
                                <input type="text" name="time_slots[{{ $d }}]"
                                    placeholder="e.g. 6:00-7:00,7:00-8:00"
                                    value="{{ old('time_slots.' . $d, $teacher->time_slots[$d] ?? '') }}"
                                    class="w-full border rounded p-2">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Published --}}
                <div class="mt-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="published" value="1"
                            @if (old('published', $teacher->published ?? true)) checked @endif>
                        <span class="ml-2 font-medium">Published</span>
                    </label>
                </div>

                {{-- remove_certificates hidden inputs will be appended by JS if user removes --}}
                <div id="removeCertInputs"></div>

                <div class="mt-6">
                    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded">
                        {{ isset($teacher) ? 'Update Teacher' : 'Create Teacher' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Alpine + scripts --}}
    @push('scripts')
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('subjectRatesComponent', (subjectList = [], preSelected = [], existingRates = {}) => ({
                    subjects: subjectList,
                    selectedSubjects: preSelected.map(s => (typeof s === 'number' ? s : s.toString())),
                    existingRates: existingRates || {},
                }));
            });

            // image previews
            document.getElementById('thumbInput')?.addEventListener('change', (e) => {
                const [file] = e.target.files;
                if (!file) return;
                document.getElementById('thumbPreview').src = URL.createObjectURL(file);
            });
            document.getElementById('mainInput')?.addEventListener('change', (e) => {
                const [file] = e.target.files;
                if (!file) return;
                document.getElementById('mainPreview').src = URL.createObjectURL(file);
            });

            // commission toggle
            const commissionEnable = document.getElementById('commissionEnable');
            const commissionBox = document.getElementById('commissionBox');
            commissionEnable?.addEventListener('change', () => {
                commissionBox.style.display = commissionEnable.checked ? 'block' : 'none';
            });

            // certificates preview & remove
            const certInput = document.getElementById('certificatesInput');
            const certGrid = document.getElementById('certGrid');
            const removeCertInputs = document.getElementById('removeCertInputs');

            certInput?.addEventListener('change', (e) => {
                Array.from(e.target.files).forEach(file => {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
            <img src="${URL.createObjectURL(file)}" class="w-20 h-20 object-cover rounded border" />
            <button type="button" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-6 h-6 text-xs">×</button>
        `;
                    certGrid.appendChild(div);
                    div.querySelector('button').addEventListener('click', () => div.remove());
                });
            });

            // existing certificate remove buttons
            document.querySelectorAll('.remove-cert-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const file = btn.getAttribute('data-file');
                    const parent = btn.closest('div[data-file]');
                    if (!parent) return;
                    parent.remove();

                    // add hidden input to notify server to remove file
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'remove_certificates[]';
                    input.value = file;
                    removeCertInputs.appendChild(input);
                });
            });
        </script>
    @endpush

@endsection
