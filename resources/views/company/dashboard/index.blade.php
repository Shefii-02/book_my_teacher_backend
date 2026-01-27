@extends('layouts.layout')

@section('nav-options')
    <nav>
        <!-- breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="leading-normal text-sm">
                <a class="text-white " href="javascript:;">Home</a>
            </li>
            <li class="text-sm pl-2 capitalize font-bold text-white before:float-left before:pr-2 before:text-white before:content-['/']"
                aria-current="page">Dashboard</li>
        </ol>
        <h6 class="mb-0 font-bold text-white capitalize">Dashboard</h6>
    </nav>
@endsection

@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
        <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
            <!-- card1 -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p
                                        class="mb-0 font-petro font-semibold leading-normal uppercase text-neutral-900 dark:text-white dark:opacity-60 text-sm">
                                        Total Students</p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['students']['total'] }}</h5>
                                    <p class="mb-0 dark:text-white text-neutral-900 dark:opacity-60">
                                        <span class="font-bold leading-normal text-sm text-emerald-500">
                                            Last Week Reg :
                                        </span>
                                        <span class="font-bold">{{ $data['students']['last_week'] }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                                    <i class="ni ni-single-02 text-lg relative mt-2 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card2 -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p
                                        class="mb-0 font-petro font-semibold leading-normal text-neutral-900 uppercase dark:text-white dark:opacity-60 text-sm">
                                        Total Teachers</p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['teachers']['total'] }}</h5>
                                    <p class="mb-0 dark:text-white text-neutral-900 dark:opacity-60">
                                        <span class="font-bold leading-normal text-sm text-emerald-500">Last Week
                                            Reg:</span>
                                        <span class="font-bold">{{ $data['teachers']['total'] }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                                    <i class="ni ni-hat-3 text-lg relative mt-2 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card3 -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p
                                        class="mb-0 text-neutral-900 font-petro font-semibold leading-normal uppercase dark:text-white dark:opacity-60 text-sm">
                                        Total Class's</p>
                                    <h5 class="mb-2 font-bold dark:text-white">{{ $data['classes']['total'] }}</h5>
                                    <p class="mb-0 dark:text-white dark:opacity-60">
                                        <span class="font-bold leading-normal  text-sm text-emerald-500">
                                            Last Week Created :</span>
                                        <span class="font-bold text-neutral-900">{{ $data['classes']['total'] }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400">
                                    <i class="ni ni-tv-2 text-lg relative mt-2 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card4 -->
            <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p
                                        class="mb-0 text-neutral-900 font-petro font-semibold leading-normal uppercase dark:text-white dark:opacity-60 text-sm">
                                        Total Revenue</p>
                                    <h5 class="mb-2 font-bold dark:text-white">₹{{ $data['revenue']['total'] }}</h5>
                                    <p class="mb-0 text-neutral-900 dark:text-white dark:opacity-60">
                                        <span class="font-bold leading-normal text-sm text-emerald-500">Last Week Revenue :
                                        </span>
                                        <span class="font-bold">{{ $data['revenue']['total'] }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500">
                                    <i class="ni ni-money-coins text-lg relative mt-2 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- cards row 2 -->
        <div class="flex flex-wrap mt-6 -mx-3">
            <div class="w-full max-w-full px-3 mt-0 lg:w-7/12 lg:flex-none">
                <div
                    class="border-black/12.5 dark:bg-slate-850 dark:shadow-dark-xl shadow-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                    <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid p-6 pt-4 pb-0">
                        <h6 class="capitalize dark:text-white">Overall overview</h6>
                        <p class="mb-0 leading-normal dark:text-white dark:opacity-60 text-sm">
                            <i class="fa fa-arrow-up text-emerald-500"></i>
                            <span class="font-semibold">Last 5 Week</span>
                        </p>
                    </div>
                    <div class="flex-auto p-4">
                        <div>
                            <canvas id="weeklyAnalyticsChart" height="300"></canvas>

                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 lg:w-5/12 lg:flex-none">
                <div data-slider class="relative w-full h-full overflow-hidden rounded-2xl">

                    <!-- slide 1 -->
                    <div data-slide class="absolute inset-0 transition-all duration-500">
                        <img class="object-cover w-full h-full"
                            src="https://demos.creative-tim.com/argon-dashboard-tailwind/assets/img/carousel-1.jpg">
                    </div>

                    <!-- slide 2 -->
                    <div data-slide class="absolute inset-0 transition-all duration-500 opacity-0">
                        <img class="object-cover w-full h-full"
                            src="https://demos.creative-tim.com/argon-dashboard-tailwind/assets/img/carousel-2.jpg">
                    </div>

                    <!-- slide 3 -->
                    <div data-slide class="absolute inset-0 transition-all duration-500 opacity-0">
                        <img class="object-cover w-full h-full"
                            src="https://demos.creative-tim.com/argon-dashboard-tailwind/assets/img/carousel-3.jpg">
                    </div>

                    <!-- Controls -->
                    <button data-prev
                        class="absolute z-10 w-10 h-10 text-white bg-black/40 rounded-full top-6 right-16">‹</button>

                    <button data-next
                        class="absolute z-10 w-10 h-10 text-white bg-black/40 rounded-full top-6 right-4">›</button>
                </div>

            </div>
        </div>

        <!-- cards row 3 -->

        <div class="flex flex-wrap mt-6 -mx-3">

            <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0 mb-0 rounded-t-4">
                        <div class="flex justify-between">
                            <h6 class="mb-2 dark:text-white">Analystics</h6>
                            <p>Last 5 Weeks</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-2 mx-3">
                                <thead>
                                    <tr>
                                        <th>Metric</th>
                                        <th class="text-capitalize font-monospace">Web</th>
                                        <th class="text-capitalize font-monospace">Android</th>
                                        <th class="text-capitalize font-monospace">iOS</th>
                                    </tr>
                                </thead>

                                <tbody class="p-3 border">

                                    <tr>
                                        <td class="font-weight-bold">Visitors</td>
                                        <td>{{ $analytics['web']['visitors_count'] }}</td>
                                        <td>{{ $analytics['android']['visitors_count'] }}</td>
                                        <td>{{ $analytics['ios']['visitors_count'] }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">Buy Now Clicks</td>
                                        <td>{{ $analytics['web']['buy_now_click_count'] }}</td>
                                        <td>{{ $analytics['android']['buy_now_click_count'] }}</td>
                                        <td>{{ $analytics['ios']['buy_now_click_count'] }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">New Students</td>
                                        <td>{{ $analytics['web']['new_students_count'] }}</td>
                                        <td>{{ $analytics['android']['new_students_count'] }}</td>
                                        <td>{{ $analytics['ios']['new_students_count'] }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">New Teachers</td>
                                        <td>{{ $analytics['web']['new_teachers_count'] }}</td>
                                        <td>{{ $analytics['android']['new_teachers_count'] }}</td>
                                        <td>{{ $analytics['ios']['new_teachers_count'] }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">Purchases</td>
                                        <td>{{ $analytics['web']['total_purchases_count'] }}</td>
                                        <td>{{ $analytics['android']['total_purchases_count'] }}</td>
                                        <td>{{ $analytics['ios']['total_purchases_count'] }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">Total Revenue (₹)</td>
                                        <td class="text-success font-weight-bold">
                                            ₹{{ number_format($analytics['web']['total_revenue']) }}
                                        </td>
                                        <td class="text-success font-weight-bold">
                                            ₹{{ number_format($analytics['android']['total_revenue']) }}
                                        </td>
                                        <td class="text-success font-weight-bold">
                                            ₹{{ number_format($analytics['ios']['total_revenue']) }}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mt-0 lg:w-5/12 lg:flex-none">
                <div
                    class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                    <div class="p-4 pb-0 rounded-t-4">
                        <h6 class="mb-0 dark:text-white">Top Teachers</h6>
                    </div>

                    {{--  Teacher ,no:of courses no:of classes, total spend time, total watch time  --}}
                    <div class="flex-auto p-4">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">

                            @foreach ($data['top_teachers'] as $teacher)
                                <li
                                    class="relative flex justify-between py-3 pr-4 mb-2 rounded-xl bg-gray-50 dark:bg-slate-800">
                                    <div class="flex items-center">
                                        <div
                                            class="inline-flex items-center justify-center w-10 h-10 mr-4 text-white bg-gradient-to-tl from-indigo-600 to-purple-600 rounded-xl">
                                            <i class="ni ni-hat-3 text-sm"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-sm font-semibold dark:text-white">
                                                {{ $teacher['name'] }}
                                            </h6>
                                            <p class="mb-0 text-xs text-gray-500 dark:text-gray-300">
                                                {{ $teacher['courses'] }} Courses • {{ $teacher['classes'] }} Classes
                                            </p>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <p class="mb-0 text-xs text-gray-500 dark:text-gray-300">Revenue</p>
                                        <h6 class="mb-0 text-sm font-bold text-emerald-500">
                                            ₹{{ number_format($teacher['revenue']) }}
                                        </h6>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap mt-6 -mx-3">
            <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-4/12 lg:flex-none">
                <div
                    class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                    <div class="p-4 pb-0 rounded-t-4">
                        <h6 class="mb-0 dark:text-white">Used Devices</h6>
                    </div>
                    {{-- device details  depending count --}}
                    <div class="flex-auto p-4">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                            @foreach ($data['devices'] as $device)
                                <li class="flex justify-between py-3 pr-4 mb-2 rounded-xl bg-gray-50 dark:bg-slate-800">
                                    <div class="flex items-center">
                                        <div
                                            class="inline-flex items-center justify-center w-9 h-9 mr-4 text-white bg-gradient-to-tl from-slate-700 to-slate-900 rounded-xl">
                                            <i class="ni ni-mobile-button text-xs"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-sm dark:text-white">{{ $device['name'] }}</h6>
                                            <p class="mb-0 text-xs text-gray-500 dark:text-gray-300">
                                                {{ number_format($device['users']) }} Users
                                            </p>
                                        </div>
                                    </div>

                                    <span class="text-sm font-semibold text-indigo-500">
                                        {{ $device['percent'] }}%
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mt-0 lg:w-4/12 lg:flex-none">
                <div
                    class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                    <div class="p-4 pb-0 rounded-t-4">
                        <h6 class="mb-0 dark:text-white">Top Sources</h6>
                    </div>
                    {{-- show visites form where  --}}
                    <div class="flex-auto p-4">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                            @foreach ($data['sources'] as $source)
                                <li class="flex justify-between py-3 pr-4 mb-2 rounded-xl bg-gray-50 dark:bg-slate-800">
                                    <div class="flex items-center">
                                        <div
                                            class="inline-flex items-center justify-center w-9 h-9 mr-4 text-white bg-gradient-to-tl from-orange-500 to-yellow-500 rounded-xl">
                                            <i class="ni ni-world text-xs"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-sm dark:text-white">
                                                {{ $source['name'] }}
                                            </h6>
                                            <p class="mb-0 text-xs text-gray-500 dark:text-gray-300">
                                                {{ number_format($source['visits']) }} Visits
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mt-0 lg:w-4/12 lg:flex-none">
                <div
                    class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                    <div class="p-4 pb-0 rounded-t-4">
                        <h6 class="mb-0 dark:text-white">Top Cities</h6>
                    </div>
                    {{-- use cities or any other use i need fill this section --}}
                    <div class="flex-auto p-4">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                            @foreach ($data['cities'] as $city)
                                <li class="flex justify-between py-3 pr-4 mb-2 rounded-xl bg-gray-50 dark:bg-slate-800">
                                    <div class="flex items-center">
                                        <div
                                            class="inline-flex items-center justify-center w-9 h-9 mr-4 text-white bg-gradient-to-tl from-emerald-500 to-teal-400 rounded-xl">
                                            <i class="ni ni-pin-3 text-xs"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-sm dark:text-white">
                                                {{ $city['name'] }}
                                            </h6>
                                            <p class="mb-0 text-xs text-gray-500 dark:text-gray-300">
                                                {{ number_format($city['users']) }} Active Users
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- end cards -->
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const chartData = @json($data['chart']);

        const ctx = document.getElementById('weeklyAnalyticsChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                        label: 'New Students',
                        data: chartData.students,
                    },
                    {
                        label: 'New Teachers',
                        data: chartData.teachers,
                    },
                    {
                        label: 'Revenue',
                        data: chartData.revenue,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Revenue (₹)'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Last 5 Weeks'
                        }
                    }
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slider = document.querySelector('[data-slider]');
            const slides = slider.querySelectorAll('[data-slide]');
            const nextBtn = slider.querySelector('[data-next]');
            const prevBtn = slider.querySelector('[data-prev]');

            let current = 0;

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.classList.toggle('opacity-0', i !== index);
                    slide.classList.toggle('opacity-100', i === index);
                });
            }

            nextBtn.addEventListener('click', () => {
                current = (current + 1) % slides.length;
                showSlide(current);
            });

            prevBtn.addEventListener('click', () => {
                current = (current - 1 + slides.length) % slides.length;
                showSlide(current);
            });

            // Init
            showSlide(current);
        });
    </script>
@endpush
