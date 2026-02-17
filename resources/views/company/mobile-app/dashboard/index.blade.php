@extends('layouts.mobile-layout')

@section('title', 'App Dashboard')

@section('content')
<div class="px-3 md:px-6 py-4 space-y-6">

    {{-- ===================== --}}
    {{-- 🔥 TOP STATS --}}
    {{-- ===================== --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        @foreach([
            ['Students','1,240','from-blue-700 to-zinc-700','bi-people'],
            ['Teachers','120','from-red-600 to-zinc-700','bi-person-video'],
            ['Courses','86','from-emerald-500 to-zinc-700','bi-journal-bookmark'],
            ['Live Today','12','from-green-600 to-zinc-700','bi-broadcast']
        ] as $stat)
        <div class="bg-gradient-to-r {{$stat[2]}} text-white rounded-2xl p-4 shadow-lg hover:scale-[1.02] transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs opacity-80">{{$stat[0]}}</p>
                    <h3 class="text-2xl text-light font-bold">{{$stat[1]}}</h3>
                </div>
                <i class="bi {{$stat[3]}} text-2xl opacity-80"></i>
            </div>
        </div>
        @endforeach
    </div>


    {{-- ===================== --}}
    {{-- 📊 CHARTS --}}
    {{-- ===================== --}}
    <div class="grid md:grid-cols-2 gap-4">

        {{-- Watch vs Spend --}}
        <div class="bg-white/80 backdrop-blur rounded-2xl p-4 shadow">
            <h3 class="font-semibold mb-2">Watch vs Spend Time</h3>
            <div id="watchSpendChart"></div>
        </div>

        {{-- Revenue Chart --}}
        <div class="bg-white/80 backdrop-blur rounded-2xl p-4 shadow">
            <h3 class="font-semibold mb-2">Monthly Revenue</h3>
            <div id="revenueChart"></div>
        </div>
    </div>


    {{-- ===================== --}}
    {{-- ⚡ QUICK ACTIONS --}}
    {{-- ===================== --}}
    <div class="bg-white rounded-2xl shadow p-4">
        <h3 class="font-bold mb-3">Quick Actions</h3>

        <div class="grid grid-cols-3 md:grid-cols-6 gap-3 text-center text-xs">
            @foreach([
                ['Add Banner','bi-image'],
                ['Add Teacher','bi-person-plus'],
                ['Create Course','bi-book'],
                ['Add Subject','bi-diagram-3'],
                ['Create Webinar','bi-camera-video'],
                ['Add Grade','bi-award']
            ] as $action)
            <div class="p-3 rounded-xl bg-gray-50 hover:bg-blue-50 cursor-pointer transition shadow-sm hover:shadow">
                <i class="bi {{$action[1]}} text-blue-600 text-lg"></i>
                <p class="mt-1 font-medium">{{$action[0]}}</p>
            </div>
            @endforeach
        </div>
    </div>


    {{-- ===================== --}}
    {{-- 📦 GRID SECTIONS --}}
    {{-- ===================== --}}
    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">

        {{-- Teachers --}}
        <div class="bg-white rounded-2xl p-4 shadow">
            <h4 class="font-semibold mb-2">Teachers</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span>Total</span><b>120</b></div>
                <div class="flex justify-between"><span>Pending</span><b class="text-amber-600">9</b></div>
                <div class="flex justify-between"><span>Top Selected</span><b class="text-green-600">15</b></div>
            </div>
        </div>

        {{-- Academics --}}
        <div class="bg-white rounded-2xl p-4 shadow">
            <h4 class="font-semibold mb-2">Academics</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span>Grades</span><b>10</b></div>
                <div class="flex justify-between"><span>Boards</span><b>4</b></div>
                <div class="flex justify-between"><span>Subjects</span><b>45</b></div>
            </div>
        </div>

        {{-- Rewards --}}
        <div class="bg-white rounded-2xl p-4 shadow">
            <h4 class="font-semibold mb-2">Rewards</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span>Wallet</span><b>₹54,200</b></div>
                <div class="flex justify-between"><span>Referrals</span><b>320</b></div>
                <div class="flex justify-between"><span>Transfers</span><b>7</b></div>
            </div>
        </div>

        {{-- Statistics --}}
        <div class="bg-white rounded-2xl p-4 shadow">
            <h4 class="font-semibold mb-2">Statistics</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span>Spend Analytics</span><b>View</b></div>
                <div class="flex justify-between"><span>Watch Analytics</span><b>View</b></div>
                <div class="flex justify-between"><span>Top Classes</span><b>Charts</b></div>
            </div>
        </div>

        {{-- Reviews --}}
        <div class="bg-white rounded-2xl p-4 shadow">
            <h4 class="font-semibold mb-2">Reviews</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span>Course</span><b>320</b></div>
                <div class="flex justify-between"><span>Teacher</span><b>210</b></div>
                <div class="flex justify-between"><span>Pending</span><b class="text-rose-500">6</b></div>
            </div>
        </div>

    </div>

</div>
@endsection


@push('scripts')
{{-- ApexCharts CDN --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener("DOMContentLoaded", function(){

    // Watch vs Spend Chart
    new ApexCharts(document.querySelector("#watchSpendChart"), {
        chart: { type: 'area', height: 250, toolbar: { show:false }},
        series: [
            { name: 'Watch', data: [30, 40, 45, 50, 49, 60, 70] },
            { name: 'Spend', data: [20, 29, 37, 36, 44, 45, 50] }
        ],
        stroke: { curve: 'smooth' },
        colors: ['#4f46e5','#06b6d4'],
        dataLabels: { enabled: false }
    }).render();

    // Revenue Chart
    new ApexCharts(document.querySelector("#revenueChart"), {
        chart: { type: 'bar', height: 250, toolbar:{show:false}},
        series: [{
            name: 'Revenue',
            data: [12000, 15000, 18000, 22000, 26000, 30000]
        }],
        xaxis: { categories: ['Jan','Feb','Mar','Apr','May','Jun'] },
        colors: ['#22c55e']
    }).render();

});
</script>
@endpush
