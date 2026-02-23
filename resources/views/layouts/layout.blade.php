<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BookMyTeacher-Dashboard</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Nucleo Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/argon-dashboard/2.0.4/css/nucleo-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <!-- Popper -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <!-- Main Styling -->
    <link href="{{ asset('assets/css/dashboard.css?v=1.0.1') }}" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.15.0/dist/cdn.min.js"></script>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <style>
        .form-container {
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 24px;
        }

        .swal2-icon.swal2-warning.swal2-icon-show {
            background-color: #ff00008a !important;
            color: #ffffff !important;
        }

        div:where(.swal2-container) img:where(.swal2-image),
        div:where(.swal2-container) label:where(.swal2-checkbox) {
            margin: 0 !important;
        }

        .swal2-checkbox {
            display: none !important;
        }

        .menu-toggle .bi-caret-down {
            transition: transform 0.25s ease;
        }

        .menu-toggle.active .rotate-180 {
            transform: rotate(180deg);
        }

        .tox-promotion,
        .tox-menubar,
        .tox-statusbar {
            display: none !important;
            margin-bottom: 10px !important;
        }

        .tox .tox-editor-container {
            border: 1px solid #e4e4e4 !important;
            border-radius: 9px;
        }


    </style>
    @stack('styles')
</head>

<body
    class="m-0 font-petro antialiased font-normal dark:bg-slate-900 text-base leading-default bg-gray-50 text-slate-500">

    <div class="absolute w-full bg-emerald-500/30  min-h-75"></div>
    <!-- sidenav  -->

    <aside
        class="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0  overflow-y-auto antialiased transition-transform duration-200 -translate-x-full bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-3 xl:left-0 xl:translate-x-0"
        aria-expanded="false">
        <div class="h-19">
            <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden"
                sidenav-close></i>
            <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700" href="/company">
                <img src="/assets/images/logo/BookMyTeacher-black.png"
                    class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8"
                    alt="main_logo" />
                <img src="/assets/images/logo/BookMyTeacher-white.png"
                    class="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-8"
                    alt="main_logo" />
            </a>
        </div>

        <hr
            class="h-px mt-0 bg-transparent bg-gradient-to-r m-0 overflow-hidden from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />
        <div class="flex gap-2">
            <div class=" bg-emerald-500/30 h-[calc(100vh-5rem)]" style="border-right: 1px solid blanchedalmond;">
                <ul class="px-2   mt-4 flex flex-col gap-2.5">
                    <li class="my-3">
                        <a href="{{ route('company.dashboard.index') }}" title="LMS">
                            <div
                                class="mr-2 flex flex-col h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                <img src="{{ asset('assets/images/logo/lms1.png') }}"
                                    class="relative top-0 w-8 shadow-lg rounded-10 leading-normal text-blue-500 text-sm">
                                <span class="text-xxs my-2 text-teal-600 dark:text-white">LMS</span>
                            </div>
                        </a>
                    </li>
                    <li class="my-3">
                        <a href="{{ route('company.app.index') }}" title="App">
                            <div
                                class="mr-2 flex flex-col h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                <img src="{{ asset('assets/images/logo/mobile.png') }}"
                                    class="relative top-0 w-8 shadow-lg rounded-10 leading-normal text-blue-500 text-sm">
                                <span class="text-xxs my-2 text-teal-600 dark:text-white">App</span>
                            </div>
                        </a>
                    </li>
                    {{-- <li class="my-3">
                        <a href="{{ route('company.dashboard') }}" title="CRMS">
                            <div
                                class="mr-2 flex flex-col h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                <img src="{{ asset('assets/images/logo/crms.png') }}"
                                    class="relative top-0 w-8 shadow-lg rounded-10 leading-normal text-blue-500 text-sm">
                                <span class="text-xxs my-2 text-teal-600 dark:text-white">CRMS</span>
                            </div>
                        </a>
                    </li> --}}
                    {{-- <li class="my-3">
                        <a href="{{ route('company.hrms.dashboard.index') }}" title="HRMS">
                            <div
                                class="mr-2 flex flex-col h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                <img src="{{ asset('assets/images/logo/hr.png') }}"
                                    class="relative top-0 w-8 shadow-lg rounded-10 leading-normal text-blue-500 text-sm">
                                <span class="text-xxs my-2 text-teal-600 dark:text-white">HRMS</span>
                            </div>
                        </a>
                    </li> --}}
                    {{-- <li class="my-3">
                        <a href="" title="ACCOUNTS">
                            <div
                                class="mr-2 flex flex-col h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                <img src="{{ asset('assets/images/logo/accounting.png') }}"
                                    class="relative top-0 w-8 shadow-lg rounded-10 leading-normal text-blue-500 text-sm">
                                <span class="text-xxs my-2 text-teal-600 dark:text-white">ACCOUNTS</span>
                            </div>
                        </a>
                    </li> --}}
                </ul>
            </div>
            <div class="w-full">
                <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav-test grow basis-full">
                    <ul class="flex flex-col pl-0 mb-0">
                        <li class="mt-0.5 w-full">
                            <a class="py-2.7  {{ Request::routeIs('company.dashboard') ? 'bg-blue-500/13' : '' }} dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap rounded-lg  font-semibold text-slate-700 transition-colors"
                                href="{{ route('company.dashboard') }}">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                    <i class="relative top-0 leading-normal text-emerald-500 ni ni-tv-2 text-sm"></i>
                                </div>
                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Dashboard</span>
                            </a>
                        </li>
                        <li class="mt-0.5 w-full">
                            <a class="menu-toggle justify-content-between {{ Request::routeIs('company.teachers') || Request::routeIs('company.students') || Request::routeIs('company.guest.*') ? 'bg-blue-500/13' : '' }} dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 flex items-center whitespace-nowrap transition-colors"
                                href="#">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 text-lg bi bi-r-circle"></i>
                                </div>

                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Registration</span>

                                <!-- Right aligned caret -->
                                <span class="bi bi-caret-down ml-auto mr-4"></span>
                            </a>

                            <ul
                                class="submenu pl-6 {{ Request::routeIs('company.teachers.*') || Request::routeIs('company.students.*') ? '' : 'hidden' }} ">
                                <li class="w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.teachers.*') ? 'bg-blue-100' : '' }} dark:opacity-80 py-1 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.teachers.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-mortarboard"></i>
                                        </div>
                                        <span
                                            class="ml-1 duration-300 opacity-100 pointer-events-none ease">Teachers</span>
                                    </a>
                                </li>
                                <li class=" w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.students.*') ? 'bg-blue-100' : '' }} dark:opacity-80 py-1 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.students.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-fill"></i>
                                        </div>
                                        <span
                                            class="ml-1 duration-300 opacity-100 pointer-events-none ease">Students</span>
                                    </a>
                                </li>
                                {{-- <li class=" w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.guest.*') ? 'bg-blue-100' : '' }} dark:opacity-80 py-1 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.guest.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-fill-exclamation"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Guest
                                            User </span>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>
                        <li class="mt-0.5 w-full">
                            <a class="menu-toggle justify-content-between {{ Request::routeIs('company.otp-list') || Request::routeIs('company.otp-list') || Request::routeIs('company.google-signIn') || Request::routeIs('company.apple-signIn') ? 'bg-blue-500/13' : '' }} dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 flex items-center whitespace-nowrap transition-colors"
                                href="#">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 text-lg bi bi-fingerprint"></i>
                                </div>
                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Login &
                                    Security</span>

                                <!-- Right aligned caret -->
                                <span class="bi bi-caret-down ml-auto mr-4"></span>
                            </a>

                            <ul
                                class="submenu pl-6 {{ Request::routeIs('company.otp-list') || Request::routeIs('company.otp-list') || Request::routeIs('company.google-signIn') || Request::routeIs('company.apple-signIn') ? '' : 'hidden' }}">
                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.otp-list') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.otp-list') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-key"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">OTP
                                            List</span>
                                    </a>
                                </li>
                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.google-signIn') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.google-signIn') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-google"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease"> Google
                                            Sign In</span>
                                    </a>
                                </li>
                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.apple-signIn') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.apple-signIn') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-apple"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease"> Apple
                                            Sign In</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="mt-0.5 w-full">
                            <a class="menu-toggle justify-content-between {{ Request::routeIs('company.courses.*') || Request::routeIs('company.webinars.*') || Request::routeIs('company.workshops.*') || Request::routeIs('company.categories.*') || Request::routeIs('company.subcategories.*') || Request::routeIs('company.demo-classes.*') ? 'bg-blue-500/13' : '' }} dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 flex items-center whitespace-nowrap transition-colors"
                                href="#">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 text-lg bi bi-person-video3"></i>
                                </div>

                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Sections</span>

                                <!-- Right aligned caret -->
                                <span class="bi bi-caret-down ml-auto mr-4"></span>
                            </a>

                            <ul
                                class="submenu pl-6 {{ Request::routeIs('company.courses.*') || Request::routeIs('company.webinars.*') || Request::routeIs('company.workshops.*') || Request::routeIs('company.categories.*') || Request::routeIs('company.subcategories.*') || Request::routeIs('company.demo-classes.*') ? '' : 'hidden' }}">

                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.courses.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.courses.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video"></i>
                                        </div>
                                        <span
                                            class="ml-1 duration-300 opacity-100 pointer-events-none ease">Courses</span>
                                    </a>
                                </li>

                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.webinars.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.webinars.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video2"></i>
                                        </div>
                                        <span
                                            class="ml-1 duration-300 opacity-100 pointer-events-none ease">Webinars</span>
                                    </a>
                                </li>

                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.workshops.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.workshops.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-pip"></i>
                                        </div>
                                        <span
                                            class="ml-1 duration-300 opacity-100 pointer-events-none ease">Workshops</span>
                                    </a>
                                </li>

                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.demo-classes.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.demo-classes.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video2"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Demo
                                            Class</span>
                                    </a>
                                </li>



                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.categories.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.categories.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video2"></i>
                                        </div>
                                        <span
                                            class="ml-1 duration-300 opacity-100 pointer-events-none ease">Category</span>
                                    </a>
                                </li>

                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.subcategories.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.subcategories.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video2"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Sub
                                            Category</span>
                                    </a>
                                </li>


                            </ul>
                        </li>
                        {{-- <li class="mt-0.5 w-full">
                            <a class="menu-toggle justify-content-between {{ Request::routeIs('company.teachers1') ? 'bg-blue-500/13' : '' }} dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 flex items-center whitespace-nowrap transition-colors"
                                href="#">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 text-lg bi bi-person-video3"></i>
                                </div>

                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Users</span>

                                <!-- Right aligned caret -->
                                <span class="bi bi-caret-down ml-auto mr-4"></span>
                            </a>

                            <ul class="submenu pl-6 hidden">
                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.students.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.students.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video"></i>
                                        </div>
                                        <span
                                            class="ml-1 duration-300 opacity-100 pointer-events-none ease">Students</span>
                                    </a>
                                </li>
                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.teachers.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.teachers.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video2"></i>
                                        </div>
                                        <span
                                            class="ml-1 duration-300 opacity-100 pointer-events-none ease">Teachers</span>
                                    </a>
                                </li>

                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.guest') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.guest.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-pip"></i>
                                        </div>
                                        <span
                                            class="ml-1 duration-300 opacity-100 pointer-events-none ease">Staff</span>
                                    </a>
                                </li>
                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.guest') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.guest.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-pip"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Guest
                                            Users</span>
                                    </a>
                                </li>

                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.guest') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.guest.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-pip"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Guest
                                            Teachers</span>
                                    </a>
                                </li>

                            </ul>
                        </li> --}}
                        <li class="mt-0.5 w-full">
                            <a class="menu-toggle justify-content-between {{ Request::routeIs('company.requests.*') ? 'bg-blue-500/13' : '' }} dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 flex items-center whitespace-nowrap transition-colors"
                                href="#">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 text-lg bi bi-person-video3"></i>
                                </div>

                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">
                                    Requestes</span>

                                <!-- Right aligned caret -->
                                <span class="bi bi-caret-down ml-auto mr-4"></span>
                            </a>

                            <ul class="submenu pl-6 {{ Request::routeIs('company.requests.*') ? '' : 'hidden' }}">

                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.requests.form-class.index') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.requests.form-class.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Request
                                            Form </span>
                                    </a>
                                </li>

                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.requests.banner.index') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.requests.banner.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Banner Requests
                                        </span>
                                    </a>
                                </li>

                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.requests.teacher-class.index') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.requests.teacher-class.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-pip"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Teacher
                                            Class </span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        {{-- <li class="mt-0.5 w-full">
                            <a class=" dark:text-white {{ Request::routeIs('company.guest') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                href="{{ route('company.guest.index') }}">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 text-lg  bi bi-file-earmark-richtext"></i>
                                </div>
                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Content</span>
                            </a>
                        </li> --}}

                        {{--
                        <li class="mt-0.5 w-full">
                            <a class=" dark:text-white {{ Request::routeIs('company.guest-teacher') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                href="{{ route('company.guest-teacher.index') }}">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 text-lg  bi bi-person-check-fill"></i>
                                </div>
                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Guest
                                    Teacher</span>
                            </a>
                        </li> --}}

                        <li class="mt-0.5 w-full">
                            <a class="menu-toggle justify-content-between {{ Request::routeIs('company.coupons.*') || Request::routeIs('company.custom.invoices.*') ? 'bg-blue-500/13' : '' }} dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 flex items-center whitespace-nowrap transition-colors"
                                href="#">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 text-lg bi bi-person-video3"></i>
                                </div>

                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Academic</span>

                                <!-- Right aligned caret -->
                                <span class="bi bi-caret-down ml-auto mr-4"></span>
                            </a>

                            <ul
                                class="submenu pl-6 {{ Request::routeIs('company.coupons.*') || Request::routeIs('company.admissions.*') || Request::routeIs('company.custom.invoices.*') ? '' : 'hidden' }}">
                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.admissions.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.admissions.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video"></i>
                                        </div>
                                        <span
                                            class="ml-1 duration-300 opacity-100 pointer-events-none ease">Admissions</span>
                                    </a>
                                </li>
                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.custom.invoices.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.custom.invoices.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Custom
                                            Invoice</span>
                                    </a>
                                </li>
                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.course-swap.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.course-swap.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video2"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease"> Course
                                            Extend</span>
                                    </a>
                                </li>
                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.course-swap.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.course-swap.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video2"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease"> Course
                                            Swap</span>
                                    </a>
                                </li>

                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.coupons.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.coupons.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-pip"></i>
                                        </div>
                                        <span
                                            class="ml-1 duration-300 opacity-100 pointer-events-none ease">Coupons</span>
                                    </a>
                                </li>



                            </ul>
                        </li>
                        {{-- <li class="mt-0.5 w-full">
                            <a class=" dark:text-white {{ Request::routeIs('company.coupons.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                href="{{ route('company.coupons.index') }}">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 text-sm bi bi-c-circle"></i>
                                </div>
                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Coupons</span>
                            </a>
                        </li> --}}

                        <li class="mt-0.5 w-full">
                            <a class="menu-toggle justify-content-between {{ Request::routeIs('company.analytics.*') ? 'bg-blue-500/13' : '' }} dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 flex items-center whitespace-nowrap transition-colors"
                                href="#">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 text-lg bi bi-person-video3"></i>
                                </div>

                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Analytics</span>

                                <!-- Right aligned caret -->
                                <span class="bi bi-caret-down ml-auto mr-4"></span>
                            </a>

                            <ul class="submenu pl-6 {{ Request::routeIs('company.analytics.*') ? '' : 'hidden' }}">
                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.guest') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.guest.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video"></i>
                                        </div>
                                        <span
                                            class="ml-1 duration-300 opacity-100 pointer-events-none ease">Admissions</span>
                                    </a>
                                </li>
                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.guest') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.guest.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-person-video2"></i>
                                        </div>
                                        <span
                                            class="ml-1 duration-300 opacity-100 pointer-events-none ease">Registrations</span>
                                    </a>
                                </li>

                                {{-- <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.guest') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.guest.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-pip"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Bank
                                            Accounts</span>
                                    </a>
                                </li> --}}

                                <li class="mt-0.5 w-full">
                                    <a class=" dark:text-white {{ Request::routeIs('company.guest') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                        href="{{ route('company.guest.index') }}">
                                        <div
                                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                            <i
                                                class="relative top-0 leading-normal text-cyan-500 text-lg  bi bi-pip"></i>
                                        </div>
                                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Referral
                                            Rewards</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- <li class="mt-0.5 w-full">
                            <a class=" dark:text-white {{ Request::routeIs('company.analytics.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                href="{{ route('company.analytics.index') }}">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 text-sm ni ni-single-copy-04"></i>
                                </div>
                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Analytics</span>
                            </a>
                        </li> --}}
                        {{-- <li class="mt-0.5 w-full">
                            <a class=" dark:text-white {{ Request::routeIs('company.staffs.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                href="{{ route('company.staffs') }}">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 text-sm ni ni-world-2"></i>
                                </div>
                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Staffs</span>
                            </a>
                        </li> --}}

                        <li class="mt-0.5 w-full">
                            <a class=" dark:text-white {{ Request::routeIs('company.webinars.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                href="{{ route('company.company.settings') }}">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 bi bi-headset text-sm"></i>
                                </div>
                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Company Settings
                                </span>
                            </a>
                        </li>


                        <li class="mt-0.5 w-full">
                            <a class=" dark:text-white {{ Request::routeIs('company.profile.*') ? 'bg-blue-500/13' : '' }} dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0  flex items-center whitespace-nowrap transition-colors"
                                href="{{ route('company.profile') }}">
                                <div
                                    class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                                    <i
                                        class="relative top-0 leading-normal text-emerald-500 text-sm ni ni-collection"></i>
                                </div>
                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Profile</span>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </aside>

    <!-- end sidenav -->

    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
        <!-- Navbar -->
        <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start"
            navbar-main navbar-scroll="false">
            <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
                @yield('nav-options')
                <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
                    <div class="flex items-center md:ml-auto md:pr-4 w-3/5">
                        <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease">
                            <span
                                class="text-sm ease leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text"
                                class="pl-9 text-sm focus:shadow-primary-outline ease w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow"
                                placeholder="Type here..." />
                        </div>
                    </div>
                    <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
                        <li class="flex items-center mr-3">
                            <button id="theme-toggle" type="button"
                                class="text-white flex dark:text-black bg-black  hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1">
                                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                                </svg>
                                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                        fill-rule="evenodd" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </li>
                        <!-- notifications -->

                        <li class="relative flex items-center px-4">
                            <p class="hidden transform-dropdown-show"></p>
                            <a href="javascript:;"
                                class="block p-0 text-black dark:text-white transition-all text-sm ease-nav-brand"
                                dropdown-trigger aria-expanded="false">
                                <i class="cursor-pointer bi bi-bell-fill text-2xl"></i>
                            </a>

                            <ul dropdown-menu
                                class="text-sm transform-dropdown before:font-awesome before:leading-default before:duration-350 before:ease lg:shadow-3xl duration-250 min-w-44 before:sm:right-8 before:text-5.5 pointer-events-none absolute right-0 top-0 z-50 origin-top list-none rounded-lg border-0 border-solid border-transparent dark:shadow-dark-xl dark:bg-slate-850 bg-white bg-clip-padding px-2 py-4 text-left text-slate-500 opacity-0 transition-all before:absolute before:right-2 before:left-auto before:top-0 before:z-50 before:inline-block before:font-normal before:text-white before:antialiased before:transition-all before:content-['\f0d8'] sm:-mr-6 lg:absolute lg:right-0 lg:left-auto lg:mt-2 lg:block lg:cursor-pointer">
                                <!-- add show class on dropdown open js -->
                                <li class="relative mb-2">
                                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors"
                                        href="javascript:;">
                                        <div class="flex py-1">
                                            <div class="my-auto">
                                                <img src="https://demos.creative-tim.com/argon-dashboard-tailwind/assets/img/team-2.jpg"
                                                    class="inline-flex items-center justify-center mr-4 text-white text-sm h-9 w-9 max-w-none rounded-xl" />
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <h6 class="mb-1 font-normal leading-normal dark:text-white text-sm">
                                                    <span class="font-semibold">New message</span> from Laur
                                                </h6>
                                                <p
                                                    class="mb-0 leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    <i class="mr-1 fa fa-clock"></i>
                                                    13 minutes ago
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li class="relative mb-2">
                                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg px-4 transition-colors duration-300 hover:bg-gray-200 hover:text-slate-700"
                                        href="javascript:;">
                                        <div class="flex py-1">
                                            <div class="my-auto">
                                                <img src="https://demos.creative-tim.com/argon-dashboard-tailwind/assets/img/small-logos/logo-spotify.svg"
                                                    class="inline-flex items-center justify-center mr-4 text-white text-sm bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 h-9 w-9 max-w-none rounded-xl" />
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <h6 class="mb-1 font-normal leading-normal dark:text-white text-sm">
                                                    <span class="font-semibold">New album</span> by Travis Scott
                                                </h6>
                                                <p
                                                    class="mb-0 leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    <i class="mr-1 fa fa-clock"></i>
                                                    1 day
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li class="relative">
                                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg px-4 transition-colors duration-300 hover:bg-gray-200 hover:text-slate-700"
                                        href="javascript:;">
                                        <div class="flex py-1">
                                            <div
                                                class="inline-flex items-center justify-center my-auto mr-4 text-white transition-all duration-200 ease-nav-brand text-sm bg-gradient-to-tl from-slate-600 to-slate-300 h-9 w-9 rounded-xl">
                                                <svg width="12px" height="12px" viewBox="0 0 43 36"
                                                    version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <title>credit-card</title>
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
                                                        <g transform="translate(-2169.000000, -745.000000)"
                                                            fill="#FFFFFF" fill-rule="nonzero">
                                                            <g transform="translate(1716.000000, 291.000000)">
                                                                <g transform="translate(453.000000, 454.000000)">
                                                                    <path class="color-background"
                                                                        d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                        opacity="0.593633743"></path>
                                                                    <path class="color-background"
                                                                        d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <h6 class="mb-1 font-normal leading-normal dark:text-white text-sm">
                                                    Payment
                                                    successfully
                                                    completed</h6>
                                                <p
                                                    class="mb-0 leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    <i class="mr-1 fa fa-clock"></i>
                                                    2 days
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="flex items-center">
                            <div class="flex items-center gap-4">

                                <div class="font-medium dark:text-white">
                                    <div class="text-black font-bold dark:text-white capitalize">
                                        {{ auth()->user()->name }}</div>
                                    <div class="text-sm text-black dark:text-white">{{ auth()->user()->acc_type }}
                                    </div>
                                </div>
                                <img class="w-10 h-10 rounded-full" data-dropdown-toggle="userDropdown"
                                    data-dropdown-placement="bottom-start" src="{{ auth()->user()->avatar_url }}"
                                    alt="">
                            </div>
                            <!-- Dropdown menu -->
                            <div id="userDropdown"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">

                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="avatarButton">
                                    <li>
                                        <a href="{{ route('company.profile') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-white dark:hover:text-white">Profile</a>
                                    </li>
                                </ul>
                                <div class="py-1">
                                    <form action="{{ route('logout') }}" method="POST" class="">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" role="button"
                                            class="block text-start px-4 py-2 w-full text-sm text-gray-700 hover:bg-gray-100 dark:hover:text-white dark:text-gray-200 dark:hover:text-white">Sign
                                            out</button>
                                    </form>


                                </div>
                            </div>
                        </li>
                        <li class="flex items-center pl-4 xl:hidden">
                            <a href="javascript:;" class="block p-0 text-white transition-all ease-nav-brand text-sm"
                                sidenav-trigger>
                                <div class="w-4.5 overflow-hidden">
                                    <i
                                        class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                                    <i
                                        class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                                    <i class="ease relative block h-0.5 rounded-sm bg-white transition-all"></i>
                                </div>
                            </a>
                        </li>
                        {{-- <li class="flex items-center px-4">
                            <a href="javascript:;" class="p-0 text-black dark:text-white transition-all text-sm ease-nav-brand">
                                <i fixed-plugin-button-nav class="cursor-pointer bi bi-bell-fill text-2xl"></i>
                                <!-- fixed-plugin-button-nav  -->
                            </a>
                        </li> --}}


                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
        @include('components.drawer-right')
    </main>
    <footer class="pt-4">
        <div class="w-full px-6 mx-auto fixed-bottom flex justify-content-center whitespace-nowrap bg-green-300 ">
            <div class="flex flex-wrap items-center -mx-3 lg:justify-between">
                <div class="w-full max-w-full px-3 mt-0 mb-6 shrink-0 lg:mb-0 lg:w-1/2 lg:flex-none">
                    <div class="leading-normal text-center text-sm text-slate-500 lg:text-left">
                        ©
                        <script>
                            document.write(new Date().getFullYear() + ",");
                        </script>
                        made with <i class="fa fa-heart"></i> by
                        Pachavellam Innovations Technologies
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- plugin for charts  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.min.js" async></script>
    <!-- plugin for scrollbar  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.6/perfect-scrollbar.min.js" async>
    </script>
    <!-- main script file  -->
    <script src="https://cdn.tiny.cloud/1/{{ env('TinyEditor1') }}/tinymce/8/tinymce.min.js" referrerpolicy="origin"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script> --}}
    <script src="{{ asset('assets/js/main.js') }}" async></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right", // Toast position
            "timeOut": "5000", // Timeout duration
            "extendedTimeOut": "5000",
        };

        @if (session('success'))
            toastr.success("{{ session('success') }}", "Success");
        @elseif (session('error'))
            toastr.error("{{ session('error') }}", "Error");
        @elseif (session('info'))
            toastr.info("{{ session('info') }}", "Info");
        @elseif (session('warning'))
            toastr.warning("{{ session('warning') }}", "Warning");
        @endif

        // Validation errors
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}", "Validation Error");
            @endforeach
        @endif
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(Idd) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if confirmed
                    document.getElementById('form_' + Idd).submit();
                }
            });
        }

          function confirmSubmit(Idd) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'can I continue?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, do it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if confirmed
                    document.getElementById('form2_' + Idd).submit();
                }
            });
        }



        function confirmDeleteAll(event, $form) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if confirmed
                    document.getElementById($form).submit();
                }
            });
        }
    </script>
    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {

            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }

                // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }

        });
    </script>

    <script>
        document.querySelectorAll('.menu-toggle').forEach(btn => {
            btn.addEventListener('click', () => {
                const submenu = btn.nextElementSibling;
                const arrow = btn.querySelector('.arrow');
                submenu.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            });
        });

        function copyPageLink(content) {

            navigator.clipboard.writeText(content)
                .then(() => {
                    toastr.success("copied to clipboard successfully!", "Success");

                })
                .catch(err => {
                    toastr.error("Failed to copy link." + err, "Error");
                });
        }


        document.addEventListener('change', function(event) {
            if (event.target.classList.contains('image-preview-input')) {
                let input = event.target;
                let previewImg = document.querySelector(input.dataset.preview);

                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = e => previewImg.src = e.target.result;
                    reader.readAsDataURL(input.files[0]);
                }
            }
        });
    </script>
    @stack('scripts')

    <script>
        $(document).ready(function() {

            $(document).on('click', '.open-drawer', function(e) {
                e.preventDefault();

                let url = $(this).data('url');

                $('#drawerContent').html('<div class="text-center text-gray-400 p-5">Loading...</div>');

                $.get(url, function(html) {
                    $('#drawerContent').html(html);
                    openDrawer();
                }).fail(function() {
                    $('#drawerContent').html(
                        '<div class="text-center text-red-500 p-5">Failed to load.</div>'
                    );
                });
            });
        });
    </script>



    <script>
        // tinymce.init({
        //     selector: 'textarea.editor',
        //     plugins: [
        //         // Core editing features
        //         'anchor', 'charmap', 'lists',
        //         // Your account includes a free trial of TinyMCE premium features
        //         // Try the most popular premium features until Jan 10, 2026:
        //         'checklist', 'typography',
        //     ],
        //     toolbar: 'fontsize | bold italic underline strikethrough | align lineheight | numlist bullist indent outdent | forecolor backcolor',

        // });
    </script>


    <script>
        const quill = new Quill('#noteEditor', {
            theme: 'snow',
            placeholder: 'Write notes here...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('note').value = quill.root.innerHTML;
        });
    </script>

</body>

</html>
