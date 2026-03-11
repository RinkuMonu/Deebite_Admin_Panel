@extends('admin.layout.main')
@section('title', 'User Feedback')
@section('page-title', 'Customer Feedback List')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 border-b">
            <tr>
                <th class="p-4">User Name</th>
                <th class="p-4">Mobile Number</th>
                <th class="p-4">Feedback Message</th>
                <th class="p-4">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($feedbacks as $item)
            <tr class="hover:bg-slate-50">
                <td class="p-4">{{ $item->name }}</td>
                <td class="p-4 font-mono">{{ $item->number }}</td>
                <td class="p-4 text-slate-600 italic">"{{ $item->feedback }}"</td>
                <td class="p-4 text-sm text-slate-400">
                    {{ $item->created_at->format('d M, Y') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-8 text-center text-slate-500">No feedback received yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-6">
        {{ $feedbacks->links() }}
    </div>
</div>
@endsection