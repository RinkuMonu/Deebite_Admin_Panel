@extends('admin.layout.main')
@section('title', 'User Feedback')
@section('page-title', 'Customer Feedback List')

@section('content')
<div class="rounded-3xl border border-rose-100/80 bg-gradient-to-br from-rose-50 via-[#fffdf8] to-amber-50 p-6 shadow-lg shadow-rose-100/40">
    <div class="overflow-hidden rounded-3xl border border-rose-100 bg-gradient-to-br from-[#fff6f8] via-white to-[#fff8e8] shadow-lg shadow-rose-100/30">
    <div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gradient-to-r from-[#fde9a9] via-[#fff3f6] to-white text-slate-900 uppercase text-xs tracking-wider">
            <tr>
                <th class="p-4">User Name</th>
                <th class="p-4">Mobile Number</th>
                <th class="p-4">Feedback Message</th>
                <th class="p-4">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-rose-100/70 bg-white/70">
            @forelse($feedbacks as $item)
            <tr class="transition duration-200 hover:bg-gradient-to-r hover:from-[#fff4cf] hover:via-rose-50/70 hover:to-white">
                <td class="p-4 font-medium text-slate-900">{{ $item->name }}</td>
                <td class="p-4 font-mono text-slate-600">{{ $item->number }}</td>
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
    </div>
    </div>

    <div class="mt-6">
        {{ $feedbacks->links() }}
    </div>
</div>
@endsection
