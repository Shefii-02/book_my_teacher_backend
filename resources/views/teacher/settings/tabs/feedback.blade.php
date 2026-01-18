<h2 class="text-xl font-bold mb-4 dark:text-white">Feedback & Suggestions</h2>

<p class="text-gray-600 dark:text-gray-300 mb-6">
    Help us improve BookMyTeacher by sharing your thoughts.
</p>

<form class="space-y-4" method="POST" action="{{ route('teacher.settings.feedback.store') }}">
    @csrf
    <textarea placeholder="Your feedback or suggestions"
        class="w-full rounded-lg border px-4 py-2 h-40
               dark:bg-slate-700 dark:border-slate-600 dark:text-dark"></textarea>

    <button class="bg-green-600 text-white px-6 py-2 rounded-lg">
        Send Feedback
    </button>
</form>
