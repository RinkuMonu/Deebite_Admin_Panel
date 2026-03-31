@extends('admin.layout.main')
@section('title', 'Vendor Enquiries')
@section('page-title', 'Vendor Enquiry List')

@section('content')

<div class="overflow-x-auto rounded-lg border border-gray-700 shadow-md mt-4">

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

    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Mobile</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Created At</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Action</th>
            </tr>
        </thead>
        <tbody class="bg-gray-900 divide-y divide-gray-700">
            @forelse($enquiries as $enquiry)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                        {{ $loop->iteration + ($enquiries->currentPage() - 1) * $enquiries->perPage() }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $enquiry->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $enquiry->mobile }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $enquiry->email ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                        {{ $enquiry->created_at->format('d M Y, H:i') }}
                    </td>
                    <td>
                        <form action="{{ route('admin.enquiry.destroy') }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this enquiry?');">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="enquiry_id" value="{{ $enquiry->id }}">
                            
                            <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-400">
                        No vendor enquiries found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $enquiries->links() }}
    </div>


</div>

@endsection