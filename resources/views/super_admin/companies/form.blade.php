<div>
    <div class="position-relative">
        <h6 class="mb-0 font-bold text-black absolute top-2 text-8xl capitalize">Category
            {{ isset($company) ? 'Edit' : 'Create' }}</h6>
    </div>

    <form action="{{ isset($company) ? route('admin.companies.update', $company->id) : route('admin.companies.store') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($company))
            @method('PUT')
        @else
            @method('POST')
        @endif

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            {{-- Fav --}}
            @include('components.thumbImg-input', [
                'name' => 'fav_logo',
                'field' => 'fav_url',
                'label' => 'Fav Icon',
                'size' => '128x128 px',
                'item' => $company ?? null,
                'src' => $company ? $company->favicon_url : '',
                'isEdit' => isset($company),
            ])
            {{-- Black Logo --}}
            @include('components.thumbImg-input', [
                'name' => 'black_logo',
                'field' => 'black_url',
                'label' => 'Black Logo',
                'size' => '800×120 px',
                'item' => $company ?? null,
                'src' => $company ? $company->black_logo_url : '',
                'isEdit' => isset($company),
            ])

        </div>
        {{-- White Logo --}}
        @include('components.thumbImg-input', [
            'name' => 'white_logo',
            'field' => 'white_url',
            'label' => 'White Logo',
            'size' => '800×120 px',
            'item' => $company ?? null,
                'src' => $company ? $company->white_logo_url : '',
            'isEdit' => isset($company),
        ])
        <h5 class="text-bold text-primary text-underline text-center">Company Details</h5>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            {{-- Title --}}
            @include('components.text-input', [
                'name' => 'title',
                'value_name' => $company ? $company->name : '',
                'label' => 'Title',
                'item' => $company ?? null,
                'isEdit' => isset($company),
                'required' => true,
            ])
            {{-- Email --}}
            @include('components.text-input', [
                'name' => 'email',
                'value_name' => $company ? $company->email : '',
                'label' => 'Email',
                'item' => $company ?? null,
                'isEdit' => isset($company),
                'required' => true,
            ])
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            {{-- Phone --}}
            @include('components.text-input', [
                'name' => 'phone',
                'label' => 'Phone Number',
                'value_name' => $company ? $company->mobile : '',
                'item' => $company ?? null,
                'isEdit' => isset($company),
                'required' => true,
            ])

            {{-- Whatsapp --}}
            @include('components.text-input', [
                'name' => 'whatsapp',
                'label' => 'Whatsapp Number',
                'value_name' => $company ? $company->whatsapp : '',
                'item' => $company ?? null,
                'isEdit' => isset($company),
                'required' => true,
            ])
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            {{-- Website --}}

            @include('components.text-input', [
                'name' => 'website',
                'label' => 'Website Url',
                'value_name' => $company ? $company->website : '',
                'item' => $company ?? null,
                'isEdit' => isset($company),
                'required' => true,
            ])
            {{-- Prefix --}}
            @include('components.text-input', [
                'name' => 'prefix',
                'label' => 'Prefix',
                'value_name' => $company ? $company->slug : '',
                'item' => $company ?? null,
                'isEdit' => isset($company),
                'required' => true,
            ])
        </div>


        {{-- Address 1 --}}
        @include('components.textarea-input', [
            'name' => 'address_1',
            'label' => 'Address Line 1',
            'value_name' => $company ? $company->address_line1 : '',
            'rows' => 4,
            'item' => $company ?? null,
            'isEdit' => isset($company),
        ])

        {{-- Address 2 --}}
        @include('components.textarea-input', [
            'name' => 'address_2',
            'label' => 'Address Line 2',
            'value_name' => $company ? $company->address_line2 : '',
            'rows' => 4,
            'item' => $company ?? null,
            'isEdit' => isset($company),
        ])


        <div class="grid gap-6 mb-6 md:grid-cols-2">

            {{-- City --}}
            @include('components.text-input', [
                'name' => 'city',
                'label' => 'City',
                'value_name' => $company ? $company->city : '',
                'item' => $company ?? null,
                'isEdit' => isset($company),
                'required' => true,
            ])

            {{-- State --}}
            @include('components.text-input', [
                'name' => 'state',
                'label' => 'State',
                'item' => $company ?? null,
                'value_name' => $company ? $company->state : '',
                'isEdit' => isset($company),
                'required' => true,
            ])
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            {{-- Country --}}
            @include('components.text-input', [
                'name' => 'country',
                'label' => 'Country',
                'value_name' => $company ? $company->country : '',
                'item' => $company ?? null,
                'isEdit' => isset($company),
                'required' => true,
            ])


            {{-- Pin code --}}
            @include('components.text-input', [
                'name' => 'pincode',
                'label' => 'Pin Code',
                'value_name' => $company ? $company->pincode : '',
                'item' => $company ?? null,
                'isEdit' => isset($company),
                'required' => true,
            ])

        </div>

        <!-- Description -->
        {{-- @include('components.textarea-input', [
            'name' => 'description',
            'label' => 'Description',
            'rows' => 4,
            'item' => $company ?? null,
            'isEdit' => isset($company),
        ]) --}}

        <h5 class="text-bold text-primary text-underline text-center">Contact Details</h5>

        {{-- White Logo --}}
        @include('components.thumbImg-input', [
            'name' => 'avatar_logo',
            'field' => 'avatar_logo',
            'label' => 'Avaatr Image',
            'size' => '400×400 px',
            'item' => $company ?? null,
            'src' => $company ? $company->user->avatar_url : '',
            'isEdit' => isset($company),
        ])

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            {{-- Title --}}
            @include('components.text-input', [
                'name' => 'name',
                'label' => 'Full Name',
                'value_name' => $company ? $company->user->name : '',
                'item' => $company ?? null,
                'isEdit' => isset($company),
                'required' => true,
            ])
            {{-- Email --}}
            @include('components.text-input', [
                'name' => 'personal_email',
                'label' => 'Personal Email',
                'item' => $company ?? null,
                'value_name' => $company ? $company->user->email : '',
                'isEdit' => isset($company),
                'required' => true,
            ])
            {{-- Mobile --}}
            @include('components.text-input', [
                'name' => 'personal_mobile',
                'label' => 'Personal Mobile',
                'value_name' => $company ? $company->user->mobile : '',
                'item' => $company ?? null,
                'isEdit' => isset($company),
                'required' => true,
            ])
            {{-- Password --}}
            @include('components.text-input', [
                'name' => 'password',
                'label' => 'Password',
                'item' => $company ?? null,
                'isEdit' => isset($company),
                'required' => $company ? false :true,
            ])
        </div>

        <!-- PUBLISHED TOGGLE -->
        @include('components.toggle-status', [
            'name' => 'status',
            'label' => 'Published',
            'item' => $company ?? null,
            'value_name' => $company ? $company->user->status : '',
            'isEdit' => isset($company),
        ])

        @include('components.submit-button', [
            'label' => isset($company) && $company ? 'Update' : 'Create',
            'color' => 'green',
            'full' => false,
            'center' => false,
        ])

    </form>

</div>
