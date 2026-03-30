@extends('admin.layout.main')

@section('title', 'Admin Profile')
@section('page-title', 'Admin Profile')

@section('content')

<div class="max-w-7xl mx-auto p-4">

    <!-- Alerts -->
    @if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-700 border border-green-200">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 text-red-700 border border-red-200">
        {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 text-red-700 border border-red-200">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-12 gap-6">

        <!-- SIDEBAR -->
        <div class="col-span-12 md:col-span-4">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">

                <!-- Avatar -->
                @if($admin->avatar)
                <img src="{{ asset('storage/'.$admin->avatar) }}"
                    class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-indigo-100">
                @else
                <div
                    class="w-32 h-32 mx-auto rounded-full bg-rose-500 text-white flex items-center justify-center text-4xl font-semibold">
                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                </div>
                @endif

                <!-- Info -->
                <h3 class="mt-4 text-lg font-semibold text-gray-800">
                    {{ $admin->name }}
                </h3>

                <p class="text-sm text-gray-500">
                    {{ $admin->email }}
                </p>

                <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full bg-green-100 text-green-600 font-medium">
                    Active
                </span>

                <!-- Divider -->
                <div class="my-6 border-t border-gray-100"></div>

                <!-- Details -->
                <div class="text-left space-y-4 text-sm">
                    <div>
                        <p class="text-gray-400">Member Since</p>
                        <p class="font-medium text-gray-700">
                            {{ $admin->created_at->format('F d, Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Last Updated</p>
                        <p class="font-medium text-gray-700">
                            {{ $admin->updated_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

            </div>

        </div>


        <!-- MAIN CONTENT -->
        <div class="col-span-12 md:col-span-8 space-y-6">

            <!-- UPDATE PROFILE -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Update Profile Information
                </h2>

                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="text-sm text-gray-600">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                                class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none"
                                required>
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                                class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none"
                                required>
                        </div>

                    </div>

                    <button type="submit"
                        class="mt-4 px-5 py-2 bg-rose-500 hover:bg-rose-600 text-white text-sm rounded-lg transition">
                        Update Profile
                    </button>

                </form>
            </div>


            <!-- CHANGE PASSWORD -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Change Password
                </h2>

                <form action="{{ route('admin.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">

                        <div>
                            <label class="text-sm text-gray-600">Current Password</label>
                            <input type="password" name="current_password"
                                class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none"
                                required>
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">New Password</label>
                            <input type="password" name="new_password"
                                class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none"
                                required>
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation"
                                class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none"
                                required>
                        </div>

                    </div>

                    <button type="submit"
                        class="mt-4 px-5 py-2 bg-rose-500 hover:bg-rose-600 text-white text-sm rounded-lg transition">
                        Change Password
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection