<h2 class="text-xl font-bold mb-4 dark:text-white">Security</h2>

<p class="text-gray-600 dark:text-gray-300 mb-6">
    Update your password and secure your account.
</p>
<form action="{{ route('company.profile.changePassword') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="new_password"
                                    class="block mb-2 text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" id="new_password" name="new_password"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Enter new password" required>
                                @error('new_password')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password_confirmation"
                                    class="block mb-2 text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Confirm new password" required>
                                @error('new_password_confirmation')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2.5 bg-emerald-500/50 hover:bg-indigo-700 text-white rounded-lg shadow font-medium">
                                Change Password
                            </button>
                        </div>
                    </form>
