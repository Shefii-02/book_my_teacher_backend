<h5 class="font-bold mb-6">Manage Group Conversation</h5>

<form method="POST" action="{{ route('company.courses.addonTeachersSave', $course->course_identity) }}">
    @csrf

    {{-- Course details --}}
    <div class="p-4 border bg-white rounded mb-4">
        <div class="flex gap-2">
            Course Name :
            <div class="font-semibold text-lg">{{ $course->title }}</div>
        </div>

        <div class="flex gap-2">
            Description :
            <p class="text-sm text-gray-600 mt-1">{{ $course->description }}</p>
        </div>

        <div class="mt-2 text-sm text-gray-700">
            Created at: {{ $course->created_at }} &nbsp;
            Updated at: {{ $course->updated_at }}
        </div>
    </div>
    <div class="mb-3">
        <label>Group Name</label>
        <input type="text" value="{{ $conversation ? $conversation->name : $course->title }}" name="title" class="border px-4 py-2 rounded w-full mb-4" />
    </div>

    {{-- SEARCH BOX --}}
    <input type="text" id="userSearch" placeholder="Search user..." class="border px-4 py-2 rounded w-full mb-4">

    {{-- SEARCH RESULTS --}}
    <div id="userResults" class="border rounded mb-6 hidden max-h-60 overflow-y-auto"></div>

    {{-- SELECTED USERS --}}
    <h6 class="font-semibold mb-2">Selected Members</h6>

    <div id="selectedUsers" class="flex flex-wrap gap-3 mb-6">

      @foreach ($teachers as $teacher)
            <div class="teacher-item flex items-center justify-between p-3 border-b cursor-pointer hover:bg-gray-50"
                data-name="{{ strtolower($teacher->name) }}" data-id="{{ $teacher->id }}"
                data-image="{{ $teacher->profile_image ?? asset('default-user.png') }}"
                data-email="{{ $teacher->email }}" data-mobile="{{ $teacher->teacher->mobile ?? '' }}">

                <div class="flex items-center gap-3">

                    <img src="{{ $teacher->profile_image ?? asset('default-user.png') }}"
                        class="w-10 h-10 rounded-full">

                    <div>

                        <p class="font-semibold text-sm">{{ $teacher->name }}</p>

                        <p class="text-xs text-gray-500">
                            {{ $teacher->email }}
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ $teacher->teacher->mobile ?? '' }}
                        </p>

                    </div>

                </div>

                <span class="text-sm text-blue-500">Select</span>

            </div>
        @endforeach

    </div>

    <div class="text-center">
        <button class="bg-emerald-500/50 text-white px-6 py-2 rounded">
            Save Members
        </button>
    </div>


</form>

<script>
    let selectedUsers = {
        @foreach ($conversation?->members ?? [] as $member)
            "{{ $member->user->id }}": true,
        @endforeach
    };

    const searchInput = document.getElementById('userSearch');
    const userResults = document.getElementById('userResults');

    // 🔍 AJAX SEARCH
    searchInput.addEventListener('keyup', function() {

        let value = this.value.trim();

        if (value.length < 1) {
            userResults.classList.add('hidden');
            userResults.innerHTML = '';
            return;
        }

        fetch(`{{ route('company.teacher.search') }}?q=${value}`)
            .then(res => res.json())
            .then(data => {

                userResults.innerHTML = '';

                if (data.length === 0) {
                    userResults.classList.add('hidden');
                    return;
                }

                userResults.classList.remove('hidden');

                data.forEach(user => {

                    // prevent duplicate
                    if (selectedUsers[user.id]) return;

                    let html = `
                <div class="user-item flex justify-between p-3 border-b cursor-pointer"
                    onclick="addUser(${user.id}, '${user.name}', '${user.email}', '${user.profile_image ?? ''}')">

                    <div class="flex gap-2">
                        <img src="${user.profile_image ?? '/default-user.png'}"
                            class="w-8 h-8 rounded-full">

                        <div>
                            <p>${user.name}</p>
                            <p class="text-xs">${user.email}</p>
                        </div>
                    </div>

                    <span class="text-blue-500">Select</span>
                </div>
                `;

                    userResults.insertAdjacentHTML('beforeend', html);

                });

            });

    });

     // ❌ REMOVE USER
    function removeUser(id) {

        delete selectedUsers[id];

        let el = document.getElementById('user_' + id);
        if (el) el.remove();

    }

    // ➕ ADD USER
    function addUser(id, name, email, image) {

        if (selectedUsers[id]) return;

        selectedUsers[id] = true;

        let html = `
    <div class="border p-2 flex gap-2 bg-gray-50" id="user_${id}">

        <input type="hidden" name="users[]" value="${id}">

        <img src="${image || '/default-user.png'}"
            class="w-8 h-8 rounded-full">

        <div>
            <p class="font-semibold">${name}</p>
            <p class="text-xs">${email}</p>
        </div>

        <button type="button"
            onclick="removeUser(${id})"
            class="text-red-500 ml-2">×</button>

    </div>
    `;

        document.getElementById('selectedUsers')
            .insertAdjacentHTML('beforeend', html);

        searchInput.value = '';
        userResults.innerHTML = '';
        userResults.classList.add('hidden');
    }



</script>
