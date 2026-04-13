<h5 class="font-bold mb-6">Assign Teachers</h5>

<form method="POST" action="{{ route('company.courses.addonTeachersSave', $course->course_identity) }}">
    @csrf

    {{-- Course details --}}
    <div id="courseDetails" class="p-4 border bg-white rounded rounded mb-4 ">
        <div class="flex gap-2">

            Course Name : <div id="cd_title" class="font-semibold text-lg">{{ $course->title }}</div>
        </div>
        <div class="flex gap-2">
            Description : <p id="cd_desc" class="text-sm text-gray-600 mt-1">{{ $course->description }}</p>
        </div>
        <div class="mt-2 text-sm text-gray-700">
            Created at: <span id="">{{ $course->created_at }}</span> &nbsp;
            Updated at: <span id="cd_net_price">{{ $course->updated_at }}</span> &nbsp;
        </div>
    </div>
    {{-- SEARCH BOX --}}

    <div class="mb-4">
        <input type="text" id="teacherSearch" placeholder="Search teacher by name..."
            class="border px-4 py-2 rounded w-full">
    </div>


    {{-- SEARCH RESULTS --}}

    <div id="teacherResults" class="border rounded mb-6 hidden max-h-60 overflow-y-auto">

        {{-- @foreach ($teachers as $teacher)
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
        @endforeach --}}

    </div>



    {{-- SELECTED TEACHERS --}}

    <h6 class="font-semibold mb-2">Selected Teachers</h6>

    <div id="selectedTeachers" class="flex flex-wrap gap-3 mb-6">

        @foreach ($course->teachers as $teacher)
            <div class="flex items-center gap-3 border rounded p-2 bg-gray-50" id="teacher_{{ $teacher->id }}">

                <input type="hidden" name="teachers[]" value="{{ $teacher->id }}">

                <img src="{{ $teacher->profile_image ?? asset('default-user.png') }}" class="w-8 h-8 rounded-full">

                <div class="text-xs">

                    <p class="font-semibold">{{ $teacher->name }}</p>

                    <p>{{ $teacher->email }}</p>

                    <p>{{ $teacher->teacher->mobile ?? '' }}</p>

                </div>

                <button type="button" onclick="removeTeacher({{ $teacher->id }})" class="text-red-500 text-lg ml-2">
                    ×
                </button>

            </div>
        @endforeach

    </div>



    <button class="bg-emerald-500/50 text-white px-6 py-2 rounded">
        Save Teachers
    </button>

</form>
<script>
    let selectedTeachers = {

        @foreach ($course->teachers as $teacher)
            "{{ $teacher->id }}": true,
        @endforeach

    }


    const searchInput = document.getElementById('teacherSearch');
    const teacherResults = document.getElementById('teacherResults');

    // 🔍 AJAX SEARCH
    searchInput.addEventListener('keyup', function() {

        let value = this.value.trim();

        if (value.length < 1) {
            teacherResults.classList.add('hidden');
            teacherResults.innerHTML = '';
            return;
        }

        fetch(`{{ route('company.teacher.search') }}?q=${value}`)
            .then(res => res.json())
            .then(data => {

                teacherResults.innerHTML = '';

                if (data.length === 0) {
                    teacherResults.classList.add('hidden');
                    return;
                }

                teacherResults.classList.remove('hidden');

                data.forEach(teacher => {

                    // prevent duplicate
                    if (selectedTeachers[teacher.id]) return;

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

        <input type="hidden" name="teachers[]" value="${id}">

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
