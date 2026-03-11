@extends('admin.layout.main')
@section('title', 'Delivery Partners')
@section('page-title', 'Delivery Partners List')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    
    <form action="{{ route('admin.delivery-partners') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Search by name, number, email..." class="border p-2 rounded w-72">
        
        <select name="status" class="border p-2 rounded">
            <option value="">All Status</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
        </select>
        
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Filter</button>
        <a href="{{ route('admin.delivery-partners') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Reset</a>
    </form>

    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50">
            <tr>
                <th class="p-4">Name</th>
                <th class="p-4">Contact</th>
                <th class="p-4">Location (Lat/Long)</th>
                <th class="p-4">Status</th>
                <th class="p-4">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($users as $user)
            <tr>
                <td class="p-4">{{ $user->name }}</td>
                <td class="p-4">
                    {{ $user->number ?? 'N/A' }} <br>
                    <small class="text-slate-400">{{ $user->email }}</small>
                </td>
                <td class="p-4 text-xs font-mono">
                    {{ $user->latitude ?? '0' }}, {{ $user->longitude ?? '0' }}
                </td>
                <td class="p-4">
                    <span class="px-2 py-1 text-xs rounded {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="p-4">
                    <button class="text-indigo-600 hover:text-indigo-900">Track Location</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-4 text-center text-slate-500">No delivery partners found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection