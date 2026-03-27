@extends('admin.layout.main')
@section('title', 'Vendor Management')
@section('page-title', 'Vendor List')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">

    <!-- Header Row -->
    <div class="flex justify-between items-center mb-6">

        <!-- Left Heading -->
        <h2 class="text-lg font-semibold text-slate-700">
            Vendors 
        </h2>

        <!-- Right Side (Filters + Button) -->
        <div class="flex items-center gap-4">

            <!-- Filters -->
            <form action="{{ route('admin.vendors') }}" method="GET" 
                  class="flex items-center gap-3">

                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Search owner or shop..."
                    class="border border-slate-200 px-3 py-2 rounded-lg w-64 text-sm 
                           focus:outline-none focus:ring-1 focus:ring-indigo-400">

                <select name="status" 
                    class="border border-slate-200 px-3 py-2 rounded-lg text-sm 
                           focus:outline-none focus:ring-1 focus:ring-indigo-400">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white 
                           px-4 py-2 rounded-lg text-sm transition">
                    <i class="fa-solid fa-filter mr-1"></i>
                    Filter
                </button>

            </form>

            <!-- Add Button -->
            <button onclick="toggleModal()" 
                class="bg-green-600 hover:bg-green-700 text-white 
                       px-4 py-2 rounded-lg text-sm transition">
                + Add Vendor
            </button>

        </div>

    </div>

    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

    <!-- Table -->
    <table class="w-full text-sm text-left">
        
        <!-- Header -->
        <thead class="bg-gradient-to-r from-slate-100 to-slate-50 text-slate-700 uppercase text-xs tracking-wider">
            <tr>
                <th class="p-4"><i class="fa-regular fa-user mr-2"></i>Owner</th>
                <th class="p-4"><i class="fa-solid fa-location-dot mr-2"></i>Location</th>
                <th class="p-4"><i class="fa-solid fa-shop mr-2"></i>Shop</th>
                <th class="p-4"><i class="fa-solid fa-id-card mr-2"></i>FSSAI</th>
                <th class="p-4"><i class="fa-solid fa-signal mr-2"></i>Status</th>
                <th class="p-4 text-center"><i class="fa-solid fa-gear mr-2"></i>Action</th>
            </tr>
        </thead>

        <!-- Body -->
        <tbody class="divide-y">

            @foreach($vendors as $vendor)
            <tr class="hover:bg-blue-200 transition duration-200">

                <!-- Owner -->
                <td class="p-4 font-medium text-slate-800">
                    {{ $vendor->name }}
                </td>

                <!-- Location -->
                <td class="p-4 text-xs font-mono text-slate-500">
                    {{ $vendor->latitude ?? '0' }}, {{ $vendor->longitude ?? '0' }}
                </td>

                <!-- Shop -->
                <td class="p-4 text-slate-700">
                    {{ $vendor->vendorDetail->shop_name ?? 'N/A' }}
                </td>

                <!-- FSSAI -->
                <td class="p-4 text-slate-600">
                    {{ $vendor->vendorDetail->fssai_number ?? 'N/A' }}
                </td>

                <!-- Status -->
                <td class="p-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $vendor->is_active 
                            ? 'bg-green-100 text-green-700' 
                            : 'bg-red-100 text-red-700' }}">
                        <i class="fa-solid {{ $vendor->is_active ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-1"></i>
                        {{ $vendor->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                <!-- Actions -->
                <td class="p-4 text-center space-x-3">

                    <!-- View -->
                    <a href="{{ route('admin.vendors.show', $vendor->id) }}" 
                       class="text-blue-600 hover:text-blue-800 transition"
                       title="View">
                        <i class="fa-regular fa-eye text-lg"></i>
                    </a>

                    <!-- Edit -->
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
                        class="text-indigo-600 hover:text-indigo-800 transition"
                        title="Edit">
                        <i class="fa-regular fa-pen-to-square text-lg"></i>
                    </button>

                </td>

            </tr>
            @endforeach

        </tbody>
    </table>


</div>

    <div class="mt-4">{{ $vendors->links() }}</div>
</div>

<div id="vendorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">

    <!-- Modal Card -->
    <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-y-auto max-h-[90vh]">

        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b bg-gradient-to-r from-slate-100 to-slate-50">
            <h3 class="text-lg font-semibold text-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-indigo-600"></i>
                Register New Vendor
            </h3>
            <button onclick="toggleModal()" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>

        <!-- Form -->
        <form id="vendorForm" action="{{ route('admin.vendors.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <input type="hidden" name="vendor_id" id="vendor_id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Owner Section -->
                <div class="col-span-2 flex items-center gap-2 text-indigo-600 font-semibold border-b pb-1">
                    <i class="fa-solid fa-user"></i> Owner Details
                </div>

                <div>
                    <label class="text-sm text-slate-600">Owner Name *</label>
                    <input type="text" name="name" id="edit_name" value="{{ old('name') }}" 
                        class="w-full border border-slate-200 px-3 py-2 rounded-lg text-sm focus:ring-1 focus:ring-indigo-400">
                </div>

                <div>
                    <label class="text-sm text-slate-600">Email *</label>
                    <input type="email" name="email" id="edit_email" value="{{ old('email') }}" 
                        class="w-full border border-slate-200 px-3 py-2 rounded-lg text-sm focus:ring-1 focus:ring-indigo-400">
                </div>

                <div>
                    <label class="text-sm text-slate-600">Phone Number *</label>
                    <input type="text" name="number" id="edit_number" value="{{ old('number') }}" 
                        class="w-full border border-slate-200 px-3 py-2 rounded-lg text-sm focus:ring-1 focus:ring-indigo-400">
                </div>

                <div>
                    <label class="text-sm text-slate-600">Password</label>
                    <input type="text" name="password" id="edit_password" 
                        class="w-full border border-slate-200 px-3 py-2 rounded-lg text-sm focus:ring-1 focus:ring-indigo-400"
                        placeholder="Leave blank to keep same">
                </div>

                <!-- Shop Section -->
                <div class="col-span-2 flex items-center gap-2 text-indigo-600 font-semibold border-b pb-1 mt-3">
                    <i class="fa-solid fa-shop"></i> Shop & Documents
                </div>

                <div class="col-span-2">
                    <label class="text-sm text-slate-600">Shop Name *</label>
                    <input type="text" name="shop_name" id="edit_shop_name" value="{{ old('shop_name') }}" 
                        class="w-full border border-slate-200 px-3 py-2 rounded-lg text-sm focus:ring-1 focus:ring-indigo-400">
                </div>

                <div>
                    <label class="text-sm text-slate-600">FSSAI Number</label>
                    <input type="text" name="fssai_number" id="edit_fssai_number" value="{{ old('fssai_number') }}" 
                        class="w-full border border-slate-200 px-3 py-2 rounded-lg text-sm focus:ring-1 focus:ring-indigo-400">
                </div>

                <div>
                    <label class="text-sm text-slate-600">Document Type *</label>
                    <select name="document_type" id="edit_document_type" 
                        class="w-full border border-slate-200 px-3 py-2 rounded-lg text-sm focus:ring-1 focus:ring-indigo-400">
                        <option value="Aadhar">Aadhar Card</option>
                        <option value="PAN">PAN Card</option>
                        <option value="FSSAI">FSSAI License</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-slate-600">Profile Photo</label>
                    <input type="file" name="profile_photo" id="profile_photo_input" 
                        class="w-full border border-slate-200 p-1 rounded-lg text-sm">
                    <div id="profile_preview" class="mt-1 text-xs text-indigo-600"></div>
                </div>

                <div>
                    <label class="text-sm text-slate-600">Document File</label>
                    <input type="file" name="document_file" id="document_file_input" 
                        class="w-full border border-slate-200 p-1 rounded-lg text-sm">
                    <div id="document_preview" class="mt-1 text-xs text-indigo-600"></div>
                </div>

            </div>

            <!-- Buttons -->
            <div class="mt-6 flex gap-3">
                <button type="submit" id="submitBtn" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex-1 transition">
                    <i class="fa-solid fa-check mr-1"></i> Register Vendor
                </button>

                <button type="button" onclick="toggleModal()" 
                    class="bg-gray-200 hover:bg-gray-300 px-5 py-2.5 rounded-lg text-sm transition">
                    Cancel
                </button>
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