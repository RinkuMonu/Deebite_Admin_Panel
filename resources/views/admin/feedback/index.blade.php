@extends('admin.layout.main')
@section('title', 'User Feedback')
@section('page-title', 'Customer Feedback List')

@section('content')
<div class="space-y-6">
    <div class="rounded-xl border bg-white p-6 shadow-lg shadow-rose-100/40">
        <h2 class="text-lg font-semibold text-slate-900">Customer Feedback</h2>
    </div>

    <div class="rounded-xl overflow-hidden border border-rose-200 bg-rose-200 shadow-lg shadow-rose-100/30">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">
                <thead class="bg-rose-200 text-xs uppercase tracking-wider text-slate-900">
                    <tr>
                        <th class="p-4">User Name</th>
                        <th class="p-4">Mobile Number</th>
                        <th class="p-4">Feedback Message</th>
                        <th class="p-4">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rose-200 bg-white">
                    @forelse($feedbacks as $item)
                    <tr class="transition duration-200 hover:bg-rose-50">
                        <td class="p-4 font-medium text-slate-900">{{ $item->name }}</td>
                        <td class="p-4 font-mono text-slate-600">{{ $item->number }}</td>
                        <td class="p-4 italic text-slate-600">"{{ $item->feedback }}"</td>
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
        </div>
    </div>

    <div class="mt-6">
        {{ $feedbacks->links() }}
    </div>
</div>
@endsection
