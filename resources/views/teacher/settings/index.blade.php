@extends('layouts.teacher')

@section('content')
<style>
  .input {
    width: 100%;
    padding: 10px 14px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    background: white;
}

.dark .input {
    background: #1e293b;
    border-color: #334155;
    color: white;
}
</style>
<div class="max-w-7xl mx-auto p-6">
    <div class="flex flex-col md:flex-row gap-6">

        <!-- LEFT VERTICAL TABS -->
        <div class="md:w-1/4">
            <div class="bg-white relative overflow-x-auto flex gap-1 dark:bg-slate-800 rounded-2xl shadow p-4 space-y-1">

                @php
                    $tabs = [
                        'profile'  => ['Personal Information', 'person'],
                        'teaching_details'  => ['Teaching Details', 'person'],
                        'extra_information'  => ['Extra Information', 'person'],
                        'teaching_grade' => ['Teaching Grade', 'clock'],
                        'time_slots'  => ['Time Slots', 'chat'],
                        'security' => ['Security', 'lock']
                    ];
                @endphp

                @foreach($tabs as $key => [$label, $icon])
                    <a href="#{{ $key }}"
                       class="tab-btn flex items-center gap-3 px-4 py-2 rounded-lg
                              text-gray-700 dark:text-gray-200
                              hover:bg-gray-100 dark:hover:bg-slate-700">
                        <i class="w-5 h-5 bi bi-{{ $icon }}"></i>
                        {{ $label }}
                    </a>
                @endforeach

            </div>
        </div>

        <!-- RIGHT CONTENT -->
        <div class="md:w-3/4">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow p-6">

                <div id="profile" class="tab-content">
                    @include('teacher.settings.tabs.profile')
                </div>

               <div id="teaching_details" class="tab-content hidden">
                    @include('teacher.settings.tabs.teaching_details')
                </div>

                <div id="extra_information" class="tab-content hidden">
                    @include('teacher.settings.tabs.extra_information')
                </div>

                <div id="teaching_grade" class="tab-content hidden">
                    @include('teacher.settings.tabs.teaching_grade')
                </div>

                <div id="time_slots" class="tab-content hidden">
                    @include('teacher.settings.tabs.time_slots')
                </div>
                <div id="security" class="tab-content hidden">
                    @include('teacher.settings.tabs.security')
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')

<script>
    function activateTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('bg-emerald-500/30','text-white'));

        const content = document.getElementById(tabId);
        if (content) content.classList.remove('hidden');

        document.querySelectorAll(`a[href="#${tabId}"]`).forEach(btn => {
            btn.classList.add('bg-emerald-500/30','text-white');
        });
    }

    window.addEventListener('load', () => {
        const hash = window.location.hash.replace('#','') || 'profile';
        activateTab(hash);
    });

    window.addEventListener('hashchange', () => {
        const hash = window.location.hash.replace('#','');
        activateTab(hash);
    });



    function toggleModal(id) {
        const modal = document.getElementById(id);

        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
</script>

@endpush
