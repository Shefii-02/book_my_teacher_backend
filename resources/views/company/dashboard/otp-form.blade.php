<form method="POST" action="{{ route('company.otp.update', $otp->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block text-sm font-medium">Mobile</label>
        <input type="text" name="mobile" value="{{ $otp->mobile }}"
            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium">OTP</label>
        <input type="text" name="otp" value="{{ $otp->otp }}"
            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium">Verified</label>
        <select name="verified"
            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">
            <option value="1" @selected($otp->verified == 1)>Verified</option>
            <option value="0" @selected($otp->verified == 0)>Unverified</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium">Expires at</label>
        <input type="datetime-local" name="expires_at" value="{{ $otp->expires_at }}"
            class="pl-3 text-sm focus:shadow-primary-outline ease w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow">

    </div>



    <button type="submit" class="w-full px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">
        Save Changes
    </button>
</form>
