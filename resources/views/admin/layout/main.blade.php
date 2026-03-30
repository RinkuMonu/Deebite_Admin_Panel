<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin | @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="overflow-x-hidden bg-gradient-to-br from-slate-50 via-white to-amber-50 font-sans text-slate-800">
    <div class="flex min-h-screen overflow-x-hidden">
        @include('admin.layout.sidebar')

        <div class="flex min-h-screen min-w-0 flex-1 flex-col">
            <header class=" bg-white px-4 py-2 sm:px-6">
                <div
                    class="flex flex-wrap items-center justify-between gap-2  bg-gradient-to-r from-white via-rose-50/70 to-white px-3 py-2 shadow-sm shadow-rose-100/40 sm:px-4">

                    <div class="flex min-w-0 items-center gap-3">
                        <button id="mobileSidebarToggle" type="button"
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-rose-200 bg-rose-50 text-[#f5185a] transition hover:bg-rose-100 lg:hidden">
                            <i class="fa-solid fa-bars-staggered"></i>
                        </button>
                        <div class="min-w-0">
                            <h1 class="truncate text-sm font-semibold text-slate-900 sm:text-base">@yield('page-title')
                            </h1>
                            <p class="truncate text-xs text-rose-400">Admin Workspace</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">

                        <div class="relative">
                            <input type="text" placeholder="Search..."
                                class="h-9 w-40 sm:w-56 pl-9 pr-3 rounded-full border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 transition">

                            <i
                                class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                        </div>
                        <!-- Messages -->
                        <div class="relative">
                            <button
                                class="h-9 w-9 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
                                <i class="fa-regular fa-envelope text-gray-600"></i>
                            </button>
                            <span
                                class="absolute -top-1 -right-1 bg-blue-500 text-white text-[10px] px-1.5 rounded-full">5</span>
                        </div>



                        <div class="invisible absolute right-0 mt-2 w-44 rounded-2xl border border-slate-200 bg-white shadow-lg opacity-0 transition duration-200 group-hover:visible group-hover:opacity-100">
                            <a href="{{ route('admin.profile')}}" class="block rounded-t-2xl px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-50">
                                My Profile
                            </a>

                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full rounded-b-2xl px-4 py-3 text-left text-sm text-slate-700 transition hover:bg-slate-50">
                                    Logout
                                </button>
                            </form>
                        </div>

                        <!-- Grid -->
                        <button
                            class="h-9 w-9 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
                            <i class="fa-solid fa-table"></i>
                        </button>

                        <!-- Fullscreen -->
                        <button id="fullscreenToggle"
                            class="h-9 w-9 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
                            <i class="fa-solid fa-expand text-gray-600"></i>
                        </button>

                        <!-- Profile -->
                        <div class="relative">
                            <div id="profileToggle" class="flex items-center gap-2 cursor-pointer">
                                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}"
                                    class="h-9 w-9 rounded-full border">

                                <div class="hidden sm:block">
                                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>

                                </div>
                            </div>

                            <!-- Dropdown -->
                            <div id="profileDropdown"
                                class="hidden absolute right-0 mt-3 w-52 bg-white shadow-lg rounded-xl p-2">

                                <a href="/" class="block px-4 py-2 text-sm hover:bg-gray-100 rounded-lg">
                                    My Profile
                                </a>

                                <form method="POST" action="/logout">
                                    @csrf
                                    <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 rounded-lg">
                                        Logout
                                    </button>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </header>

            <main class="min-w-0 flex-1 overflow-x-auto overflow-y-auto p-4 sm:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <div id="sidebarOverlay" class="fixed inset-0 z-30 hidden bg-black/40 lg:hidden"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const body = document.body;
        const sidebar = document.getElementById('adminSidebar');
        const toggleButtons = document.querySelectorAll('#sidebarToggle, #mobileSidebarToggle');
        const overlay = document.getElementById('sidebarOverlay');
        const collapsedClass = 'sidebar-collapsed';

        function applySidebarState(isCollapsed) {
            const isMobile = window.innerWidth < 1024;
            body.classList.toggle(collapsedClass, isCollapsed);

            sidebar.classList.toggle('w-60', !isCollapsed || isMobile);
            sidebar.classList.toggle('w-20', isCollapsed && !isMobile);
            sidebar.classList.toggle('px-4', !isCollapsed && !isMobile);
            sidebar.classList.toggle('px-3', isCollapsed || isMobile);
            sidebar.classList.toggle('-translate-x-full', isCollapsed && isMobile);
            sidebar.classList.toggle('translate-x-0', !isCollapsed || !isMobile);
            overlay.classList.toggle('hidden', isCollapsed || !isMobile);

            sidebar.querySelectorAll('.sidebar-text').forEach((element) => {
                const collapseText = isCollapsed && !isMobile;
                element.classList.toggle('opacity-0', collapseText);
                element.classList.toggle('w-0', collapseText);
                element.classList.toggle('pointer-events-none', collapseText);
                element.classList.toggle('opacity-100', !collapseText);
                element.classList.toggle('w-auto', !collapseText);
            });

            sidebar.querySelectorAll('nav a, form button').forEach((element) => {
                element.classList.toggle('justify-center', isCollapsed && !isMobile);
            });
        }

        const isInitiallyCollapsed = window.innerWidth < 1024;
        applySidebarState(isInitiallyCollapsed);

        toggleButtons.forEach((toggleButton) => {
            toggleButton.addEventListener('click', function() {
                const nextState = !body.classList.contains(collapsedClass);
                applySidebarState(nextState);
            });
        });

        overlay.addEventListener('click', function() {
            applySidebarState(true);
        });

        window.addEventListener('resize', function() {
            const nextState = window.innerWidth < 1024;
            applySidebarState(nextState);
        });

        // ✅ Profile dropdown click logic (ONLY ADDITION)
        const toggle = document.getElementById("profileToggle");
        const dropdown = document.getElementById("profileDropdown");

        toggle.addEventListener("click", function(e) {
            e.stopPropagation();
            dropdown.classList.toggle("hidden");
        });

        document.addEventListener("click", function(e) {
            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add("hidden");
            }
        });

    });
    const fsBtn = document.getElementById("fullscreenToggle");
    const fsIcon = fsBtn.querySelector("i");

    fsBtn.addEventListener("click", function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            fsIcon.classList.remove("fa-expand");
            fsIcon.classList.add("fa-compress");
        } else {
            document.exitFullscreen();
            fsIcon.classList.remove("fa-compress");
            fsIcon.classList.add("fa-expand");
        }
    });
    </script>
</body>

</html>