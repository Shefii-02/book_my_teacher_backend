         @php
             $isEdit = isset($material);
         @endphp
         <h6 class="dark:text-white">{{ isset($class) ? 'Edit Material' : 'Create Material' }}</h6>

         <div class="flex-none w-full max-w-full px-3">
             <div class="relative flex flex-col min-w-0 mb-6 break-words">
                 <form method="POST" enctype="multipart/form-data"
                     action="{{ $isEdit
                         ? route('company.courses.materials.update', [$course->course_identity, $material->id])
                         : route('company.courses.materials.store', $course->course_identity) }}">

                     @csrf
                     @if ($isEdit)
                         @method('PUT')
                     @endif

                     {{-- Title --}}
                     <label class="block mb-2 font-medium">Title</label>
                     <input type="text" name="title" value="{{ old('title', $material->title ?? '') }}"
                         class="w-full border p-2 rounded" required />

                     {{-- File --}}
                     <label class="block mt-4 mb-2 font-medium">
                         Upload File @if ($isEdit)
                             <small class="text-gray-500">(Optional)</small>
                         @endif
                     </label>

                     <input type="file" name="file" class="w-full border p-2 rounded"
                         @if (!$isEdit) required @endif />

                     @if ($isEdit && $material->file_path)
                         <p class="text-sm mt-1">
                             Current: <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                 class="text-blue-500 underline">View File</a>
                         </p>
                     @endif

                     {{-- Position --}}
                     <label class="block mt-4 mb-2 font-medium">Position</label>
                     <input type="number" name="position" value="{{ old('position', $material->position ?? 1) }}"
                         class="w-full border p-2 rounded" required />

                     {{-- Status --}}
                     <label class="block mt-4 mb-2 font-medium">Status</label>
                     <select name="status" class="w-full border p-2 rounded">
                         <option value="published" @selected(old('status', $material->status ?? '') === 'published')>
                             Published
                         </option>

                         <option value="draft" @selected(old('status', $material->status ?? '') === 'draft')>
                             Draft
                         </option>
                     </select>

                     {{-- Submit --}}
                     <button class="mt-6 px-4 py-2 bg-blue-600 text-white rounded">
                         {{ $isEdit ? 'Update Material' : 'Create Material' }}
                     </button>
                 </form>
             </div>
         </div>
