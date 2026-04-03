@extends('admin.layout.main')

@section('title', 'User Profile')
@section('page-title', 'User Profile')

@section('content')

<div class="max-w-7xl mx-auto p-4 space-y-6">

    <!-- ================= PROFILE CARD ================= -->
    <div class="bg-white  shadow-sm border border-gray-100 p-6">

        <div class="grid grid-cols-12 gap-6 items-center">

            <!-- Avatar -->
            <div class="col-span-12 md:col-span-2 text-center">
                <div class="w-24 h-24 mx-auto rounded-full bg-rose-500 text-white flex items-center justify-center text-3xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <span class="mt-3 inline-block px-3 py-1 text-xs rounded-full font-medium 
                    {{ $user->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <!-- Info -->
            <div class="col-span-12 md:col-span-5">
                <h3 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h3>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>

                <p class="text-sm text-gray-600 mt-2">
                    <i class="fa-solid fa-phone"></i> {{ $user->number ?? 'Not provided' }}
                </p>

                <p class="text-sm text-gray-600">
                    <i class="fa-solid fa-location-arrow"></i> {{ $user->address ?? 'Not provided' }}
                </p>
            </div>

            <!-- Stats -->
            <div class="col-span-12 md:col-span-5 grid grid-cols-3 gap-4 text-center">

                <div class="bg-gray-50  p-3">
                    <p class="text-indigo-600 font-bold text-lg">{{ $user->orders->count() }}</p>
                    <p class="text-xs text-gray-500">Orders</p>
                </div>

                <div class="bg-gray-50  p-3">
                    <p class="text-yellow-500 font-bold text-lg">
                        {{ number_format($user->rating ?? 0, 1) }}
                    </p>
                    <p class="text-xs text-gray-500">Rating</p>
                </div>

                <div class="bg-gray-50  p-3">
                    <p class="text-blue-500 font-bold text-lg">{{ ucfirst($user->role) }}</p>
                    <p class="text-xs text-gray-500">Role</p>
                </div>

            </div>

        </div>

        <div class="flex justify-between text-xs text-gray-500 mt-6 border-t pt-3">
            <span>Member since: {{ $user->created_at->format('d M Y') }}</span>
            <span>Updated: {{ $user->updated_at->diffForHumans() }}</span>
        </div>

    </div>


    <!-- ================= ORDER TABLE ================= -->
    <div class="bg-white  shadow-sm border border-gray-100 overflow-hidden">

        <!-- Header -->
        <div class="px-5 py-4 border-b">
            <h5 class="font-semibold text-gray-800">Order History</h5>
        </div>

        <!-- Table -->
        <div class="overflow-hidden border border-rose-200 bg-rose-200 shadow-lg shadow-rose-100/40">

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">

            <!-- Header -->
            <thead class="bg-rose-200 text-slate-900 uppercase text-xs tracking-wider">
                <tr>
                    <th class="p-4">#</th>
                    <th class="p-4"><i class="fa-solid fa-hashtag mr-2"></i>Order ID</th>
                    <th class="p-4"><i class="fa-solid fa-indian-rupee-sign mr-2"></i>Amount</th>
                    <th class="p-4"><i class="fa-solid fa-signal mr-2"></i>Status</th>
                    <th class="p-4"><i class="fa-solid fa-credit-card mr-2"></i>Payment</th>
                    <th class="p-4"><i class="fa-regular fa-calendar mr-2"></i>Date</th>
                    <th class="p-4 text-center"><i class="fa-solid fa-gear mr-2"></i>Action</th>
                </tr>
            </thead>

            <!-- Body -->
            <tbody class="divide-y divide-rose-200 bg-white">

                <!-- EMPTY STATE -->
                <tr class="transition duration-200 hover:bg-rose-50">
                    <td colspan="7" class="p-6 text-center text-slate-500">
                        <i class="fa-solid fa-box mr-2"></i> No orders available
                    </td>
                </tr>

            </tbody>

        </table>
    </div>

</div>

    </div>

</div>

@endsection 