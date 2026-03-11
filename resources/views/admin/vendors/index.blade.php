@extends('admin.layout.main')
@section('title', 'Vendor Management')
@section('page-title', 'Vendor List')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    
    <form action="{{ route('admin.vendors') }}" method="GET" class="mb-6">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Search by vendor name or shop name..." class="border p-2 rounded w-72">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Filter</button>
    </form>

    <table class="w-full border-collapse text-left">
        <thead class="bg-slate-50">
            <tr>
                <th class="p-4">Owner Name</th>
                <th class="p-4">Shop Name</th>
                <th class="p-4">FSSAI No.</th>
                <th class="p-4">Status</th>
                <th class="p-4">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($vendors as $vendor)
            <tr>
                <td class="p-4">{{ $vendor->name }}</td>
                <td class="p-4">{{ $vendor->vendorDetail->shop_name ?? 'N/A' }}</td>
                <td class="p-4">{{ $vendor->vendorDetail->fssai_number ?? 'N/A' }}</td>
                <td class="p-4">
                    <span class="px-2 py-1 text-xs {{ $vendor->is_active ? 'bg-green-100' : 'bg-red-100' }}">
                        {{ $vendor->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="p-4">
                    <a href="{{ route('admin.vendors.show', $vendor->id) }}" class="text-blue-600">View Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $vendors->links() }}
    </div>
</div>
@endsection