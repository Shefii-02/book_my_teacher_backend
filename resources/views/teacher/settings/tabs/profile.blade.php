<h2 class="text-xl font-bold mb-4 dark:text-white">Profile</h2>

<p class="text-gray-600 dark:text-gray-300 mb-6">
    Update your personal information.
</p>
<form action="{{ route('company.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="flex items-center gap-6">
        <!-- Avatar Upload -->
        <div class="flex flex-col items-center text-center">
            <img class="w-24 h-24 object-cover rounded-full border-4 border-indigo-200"
                src="{{ auth()->user()->avatar_url }}" id="imagePreview" alt="Profile Picture">
            <label
                class="mt-3 cursor-pointer px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow">
                Change Picture
                <input type="file" id="avatarInput" accept="image/*" class="hidden" name="avatar"
                    onchange="previewImage(event)">
            </label>
            @error('avatar')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- User Details -->
        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 flex-1">
            <div>
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" id="first_name" name="name" value="{{ auth()->user()->name }}"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('first_name')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('email')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit"
            class="px-6 py-2.5 bg-emerald-500/50 hover:bg-emerald-700 text-white rounded-lg shadow font-medium">
            Save Changes
        </button>
    </div>
</form>
<script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
