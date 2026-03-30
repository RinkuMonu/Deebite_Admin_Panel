@extends('admin.layout.main')
@section('title', 'Vendor Management')
@section('page-title', 'Vendor List')

@section('content')
<div class="space-y-6">
    <div class="rounded-xl border bg-white p-6 shadow-lg shadow-rose-100/50">

        <!-- Header Row -->
        <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">

            <!-- Left Heading -->
            <h2 class="text-lg font-semibold text-slate-900">
                Vendors
            </h2>

            <!-- Right Side (Filters + Button) -->
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center">

                <!-- Filters -->
                <form action="{{ route('admin.vendors') }}" method="GET"
                      class="flex flex-col gap-3 md:flex-row md:items-center">

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search owner or shop..."
                        class="w-full rounded-xl border border-rose-200 bg-white px-3 py-2 text-sm text-slate-700 md:w-64
                               focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-200">

                    <select name="status"
                        class="w-full rounded-xl border border-rose-200 bg-white px-3 py-2 text-sm text-slate-700 md:w-44
                               focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-200">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    <button type="submit"
                        class="rounded-xl bg-[#f5185a] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#d8144f]">
                        <i class="fa-solid fa-filter mr-1"></i>
                        Filter
                    </button>

                    <a href="{{ route('admin.vendors') }}"
                       class="rounded-xl border border-rose-200 bg-white px-4 py-2 text-center text-sm font-medium text-slate-700 transition hover:bg-rose-50">
                        <i class="fa-solid fa-rotate-left mr-1"></i> Reset
                    </a>
                </form>

                <!-- Add Button -->
                <button onclick="toggleModal()"
                    class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
                    + Add Vendor
                </button>

            </div>
        </div>
    </div>

    <div class="rounded-xl overflow-hidden border border-rose-200 bg-rose-200 shadow-lg shadow-rose-100/40">

        <!-- Table -->
        <table class="w-full text-sm text-left">
        
            <!-- Header -->
            <thead class="bg-rose-200 text-slate-900 uppercase text-xs tracking-wider">
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
            <tbody class="divide-y divide-rose-200 bg-white">

                @foreach($vendors as $vendor)
                <tr class="transition duration-200 hover:bg-rose-50">

                <!-- Owner -->
                <td class="p-4 font-medium text-slate-900">
                    {{ $vendor->name }}
                </td>

                <!-- Location -->
                <td class="p-4 text-xs font-mono text-slate-500">
                    {{ $vendor->latitude ?? '0' }}, {{ $vendor->longitude ?? '0' }}
                </td>

                <!-- Shop -->
                <td class="p-4 text-slate-800">
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
                            ? 'bg-amber-100 text-amber-800' 
                            : 'bg-rose-100 text-rose-700' }}">
                        <i class="fa-solid {{ $vendor->is_active ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-1"></i>
                        {{ $vendor->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                <!-- Actions -->
                <td class="p-4 text-center space-x-3">

                    <!-- View -->
                    <a href="{{ route('admin.vendors.show', $vendor->id) }}" 
                       class="text-slate-700 transition hover:text-[#f5185a]"
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
                        class="text-slate-700 transition hover:text-[#f5185a]"
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

<div id="vendorModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 p-4">

    <!-- Modal Card -->
    <div class="max-h-[90vh] w-full max-w-3xl overflow-y-auto  border border-slate-200 bg-white shadow-xl shadow-slate-900/10">

        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-200 bg-white px-6 py-4">
            <h3 class="flex items-center gap-2 text-lg font-semibold text-slate-900">
                <i class="fa-solid fa-user-plus text-slate-600"></i>
                Register New Vendor
            </h3>
            <button onclick="toggleModal()" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>

        <!-- Form -->
        <form id="vendorForm" action="{{ route('admin.vendors.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <input type="hidden" name="vendor_id" id="vendor_id">

            <div class="mb-6 rounded-2xl border border-slate-200 bg-slate-50 p-4 shadow-sm shadow-slate-900/5">
                <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                    <div class="vendor-step-indicator flex min-w-0 items-center gap-3 rounded-2xl border border-rose-200 bg-white px-4 py-3" data-step-indicator="1">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-rose-500 text-sm font-semibold text-white shadow-sm">1</div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-700">Owner Details</p>
                        </div>
                    </div>
                    <div class="vendor-step-indicator flex min-w-0 items-center gap-3 rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3" data-step-indicator="2">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-rose-100 text-sm font-semibold text-rose-700">2</div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-700">Shop Details</p>
                        </div>
                    </div>
                    <div class="vendor-step-indicator flex min-w-0 items-center gap-3 rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3" data-step-indicator="3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-rose-100 text-sm font-semibold text-rose-700">3</div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-700">Documents</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <section class="vendor-step-panel" data-step-panel="1">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-900/5">
                        <div class="mb-5 flex items-center gap-3 border-b border-slate-200 pb-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-semibold text-slate-700">Owner Details</h4>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-600">Owner Name *</label>
                                <input type="text" name="name" id="edit_name" value="{{ old('name') }}"
                                    class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-600">Email *</label>
                                <input type="email" name="email" id="edit_email" value="{{ old('email') }}"
                                    class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-600">Phone Number *</label>
                                <input type="text" name="number" id="edit_number" value="{{ old('number') }}"
                                    class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-600">Password</label>
                                <input type="text" name="password" id="edit_password"
                                    class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
                                    placeholder="Leave blank to keep same">
                            </div>
                        </div>
                    </div>
                </section>

                <section class="vendor-step-panel hidden" data-step-panel="2">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-900/5">
                        <div class="mb-5 flex items-center gap-3 border-b border-slate-200 pb-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                                <i class="fa-solid fa-shop"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-semibold text-slate-700">Shop Details</h4>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-slate-600">Shop Name *</label>
                                <input type="text" name="shop_name" id="edit_shop_name" value="{{ old('shop_name') }}"
                                    class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-600">FSSAI Number</label>
                                <input type="text" name="fssai_number" id="edit_fssai_number" value="{{ old('fssai_number') }}"
                                    class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-600">Document Type *</label>
                                <select name="document_type" id="edit_document_type"
                                    class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                                    <option value="Aadhar">Aadhar Card</option>
                                    <option value="PAN">PAN Card</option>
                                    <option value="FSSAI">FSSAI License</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="vendor-step-panel hidden" data-step-panel="3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-900/5">
                        <div class="mb-5 flex items-center gap-3 border-b border-slate-200 pb-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-semibold text-slate-700">Documents</h4>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-600">Profile Photo</label>
                                <input type="file" name="profile_photo" id="profile_photo_input"
                                    class="mt-1 w-full rounded-xl border border-slate-300 bg-white p-2 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                                <div id="profile_preview" class="mt-2 text-xs font-medium text-slate-500"></div>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-600">Document File</label>
                                <input type="file" name="document_file" id="document_file_input"
                                    class="mt-1 w-full rounded-xl border border-slate-300 bg-white p-2 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                                <div id="document_preview" class="mt-2 text-xs font-medium text-slate-500"></div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex gap-3">
                    <button type="button" onclick="toggleModal()"
                        class="rounded-xl bg-rose-100 px-5 py-2.5 text-sm font-medium text-rose-700 transition hover:bg-rose-200">
                        Cancel
                    </button>

                    <button type="button" id="prevStepBtn"
                        class="hidden rounded-xl border border-rose-200 bg-white px-5 py-2.5 text-sm font-medium text-rose-600 transition hover:bg-rose-50">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Previous
                    </button>
                </div>

                <div class="flex gap-3 sm:ml-auto">
                    <button type="button" id="nextStepBtn"
                        class="rounded-xl bg-rose-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-600">
                        Next Step <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>

                <button type="submit" id="submitBtn" 
                    class="hidden rounded-xl bg-rose-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-600">
                    <i class="fa-solid fa-check mr-1"></i> Register Vendor
                </button>
                </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('vendorModal');
        const stepPanels = Array.from(document.querySelectorAll('[data-step-panel]'));
        const stepIndicators = Array.from(document.querySelectorAll('[data-step-indicator]'));
        const nextBtn = document.getElementById('nextStepBtn');
        const prevBtn = document.getElementById('prevStepBtn');
        const submitBtn = document.getElementById('submitBtn');
        let currentStep = 1;

        function setVendorStep(step) {
            currentStep = step;

            stepPanels.forEach((panel) => {
                panel.classList.toggle('hidden', Number(panel.dataset.stepPanel) !== step);
            });

            stepIndicators.forEach((indicator) => {
                const isActive = Number(indicator.dataset.stepIndicator) === step;
                const bubble = indicator.querySelector('div');

                indicator.classList.toggle('border-rose-200', isActive);
                indicator.classList.toggle('bg-white', isActive);
                indicator.classList.toggle('border-slate-200', !isActive);
                indicator.classList.toggle('bg-slate-100', !isActive);

                if (bubble) {
                    bubble.classList.toggle('bg-rose-500', isActive);
                    bubble.classList.toggle('text-white', isActive);
                    bubble.classList.toggle('bg-rose-100', !isActive);
                    bubble.classList.toggle('text-rose-700', !isActive);
                }
            });

            prevBtn.classList.toggle('hidden', step === 1);
            nextBtn.classList.toggle('hidden', step === 3);
            submitBtn.classList.toggle('hidden', step !== 3);
        }

        nextBtn.addEventListener('click', function () {
            if (currentStep < 3) {
                setVendorStep(currentStep + 1);
            }
        });

        prevBtn.addEventListener('click', function () {
            if (currentStep > 1) {
                setVendorStep(currentStep - 1);
            }
        });

        const observer = new MutationObserver(function () {
            if (!modal.classList.contains('hidden')) {
                setVendorStep(1);
            }
        });

        observer.observe(modal, { attributes: true, attributeFilter: ['class'] });
        setVendorStep(1);
    });
</script>
@endsection
