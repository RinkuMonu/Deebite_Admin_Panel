@extends('admin.layout.main')
@section('title', 'User Management')
@section('page-title', 'User List')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    
    <form action="{{ route('admin.users') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." class="border p-2 rounded w-64">
        
        <select name="status" class="border p-2 rounded">
            <option value="">All Status</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
        </select>
        
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Filter</button>
        <a href="{{ route('admin.users') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Reset</a>
    </form>

    <table class="w-full border-collapse">
        <thead class="bg-slate-50">
            <tr class="text-left text-slate-600 uppercase text-sm">
                <th class="p-4">Name</th>
                <th class="p-4">Email</th>
                <th class="p-4">Status</th>
                <th class="p-4">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($users as $user)
            <tr>
                <td class="p-4">{{ $user->name }}</td>
                <td class="p-4">{{ $user->email }}</td>
                <td class="p-4">
                    <span class="px-2 py-1 rounded text-xs {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="p-4">
                    <a href="#" class="text-indigo-600 hover:underline">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection