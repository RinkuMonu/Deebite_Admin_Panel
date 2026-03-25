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
                <th class="p-4">Location (Lat/Long)</th>
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
                <td class="p-4 text-xs font-mono">
                    {{ $vendor->latitude ?? '0' }}, {{ $vendor->longitude ?? '0' }}
                </td>
                <td class="p-4">{{ $vendor->vendorDetail->shop_name ?? 'N/A' }}</td>
                <td class="p-4">{{ $vendor->vendorDetail->fssai_number ?? 'N/A' }}</td>
                <td class="p-4">
                    <span class="px-2 py-1 text-xs {{ $vendor->is_active ? 'bg-green-100' : 'bg-red-100' }}">
                        {{ $vendor->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="p-4">
                    <a href="{{ route('admin.vendors.show', $vendor->id) }}" class="text-blue-600">View Details</a>
                    <button type="button" 
                        onclick="openEditModal({{ json_encode([
                            'id' => $vendor->id,
                            'name' => $vendor->name,
                            'email' => $vendor->email,
                            'number' => $vendor->number,
                            'shop_name' => $vendor->vendorDetail->shop_name ?? '',
                            'fssai_number' => $vendor->vendorDetail->fssai_number ?? '',
                            'document_type' => $vendor->vendorDetail->document_type ?? 'Aadhar',
                            'profile_photo' => $vendor->vendorDetail->profile_photo ?? '',
                            'document_file' => $vendor->vendorDetail->document_file ?? ''
                        ]) }})"
                        class="text-indigo-600 font-bold">
                        Edit
                    </button>
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
        
        <form id="vendorForm" action="{{ route('admin.vendors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="vendor_id" id="vendor_id">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-2"><h4 class="font-bold border-b pb-1 text-indigo-600">Owner Details</h4></div>
                
                <div>
                    <label class="block text-sm font-medium">Owner Name *</label>
                    <input type="text" name="name" id="edit_name" value="{{ old('name') }}" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Email *</label>
                    <input type="email" name="email" id="edit_email" value="{{ old('email') }}" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Phone Number *</label>
                    <input type="text" name="number" id="edit_number" value="{{ old('number') }}" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Password</label>
                    <input type="text" name="password" id="edit_password" class="w-full border p-2 rounded" placeholder="Leave blank to keep same">
                </div>

                <div class="col-span-2 mt-4"><h4 class="font-bold border-b pb-1 text-indigo-600">Shop & Documents</h4></div>
                
                <div class="col-span-2">
                    <label class="block text-sm font-medium">Shop Name *</label>
                    <input type="text" name="shop_name" id="edit_shop_name" value="{{ old('shop_name') }}" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">FSSAI Number</label>
                    <input type="text" name="fssai_number" id="edit_fssai_number" value="{{ old('fssai_number') }}" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Document Type *</label>
                    <select name="document_type" id="edit_document_type" class="w-full border p-2 rounded">
                        <option value="Aadhar">Aadhar Card</option>
                        <option value="PAN">PAN Card</option>
                        <option value="FSSAI">FSSAI License</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Profile Photo</label>
                    <input type="file" name="profile_photo" id="profile_photo_input" class="w-full border p-1 rounded text-sm">
                    <div id="profile_preview" class="mt-1 text-xs text-blue-600"></div> 
                </div>

                <div>
                    <label class="block text-sm font-medium">Document File</label>
                    <input type="file" name="document_file" id="document_file_input" class="w-full border p-1 rounded text-sm">
                    <div id="document_preview" class="mt-1 text-xs text-blue-600"></div> 
                </div>
            </div>
            
            <div class="mt-8 flex gap-3">
                <button type="submit" id="submitBtn" class="bg-indigo-600 text-white px-6 py-3 rounded flex-1 font-bold">Register Vendor</button>
                <button type="button" onclick="toggleModal()" class="bg-gray-200 px-6 py-3 rounded">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    // 1. Modal toggle function
    function toggleModal() {
        const modal = document.getElementById('vendorModal');
        const form = document.getElementById('vendorForm');
        
        if (modal.classList.contains('hidden')) {
            // Reset form for "Add New"
            form.reset();
            form.action = "{{ route('admin.vendors.store') }}";
            document.querySelector('#vendorModal h3').innerText = "Register New Vendor";
            document.getElementById('submitBtn').innerText = "Register Vendor";
            
            // Re-enable required for files on Add
            document.getElementById('profile_photo_input').required = true;
            document.getElementById('document_file_input').required = true;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    function openEditModal(vendor) {
        const modal = document.getElementById('vendorModal');
        const form = document.getElementById('vendorForm'); // ID match honi chahiye
        
        // UI Update
        document.querySelector('#vendorModal h3').innerText = "Edit Vendor";
        document.getElementById('submitBtn').innerText = "Update Vendor";
        
        // Form Action update
        form.action = `/admin/vendors/update/${vendor.id}`;
        
        // Values Fill
        document.getElementById('edit_name').value = vendor.name;
        document.getElementById('edit_email').value = vendor.email;
        document.getElementById('edit_number').value = vendor.number;
        document.getElementById('edit_shop_name').value = vendor.shop_name;
        document.getElementById('edit_fssai_number').value = vendor.fssai_number;
        document.getElementById('edit_document_type').value = vendor.document_type;
        
        document.getElementById('edit_password').required = false;
        document.getElementById('profile_photo_input').required = false;
        document.getElementById('document_file_input').required = false;
        const profilePreview = document.getElementById('profile_preview');
            if (vendor.profile_photo) {
                profilePreview.innerHTML = `<a href="${vendor.profile_photo}" target="_blank">📄 View Current Profile</a>`;
            } else {
                profilePreview.innerHTML = '';
            }

            // Document File Preview logic
            const docPreview = document.getElementById('document_preview');
            if (vendor.document_file) {
                docPreview.innerHTML = `<a href="${vendor.document_file}" target="_blank">📄 View Current Document</a>`;
            } else {
                docPreview.innerHTML = '';
            }
        modal.classList.remove('hidden');
        modal.classList.add('flex');
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