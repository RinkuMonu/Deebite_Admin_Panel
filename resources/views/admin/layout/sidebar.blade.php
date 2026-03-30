@php
    $navItems = [
        ['route' => 'admin.dashboard', 'icon' => 'fa-gauge', 'label' => 'Dashboard'],
        ['route' => 'admin.users', 'icon' => 'fa-users', 'label' => 'Customers'],
        ['route' => 'admin.vendors', 'icon' => 'fa-store', 'label' => 'Vendors'],
        ['route' => 'admin.delivery-partners', 'icon' => 'fa-truck', 'label' => 'Delivery Partners'],
        ['route' => 'admin.categories.index', 'icon' => 'fa-layer-group', 'label' => 'Categories'],
        ['route' => 'feedback.index', 'icon' => 'fa-comment', 'label' => 'Feedback'],
    ];
@endphp

<aside id="adminSidebar" class="group fixed inset-y-0 left-0 z-40 flex min-h-screen w-60 shrink-0 flex-col border-r border-slate-800 bg-slate-950 px-3 py-5 text-white shadow-xl shadow-slate-900/30 transition-all duration-300 ease-out lg:static lg:translate-x-0">
    <div class="mb-8 flex items-center gap-3 overflow-hidden px-1">
        <button
            id="sidebarToggle"
            type="button"
            aria-label="Toggle sidebar"
            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg border border-white/15 bg-white/10 text-base text-white shadow-md shadow-black/15 transition hover:bg-white/20"
        >
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <div class="sidebar-text min-w-0 transition-all duration-300">
            <p class="truncate text-lg font-semibold tracking-wide text-white">Admin Panel</p>
            <p class="truncate text-xs uppercase tracking-[0.25em] text-slate-400">Control Center</p>
        </div>
    </div>

    <nav class="flex-1 space-y-2">
        @foreach($navItems as $item)
            @php
                $isActive = request()->routeIs($item['route']);
            @endphp

            <a href="{{ route($item['route']) }}"
                title="{{ $item['label'] }}"
                class="flex items-center gap-3 overflow-hidden rounded-md px-2.5 py-2.5 text-sm font-medium transition-all duration-200 {{ $isActive ? 'bg-white text-black shadow-md shadow-white/10' : 'text-slate-200 hover:text-white' }}">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md {{ $isActive ? 'bg-black/5 text-black' : 'bg-white/10 text-slate-200 group-hover:text-white' }}">
                    <i class="fa-solid {{ $item['icon'] }}"></i>
                </span>
                <span class="sidebar-text whitespace-nowrap transition-all duration-300">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="mt-6 border-t border-white/10 pt-4">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" title="Logout" class="flex w-full items-center gap-3 overflow-hidden rounded-md px-2.5 py-2.5 text-sm font-medium text-slate-200 transition-all duration-200 hover:text-white">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-white/10">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </span>
                <span class="sidebar-text whitespace-nowrap transition-all duration-300">Logout</span>
            </button>
        </form>
    </div>
</aside>
