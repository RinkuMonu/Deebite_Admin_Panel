@extends('admin.layout.main')
@section('title', 'User Management')
@section('page-title', 'User List')

@section('content')
<div class="bg-white shadow-lg rounded-xl overflow-hidden p-5">

    <!-- Filter Bar -->
   <div class="flex justify-between items-center mb-5">

    <!-- Left Side Heading -->
    <h2 class="text-lg font-semibold text-slate-700">
        Customer List
    </h2>

    <!-- Right Side Filters -->
    <form action="{{ route('admin.users') }}" method="GET" 
          class="flex items-center gap-3">

        <input type="text" name="search" value="{{ request('search') }}" 
            placeholder="Search by name or email..."
            class="border border-slate-200 px-3 py-2 rounded-lg w-64 text-sm 
                   focus:outline-none focus:ring-1 focus:ring-indigo-400">

        <select name="status" 
            class="border border-slate-200 px-3 py-2 rounded-lg text-sm 
                   focus:outline-none focus:ring-1 focus:ring-indigo-400">
            <option value="">All Status</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
        </select>

        <button type="submit" 
            class="bg-indigo-600 hover:bg-indigo-700 text-white 
                   px-4 py-2 rounded-lg text-sm transition">
            <i class="fa-solid fa-filter mr-1"></i> Filter
        </button>

        <a href="{{ route('admin.users') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white 
                  px-4 py-2 rounded-lg text-sm transition">
            <i class="fa-solid fa-rotate-left mr-1"></i> Reset
        </a>

    </form>

</div>
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
    <!-- Table -->
    <table class="w-full text-sm text-left">

        <!-- Header -->
        <thead class="bg-gradient-to-r from-slate-100 to-slate-50 
                      text-slate-700 uppercase text-xs tracking-wider">
            <tr>
                <th class="p-4"><i class="fa-regular fa-user mr-2"></i>Name</th>
                <th class="p-4"><i class="fa-regular fa-envelope mr-2"></i>Email</th>
                <th class="p-4"><i class="fa-solid fa-signal mr-2"></i>Status</th>
                <th class="p-4 text-center"><i class="fa-solid fa-gear mr-2"></i>Action</th>
            </tr>
        </thead>

        <!-- Body -->
        <tbody class="divide-y">

            @foreach($users as $user)
            <tr class="hover:bg-blue-200 transition duration-200">

                <td class="p-4 font-medium text-slate-800">
                    {{ $user->name }}
                </td>

                <td class="p-4 text-slate-600">
                    {{ $user->email }}
                </td>

                <td class="p-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $user->is_active 
                            ? 'bg-green-100 text-green-700' 
                            : 'bg-red-100 text-red-700' }}">
                        <i class="fa-solid {{ $user->is_active ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-1"></i>
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                <!-- Action -->
                <td class="p-4 text-center">
                    <a href="#" 
                       class="text-indigo-600 hover:text-indigo-800 transition"
                       title="View">
                        <i class="fa-regular fa-eye text-lg"></i>
                    </a>
                </td>

            </tr>
            @endforeach

        </tbody>

    </table>
</div>

    <!-- Pagination -->
    <div class="mt-5">
        {{ $users->links() }}
    </div>

</div>
@endsection