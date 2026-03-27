@extends('admin.layout.main')
@section('title', 'Delivery Partners')
@section('page-title', 'Delivery Partners List')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    
    <div class="flex justify-between items-center mb-6">
        <form action="{{ route('admin.delivery-partners') }}" method="GET" class="flex flex-wrap gap-4">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search name, number..." class="border p-2 rounded w-64 text-sm">
            
            <select name="status" class="border p-2 rounded text-sm">
                <option value="">All Status</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">Filter</button>
            <a href="{{ route('admin.delivery-partners') }}" class="bg-gray-500 text-white px-4 py-2 rounded text-sm">Reset</a>
        </form>

        <a href="{{ route('admin.delivery.heatmap') }}" class="bg-orange-500 text-white px-4 py-2 rounded text-sm flex items-center gap-2 hover:bg-orange-600">
            <i class="fas fa-map-marked-alt"></i> View Global Heat Map
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="p-4 text-sm font-semibold text-slate-700">Partner Details</th>
                    <th class="p-4 text-sm font-semibold text-slate-700">Performance</th>
                    <th class="p-4 text-sm font-semibold text-slate-700">Current Load</th>
                    <th class="p-4 text-sm font-semibold text-slate-700">Movement</th>
                    <th class="p-4 text-sm font-semibold text-slate-700">Status</th>
                    <th class="p-4 text-sm font-semibold text-slate-700 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4">
                        <div class="font-bold text-slate-800">{{ $user->name }}</div>
                        <div class="text-xs text-slate-500">{{ $user->number ?? 'No Number' }}</div>
                        <div class="text-xs text-indigo-500">{{ $user->email }}</div>
                    </td>

                    <td class="p-4">
                        <div class="text-sm">⭐ <span class="font-bold">{{ $user->rating ?? '5.0' }}</span></div>
                        <div class="text-xs text-slate-400 font-mono">{{ $user->latitude }}, {{ $user->longitude }}</div>
                    </td>

                    <td class="p-4">
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-bold">
                            {{ $user->active_orders_count ?? 0 }} Orders Active
                        </span>
                    </td>

                    <td class="p-4">
                        @if($user->is_moving)
                            <span class="flex items-center gap-1 text-green-600 text-xs font-bold italic">
                                <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                Moving
                            </span>
                        @else
                            <span class="text-slate-400 text-xs font-bold italic">Idle</span>
                        @endif
                    </td>

                    <td class="p-4">
                        <span class="px-2 py-1 text-[10px] uppercase font-bold rounded {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $user->is_active ? 'Active' : 'Blocked' }}
                        </span>
                    </td>

                    <td class="p-4">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.delivery.track', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium" title="Live Tracking">
                                <i class="fas fa-location-arrow"></i> Track
                            </a>

                            <form action="{{ route('admin.delivery.toggle', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                <button type="submit" class="{{ $user->is_active ? 'text-red-500' : 'text-green-500' }} text-sm font-medium">
                                    {{ $user->is_active ? 'Block' : 'Unblock' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-10 text-center text-slate-400">No delivery partners found matching your criteria.</td>
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