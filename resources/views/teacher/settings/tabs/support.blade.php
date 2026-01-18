<h2 class="text-xl font-bold mb-2 dark:text-white">
    Support & Community
</h2>

<p class="text-gray-600 dark:text-gray-300 mb-6">
    Reach us directly or join our community channels for faster support.
</p>

<!-- ================= COMMUNITY LINKS ================= -->
<h3 class="text-lg font-semibold mb-4 dark:text-white">
    Community Channels
</h3>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

    @forelse($socials as $social)
        <a href="{{ $social->link }}" target="_blank"
           class="group flex items-center gap-4 p-2 rounded-2xl
                  bg-white dark:bg-slate-800
                  border border-gray-100 dark:border-slate-700
                  shadow hover:shadow-lg transition">

            <div class="w-14 h-14 flex items-center justify-center
                        rounded-xl bg-blue-50 dark:bg-slate-700 overflow-hidden">
                <img src="{{ $social->icon }}" alt="{{ $social->name }}"
                     class="w-10 h-10 object-contain">
            </div>

            <div class="flex-1">
                <h4 class="font-semibold text-sm text-gray-800 dark:text-white">
                    {{ $social->name }}
                </h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 capitalize">
                    {{ $social->type }} community
                </p>
            </div>

            <span class="text-blue-600 dark:text-blue-400 group-hover:translate-x-1 transition me-3">
                →
            </span>
        </a>
    @empty
        <p class="text-gray-500 dark:text-gray-400 col-span-full">
            No community links available.
        </p>
    @endforelse

</div>

<!-- ================= DIRECT CONTACT ================= -->
<h3 class="text-lg font-semibold mb-4 dark:text-white">
    Contact Information
</h3>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    @if($company->email)
        <div class="flex items-center gap-4 p-2 rounded-xl
                    bg-white dark:bg-slate-800 border dark:border-slate-700">
            <i data-lucide="mail" class="w-6 h-6 text-blue-600"></i>
            <div>
                <p class="text-sm text-dark">Email</p>
                <p class="font-medium dark:text-dark">{{ $company->email }}</p>
            </div>
        </div>
    @endif

    @if($company->phone)
        <div class="flex items-center gap-4 p-2 rounded-xl
                    bg-white dark:bg-slate-800 border dark:border-slate-700">
            <i data-lucide="phone" class="w-6 h-6 text-green-600"></i>
            <div>
                <p class="text-sm text-dark">Phone</p>
                <p class="font-medium dark:text-dark">{{ $company->phone }}</p>
            </div>
        </div>
    @endif

    @if($company->whatsapp)
        <a href="https://wa.me/{{ preg_replace('/\D/', '', $company->whatsapp) }}"
           target="_blank"
           class="flex items-center gap-4 p-2 rounded-xl
                  bg-white dark:bg-slate-800 border dark:border-slate-700">
            <i data-lucide="message-circle" class="w-6 h-6 text-green-500"></i>
            <div>
                <p class="text-sm text-dark">WhatsApp</p>
                <p class="font-medium dark:text-dark">{{ $company->whatsapp }}</p>
            </div>
        </a>
    @endif

    @if($company->website)
        <a href="{{ $company->website }}" target="_blank"
           class="flex items-center gap-4 p-2 rounded-xl
                  bg-white dark:bg-slate-800 border dark:border-slate-700">
            <i data-lucide="globe" class="w-6 h-6 text-indigo-600"></i>
            <div>
                <p class="text-sm text-dark">Website</p>
                <p class="font-medium dark:text-dark">{{ $company->website }}</p>
            </div>
        </a>
    @endif

    @if($company->address)
        <div class="md:col-span-2 flex items-start gap-4 p-2 rounded-xl
                    bg-white dark:bg-slate-800 border dark:border-slate-700">
            <i data-lucide="map-pin" class="w-6 h-6 text-red-500 mt-1"></i>
            <div>
                <p class="text-sm text-dark">Address</p>
                <p class="font-medium dark:text-dark">
                    {{ $company->address }}
                </p>
            </div>
        </div>
    @endif

</div>

<!-- SUPPORT NOTE -->
<div class="mt-8 p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20">
    <p class="text-sm text-blue-700 dark:text-blue-300">
        💬 Our support team usually responds within 24 hours.
    </p>
</div>
