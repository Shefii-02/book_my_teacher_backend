<table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
    <thead class="align-bottom">
        <tr class="bg-gray-100">
            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">#</th>
            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">Teacher</th>
            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">Ranking</th>
            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">Rating</th>
            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">Status</th>
            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">Last Updated</th>
            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($teachers as $teacher)
        <tr class="border-b">

            <td class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">{{ $teacher->id }}</td>

            <td class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                <div class="flex gap-2 items-center">
                    <img src="{{ asset('storage/'.$teacher->avatar ?? 'default.png') }}"
                         class="w-10 h-10 rounded">

                    <div>
                        <div>{{ $teacher->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $teacher->user->email }}</div>
                        <div class="text-xs text-gray-500">{{ $teacher->user->mobile }}</div>
                    </div>
                </div>
            </td>

            <td class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">{{ $teacher->ranking ?? 0 }}</td>

            <td class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                ⭐ {{ $teacher->rating ?? 0 }}
            </td>

            <td class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                @if($teacher->user->status == '1')
                    <span class="text-green-600">Active</span>
                @else
                    <span class="text-red-600">Inactive</span>
                @endif
            </td>

            <td class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
              {{ timeAgo($teacher->user->last_activation) }}
            </td>

            <td class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none  text-slate-400 opacity-70">
                <button onclick="openEditModal({{ $teacher->id }}, {{ $teacher->ranking ?? 0 }}, {{ $teacher->rating ?? 0 }})"
                    class="bg-yellow-500 text-white px-3 py-1 rounded">
                    Edit
                </button>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
