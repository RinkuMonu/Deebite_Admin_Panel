@extends('admin.layout.main')
@section('title', 'Vendor Management')
@section('page-title', 'Vendor List')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <form action="{{ route('admin.vendors') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search owner or shop..." class="border p-2 rounded w-72">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Filter</button>
        </form>
        <button onclick="toggleModal()" class="bg-green-600 text-white px-4 py-2 rounded shadow">+ Add Vendor</button>
    </div>

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

    <div class="mt-4">{{ $vendors->links() }}</div>
</div>

<div id="vendorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white p-8 rounded-lg w-full max-w-2xl shadow-2xl overflow-y-auto max-h-[90vh]">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">Register New Vendor</h3>
            <button onclick="toggleModal()" class="text-gray-500 text-2xl">&times;</button>
        </div>
        
        <form action="{{ route('admin.vendors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-2"><h4 class="font-bold border-b pb-1 text-indigo-600">Owner Details</h4></div>
                
                <div>
                    <label class="block text-sm font-medium">Owner Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded @error('name') border-red-500 @enderror">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded @error('email') border-red-500 @enderror">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Phone Number *</label>
                    <input type="text" name="number" value="{{ old('number') }}" class="w-full border p-2 rounded @error('number') border-red-500 @enderror">
                    @error('number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Password *</label>
                    <input type="text" name="password" value="{{ old('password') }}" class="w-full border p-2 rounded @error('password') border-red-500 @enderror">
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-2 mt-4"><h4 class="font-bold border-b pb-1 text-indigo-600">Shop & Documents</h4></div>
                
                <div class="col-span-2">
                    <label class="block text-sm font-medium">Shop Name *</label>
                    <input type="text" name="shop_name" value="{{ old('shop_name') }}" class="w-full border p-2 rounded @error('shop_name') border-red-500 @enderror">
                    @error('shop_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">FSSAI Number</label>
                    <input type="text" name="fssai_number" value="{{ old('fssai_number') }}" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Document Type *</label>
                    <select name="document_type" class="w-full border p-2 rounded">
                        <option value="Aadhar" {{ old('document_type') == 'Aadhar' ? 'selected' : '' }}>Aadhar Card</option>
                        <option value="PAN" {{ old('document_type') == 'PAN' ? 'selected' : '' }}>PAN Card</option>
                        <option value="FSSAI" {{ old('document_type') == 'FSSAI' ? 'selected' : '' }}>FSSAI License</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Profile Photo *</label>
                    <input type="file" name="profile_photo" class="w-full border p-1 rounded text-sm @error('profile_photo') border-red-500 @enderror">
                    @error('profile_photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Document File (PDF/Image) *</label>
                    <input type="file" name="document_file" class="w-full border p-1 rounded text-sm @error('document_file') border-red-500 @enderror">
                    @error('document_file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <div class="mt-8 flex gap-3">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded flex-1 font-bold">Register Vendor</button>
                <button type="button" onclick="toggleModal()" class="bg-gray-200 px-6 py-3 rounded">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    // 1. Modal toggle function
    function toggleModal() {
        const modal = document.getElementById('vendorModal');
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }

    // 2. ERROR CHECK: Agar validation fail hui hai toh modal ko wapas open karo
    @if($errors->any())
        // Hum ensures karte hain ki page load hone ke baad modal dikhe
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('vendorModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    @endif
</script>
@endsection