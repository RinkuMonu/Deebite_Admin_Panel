@extends('admin.layout.main')
@section('title', 'Vendor Details')
@section('page-title', 'Vendor Details')

@section('content')
<div class="rounded-3xl border border-amber-100 bg-gradient-to-br from-[#fff7db] via-white to-rose-50 p-6 shadow-lg shadow-amber-100/50">
    <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Vendor Overview</h2>
            <p class="text-sm text-slate-500">Manage vendor profile, add menu items, and review the current food list.</p>
        </div>
        <a href="{{ route('admin.vendors') }}"
            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back To Vendors
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="rounded-3xl border border-amber-100 bg-white p-6 shadow-lg shadow-amber-100/40">
            <div class="text-center">
                <img src="{{ $vendor->vendorDetail->profile_photo }}"
                    class="mx-auto h-32 w-32 rounded-full border-4 border-amber-100 object-cover shadow-md shadow-amber-100/50">
                <h3 class="mt-4 text-xl font-semibold text-slate-900">{{ $vendor->vendorDetail->shop_name ?? 'N/A' }}</h3>
                <span class="mt-2 inline-flex rounded-full bg-[#fff1c2] px-3 py-1 text-xs font-semibold text-slate-900">
                    Vendor ID: #{{ $vendor->id }}
                </span>
            </div>

            <div class="my-5 border-t border-amber-100"></div>

            <div class="space-y-4 text-sm">
                <div class="rounded-2xl border border-amber-100 bg-[#fff8df] p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Owner</p>
                    <p class="mt-1 font-medium text-slate-900">{{ $vendor->name }}</p>
                </div>

                <div class="rounded-2xl border border-amber-100 bg-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Contact</p>
                    <p class="mt-1 font-medium text-slate-900">{{ $vendor->number }}</p>
                </div>

                <div class="rounded-2xl border border-amber-100 bg-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">FSSAI</p>
                    <p class="mt-1 font-medium text-slate-900">{{ $vendor->vendorDetail->fssai_number ?? 'N/A' }}</p>
                </div>

                <div class="rounded-2xl border border-amber-100 bg-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Document Type</p>
                    <p class="mt-1 font-medium text-slate-900">{{ $vendor->vendorDetail->document_type }}</p>
                </div>

                <a href="{{ $vendor->vendorDetail->document_file }}" target="_blank"
                    class="inline-flex items-center text-sm font-medium text-[#f5185a] transition hover:text-[#d8144f]">
                    <i class="fa-solid fa-file-lines mr-2"></i> View Document File
                </a>
            </div>
        </div>

        <div class="xl:col-span-2 rounded-3xl border border-amber-100 bg-white p-6 shadow-lg shadow-amber-100/40" x-data="{ count: 1 }">
            <div class="mb-5 flex items-center gap-3 border-b border-amber-100 pb-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#fff1c2] text-[#f5185a]">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Add New Food Item</h3>
                </div>
            </div>

            <form action="{{ route('admin.food.store') }}" method="POST">
                @csrf
                <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-600">Category</label>
                        <select name="category_id"
                            class="mt-1 w-full rounded-xl border border-amber-200 bg-[#fff9e8] px-3 py-2.5 text-sm text-slate-800 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-100">
                            <option value="" {{ old('category_id') ? '' : 'selected' }} style="background-color: #ffffff; color: #000000;">
                                Select Category
                            </option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }} style="background-color: #fff1c2; color: #000000;">
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-600">Food Name</label>
                        <input type="text" name="name" placeholder="E.g. Paneer Tikka"
                            class="mt-1 w-full rounded-xl border border-amber-200 bg-[#fff9e8] px-3 py-2.5 text-sm text-slate-800 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-100"
                            required>
                    </div>
                </div>

                <div class="mt-5">
                    <label class="text-sm font-medium text-slate-600">Variants & Pricing</label>
                    <div id="variants-container" class="mt-2 space-y-3">
                        <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                            <input type="text" name="variants[0][name]" placeholder="Variant (Half/Full)"
                                class="w-full rounded-xl border border-amber-200 bg-[#fff9e8] px-3 py-2.5 text-sm text-slate-800 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-100"
                                required>
                            <input type="number" name="variants[0][price]" placeholder="Price"
                                class="w-full rounded-xl border border-amber-200 bg-[#fff9e8] px-3 py-2.5 text-sm text-slate-800 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-100"
                                required>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <button type="button" onclick="addVariant()"
                        class="inline-flex items-center justify-center rounded-xl border border-amber-200 bg-white px-4 py-2.5 text-sm font-medium text-[#f5185a] transition hover:bg-[#fff8df]">
                        <i class="fa-solid fa-plus mr-2"></i> Add More Variant
                    </button>

                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-[#f5185a] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#d8144f]">
                        <i class="fa-solid fa-check mr-2"></i> Save Food Item
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-3xl border border-rose-100 bg-white shadow-lg shadow-rose-100/40">
        <div class="border-b border-rose-100 bg-gradient-to-r from-[#fff1c2] via-rose-50 to-white px-4 py-4">
            <h3 class="font-semibold text-slate-900">Vendor's Menu List</h3>
        </div>

        <table class="w-full text-left text-sm">
            <thead class="bg-gradient-to-r from-[#fff1c2] via-rose-50 to-white text-xs uppercase tracking-wider text-slate-900">
                <tr>
                    <th class="p-4"><i class="fa-solid fa-bowl-food mr-2"></i>Food Name</th>
                    <th class="p-4"><i class="fa-solid fa-layer-group mr-2"></i>Category</th>
                    <th class="p-4"><i class="fa-solid fa-tags mr-2"></i>Variants (Price)</th>
                    <th class="p-4 text-center"><i class="fa-solid fa-gear mr-2"></i>Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($vendor->foodItems as $food)
                    <tr class="transition duration-200 hover:bg-[#fff9e8]">
                        <td class="p-4 font-medium text-slate-900">{{ $food->name }}</td>
                        <td class="p-4">
                            <span class="inline-flex rounded-full bg-[#fff1c2] px-3 py-1 text-xs font-semibold text-slate-900">
                                {{ $food->category->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach($food->variants as $variant)
                                    <span class="inline-flex rounded-full bg-[#fff1c2] px-3 py-1 text-xs font-semibold text-slate-900">
                                        {{ $variant->name }}: Rs. {{ $variant->price }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <button class="text-slate-700 transition hover:text-[#f5185a]">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center italic text-slate-400">No food items added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    let i = 1;

    function addVariant() {
        const html = `<div class="grid grid-cols-1 gap-3 md:grid-cols-2">
            <input type="text" name="variants[${i}][name]" placeholder="Variant"
                class="w-full rounded-xl border border-amber-200 bg-[#fff9e8] px-3 py-2.5 text-sm text-slate-800 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-100">
            <input type="number" name="variants[${i}][price]" placeholder="Price"
                class="w-full rounded-xl border border-amber-200 bg-[#fff9e8] px-3 py-2.5 text-sm text-slate-800 focus:border-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-100">
        </div>`;

        document.getElementById('variants-container').insertAdjacentHTML('beforeend', html);
        i++;
    }
</script>
@endsection
