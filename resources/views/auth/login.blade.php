<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deebite Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-image:
                radial-gradient(circle at top left, rgba(245, 24, 90, 0.08), transparent 22%),
                linear-gradient(135deg, rgba(248, 233, 226, 0.78) 0%, rgba(245, 223, 216, 0.78) 100%),
                url('{{ asset('images/backgrounds/doodle.png') }}');
            background-size: auto, auto, 420px;
            background-repeat: no-repeat, no-repeat, repeat;
        }
    </style>
</head>
<body class="min-h-screen px-4 py-6 md:px-8 md:py-8">
    @php
        $showcaseImage = asset('images/backgrounds/login.jpg');
        $brandColor = '#f5185a';
    @endphp

    <div class="mx-auto flex min-h-[calc(100vh-3rem)] w-full max-w-6xl overflow-hidden rounded-[2rem] border border-white/50 bg-white/30 shadow-[0_30px_80px_rgba(95,47,61,0.16)] backdrop-blur-sm">
        <section class="flex w-full items-center justify-center bg-white px-6 py-10 md:w-1/2 md:px-10 lg:px-14">
            <div class="w-full max-w-sm">
                <div class="mb-8">
                    <div class="mb-6 flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full border-2 text-[var(--brand)] text-[var(--brand)]" style="--brand: {{ $brandColor }}">
                            <i class="fa-solid fa-utensils"></i>
                        </span>
                        <div>
                            <p class="text-2xl font-semibold tracking-tight text-slate-800">Deebite</p>
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Admin Panel</p>
                        </div>
                    </div>

                    <h1 class="text-3xl font-bold text-slate-900">Sign in to your account</h1>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Welcome back. Log in with your email and password to access the Deebite admin dashboard.</p>
                </div>

                @if(session('error'))
                    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                        <input
                            type="email"
                            name="email"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:bg-white focus:ring-4"
                            style="--tw-ring-color: rgba(245, 24, 90, 0.1); border-color: #e5e7eb;"
                            onfocus="this.style.borderColor='{{ $brandColor }}'"
                            onblur="this.style.borderColor='#e5e7eb'"
                            placeholder="admin@example.com"
                        >
                        @error('email') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <label class="block text-sm font-medium text-slate-700">Password</label>
                            <a href="#" class="text-xs text-slate-500 hover:text-[#f5185a]">Forgot Password?</a>
                        </div>
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-11 text-sm text-slate-700 outline-none transition focus:bg-white focus:ring-4"
                                style="--tw-ring-color: rgba(245, 24, 90, 0.1); border-color: #e5e7eb;"
                                onfocus="this.style.borderColor='{{ $brandColor }}'"
                                onblur="this.style.borderColor='#e5e7eb'"
                                placeholder="Enter your password"
                            >
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                                <i class="fa-regular fa-eye"></i>
                            </span>
                        </div>
                        @error('password') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-500">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-[#f5185a] focus:ring-[#f5185a]/30">
                        Keep me signed in
                    </label>

                    <button
                        type="submit"
                        class="w-full rounded-xl px-4 py-3 text-sm font-semibold text-white shadow-[0_16px_32px_rgba(245,24,90,0.22)] transition hover:bg-[#db1451]"
                        style="background-color: {{ $brandColor }}"
                    >
                        Log In
                    </button>
                </form>

                <div class="mt-6 rounded-2xl border border-[#f5185a]/10 bg-[#fef4f7] px-4 py-3 text-sm text-slate-500">
                    <p class="font-medium text-slate-700">Image paths</p>
                    <p class="mt-1 text-xs leading-5 text-slate-500"> &copy; 2026 Admin Panel v2.0. All rights reserved.
 
                </div>
            </div>
        </section>

        <section class="relative hidden md:flex md:w-1/2">
            <img
                src="{{ $showcaseImage }}"
                alt="Deebite login showcase"
                class="h-full w-full object-cover"
            >
            <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(10,10,10,0.12),rgba(10,10,10,0.38))]"></div>
            <div class="absolute inset-x-0 bottom-0 p-8 lg:p-10">
                <div class="max-w-sm rounded-[1.5rem] border border-white/20 bg-white/10 p-5 text-white backdrop-blur-md">
                    <p class="text-xs uppercase tracking-[0.28em] text-white/70">Deebite</p>
                    <h2 class="mt-2 text-2xl font-semibold">Manage your food platform with confidence</h2>
                    <p class="mt-3 text-sm leading-6 text-white/80">Menus, vendors, orders, and customer operations, all from one admin workspace.</p>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
