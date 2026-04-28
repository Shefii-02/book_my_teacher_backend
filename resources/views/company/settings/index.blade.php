@extends('layouts.layout')

@section('content')
    <div class="max-w-7xl mx-auto p-6">

        <h2 class="text-2xl font-bold mb-6">Company Settings</h2>

        <div x-data="{ tab: 'general' }" class="flex gap-6">

            <!-- LEFT TABS -->
            <div class="w-64 bg-white shadow rounded-lg p-4">

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
                            Social Media
                        </button>
                    </li>

                    <li>
                        <button @click="tab='community'"
                            :class="tab == 'community' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                            class="w-full text-left px-4 py-2 rounded-lg">
                            Community Links
                        </button>
                    </li>

                    <li>
                        <button @click="tab='otp'"
                            :class="tab == 'otp' ?
                                'bg-blue-600 text-white' :
                                'bg-gray-100 text-gray-700'"
                            class="w-full text-left px-4 py-2 rounded-lg">

                            Test OTP

                        </button>
                    </li>


                    <li>
                        <button @click="tab='push'"
                            :class="tab == 'push' ?
                                'bg-blue-600 text-white' :
                                'bg-gray-100 text-gray-700'"
                            class="w-full text-left px-4 py-2 rounded-lg">

                            Test Push Notification

                        </button>
                    </li>

                </ul>
            </div>

            <!-- RIGHT CONTENT -->
            <div class="flex-1">

                <div class="bg-white shadow-lg p-6 rounded-xl">

                    <!-- ================= GENERAL ================= -->
                    <div x-show="tab=='general'" x-transition>

                        <h3 class="text-xl font-bold mb-5">
                            General Information
                        </h3>

                        <form method="POST" action="{{ route('company.company.settings.general.update') }}">

                            @csrf

                            <div class="grid md:grid-cols-2 gap-5">

                                <div>
                                    <label class="font-semibold">
                                        Company Email
                                    </label>

                                    <input name="email" value="{{ $general?->email }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>

                                <div>
                                    <label class="font-semibold">
                                        Phone
                                    </label>

                                    <input name="phone" value="{{ $general?->phone }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>

                                <div>
                                    <label class="font-semibold">
                                        Website
                                    </label>

                                    <input name="website" value="{{ $general?->website }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>

                                <div>
                                    <label class="font-semibold">
                                        Whatsapp
                                    </label>

                                    <input name="whatsapp" value="{{ $general?->whatsapp }}"
                                        class="w-full border rounded px-3 py-2">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="font-semibold">
                                        Address
                                    </label>

                                    <textarea name="address" class="w-full border rounded px-3 py-2">{{ $general?->address }}</textarea>
                                </div>

                            </div>

                            <button class="mt-5 bg-blue-600 text-white px-6 py-2 rounded-lg">
                                Save
                            </button>

                        </form>
                    </div>


                    <!-- ================= BRANDING ================= -->
                    <div x-show="tab=='branding'" x-transition>

                        <h3 class="text-xl font-bold mb-5">
                            Branding
                        </h3>

                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('company.company.settings.branding.update') }}">

                            @csrf

                            <div x-data="{
                                blackLogoPreview: '{{ $company->black_logo ? asset($company->black_logo) : '' }}',
                                whiteLogoPreview: '{{ $company->white_logo ? asset($company->white_logo) : '' }}',
                                faviconPreview: '{{ $company->favicon ? asset($company->favicon) : '' }}'
                            }" class="grid md:grid-cols-2 gap-6">

                                <div>

                                    <label class="font-semibold block mb-2">
                                        Black Logo
                                    </label>

                                    <div class="w-32 h-32 border rounded flex items-center justify-center mb-2">
                                        <template x-if="blackLogoPreview">
                                            <img :src="blackLogoPreview" class="w-full h-full object-contain">
                                        </template>
                                    </div>

                                    <input type="file" name="black_logo"
                                        @change="blackLogoPreview = URL.createObjectURL($event.target.files[0])">


                                    <label class="font-semibold block mt-6 mb-2">
                                        White Logo
                                    </label>

                                    <div class="w-32 h-32 border rounded flex items-center justify-center mb-2">
                                        <template x-if="whiteLogoPreview">
                                            <img :src="whiteLogoPreview" class="w-full h-full object-contain">
                                        </template>
                                    </div>

                                    <input type="file" name="white_logo"
                                        @change="whiteLogoPreview = URL.createObjectURL($event.target.files[0])">

                                </div>


                                <div>

                                    <label class="font-semibold block mb-2">
                                        Favicon
                                    </label>

                                    <div class="w-16 h-16 border rounded flex items-center justify-center mb-2">
                                        <template x-if="faviconPreview">
                                            <img :src="faviconPreview" class="w-full h-full object-contain">
                                        </template>
                                    </div>

                                    <input type="file" name="favicon"
                                        @change="faviconPreview = URL.createObjectURL($event.target.files[0])">


                                    <label class="font-semibold block mt-6 mb-2">
                                        Theme Color
                                    </label>

                                    <input type="color" name="theme_color"
                                        value="{{ $branding?->theme_color ?? '#000000' }}">

                                </div>

                            </div>

                            <button class="mt-6 bg-blue-600 text-white px-6 py-2 rounded-lg">
                                Save Branding
                            </button>

                        </form>
                    </div>


                    <!-- ================= SOCIAL MEDIA ================= -->
                    <div x-show="tab=='social'" x-transition>

                        <h3 class="text-xl font-bold mb-5">
                            Social Media Links
                        </h3>

                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('company.company.settings.social.update') }}">

                            @csrf

                            <input type="hidden" name="category" value="socialmedia">

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
                                    })
                                },

                                removeRow(index) {
                                    this.rows.splice(index, 1)
                                }
                            }" class="space-y-4">

                                <template x-for="(row,index) in rows" :key="index">

                                    <div class="border p-4 rounded bg-gray-50">

                                        <div class="text-right mb-3">
                                            <button type="button" @click="removeRow(index)" class="text-red-600">
                                                Remove
                                            </button>
                                        </div>

                                        <div class="grid md:grid-cols-4 gap-5">

                                            <div>

                                                <div class="w-12 h-12 rounded-full border mb-2 overflow-hidden">
                                                    <template x-if="row.preview || row.icon">
                                                        <img :src="row.preview ? row.preview : row.icon"
                                                            class="w-full h-full object-cover">
                                                    </template>
                                                </div>

                                                <input type="file" class="hidden" :id="'social_icon_' + index"
                                                    :name="'links[' + row.id + '][icon]'"
                                                    @change="row.preview=URL.createObjectURL($event.target.files[0])">

                                                <button type="button"
                                                    @click="document.getElementById('social_icon_'+index).click()"
                                                    class="bg-gray-700 text-white px-3 py-2 rounded">
                                                    Upload
                                                </button>
                                            </div>

                                            <div>
                                                <label>Name</label>
                                                <input x-model="row.name" :name="'links[' + row.id + '][name]'"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>

                                            <div>
                                                <label>Link</label>
                                                <input x-model="row.link" :name="'links[' + row.id + '][link]'"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>

                                            <div>
                                                <label>Sort</label>
                                                <input type="number" x-model="row.sort_order"
                                                    :name="'links[' + row.id + '][sort_order]'"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>

                                        </div>
                                    </div>

                                </template>

                                <button type="button" @click="addRow" class="bg-gray-600 text-white px-4 py-2 rounded">
                                    + Add Social Link
                                </button>

                            </div>

                            <button class="mt-6 bg-blue-600 text-white px-6 py-2 rounded-lg">
                                Save Social Links
                            </button>

                        </form>
                    </div>


                    <!-- ================= COMMUNITY ================= -->
                    <div x-show="tab=='community'" x-transition>

                        <h3 class="text-xl font-bold mb-5">
                            Community Links
                        </h3>

                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('company.company.settings.social.update') }}">

                            @csrf

                            <input type="hidden" name="category" value="community">

                            <div x-data="{
                                rows: {{ $communityLinks->toJson() }},

                                addRow() {
                                    this.rows.push({
                                        id: 0,
                                        name: '',
                                        link: '',
                                        sort_order: 0,
                                        icon: null,
                                        preview: null
                                    })
                                },

                                removeRow(index) {
                                    this.rows.splice(index, 1)
                                }
                            }" class="space-y-4">

                                <template x-for="(row,index) in rows" :key="index">

                                    <div class="border p-4 rounded bg-gray-50">

                                        <div class="text-right mb-3">
                                            <button type="button" @click="removeRow(index)" class="text-red-600">
                                                Remove
                                            </button>
                                        </div>

                                        <div class="grid md:grid-cols-4 gap-5">

                                            <div>

                                                <div class="w-12 h-12 rounded-full border mb-2 overflow-hidden">
                                                    <template x-if="row.preview || row.icon">
                                                        <img :src="row.preview ? row.preview : row.icon"
                                                            class="w-full h-full object-cover">
                                                    </template>
                                                </div>

                                                <input type="file" class="hidden" :id="'community_icon_' + index"
                                                    :name="'links[' + row.id + '][icon]'"
                                                    @change="row.preview=URL.createObjectURL($event.target.files[0])">

                                                <button type="button"
                                                    @click="document.getElementById('community_icon_'+index).click()"
                                                    class="bg-gray-700 text-white px-3 py-2 rounded">
                                                    Upload
                                                </button>
                                            </div>

                                            <div>
                                                <label>Name</label>
                                                <input x-model="row.name" :name="'links[' + row.id + '][name]'"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>

                                            <div>
                                                <label>Link</label>
                                                <input x-model="row.link" :name="'links[' + row.id + '][link]'"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>

                                            <div>
                                                <label>Sort</label>
                                                <input type="number" x-model="row.sort_order"
                                                    :name="'links[' + row.id + '][sort_order]'"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>

                                        </div>
                                    </div>

                                </template>

                                <button type="button" @click="addRow" class="bg-gray-600 text-white px-4 py-2 rounded">
                                    + Add Community Link
                                </button>

                            </div>

                            <button class="mt-6 bg-blue-600 text-white px-6 py-2 rounded-lg">
                                Save Community Links
                            </button>

                        </form>
                    </div>

                    <div x-show="tab=='otp'" x-transition>

                        <h3 class="text-xl font-bold mb-4">
                            Test OTP
                        </h3>

                        <form method="POST" action="{{ route('company.settings.test.otp') }}">

                            @csrf

                            <div x-data="userSearchOtp()" class="space-y-4">

                                <div>

                                    <label class="font-semibold">
                                        Find User
                                    </label>

                                    <input type="text" x-model="keyword" @keyup.debounce.500="searchUsers()"
                                        placeholder="Type name / phone / email" class="w-full border rounded px-3 py-2">

                                </div>


                                <template x-if="results.length">

                                    <div class="border rounded">

                                        <template x-for="user in results" :key="user.id">

                                            <div class="p-3 border-b hover:bg-gray-50 cursor-pointer"
                                                @click="selectUser(user)">

                                                <span x-text="user.name"></span>

                                                -
                                                <span x-text="user.mobile"></span>

                                            </div>

                                        </template>

                                    </div>

                                </template>


                                <div>

                                    <label>
                                        Selected User
                                    </label>

                                    <input readonly x-model="selectedName" class="w-full border rounded px-3 py-2">

                                    <input type="hidden" name="user_id" x-model="selectedUserId">

                                </div>

                                <button class="bg-blue-600 text-white px-6 py-2 rounded">
                                    Send Test OTP
                                </button>

                            </div>

                        </form>

                    </div>


                    <div x-show="tab=='push'" x-transition>

                        <h3 class="text-xl font-bold mb-4">
                            Test Push Notification
                        </h3>

                        <form method="POST" action="{{ route('company.settings.test.push') }}">

                            @csrf

                            <div x-data="userSearchPush()" class="space-y-4">

                                <div>

                                    <label>
                                        Find User
                                    </label>

                                    <input type="text" x-model="keyword" @keyup.debounce.500="searchUsers()"
                                        class="w-full border rounded px-3 py-2">

                                </div>


                                <template x-if="results.length">

                                    <div class="border rounded">

                                        <template x-for="user in results" :key="user.id">

                                            <div @click="selectUser(user)"
                                                class="p-3 border-b hover:bg-gray-50 cursor-pointer">

                                                <span x-text="user.name"></span>
                                                -
                                                <span x-text="user.mobile"></span>
                                            </div>

                                        </template>

                                    </div>

                                </template>


                                <input type="hidden" name="user_id" x-model="selectedUserId">


                                <div x-show="devices.length">

                                    <h4 class="font-semibold">
                                        User Devices
                                    </h4>

                                    <template x-for="device in devices" :key="device.id">

                                        <div class="border p-3 rounded mb-2">

                                            <div>
                                                Platform:
                                                <span x-text="device.platform"></span>
                                            </div>

                                            <div>
                                                City:
                                                <span x-text="device.city"></span>
                                            </div>

                                            <div>
                                                Version:
                                                <span x-text="device.app_version"></span>
                                            </div>

                                            <div>
                                                Token:
                                                <small x-text="device.fcm_token"></small>
                                            </div>

                                        </div>

                                    </template>

                                </div>


                                <div>

                                    <label>Title</label>

                                    <input name="title" class="w-full border rounded px-3 py-2">

                                </div>


                                <div>

                                    <label>Message</label>

                                    <textarea name="message" class="w-full border rounded px-3 py-2">
</textarea>

                                </div>

                                <button class="bg-blue-600 text-white px-6 py-2 rounded">

                                    Send Test Push

                                </button>

                            </div>

                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection



@push('scripts')
    <script>
        function userSearchOtp() {

            return {

                keyword: '',
                results: [],
                selectedUserId: '',
                selectedName: '',

                searchUsers() {

                    fetch(
                            '/company/ajax/users/search?key=' +
                            this.keyword
                        )

                        .then(r => r.json())

                        .then(data => {
                            this.results = data;
                        });

                },

                selectUser(user) {

                    this.selectedUserId =
                        user.id;

                    this.selectedName =
                        user.name + `- (` + user.mobile + `)`;

                    this.results = [];

                }

            }
        }



        function userSearchPush() {

            return {

                keyword: '',
                results: [],
                devices: [],
                selectedUserId: '',

                searchUsers() {

                    fetch(
                            '/company/ajax/users/search?key=' +
                            this.keyword
                        )

                        .then(r => r.json())

                        .then(data => {
                            this.results = data;
                        });

                },

                selectUser(user) {

                    this.selectedUserId =
                        user.id;

                    this.results = [];

                    fetch(
                            '/company/users/' +
                            user.id +
                            '/devices'
                        )

                        .then(r => r.json())

                        .then(data => {
                            this.devices = data;
                        });

                }

            }
        }
    </script>
@endpush
