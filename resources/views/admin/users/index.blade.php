@extends('admin.layout.main')
@section('title', 'User Management')
@section('page-title', 'User List')

@section('content')
<div class="rounded-3xl border border-rose-100/80 bg-gradient-to-br from-rose-50 via-[#fffdf8] to-amber-50 p-6 shadow-lg shadow-rose-100/40">

    <!-- Filter Bar -->
   <div class="flex justify-between items-center mb-6">

    <!-- Left Side Heading -->
    <h2 class="text-lg font-semibold text-slate-900">
        Customer List
    </h2>

    <!-- Right Side Filters -->
    <form action="{{ route('admin.users') }}" method="GET" 
          class="flex items-center gap-3">

        <input type="text" name="search" value="{{ request('search') }}" 
            placeholder="Search by name or email..."
            class="w-64 rounded-xl border border-rose-200 bg-white px-3 py-2 text-sm text-slate-700
                   focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-200">

        <select name="status" 
            class="rounded-xl border border-rose-200 bg-white px-3 py-2 text-sm text-slate-700
                   focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-200">
            <option value="">All Status</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
        </select>

        <button type="submit" 
            class="rounded-xl bg-[#f5185a] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#d8144f]">
            <i class="fa-solid fa-filter mr-1"></i> Filter
        </button>

        <a href="{{ route('admin.users') }}" 
           class="rounded-xl border border-rose-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-rose-50">
            <i class="fa-solid fa-rotate-left mr-1"></i> Reset
        </a>

    </form>

</div>
        <div class="overflow-hidden rounded-3xl border border-rose-100 bg-gradient-to-br from-[#fff6f8] via-white to-[#fff8e8] shadow-lg shadow-rose-100/30">
    <!-- Table -->
    <table class="w-full text-sm text-left">

        <!-- Header -->
        <thead class="bg-gradient-to-r from-[#fde9a9] via-[#fff3f6] to-white text-slate-900 uppercase text-xs tracking-wider">
            <tr>
                <th class="p-4"><i class="fa-regular fa-user mr-2"></i>Name</th>
                <th class="p-4"><i class="fa-regular fa-envelope mr-2"></i>Email</th>
                <th class="p-4"><i class="fa-solid fa-signal mr-2"></i>Status</th>
                <th class="p-4 text-center"><i class="fa-solid fa-gear mr-2"></i>Action</th>
            </tr>
        </thead>

        <!-- Body -->
        <tbody class="divide-y divide-rose-100/70 bg-white/70">

            @foreach($users as $user)
            <tr class="transition duration-200 hover:bg-gradient-to-r hover:from-[#fff4cf] hover:via-rose-50/70 hover:to-white">

                <td class="p-4 font-medium text-slate-900">
                    {{ $user->name }}
                </td>

                <td class="p-4 text-slate-600">
                    {{ $user->email }}
                </td>

                <td class="p-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $user->is_active 
                            ? 'bg-amber-100 text-amber-800' 
                            : 'bg-rose-100 text-rose-700' }}">
                        <i class="fa-solid {{ $user->is_active ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-1"></i>
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                <!-- Action -->
                <td class="p-4 text-center">
                    <a href="#" 
                       class="text-slate-700 transition hover:text-[#f5185a]"
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
