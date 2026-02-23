
    <div class="form-title mb-3">
        <h2 id="drawer-right-label"
            class="text-gray-400 rounded-lg text-lg text-sm absolute top-2.5  inline-flex items-center justify-center">
            <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            Banner Lead Request
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

            <div class="grid md:grid-cols-2 gap-2 text-sm">
                <div>
                    <p class="text-gray-500">Type</p>
                    <p class="font-medium text-gray-900">{{ $form_class->banner->type ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Section</p>
                    <p class="font-medium text-gray-900">{{ $form_class->banner->banner_type ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Title</p>
                    <p class="font-medium text-gray-900">{{ $form_class->banner->title ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Created at</p>
                    <p class="font-medium text-gray-900">{{ $form_class->created_at ?? '—' }}</p>
                </div>


            </div>
                <div>
                    <p class="text-gray-500">Note</p>
                    <div  class="font-medium  text-gray-900">{{ $form_class->notes ?? '—' }}</div>
                </div>
        </div>


    </div>

