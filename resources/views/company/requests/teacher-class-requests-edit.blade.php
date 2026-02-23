<form action="{{ route('company.requests.teacher-class.update', $form_class->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-title mb-3">
        <h2 id="drawer-right-label"
            class="text-gray-400 rounded-lg text-lg text-sm absolute top-2.5  inline-flex items-center justify-center">
            <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            Teacher Class Lead Requests
        </h2>
    </div>
    <div class="form-body mt-3">

        <div class="mx-3">

            <div class="my-5">
                <div>
                    <label for="imgSelect" class="mb-2">Student Details</label>
                    <div id="studentDetails" style="">
                        <div class="p-4 mt-3 rounded-xl border bg-slate-50 shadow-sm">
                            <div class="flex items-center gap-3 mb-2">
                                <div
                                    class="h-10 w-10 rounded-full bg-emerald-500/30 flex items-center justify-center text-white font-bold">
                                    s
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 p-0 m-0">{{ $form_class->user->name }}</p>
                                </div>
                            </div>

                            <div class="text-sm text-slate-700 space-y-1">
                                <p class="flex items-center gap-2 p-0 m-0">
                                    <i class="bi bi-telephone text-blue-500"></i>
                                    <span>{{ $form_class->user->mobile }}</span>
                                </p>
                                <p class="flex items-center gap-2 p-0 m-0">
                                    <i class="bi bi-envelope text-emerald-500"></i>
                                    <span>{{ $form_class->user->email }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-5">
                <div>
                    <label for="imgSelect" class="mb-2">Teacher Details</label>
                    <div id="studentDetails" style="">
                        <div class="p-4 mt-3 rounded-xl border bg-slate-50 shadow-sm">
                            <div class="flex items-center gap-3 mb-2">
                                <div
                                    class="h-10 w-10 rounded-full bg-emerald-500/30 flex items-center justify-center text-white font-bold">
                                    s
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 p-0 m-0">{{ $form_class->teacher->name }}</p>
                                </div>
                            </div>

                            <div class="text-sm text-slate-700 space-y-1">
                                <p class="flex items-center gap-2 p-0 m-0">
                                    <i class="bi bi-telephone text-blue-500"></i>
                                    <span>{{ $form_class->teacher->mobile }}</span>
                                </p>
                                <p class="flex items-center gap-2 p-0 m-0">
                                    <i class="bi bi-envelope text-emerald-500"></i>
                                    <span>{{ $form_class->teacher->email }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-2 text-sm">
                <div>
                    <p class="text-gray-500">Type</p>
                    <p class="font-medium text-gray-900">{{ $form_class->type ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Title</p>
                    <p class="font-medium text-gray-900">{{ $form_class->selected_items ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Class Type</p>
                    <p class="font-medium text-gray-900">{{ $form_class->class_type ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Days Needed</p>
                    <p class="font-medium text-gray-900">{{ $form_class->days_needed ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Created at</p>
                    <p class="font-medium text-gray-900">{{ $form_class->created_at ?? '—' }}</p>
                </div>


            </div>
            <div>
                <p class="text-gray-500">Note</p>
                <textarea rows="5" name="lead_notes" class="font-medium border  form-control w-100 w-full text-gray-900">{{ $form_class->lead_notes ?? '—' }}</textarea>
            </div>
        </div>

        <hr class="border-gray-200">
        @php
            $statusOptions = [
                'pending' => ['label' => 'Pending', 'color' => 'bg-gray-200 text-gray-800'],
                'not_connected' => ['label' => 'Not Connected', 'color' => 'bg-red-100 text-red-700'],
                'call_back_later' => ['label' => 'Call Back Later', 'color' => 'bg-yellow-100 text-yellow-700'],
                'follow_up_later' => ['label' => 'Follow Up Later', 'color' => 'bg-blue-100 text-blue-700'],
                'demo_scheduled' => ['label' => 'Demo Scheduled', 'color' => 'bg-purple-100 text-purple-700'],
                'converted_to_admission' => ['label' => 'Converted', 'color' => 'bg-green-100 text-green-700'],
                'closed' => ['label' => 'Closed', 'color' => 'bg-danger text-light'],
            ];
        @endphp

        <div class="mt-4">
            <label class="block mb-2 text-sm font-semibold text-gray-700">
                Lead Status
            </label>

            <div class="mb-3">
                <span class="text-xs text-gray-500">Current Status:</span>
                <span
                    class="ml-2 px-3 py-1 rounded-full text-xs font-semibold capitalize
        {{ $statusOptions[$form_class->status]['color'] ?? 'bg-gray-200' }}">
                    {{ $statusOptions[$form_class->status]['label'] ?? 'Unknown' }}
                </span>
            </div>

            <div class="flex flex-wrap gap-3">
                @foreach ($statusOptions as $value => $meta)
                    <label class="cursor-pointer flex gap-2 items-center">
                        <input id="{{ $value }}" type="radio" class="border" name="status"
                            value="{{ $value }}" class=" peer"
                            {{ old('status', $form_class->status) == $value ? 'checked' : '' }}>

                        <div for="{{ $value }}"
                            class="px-4 py-2 rounded-full border text-sm font-medium
                            {{ $meta['color'] }}
                            peer-checked:ring-2 peer-checked:ring-emerald-500
                            hover:scale-105 transition">

                            {{ $meta['label'] }}
                        </div>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Submit -->
    <div class="mt-5 text-left md:col-span-2">
        <input type="hidden" class="d-none" value="{{ $form_class->form_class_identity }}"
            name="form_class_identity" />

        <input type="submit"
            class="px-5 py-2.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg"
            name="overview_form" value="{{ $form_class ? 'Update' : 'Create' }}">
    </div>

</form>
