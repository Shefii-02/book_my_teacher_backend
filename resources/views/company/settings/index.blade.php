@extends('layouts.layout')

@section('content')
    <div class="max-w-7xl mx-auto p-6">

        <h2 class="text-2xl font-bold mb-6">Company Settings</h2>

        <div x-data="{ tab: 'general' }" class="flex">

            {{-- LEFT SIDE - VERTICAL TABS --}}
            <div class="w-64 bg-white shadow rounded-lg p-4 h-full">

                <ul class="space-y-2">

                    <li>
                        <button @click="tab='general'"
                            :class="tab == 'general' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                            class="w-full text-left px-4 py-2 rounded-lg">
                            General
                        </button>
                    </li>

                    <li>
                        <button @click="tab='branding'"
                            :class="tab == 'branding' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                            class="w-full text-left px-4 py-2 rounded-lg">
                            Branding
                        </button>
                    </li>

                    <li>
                        <button @click="tab='social'"
                            :class="tab == 'social' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                            class="w-full text-left px-4 py-2 rounded-lg">
                            Social Links
                        </button>
                    </li>

                    <li>
                        <button @click="tab='payment'"
                            :class="tab == 'payment' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                            class="w-full text-left px-4 py-2 rounded-lg">
                            Payment Settings
                        </button>
                    </li>

                    <li>
                        <button @click="tab='security'"
                            :class="tab == 'security' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                            class="w-full text-left px-4 py-2 rounded-lg">
                            Security
                        </button>
                    </li>

                </ul>

            </div>

            {{-- RIGHT SIDE CONTENT --}}
            <div class="flex-1 ml-6">

                <div class="bg-white shadow-lg p-6 rounded-xl">

                    {{-- GENERAL --}}
                    <div x-show="tab=='general'" x-transition>
                        <h3 class="text-xl font-bold mb-4">General Information</h3>

                        <form method="POST" action="{{ route('admin.company.settings.general.update') }}">
                            @csrf

                            <div class="grid grid-cols-2 gap-4">

                                <div>
                                    <label class="font-semibold">Company Email</label>
                                    <input type="text" name="email" value="{{ $general?->email }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>

                                <div>
                                    <label class="font-semibold">Phone</label>
                                    <input type="text" name="phone" value="{{ $general?->phone }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>

                                <div>
                                    <label class="font-semibold">Website</label>
                                    <input type="text" name="website" value="{{ $general?->website }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>

                                <div>
                                    <label class="font-semibold">Whatsapp</label>
                                    <input type="text" name="whatsapp" value="{{ $general?->whatsapp }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>

                                <div class="col-span-2">
                                    <label class="font-semibold">Address</label>
                                    <textarea name="address" class="w-full border rounded px-3 py-2">{{ $general?->address }}</textarea>
                                </div>

                            </div>

                            <button class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg">Save</button>
                        </form>
                    </div>

                    {{-- BRANDING --}}
                    <div x-show="tab=='branding'" x-transition>
                        <h3 class="text-xl font-bold mb-4">Branding</h3>

                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('admin.company.settings.branding.update') }}">
                            @csrf

                            <div class="grid grid-cols-2 gap-4">
                                <div x-data="{
                                    blackLogoPreview: '{{ $company->black_logo ? asset($company->black_logo) : '' }}',
                                    whiteLogoPreview: '{{ $company->white_logo ? asset($company->white_logo) : '' }}',
                                    faviconPreview: '{{ $company->favicon ? asset($company->favicon) : '' }}'
                                }">

                                    <!-- Black Logo -->
                                    <div class="mb-4">
                                        <label class="font-semibold block mb-1">Black Logo</label>

                                        <!-- Preview -->
                                        <div
                                            class="mb-2 w-32 h-32 flex items-center justify-center border rounded shadow-sm bg-gray-50">
                                            <template x-if="blackLogoPreview">
                                                <img :src="blackLogoPreview" class="object-contain w-full h-full">
                                            </template>
                                            <template x-if="!blackLogoPreview">
                                                <span class="text-gray-400">No Image</span>
                                            </template>
                                        </div>

                                        <!-- Input -->
                                        <input type="file" name="black_logo"
                                            @change="blackLogoPreview = URL.createObjectURL($event.target.files[0])"
                                            class="w-full border rounded px-3 py-2">
                                    </div>

                                    <!-- White Logo -->
                                    <div class="mb-4">
                                        <label class="font-semibold block mb-1">White Logo</label>

                                        <!-- Preview -->
                                        <div
                                            class="mb-2 w-32 h-32 flex items-center justify-center border rounded shadow-sm bg-gray-50">
                                            <template x-if="whiteLogoPreview">
                                                <img :src="whiteLogoPreview" class="object-contain w-full h-full">
                                            </template>
                                            <template x-if="!whiteLogoPreview">
                                                <span class="text-gray-400">No Image</span>
                                            </template>
                                        </div>

                                        <!-- Input -->
                                        <input type="file" name="white_logo"
                                            @change="whiteLogoPreview = URL.createObjectURL($event.target.files[0])"
                                            class="w-full border rounded px-3 py-2">
                                    </div>

                                    <!-- Favicon -->
                                    <div class="mb-4">
                                        <label class="font-semibold block mb-1">Favicon</label>

                                        <!-- Preview -->
                                        <div
                                            class="mb-2 w-16 h-16 flex items-center justify-center border rounded shadow-sm bg-gray-50">
                                            <template x-if="faviconPreview">
                                                <img :src="faviconPreview" class="object-contain w-full h-full">
                                            </template>
                                            <template x-if="!faviconPreview">
                                                <span class="text-gray-400">No Image</span>
                                            </template>
                                        </div>

                                        <!-- Input -->
                                        <input type="file" name="favicon"
                                            @change="faviconPreview = URL.createObjectURL($event.target.files[0])"
                                            class="w-full border rounded px-3 py-2">
                                    </div>

                                </div>


                                <div>
                                    <label class="font-semibold">Theme Color</label>
                                    <input type="color" name="theme_color"
                                        value="{{ $branding?->theme_color ?? '#000' }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>
                            </div>

                            <button class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg">Save</button>
                        </form>
                    </div>


                    {{-- SOCIAL --}}
                    <div x-show="tab=='social'" x-transition>
                        <h3 class="text-xl font-bold mb-4">Social Links</h3>

                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('admin.company.settings.social.update') }}">
                            @csrf

                            <div x-data="{
                                rows: {{ $socialLinks->toJson() }},
                                addRow() {
                                    this.rows.push({
                                        id: 0,
                                        name: '',
                                        link: '',
                                        sort_order: 0,
                                        icon: null,
                                        preview: null
                                    });
                                },
                                removeRow(index) {
                                    this.rows.splice(index, 1);
                                }
                            }" class="space-y-4">

                                <template x-for="(row, index) in rows" :key="index">
                                    <div class="border p-4 rounded-lg shadow-sm bg-gray-50">

                                        <!-- Delete Button -->
                                        <div class=" text-right">
                                            <button type="button" @click="removeRow(index)"
                                                class="text-red-600 font-semibold hover:underline">
                                                Remove
                                            </button>
                                        </div>
                                        <div class="grid md:grid-cols-4 gap-6">

                                            <div class="flex items-center gap-4">

                                                <!-- IMAGE PREVIEW -->
                                                <div
                                                    class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-100 border shadow-sm">

                                                    <template x-if="row.preview || row.icon">
                                                        <img :src="row.preview ? row.preview : '' + row.icon"
                                                            class="w-12 h-12 rounded-full object-cover">
                                                    </template>

                                                    <template x-if="!row.preview && !row.icon">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v9m0-9l3-3m-3 3L9 9" />
                                                        </svg>
                                                    </template>

                                                </div>

                                                <!-- CUSTOM UPLOAD BUTTON -->
                                                <div>
                                                    <label
                                                        class="block text-sm font-semibold mb-1 text-gray-700">Icon</label>

                                                    <button type="button"
                                                        @click="document.getElementById('icon_input_' + row.id).click()"
                                                        class="px-2 text-xxs py-2 bg-gray-700 text-white rounded-lg shadow hover:bg-gray-800 transition flex items-center gap-2">

                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v9m0-9l3-3m-3 3L9 9" />
                                                        </svg>

                                                        Upload Icon
                                                    </button>

                                                    <!-- UNIQUE FILE INPUT PER ROW -->
                                                    <input type="file" class="hidden" :id="'icon_input_' + row.id"
                                                        :name="'links[' + row.id + '][icon]'"
                                                        @change="row.preview = URL.createObjectURL($event.target.files[0])">
                                                </div>

                                            </div>



                                            <!-- Name -->
                                            <div>
                                                <label class="font-semibold">Name</label>
                                                <input type="text" :name="'links[' + row.id + '][name]'"
                                                    x-model="row.name" class="w-full border rounded px-3 py-2"
                                                    placeholder="Facebook">
                                            </div>


                                            <!-- Link -->
                                            <div>
                                                <label class="font-semibold">Link</label>
                                                <input type="text" :name="'links[' + row.id + '][link]'"
                                                    x-model="row.link" class="w-full border rounded px-3 py-2"
                                                    placeholder="https://facebook.com">
                                            </div>

                                            <!-- Sort Order -->
                                            <div>
                                                <label class="font-semibold">Sort Order</label>
                                                <input type="number" :name="'links[' + row.id + '][sort_order]'"
                                                    x-model="row.sort_order" class="w-full border rounded px-3 py-2">
                                            </div>




                                        </div>

                                    </div>
                                </template>

                                <button type="button" @click="addRow"
                                    class="mt-4 float-right text-xxs bg-gray-600 text-white px-4 py-2 rounded-lg">
                                    + Add More
                                </button>

                            </div>

                            <button class="mt-6 bg-blue-600 text-white text-center px-6 py-2 rounded-lg">Save</button>
                        </form>
                    </div>



                    {{-- PAYMENT --}}
                    <div x-show="tab=='payment'" x-transition>
                        <h3 class="text-xl font-bold mb-4">Payment Settings</h3>

                        <form method="POST" action="{{ route('admin.company.settings.payment.update') }}">
                            @csrf

                            <div class="grid grid-cols-2 gap-4">

                                <div>
                                    <label class="font-semibold">Merchant ID</label>
                                    <input type="text" name="merchant_id" value="{{ $payment?->merchant_id }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>

                                <div>
                                    <label class="font-semibold">Salt Key</label>
                                    <input type="text" name="salt_key" value="{{ $payment?->salt_key }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>

                                <div>
                                    <label class="font-semibold">Salt Index</label>
                                    <input type="text" name="salt_index" value="{{ $payment?->salt_index }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>

                            </div>

                            <button class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg">Save</button>
                        </form>
                    </div>

                    {{-- SECURITY --}}
                    <div x-show="tab=='security'" x-transition>
                        <h3 class="text-xl font-bold mb-4">Security Settings</h3>

                        <form method="POST" action="{{ route('admin.company.settings.security.update') }}">
                            @csrf

                            <div class="space-y-4">

                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" class="border" name="two_factor_enabled"
                                        @checked($security?->two_factor_enabled)>
                                    <span>Enable Two-Factor Authentication</span>
                                </label>

                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" class="border" name="maintenance_mode"
                                        @checked($security?->maintenance_mode)>
                                    <span>Enable Maintenance Mode</span>
                                </label>

                            </div>

                            <button class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg">Save</button>
                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection
