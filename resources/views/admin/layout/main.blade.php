<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin | @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans">

    <div class="flex">
        @include('admin.layout.sidebar')

        <div class="flex-1 flex flex-col h-screen">
            <header class="bg-white shadow-sm py-4 px-6 flex justify-between items-center">
                <h1 class="text-lg font-semibold text-slate-700">@yield('page-title')</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-600">Hi, <b>{{ auth()->user()->name }}</b></span>
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" class="w-10 h-10 rounded-full border">
                </div>
            </header>
            <main class="p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>