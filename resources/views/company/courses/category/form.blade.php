<div>
    <div class="position-relative">
        <h6 class="my-5 font-bold text-black absolute top-2 text-8xl capitalize">Category
            {{ isset($category) ? 'Edit' : 'Create' }}</h6>
    </div>

    <form
        action="{{ isset($category) ? route('company.categories.update', $category->id) : route('company.categories.store') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($category))
            @method('PUT')
        @else
            @method('POST')
        @endif

        <div class="my-5">

            @include('components.thumbImg-input', [
                'name' => 'thumbnail',
                'field' => 'thumbnail_url',
                'label' => 'Thumbnail',
                'size' => '128x128 px',
                'item' => $category ?? null,
                'isEdit' => isset($category),
            ])

        </div>
        {{-- Title --}}
        @include('components.text-input', [
            'name' => 'title',
            'label' => 'Title',
            'item' => $category ?? null,
            'isEdit' => isset($category),
            'required' => true,
        ])

        <!-- Description -->
        @include('components.textarea-input', [
            'name' => 'description',
            'label' => 'Description',
            'rows' => 4,
            'item' => $category ?? null,
            'isEdit' => isset($category),
        ])

        <!-- Priority -->
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            @include('components.priority-input', [
                'name' => 'position',
                'label' => 'Position',
                'item' => $category ?? null,
                'isEdit' => isset($category),
            ])
        </div>
        <!-- PUBLISHED TOGGLE -->
        @include('components.toggle-status', [
            'name' => 'status',
            'label' => 'Published',
            'item' => $category ?? null,
            'isEdit' => isset($category),
        ])

        @include('components.submit-button', [
            'label' => isset($category) && $category ? 'Update' : 'Create',
            'color' => 'green',
            'full' => false,
            'center' => false,
        ])

    </form>

</div>
