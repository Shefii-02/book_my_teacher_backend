<h2 class="text-xl font-bold mb-4 text-red-600">
    Delete Account
</h2>

<p class="text-gray-600 dark:text-gray-300 mb-6">
    This action is irreversible. All your data will be permanently deleted.
</p>

<div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg mb-6">
    <p class="text-red-600 text-sm">
        ⚠ Once deleted, your account cannot be recovered.
    </p>
</div>

<form method="POST" action="{{ route('teacher.settings.account.delete') }}" class="space-y-5">
    @csrf

    <!-- REASON -->
    <div>
        <label class="block text-sm text-dark font-medium mb-1 dark:text-white">
            Reason for deleting account <span class="text-red-500">*</span>
        </label>

        <select required
            name="delete_reason"
            class="w-full rounded-lg border px-4 py-2
                   dark:bg-slate-700 dark:border-slate-600 dark:text-dark">
            <option value="">Select a reason</option>
            <option value="not_useful">Not useful anymore</option>
            <option value="too_expensive">Too expensive</option>
            <option value="found_alternative">Found a better alternative</option>
            <option value="technical_issues">Technical issues</option>
            <option value="support_issues">Poor support</option>
            <option value="privacy_concerns">Privacy concerns</option>
            <option value="other">Other</option>
        </select>
    </div>

    <!-- OPTIONAL DETAILS -->
    <div>
        <label class="block text-sm text-dark  font-medium mb-1 dark:text-dark">
            Additional feedback (optional)
        </label>

        <textarea name="delete_feedback"
            placeholder="Tell us more (optional)"
            class="w-full rounded-lg border px-4 py-2 h-32
                   dark:bg-slate-700 dark:border-slate-600 dark:text-dark"></textarea>
    </div>

    <!-- CONFIRMATION -->
    <div class="flex items-start gap-2">
        <input type="checkbox" required
               class="mt-1 border">
        <p class="text-sm text-gray-600 dark:text-gray-300 ">
            I understand that this action is permanent and cannot be undone.
        </p>
    </div>

    <!-- SUBMIT -->
    <button type="submit"
        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">
        Permanently Delete Account
    </button>
</form>
