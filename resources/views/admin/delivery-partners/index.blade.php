@extends('admin.layout.main')
@section('title', 'Delivery Partners')
@section('page-title', 'Delivery Partners List')

@section('content')
<div class="space-y-6">
    <div class="rounded-xl border bg-white p-6 shadow-lg shadow-rose-100/50">
        <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
            <h2 class="text-lg font-semibold text-slate-900">
                Delivery Partners
            </h2>

            <div class="flex flex-col gap-3 lg:flex-row lg:items-center">
                <form action="{{ route('admin.delivery-partners') }}" method="GET"
                      class="flex flex-col gap-3 md:flex-row md:items-center">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search name, number..."
                           class="w-full rounded-xl border border-rose-200 bg-white px-3 py-2 text-sm text-slate-700 md:w-64 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-200">

                    <select name="status"
                            class="w-full rounded-xl border border-rose-200 bg-white px-3 py-2 text-sm text-slate-700 md:w-44 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-200">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    <button type="submit"
                            class="rounded-xl bg-[#f5185a] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#d8144f]">
                        <i class="fa-solid fa-filter mr-1"></i> Filter
                    </button>

                    <a href="{{ route('admin.delivery-partners') }}"
                       class="rounded-xl border border-rose-200 bg-white px-4 py-2 text-center text-sm font-medium text-slate-700 transition hover:bg-rose-50">
                        <i class="fa-solid fa-rotate-left mr-1"></i> Reset
                    </a>
                </form>

                <a href="{{ route('admin.delivery.heatmap') }}"
                   class="flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
                    <i class="fas fa-map-marked-alt"></i> View Global Heat Map
                </a>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto border border-rose-200 bg-rose-200 shadow-lg shadow-rose-100/30">
        <table class="w-full text-sm text-left">
            <thead class="bg-rose-200 text-slate-900 uppercase text-xs tracking-wider">
                <tr>
                    <th class="p-4"><i class="fa-regular fa-user mr-2"></i>Partner</th>
                    <th class="p-4"><i class="fa-solid fa-chart-line mr-2"></i>Performance</th>
                    <th class="p-4"><i class="fa-solid fa-box mr-2"></i>Load</th>
                    <th class="p-4"><i class="fa-solid fa-route mr-2"></i>Movement</th>
                    <th class="p-4"><i class="fa-solid fa-signal mr-2"></i>Status</th>
                    <th class="p-4 text-center"><i class="fa-solid fa-gear mr-2"></i>Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-rose-200 bg-white">
                @forelse($users as $user)
                <tr class="transition duration-200 hover:bg-rose-50">
                    <td class="p-4">
                        <div class="font-medium text-slate-900">
                            {{ $user->name }}
                        </div>
                        <div class="text-xs text-slate-500">
                            {{ $user->number ?? 'No Number' }}
                        </div>
                        <div class="text-xs text-[#f5185a]">
                            {{ $user->email }}
                        </div>
                    </td>

                    <td class="p-4">
                        <div class="text-sm font-semibold text-slate-700">
                            Rating: {{ $user->rating ?? '5.0' }}
                        </div>
                        <div class="text-xs font-mono text-slate-500">
                            {{ $user->latitude }}, {{ $user->longitude }}
                        </div>
                    </td>

                    <td class="p-4">
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                            {{ $user->active_orders_count ?? 0 }} Orders
                        </span>
                    </td>

                    <td class="p-4">
                        @if($user->is_moving)
                            <span class="flex w-fit items-center gap-2 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                                <span class="relative flex h-2 w-2">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-amber-400 opacity-75"></span>
                                    <span class="relative inline-flex h-2 w-2 rounded-full bg-amber-500"></span>
                                </span>
                                Moving
                            </span>
                        @else
                            <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                Idle
                            </span>
                        @endif
                    </td>

                    <td class="p-4">
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $user->is_active ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-700' }}">
                            <i class="fa-solid {{ $user->is_active ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-1"></i>
                            {{ $user->is_active ? 'Active' : 'Blocked' }}
                        </span>
                    </td>

                    <td class="p-4 text-center space-x-3">
                        <a href="{{ route('admin.delivery.track', $user->id) }}"
                           class="text-slate-700 transition hover:text-[#f5185a]"
                           title="Track">
                            <i class="fas fa-location-arrow text-lg"></i>
                        </a>

                        <form action="{{ route('admin.delivery.toggle', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            <button type="submit"
                                    class="{{ $user->is_active ? 'text-rose-600 hover:text-rose-800' : 'text-amber-700 hover:text-amber-800' }} transition"
                                    title="{{ $user->is_active ? 'Block' : 'Unblock' }}">
                                <i class="fa-solid {{ $user->is_active ? 'fa-ban' : 'fa-check' }} text-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-10 text-center text-slate-400">
                        No delivery partners found matching your criteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
