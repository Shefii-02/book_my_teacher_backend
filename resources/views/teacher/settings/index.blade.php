@extends('layouts.teacher')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex flex-col md:flex-row gap-6">

        <!-- LEFT VERTICAL TABS -->
        <div class="md:w-1/4">
            <div class="bg-white flex gap-1 dark:bg-slate-800 rounded-2xl shadow p-4 space-y-1">

                @php
                    $tabs = [
                        'profile'  => ['Profile', 'person'],
                        'security' => ['Security', 'lock'],
                        'activity' => ['Activity Logs', 'clock'],
                        'support'  => ['Support', 'chat'],
                        'delete'   => ['Account Delete', 'trash'],
                        'feedback' => ['Feedback & Suggestions', 'ui-checks-grid'],
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

                <div id="security" class="tab-content hidden">
                    @include('teacher.settings.tabs.security')
                </div>

                <div id="activity" class="tab-content hidden">
                    @include('teacher.settings.tabs.activity')
                </div>

                <div id="support" class="tab-content hidden">
                    @include('teacher.settings.tabs.support')
                </div>

                <div id="delete" class="tab-content hidden">
                    @include('teacher.settings.tabs.account-delete')
                </div>


                <div id="feedback" class="tab-content hidden">
                    @include('teacher.settings.tabs.feedback')
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
</script>

@endpush
