@extends('admin.layout.main')
@section('content')

<div class="p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded shadow-sm border">
            <div class="text-center mb-4">
                <img src="{{ $vendor->vendorDetail->profile_photo }}" class="w-32 h-32 rounded-full mx-auto border shadow-sm object-cover">
                <h2 class="text-xl font-bold mt-2">{{ $vendor->vendorDetail->shop_name ?? 'N/A' }}</h2>
                <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded">Vendor ID: #{{ $vendor->id }}</span>
            </div>
            <hr class="my-4">
            
            <div class="space-y-2 text-sm">
                <p><strong>Owner:</strong> {{ $vendor->name }}</p>
                <p><strong>Contact:</strong> {{ $vendor->number }}</p>
                <p><strong>FSSAI:</strong> {{ $vendor->vendorDetail->fssai_number ?? 'N/A' }}</p>
                <p><strong>Doc Type:</strong> {{ $vendor->vendorDetail->document_type }}</p>
                <a href="{{ $vendor->vendorDetail->document_file }}" target="_blank" class="text-blue-600 underline block mt-2">View Document File</a>
            </div>
        </div>

        <div class="md:col-span-2 bg-white p-6 rounded shadow-sm border" x-data="{ count: 1 }">
            <h3 class="font-bold mb-4 text-lg border-b pb-2">Add New Food Item</h3>
            <form action="{{ route('admin.food.store') }}" method="POST">
                @csrf
                <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-xs font-bold uppercase text-gray-500">Category</label>
                        <select name="category_id" class="w-full border p-2 rounded focus:ring-2 focus:ring-indigo-400 outline-none">
                            @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase text-gray-500">Food Name</label>
                        <input type="text" name="name" placeholder="E.g. Paneer Tikka" class="w-full border p-2 rounded focus:ring-2 focus:ring-indigo-400 outline-none" required>
                    </div>
                </div>

                <label class="text-xs font-bold uppercase text-gray-500">Variants & Pricing</label>
                <div id="variants-container" class="mt-1">
                    <div class="flex gap-2 mb-2">
                        <input type="text" name="variants[0][name]" placeholder="Variant (Half/Full)" class="border p-2 w-1/2 rounded" required>
                        <input type="number" name="variants[0][price]" placeholder="Price" class="border p-2 w-1/2 rounded" required>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-4">
                    <button type="button" onclick="addVariant()" class="text-indigo-600 font-medium text-sm hover:underline">+ Add more variant</button>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded font-bold shadow-md hover:bg-green-700">Save Food Item</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-8 bg-white rounded shadow-sm border">
        <div class="p-4 border-b bg-gray-50">
            <h3 class="font-bold">Vendor's Menu List</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-sm uppercase text-gray-600">
                    <th class="p-4">Food Name</th>
                    <th class="p-4">Category</th>
                    <th class="p-4">Variants (Price)</th>
                    <th class="p-4">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($vendor->foodItems as $food)
                <tr>
                    <td class="p-4 font-medium">{{ $food->name }}</td>
                    <td class="p-4 text-sm text-gray-600">{{ $food->category->name ?? 'N/A' }}</td>
                    <td class="p-4 text-sm">
                        @foreach($food->variants as $variant)
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 mr-2 mb-1">
                                {{ $variant->name }}: ₹{{ $variant->price }}
                            </span>
                        @endforeach
                    </td>
                    <td class="p-4">
                        <button class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i> Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-400 italic">No food items added yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    let i = 1;
    function addVariant() {
        let html = `<div class="flex gap-2 mb-2 animate-in fade-in duration-300">
            <input type="text" name="variants[${i}][name]" placeholder="Variant" class="border p-2 w-1/2 rounded">
            <input type="number" name="variants[${i}][price]" placeholder="Price" class="border p-2 w-1/2 rounded">
        </div>`;
        document.getElementById('variants-container').insertAdjacentHTML('beforeend', html);
        i++;
    }
</script>
@endsection