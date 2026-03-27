@extends('admin.layout.main')
@section('content')
<div class="rounded-3xl border border-rose-100 bg-gradient-to-br from-rose-50 via-white to-amber-50 p-6 shadow-lg shadow-rose-100/50">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-slate-900">Category Management</h2>
        <button onclick="openModal('add')" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">+ Add Category</button>
    </div>

    <form class="mb-6 flex items-center gap-3 rounded-2xl border border-rose-100 bg-white/80 p-4 shadow-sm">
        <input type="text" name="name" value="{{ request('name') }}" placeholder="Search by name" class="w-64 rounded-xl border border-rose-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-200">
        <select name="status" class="rounded-xl border border-rose-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-200">
            <option value="">All Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" class="rounded-xl bg-[#f5185a] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#d8144f]">
            <i class="fa-solid fa-filter mr-1"></i>
            Filter
        </button>
        <a href="{{ route('admin.categories.index') }}" class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200">Clear</a>
    </form>

    <div class="overflow-hidden rounded-3xl border border-rose-100 bg-white shadow-lg shadow-rose-100/40">
        <table class="w-full text-left text-sm">
            <thead class="bg-gradient-to-r from-[#fff1c2] via-rose-50 to-white text-slate-900 uppercase text-xs tracking-wider">
                <tr>
                    <th class="p-4"><i class="fa-solid fa-layer-group mr-2"></i>Name</th>
                    <th class="p-4"><i class="fa-solid fa-signal mr-2"></i>Status</th>
                    <th class="p-4 text-center"><i class="fa-solid fa-gear mr-2"></i>Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($categories as $cat)
                <tr class="transition duration-200 hover:bg-rose-50/80">
                    <td class="p-4 font-medium text-slate-900">{{ $cat->name }}</td>
                    <td class="p-4">
                        <form action="{{ route('admin.categories.toggle', $cat->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="rounded-full px-3 py-1 text-xs font-semibold {{ $cat->is_active ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-700' }}">
                                {{ $cat->is_active ? 'Active' : 'Inactive' }} (Toggle)
                            </button>
                        </form>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-4">
                            <button onclick="openModal('edit', '{{ $cat->id }}', '{{ $cat->name }}')" class="text-slate-700 transition hover:text-[#f5185a]">Edit</button>
                            <button onclick="viewFoodItems('{{ $cat->id }}', '{{ $cat->name }}')" class="text-slate-700 transition hover:text-[#f5185a]">View Items</button>
                            <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Delete?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-slate-700 transition hover:text-[#f5185a]">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="catModal" class="fixed inset-0 bg-slate-900/50 hidden items-center justify-center z-50 p-4">
    <div class="w-full max-w-md rounded-3xl border border-rose-100 bg-gradient-to-br from-rose-50 via-white to-pink-100 p-6 shadow-2xl">
        <div class="mb-5 flex items-center gap-3 border-b border-rose-100 pb-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-100 text-rose-500">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <h3 id="modalTitle" class="text-lg font-semibold text-slate-700">Add Category</h3>
        </div>
        <form id="catForm" method="POST">
            @csrf
            <input type="text" name="name" id="catName" required class="mb-4 w-full rounded-xl border border-rose-200 bg-rose-50/40 px-3 py-2.5 text-sm text-slate-800 focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-200" placeholder="Category Name">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="rounded-xl bg-rose-100 px-4 py-2 text-sm font-medium text-rose-700 transition hover:bg-rose-200">Cancel</button>
                <button type="submit" class="rounded-xl bg-rose-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-600">Save</button>
            </div>
        </form>
    </div>
</div>

<div id="itemModal" class="fixed inset-0 bg-slate-900/50 hidden items-center justify-center z-50 p-4">
    <div class="w-full max-w-2xl overflow-y-auto rounded-3xl border border-rose-100 bg-gradient-to-br from-rose-50 via-white to-pink-100 p-6 shadow-2xl max-h-[80vh]">
        <div class="mb-4 flex items-center gap-3 border-b border-rose-100 pb-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-100 text-rose-500">
                <i class="fa-solid fa-bowl-food"></i>
            </div>
            <h3 id="itemModalTitle" class="text-lg font-semibold text-slate-700">Food Items</h3>
        </div>
        <div id="itemList" class="space-y-4"></div>
        <button onclick="document.getElementById('itemModal').classList.add('hidden')" class="mt-4 rounded-xl bg-rose-100 px-4 py-2 text-sm font-medium text-rose-700 transition hover:bg-rose-200">Close</button>
    </div>
</div>

<script>
function openModal(mode, id = '', name = '') {
    const modal = document.getElementById('catModal');
    const form = document.getElementById('catForm');
    const title = document.getElementById('modalTitle');
    const input = document.getElementById('catName');

    if (mode === 'edit') {
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

    if (items.length === 0) {
        list.innerHTML = '<p class="text-sm text-slate-500">No food items found.</p>';
        return;
    }

    list.innerHTML = items.map(item => `
        <div class="flex justify-between rounded-2xl border border-rose-100 bg-white/90 p-4 shadow-sm">
            <div>
                <p class="font-semibold text-slate-900">${item.name}</p>
                <p class="text-sm text-slate-500">${item.description || 'No desc'}</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-semibold uppercase tracking-wide text-rose-500">Variants</p>
                ${item.variants.map(v => `<p class="text-xs text-slate-700">${v.name}: Rs. ${v.price}</p>`).join('')}
            </div>
        </div>
    `).join('');
}
</script>
@endsection
