{{-- PROFILE TAB --}}
<div class="mb-6 flex justify-between items-center">

    <div>
        <h3 class="text-2xl font-black text-slate-800 dark:text-white">
            Personal Information
        </h3>
        <p class="text-slate-500 text-sm">
            Teacher basic profile details
        </p>
    </div>

    <button onclick="toggleModal('profileModal')"
        class="px-5 py-2 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold">
        <i class="bi bi-pencil"></i> Edit
    </button>

</div>

{{-- VIEW --}}
<div id="profileViewBox">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        <x-info label="Full Name" :value="$teacher->user->name ?? '-'" />
        <x-info label="Email" :value="$teacher->user->email ?? '-'" />
        <x-info label="Phone" :value="$teacher->user->mobile ?? '-'" />
        <x-info label="City" :value="$teacher->user->city ?? '-'" />
        <x-info label="State" :value="$teacher->user->state ?? '-'" />
        <x-info label="Country" :value="$teacher->user->country ?? '-'" />

    </div>
</div>


   <!-- PROFILE EDIT MODAL -->
<div id="profileModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-[#050708] w-1/2 dark:bg-slate-800 w-full  rounded-2xl shadow-xl p-6">

        <div class="flex justify-between items-center mb-4">

            <h2 class="text-xl font-black text-slate-800 dark:text-white">
                Edit Profile
            </h2>

            <button onclick="toggleModal('profileModal')"
                    class="text-red-500 text-2xl font-bold">
                ×
            </button>

        </div>

        <form method="POST" action="{{ route('teacher.settings.profile.update') }}">
            @csrf

            <div class="grid md:grid-cols-2 gap-4">

                <input name="name" value="{{ $teacher->user->name ?? '' }}" placeholder="Name"
                       class="input">

                <input name="email" value="{{ $teacher->user->email ?? '' }}" placeholder="Email"
                       class="input">

                <input name="phone" value="{{ $teacher->user->mobile ?? '' }}" placeholder="Phone"
                       class="input">

                <input name="city" value="{{ $teacher->user->city ?? '' }}" placeholder="City"
                       class="input">

                <input name="state" value="{{ $teacher->user->state ?? '' }}" placeholder="State"
                       class="input">

                <input name="country" value="{{ $teacher->user->country ?? '' }}" placeholder="Country"
                       class="input">

            </div>

            <div class="flex justify-end mt-6 gap-3">

                <button type="button"
                        onclick="toggleModal('profileModal')"
                        class="px-5 py-2 bg-slate-200 rounded-xl font-bold">

                    Cancel
                </button>

                <button class="px-5 py-2 bg-blue-500 text-white rounded-xl font-bold">

                    Save
                </button>

            </div>

        </form>

    </div>

</div>
