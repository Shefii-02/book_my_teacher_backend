          <form action="{{ route('company.courses.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-title">
                  <h2 id="drawer-right-label"
                      class="text-gray-400 rounded-lg text-lg text-sm absolute top-2.5  inline-flex items-center justify-center">
                      <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                          viewBox="0 0 20 20">
                          <path
                              d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                      </svg>
                      Basic info
                  </h2>
              </div>
              <div class="form-body mt-3">
                  <div class="grid gap-6 mb-6 md:grid-cols-2 mt-5">
                      <!-- Images -->
                      {{-- @include('components.thumbImg-input', [
                          'name' => 'thumbnail',
                          'field' => 'thumbnail_url',
                          'label' => 'Select an Thumbnail',
                          'size' => '',
                          'isRequired'=>false,
                          'item' => $course ?? null,
                          'isEdit' => isset($course),
                      ]) --}}
                      @include('components.thumbImg-input', [
                          'name' => 'main_image',
                          'field' => 'main_image_url',
                          'label' => 'Select an Main Image',
                          'size' => '',
                          'item' => $course ?? null,
                          'isEdit' => isset($course),
                      ])
                      {{-- <div class="flex justify-center flex-col">
                          <p>
                              <img id="thumbImgPreview" alt="#"
                                  src="{{ old('thumbnail', $course->thumbnail_url ?? asset('assets/images/bg/dummy_image.webp')) }}"
                                  class="rounded w-1/2 border ">
                          </p>

                          <label for="thumbImgSelect" class="mb-2">Select an Thumbnail</label>
                          <input type="file" id="thumbImgSelect" name="thumbnail" accept="jpg,jpeg,png"
                              {{ isset($course) ? '' : 'required' }} ?>
                          @error('thumbnail')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                          @enderror
                      </div> --}}
                      {{-- <div>
                          <p>
                              <img id="imgPreview" alt="#"
                                  src="{{ old('main_image', $course->main_image_url ?? asset('assets/images/bg/dummy_image.webp')) }}"
                                  class="rounded border w-1/2">
                          </p>
                          <label for="imgSelect" class="mb-2">Select an Main Image</label>
                          <input type="file" id="imgSelectMain" name="main_image" accept="jpg,jpeg,png"
                              {{ isset($course) ? '' : 'required' }} ?>
                          @error('main_image')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                          @enderror
                      </div> --}}
                  </div>
                  <div class="grid gap-6 mb-6 md:grid-cols-1 mt-5">
                      <!-- Title -->
                      <div>
                          <label class="block mb-2 text-sm font-medium">Title<span class="text-danger">*</span></label>
                          <input type="text" name="title" placeholder="" required
                              value="{{ old('title', $course->title ?? '') }}"
                              class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                          @error('title')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                          @enderror
                      </div>
                      <!-- Description -->
                      <div>
                          <label class="block mb-2 text-sm font-medium">Description</label>
                          <textarea name="description"
                              class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">{{ old('description', $course->description ?? '') }}</textarea>
                          @error('description')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                          @enderror
                      </div>
                  </div>
                  <div class="grid gap-6 mb-6 md:grid-cols-2 mt-5">
                      <!-- Total days -->
                      <div>
                          <label class="block mb-2 text-sm font-medium">Total Days<span class="text-danger">*</span></label>
                          <input type="number" name="duration" placeholder="" required
                              value="{{ old('duration', $course->duration ?? '') }}"
                              class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                          @error('duration')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                          @enderror
                      </div>
                      <!-- Total Hours -->
                      <div>
                          <label class="block mb-2 text-sm font-medium">Total Hours<span class="text-danger">*</span></label>
                          <input type="number" name="total_hours" placeholder="" required
                              value="{{ old('total_hours', $course->total_hours ?? '') }}"
                              class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                          @error('total_hours')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                          @enderror
                      </div>
                      <!-- Started at -->
                      <div>
                          <label class="block mb-2 text-sm font-medium">Start Date<span class="text-danger">*</span></label>
                          <input type="date" name="started_at"
                              value="{{ old('started_at', $course->started_at ?? '') }}"
                              class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                          @error('started_at')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                          @enderror
                      </div>

                      <!-- Ended at -->
                      <div>
                          <label class="block mb-2 text-sm font-medium">End Date<span class="text-danger">*</span></label>
                          <input type="date" name="ended_at" value="{{ old('ended_at', $course->ended_at ?? '') }}"
                              class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
                          @error('end_date')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                          @enderror
                      </div>
                      @if ($course)
                          <input type="hidden" name="course_id" value="{{ $course->course_identity }}">
                      @endif
                  </div>
                  <div class="grid gap-6 mb-6 md:grid-cols-1 mt-5">


                      <div id="category-container">
                          @if (isset($course) && $course->categories && $course->categories->count() > 0)
                              @foreach ($course->categories as $index => $selectedCategory)
                                  <div class="category-group mb-4 border p-3 rounded-md">
                                      <div class="grid md:grid-cols-2 gap-4">

                                          <!-- Category -->
                                          <div>
                                              <label class="block mb-2 text-sm font-medium">Category</label>
                                              <select name="categories[{{ $index }}][category_id]"
                                                  class="category-select border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                  <option value="">-- Select Category --</option>
                                                  @foreach ($categories as $cat)
                                                      <option value="{{ $cat->id }}"
                                                          {{ $selectedCategory->id == $cat->id ? 'selected' : '' }}>
                                                          {{ $cat->title }}
                                                      </option>
                                                  @endforeach
                                              </select>
                                          </div>

                                          <!-- Sub Category -->
                                          <div>
                                              <label class="block mb-2 text-sm font-medium">Sub Categories</label>
                                              <div class="subcategory-container text-sm text-gray-700">
                                                  @php
                                                      $selectedSubcategories = json_decode(
                                                          $selectedCategory->pivot->subcategories ?? '[]',
                                                          true,
                                                      );
                                                      // $selectedSubcategories =
                                                      //     $selectedCategory->pivot->subcategories ?? [];
                                                  @endphp

                                                  @if ($selectedCategory->subcategories && $selectedCategory->subcategories->count() > 0)
                                                      @foreach ($selectedCategory->subcategories as $sub)
                                                          <label class="inline-flex items-center mr-3 mb-2">
                                                              <input type="checkbox"
                                                                  name="categories[{{ $index }}][subcategories][]"
                                                                  value="{{ $sub->id }}"
                                                                  class="subcategory-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2  dark:border-gray-600"
                                                                  {{ is_array($selectedSubcategories) ? (in_array($sub->id, $selectedSubcategories ?? []) ? 'checked' : '') : '' }}>
                                                              <span
                                                                  class="ml-1 text-gray-800">{{ $sub->title }}</span>
                                                          </label>
                                                      @endforeach
                                                  @else
                                                      <p class="text-gray-500">No subcategories available.</p>
                                                  @endif
                                              </div>
                                          </div>

                                      </div>
                                  </div>
                              @endforeach
                          @else
                              {{-- If no categories added yet --}}
                              <div class="category-group mb-4 border p-3 rounded-md">
                                  <div class="grid md:grid-cols-2 gap-4">
                                      <div>
                                          <label class="block mb-2 text-sm font-medium">Category</label>
                                          <select name="categories[0][category_id]"
                                              class="category-select border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                              <option value="">-- Select Category --</option>
                                              @foreach ($categories as $cat)
                                                  <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                              @endforeach
                                          </select>
                                      </div>

                                      <div>
                                          <label class="block mb-2 text-sm font-medium">Sub Categories</label>
                                          <div class="subcategory-container text-sm text-gray-700">
                                              <p class="text-gray-500">Select a category to load subcategories</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          @endif
                      </div>
                      <!-- Add More Button -->
                      <div class="my-2 text-right">
                          <button type="button" id="add-category"
                              class="px-4 py-2 text-sm font-medium text-white border border-1  text-left text-inherit !bg-gray-200 font-petro rounded-lg">
                              + Add Another Category
                          </button>
                      </div>


                      <!--Category-->
                      {{-- <div>
                          <label class="block mb-2 text-sm font-medium">Category</label>
                          <select name="category_id"
                              class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                              required>
                              <option value="">-- Select Category --</option>
                              @foreach ($categories as $cat)
                                  <option value="{{ $cat->id }}"
                                      {{ isset($course) && $course->category_id == $cat->id ? 'selected' : '' }}>
                                      {{ $cat->title }}
                                  </option>
                              @endforeach
                          </select>
                      </div>
                      <!--Sub Category-->
                      <div>
                          <label class="block mb-2 text-sm font-medium">Sub Category</label>
                          <select name="category_id"
                              class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                              required>
                              <option value="">-- Select Sub Category --</option>
                              @foreach ($categories as $cat)
                                  <option value="{{ $cat->id }}"
                                      {{ isset($course) && $course->category_id == $cat->id ? 'selected' : '' }}>
                                      {{ $cat->title }}
                                  </option>
                              @endforeach
                          </select>
                      </div> --}}
                  </div>
              </div>
              <div class="my-2 text-center">
                  <input type="submit"
                      class="px-5 py-2.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg "
                      name="basic_form" value="{{ $course ? 'Update' : 'Create' }}">
              </div>
          </form>

          <script>
              $(document).ready(function() {
                  let categoryIndex = 0;

                  // Load subcategories when a category changes
                  $(document).on('change', '.category-select', function() {
                      let categoryId = $(this).val();
                      let subContainer = $(this).closest('.category-group').find('.subcategory-container');

                      subContainer.html('<p class="text-gray-500">Loading subcategories...</p>');
                      if (categoryId) {
                          $.get(`/company/categories/${categoryId}/subcategories`, function(data) {
                              if (data.length > 0) {
                                  let checkboxes = '<div class="grid grid-cols-2 gap-2 mt-2">';
                                  data.forEach(function(sub) {
                                      checkboxes += `
                            <label class="flex items-center space-x-2 text-sm">
                                <input type="checkbox"
                                    name="categories[${categoryIndex}][subcategories][]"
                                    value="${sub.id}"
                                    class="subcategory-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2  dark:border-gray-600">
                                <span>${sub.title}</span>
                            </label>`;
                                  });
                                  checkboxes += '</div>';
                                  subContainer.html(checkboxes);
                              } else {
                                  subContainer.html(
                                      '<p class="text-gray-500">No subcategories found.</p>');
                              }
                          });
                      } else {
                          subContainer.html('<p class="text-gray-500">Please select a category first.</p>');
                      }
                  });

                  // Add new category-subcategory block
                  $('#add-category').click(function() {
                      categoryIndex++;
                      let newBlock = `
        <div class="category-group mb-4 border p-3 rounded-md">
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 text-sm font-medium">Category</label>
                    <select name="categories[${categoryIndex}][category_id]"
                        class="category-select  border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">Sub Categories</label>
                    <div class="subcategory-container text-sm text-gray-700">
                        <p class="text-gray-500">Select a category to load subcategories</p>
                    </div>
                </div>
            </div>
            <div class="text-right mt-2">
                <button type="button" class="remove-category text-red-500 text-sm">Remove</button>
            </div>
        </div>`;
                      $('#category-container').append(newBlock);
                  });

                  // Remove category block
                  $(document).on('click', '.remove-category', function() {
                      $(this).closest('.category-group').remove();
                  });
              });
          </script>
