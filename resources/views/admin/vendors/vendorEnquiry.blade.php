@extends('admin.layout.main')
@section('title', 'Vendor Enquiries')
@section('page-title', 'Vendor Enquiry List')

@section('content')
<<<<<<< HEAD

<div class="overflow-x-auto rounded-lg border border-gray-700 shadow-md mt-4">
=======
 <div class="rounded-xl border bg-white p-6 shadow-lg shadow-rose-100/40">
        <form action="{{ route('admin.users') }}" method="GET"
            class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
            <h2 class="text-lg font-semibold text-slate-900">
                Vendor Enquiry List
            </h2>

            <div class="flex flex-col gap-3 md:flex-row md:items-center">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name or email..." class="w-full rounded-xl border border-rose-200 bg-white px-3 py-2 text-sm text-slate-700 md:w-64
                        focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-200">

                <select name="status" class="w-full rounded-xl border border-rose-200 bg-white px-3 py-2 text-sm text-slate-700 md:w-44
                        focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-200">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit"
                    class="rounded-xl bg-[#f5185a] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#d8144f]">
                    <i class="fa-solid fa-filter mr-1"></i> Filter
                </button>

                <a href="{{ route('admin.users') }}"
                    class="rounded-xl border border-rose-200 bg-white px-4 py-2 text-center text-sm font-medium text-slate-700 transition hover:bg-rose-50">
                    <i class="fa-solid fa-rotate-left mr-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
<div class="overflow-x-auto shadow-md mt-4">
>>>>>>> d3ff0323c2d2d45cbb0f2595ab8daa1ed0c0e77e

    {{-- Session Error Message --}}
    @if(session('error'))
        <div class="bg-red-500 text-white p-2 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 mb-4 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

   <div class="rounded-xl overflow-hidden border border-rose-200 bg-rose-200 shadow-lg shadow-rose-100/40">

    <table class="w-full text-sm text-left">

        <!-- Header -->
        <thead class="bg-rose-200 text-slate-900 uppercase text-xs tracking-wider">
            <tr>
                <th class="p-4">#</th>
                <th class="p-4"><i class="fa-regular fa-user mr-2"></i>Name</th>
                <th class="p-4"><i class="fa-solid fa-phone mr-2"></i>Mobile</th>
                <th class="p-4"><i class="fa-regular fa-envelope mr-2"></i>Email</th>
                <th class="p-4"><i class="fa-regular fa-clock mr-2"></i>Created</th>
                <th class="p-4 text-center"><i class="fa-solid fa-gear mr-2"></i>Action</th>
            </tr>
        </thead>

        <!-- Body -->
        <tbody class="divide-y divide-rose-200 bg-white">

            @forelse($enquiries as $enquiry)
            <tr class="transition duration-200 hover:bg-rose-50">

                <!-- Index -->
                <td class="p-4 font-medium text-slate-900">
                    {{ $loop->iteration + ($enquiries->currentPage() - 1) * $enquiries->perPage() }}
                </td>

                <!-- Name -->
                <td class="p-4 text-slate-900 font-medium">
                    {{ $enquiry->name }}
                </td>

                <!-- Mobile -->
                <td class="p-4 text-slate-600">
                    {{ $enquiry->mobile }}
                </td>

                <!-- Email -->
                <td class="p-4 text-slate-600">
                    {{ $enquiry->email ?? '-' }}
                </td>

                <!-- Date -->
                <td class="p-4 text-xs text-slate-500 font-mono">
                    {{ $enquiry->created_at->format('d M Y, H:i') }}
                </td>

                <!-- Action -->
                <td class="p-4 text-center">

                    <form action="{{ route('admin.enquiry.destroy') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this enquiry?');">
                        @csrf
                        @method('DELETE')

                        <input type="hidden" name="enquiry_id" value="{{ $enquiry->id }}">

                        <button type="submit"
                            class="text-slate-700 transition hover:text-[#f5185a]"
                            title="Delete">
                            <i class="fa-regular fa-trash-can text-lg"></i>
                        </button>
                    </form>

                </td>

            </tr>

            @empty
            <tr>
                <td colspan="6" class="p-4 text-center text-slate-500">
                    No vendor enquiries found.
                </td>
            </tr>
            @endforelse

        </tbody>

    </table>

<<<<<<< HEAD
    <div class="mt-4">
        {{ $enquiries->links() }}
    </div>

=======
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $enquiries->links() }}
</div>
>>>>>>> d3ff0323c2d2d45cbb0f2595ab8daa1ed0c0e77e

</div>

@endsection