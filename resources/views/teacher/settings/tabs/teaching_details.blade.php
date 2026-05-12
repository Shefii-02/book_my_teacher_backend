{{-- TEACHING DETAILS TAB --}}
<div class="mb-6 flex justify-between items-center">

    <div>
        <h3 class="text-2xl font-black text-slate-800 dark:text-white">
            Teaching Details
        </h3>
        <p class="text-slate-500 text-sm">
            Professional teaching information
        </p>
    </div>

    <button onclick="toggleModal('teachingModal')"
        class="px-5 py-2 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold">

        <i class="bi bi-pencil"></i> Edit

    </button>

</div>

{{-- VIEW BOX --}}
<div class="grid md:grid-cols-2 gap-3">

    <x-info label="Profession" :value="$teacher->professionalInfo->profession ?? '-'" />

    <x-info label="Offline Experience" :value="$teacher->professionalInfo->offline_exp ?? '0' . ' yrs'" />

    <x-info label="Online Experience" :value="$teacher->professionalInfo->online_exp ?? '0' . ' yrs'" />

    <x-info label="Home Tuition Experience" :value="$teacher->professionalInfo->home_exp ?? '0' . ' yrs'" />

    <x-info label="Expected Salary Min" :value="$teacher->professionalInfo->salary_min ?? '-'" />

    <x-info label="Expected Salary Max" :value="$teacher->professionalInfo->salary_max ?? '-'" />

    <x-info label="Ready to Work (Full Time)" :value="$teacher->professional?->ready_to_work ? 'Yes' : 'No'" />

</div>


<!-- TEACHING MODAL -->
<div id="teachingModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-[#050708] w-1/2 dark:bg-slate-800 w-full  rounded-2xl shadow-xl p-6">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-xl font-black text-slate-800 dark:text-white">
                Edit Teaching Details
            </h2>

            <button onclick="toggleModal('teachingModal')"
                    class="text-red-500 text-2xl font-bold">
                ×
            </button>

        </div>

        <form method="POST" action="{{ route('teacher.settings.teaching.update') }}">
            @csrf

            <div class="grid md:grid-cols-2 gap-5">

                {{-- PROFESSION --}}
                <div class="md:col-span-2">
                    <label class="font-bold text-sm text-slate-700 dark:text-white">
                        Profession
                    </label>

                    <div class="flex gap-6 mt-2">

                        <label class="flex items-center gap-2">
                            <input type="radio" name="profession" value="Teacher"
                                {{ ($teacher->professionalInfo->profession ?? '') == 'Teacher' ? 'checked' : '' }}>
                            Teacher
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" name="profession" value="Student"
                                {{ ($teacher->professionalInfo->profession ?? '') == 'Student' ? 'checked' : '' }}>
                            Student
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" name="profession" value="Jobseeker"
                                {{ ($teacher->professionalInfo->profession ?? '') == 'Jobseeker' ? 'checked' : '' }}>
                            Job Seeking
                        </label>

                    </div>
                </div>

                {{-- OFFLINE EXP --}}
                <div>
                    <label class="font-bold text-sm">Offline Experience (Years)</label>
                    <input type="number" name="offline_exp"
                           value="{{ $teacher->professionalInfo->offline_exp ?? 0 }}"
                           class="input mt-2">
                </div>

                {{-- ONLINE EXP --}}
                <div>
                    <label class="font-bold text-sm">Online Experience (Years)</label>
                    <input type="number" name="online_exp"
                           value="{{ $teacher->professionalInfo->online_exp ?? 0 }}"
                           class="input mt-2">
                </div>

                {{-- HOME EXP --}}
                <div>
                    <label class="font-bold text-sm">Home Tuition Experience (Years)</label>
                    <input type="number" name="home_exp"
                           value="{{ $teacher->professionalInfo->home_exp ?? 0 }}"
                           class="input mt-2">
                </div>

                {{-- SALARY MIN --}}
                <div>
                    <label class="font-bold text-sm">Expected Salary Min</label>
                    <input type="number" name="salary_min"
                           value="{{ $teacher->professionalInfo->salary_min ?? 0 }}"
                           class="input mt-2">
                </div>

                {{-- SALARY MAX --}}
                <div>
                    <label class="font-bold text-sm">Expected Salary Max</label>
                    <input type="number" name="salary_max"
                           value="{{ $teacher->professionalInfo->salary_max ?? 0 }}"
                           class="input mt-2">
                </div>

                {{-- READY TO WORK --}}
                <div class="md:col-span-2">
                    <label class="font-bold text-sm">Ready To Work Full Time?</label>

                    <select name="ready_to_work" class="input mt-2">

                        <option value="1"
                            {{ ($teacher->professionalInfo->ready_to_work ?? 0) == 1 ? 'selected' : '' }}>
                            Yes
                        </option>

                        <option value="0"
                            {{ ($teacher->professionalInfo->ready_to_work ?? 0) == 0 ? 'selected' : '' }}>
                            No
                        </option>

                    </select>
                </div>

            </div>

            <div class="flex justify-end mt-6 gap-3">

                <button type="button"
                        onclick="toggleModal('teachingModal')"
                        class="px-5 py-2 bg-slate-200 rounded-xl font-bold">

                    Cancel

                </button>

                <button class="px-5 py-2 bg-blue-500 text-white rounded-xl font-bold">

                    Save Changes

                </button>

            </div>

        </form>

    </div>

</div>
