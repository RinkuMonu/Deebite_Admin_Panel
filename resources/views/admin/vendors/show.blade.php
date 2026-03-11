@extends('admin.layout.main')
@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold">Shop: {{ $vendor->vendorDetail->shop_name ?? 'N/A' }}</h2>
        <h3 class="text-slate-500">Owner: {{ $vendor->name }}</h3>
    </div>

    <div class="bg-white p-6 rounded shadow" x-data="{ count: 1 }">
        <h3 class="font-bold mb-4">Add New Food Item</h3>
        <form action="{{ route('admin.food.store') }}" method="POST">
            @csrf
            <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
            
            <select name="category_id" class="w-full border p-2 mb-3">
                @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
            </select>
            
            <input type="text" name="name" placeholder="Food Name" class="w-full border p-2 mb-3" required>

            <div id="variants-container">
                <div class="flex gap-2 mb-2">
                    <input type="text" name="variants[0][name]" placeholder="Variant (e.g. Half)" class="border p-2 w-1/2">
                    <input type="number" name="variants[0][price]" placeholder="Price" class="border p-2 w-1/2">
                </div>
            </div>
            
            <button type="button" onclick="addVariant()" class="text-blue-600 text-sm mb-4">+ Add more variant</button>
            <button type="submit" class="w-full bg-green-600 text-white p-2 rounded">Save Food Item</button>
        </form>
    </div>
</div>

<script>
    let i = 1;
    function addVariant() {
        let html = `<div class="flex gap-2 mb-2">
            <input type="text" name="variants[${i}][name]" placeholder="Variant" class="border p-2 w-1/2">
            <input type="number" name="variants[${i}][price]" placeholder="Price" class="border p-2 w-1/2">
        </div>`;
        document.getElementById('variants-container').insertAdjacentHTML('beforeend', html);
        i++;
    }
</script>
@endsection