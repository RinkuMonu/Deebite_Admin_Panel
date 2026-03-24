@extends('admin.layout.main')
@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Category Management</h2>
        <button onclick="openModal('add')" class="bg-green-600 text-white px-4 py-2 rounded">+ Add Category</button>
    </div>

    <form class="flex gap-4 mb-6 bg-gray-50 p-4 rounded">
        <input type="text" name="name" value="{{ request('name') }}" placeholder="Search by name" class="border p-2 rounded">
        <select name="status" class="border p-2 rounded">
            <option value="">All Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Filter</button>
        <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 px-4 py-2 rounded">Clear</a>
    </form>

    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 border">Name</th>
                <th class="p-3 border">Status</th>
                <th class="p-3 border">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
            <tr>
                <td class="p-3 border">{{ $cat->name }}</td>
                <td class="p-3 border">
                    <form action="{{ route('admin.categories.toggle', $cat->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3 py-1 rounded text-white text-xs {{ $cat->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ $cat->is_active ? 'Active' : 'Inactive' }} (Toggle)
                        </button>
                    </form>
                </td>
                <td class="p-3 border flex gap-2">
                    <button onclick="openModal('edit', '{{ $cat->id }}', '{{ $cat->name }}')" class="text-blue-600">Edit</button>
                    <button onclick="viewFoodItems('{{ $cat->id }}', '{{ $cat->name }}')" class="text-indigo-600">View Items</button>
                    <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="catModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-96">
        <h3 id="modalTitle" class="text-lg font-bold mb-4">Add Category</h3>
        <form id="catForm" method="POST">
            @csrf
            <input type="text" name="name" id="catName" required class="w-full border p-2 rounded mb-4" placeholder="Category Name">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="bg-gray-200 px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<div id="itemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-2xl overflow-y-auto max-h-[80vh]">
        <h3 id="itemModalTitle" class="text-lg font-bold mb-4 border-b">Food Items</h3>
        <div id="itemList" class="space-y-4"></div>
        <button onclick="document.getElementById('itemModal').classList.add('hidden')" class="mt-4 bg-gray-200 px-4 py-2 rounded">Close</button>
    </div>
</div>

<script>
function openModal(mode, id = '', name = '') {
    const modal = document.getElementById('catModal');
    const form = document.getElementById('catForm');
    const title = document.getElementById('modalTitle');
    const input = document.getElementById('catName');

    if(mode === 'edit') {
        title.innerText = "Edit Category";
        form.action = `/admin/categories/update/${id}`;
        input.value = name;
    } else {
        title.innerText = "Add Category";
        form.action = "{{ route('admin.categories.store') }}";
        input.value = '';
    }
    modal.classList.replace('hidden', 'flex');
}

function closeModal() {
    document.getElementById('catModal').classList.replace('flex', 'hidden');
}

async function viewFoodItems(id, name) {
    document.getElementById('itemModalTitle').innerText = `Food Items in ${name}`;
    const list = document.getElementById('itemList');
    list.innerHTML = "Loading...";
    document.getElementById('itemModal').classList.replace('hidden', 'flex');

    const res = await fetch(`/admin/categories/${id}/food-items`);
    const items = await res.json();

    if(items.length === 0) {
        list.innerHTML = "<p>No food items found.</p>";
        return;
    }

    list.innerHTML = items.map(item => `
        <div class="border p-3 rounded flex justify-between">
            <div>
                <p class="font-bold">${item.name}</p>
                <p class="text-sm text-gray-500">${item.description || 'No desc'}</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-bold text-indigo-600">Variants:</p>
                ${item.variants.map(v => `<p class="text-xs">${v.name}: ₹${v.price}</p>`).join('')}
            </div>
        </div>
    `).join('');
}
</script>
@endsection