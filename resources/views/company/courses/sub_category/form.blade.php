<div class="card  rounded-3 mb-3">

    <div class="position-relative">
        <h6 class="mb-0 font-bold text-black absolute top-2 text-8xl">
            {{ isset($subCategory) ? 'Edit' : 'Create' }} a Sub Category</h6>
    </div>
    <form
        action="{{ isset($subCategory) ? route('admin.subcategories.update', $subCategory->id) : route('admin.subcategories.store') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($subCategory))
            @method('PUT')
        @else
            @method('POST')
        @endif

        @include('components.thumbImg-input', [
            'name' => 'thumbnail',
            'field' => 'thumbnail_url',
            'label' => 'Thumbnail',
            'size' => '128x128 px',
            'item' => $subCategory ?? null,
            'isEdit' => isset($subCategory),
        ])

        @include('components.select-input', [
            'label' => 'Category',
            'name' => 'category_id',
            'options' => $categories->map(fn($c) => ['id' => $c->id, 'title' => $c->title])->toArray(),
            'value' => isset($subCategory) ? $subCategory->category_id : old('category_id'),
            'required' => true,
        ])


        {{-- Title --}}
        @include('components.text-input', [
            'name' => 'title',
            'label' => 'Title',
            'item' => $subCategory ?? null,
            'isEdit' => isset($subCategory),
            'required' => true,
        ])

        <!-- Description -->
        @include('components.textarea-input', [
            'name' => 'description',
            'label' => 'Description',
            'rows' => 4,
            'item' => $subCategory ?? null,
            'isEdit' => isset($subCategory),
        ])

        <!-- Priority -->
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            @include('components.priority-input', [
                'name' => 'position',
                'label' => 'Position',
                'item' => $subCategory ?? null,
                'isEdit' => isset($subCategory),
            ])
        </div>
        <!-- PUBLISHED TOGGLE -->
        @include('components.toggle-status', [
            'name' => 'status',
            'label' => 'Published',
            'item' => $subCategory ?? null,
            'isEdit' => isset($subCategory),
        ])

        @include('components.submit-button', [
            'label' => isset($subCategory) && $subCategory ? 'Update' : 'Create',
            'color' => 'green',
            'full' => false,
            'center' => false,
        ])



    </form>
</div>
</div>
