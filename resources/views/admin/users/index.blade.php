@extends('admin.layout.main')
@section('title', 'User Management')
@section('page-title', 'User List')

@section('content')
<div class="space-y-6">
    <div class="rounded-xl border bg-white p-6 shadow-lg shadow-rose-100/40">
        <form action="{{ route('admin.users') }}" method="GET"
            class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
            <h2 class="text-lg font-semibold text-slate-900">
                Customer List
            </h2>

            <div class="flex flex-col gap-3 md:flex-row md:items-center">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name or email..." class="w-full rounded-xl border border-rose-200 bg-white px-3 py-2 text-sm text-slate-700 md:w-64
                        focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-200">

                <select name="status" class="w-full rounded-xl border border-rose-200 bg-white px-3 py-2 text-sm text-slate-700 md:w-44
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
                    class="rounded-xl border border-rose-200 bg-white px-4 py-2 text-center text-sm font-medium text-slate-700 transition hover:bg-rose-50">
                    <i class="fa-solid fa-rotate-left mr-1"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <div class="rounded-xl overflow-hidden border border-rose-200 bg-rose-200 shadow-lg shadow-rose-100/30">
        <!-- Table -->
        <table class="w-full text-sm text-left">

            <!-- Header -->
            <thead class="bg-rose-200 text-slate-900 uppercase text-xs tracking-wider">
                <tr>
                    <th class="p-4"><i class="fa-regular fa-user mr-2"></i>Name</th>
                    <th class="p-4"><i class="fa-regular fa-envelope mr-2"></i>Email</th>
                    <th class="p-4"><i class="fa-solid fa-signal mr-2"></i>Status</th>
                    <th class="p-4 text-center"><i class="fa-solid fa-gear mr-2"></i>Action</th>
                </tr>
            </thead>

            <!-- Body -->
            <tbody class="divide-y divide-rose-200 bg-white">

                @foreach($users as $user)
                <tr class="transition duration-200 hover:bg-rose-50">

                    <td class="p-4 font-medium text-slate-900">
                        {{ $user->name ?? "N/A" }}
                    </td>

                    <td class="p-4 text-slate-600">
                        {{ $user->email ?? "N/A" }}
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
                        <a href="{{ route('admin.users.profile', encrypt( $user->id)  )}}"
                            class="text-slate-700 transition hover:text-[#f5185a]" title="View">
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