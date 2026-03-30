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
            <header class="border-b border-slate-200 bg-white/90 px-4 py-4 shadow-sm backdrop-blur sm:px-6">
                <div class="flex flex-wrap items-center justify-between gap-3 sm:gap-4">
                    <div class="flex min-w-0 items-center gap-3 sm:gap-4">
                        <button id="sidebarToggle" type="button" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 text-slate-700 transition hover:bg-slate-100 sm:h-11 sm:w-11 sm:rounded-2xl">
                            <i class="fa-solid fa-bars-staggered"></i>
                        </button>
                        <div class="min-w-0">
                            <h1 class="truncate text-base font-semibold text-slate-800 sm:text-lg">@yield('page-title')</h1>
                            <p class="hidden text-xs uppercase tracking-[0.25em] text-slate-400 sm:block">Admin Workspace</p>
                        </div>
                    </div>

                    <div class="relative inline-block group ml-auto">
                        <div class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 bg-white px-2.5 py-2 shadow-sm transition hover:shadow sm:gap-4 sm:rounded-2xl sm:px-3">
                            <span class="hidden text-sm text-slate-600 sm:block">
                                Hi, <b>{{ auth()->user()->name }}</b>
                            </span>
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}"
                                class="h-9 w-9 rounded-full border border-slate-200 sm:h-10 sm:w-10">
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
        document.addEventListener('DOMContentLoaded', function () {
            const body = document.body;
            const sidebar = document.getElementById('adminSidebar');
            const toggleButton = document.getElementById('sidebarToggle');
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

            toggleButton.addEventListener('click', function () {
                const nextState = !body.classList.contains(collapsedClass);
                applySidebarState(nextState);
            });

            overlay.addEventListener('click', function () {
                applySidebarState(true);
            });

            window.addEventListener('resize', function () {
                const nextState = window.innerWidth < 1024;
                applySidebarState(nextState);
            });
        });
    </script>
</body>

</html>
