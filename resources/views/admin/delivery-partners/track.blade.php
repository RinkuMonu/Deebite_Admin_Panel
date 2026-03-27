@extends('admin.layout.main')
@section('title', 'Track ' . $partner->name)

@section('content')
<div class="rounded-3xl border border-rose-100/80 bg-gradient-to-br from-rose-50 via-[#fffdf8] to-amber-50 p-6 shadow-lg shadow-rose-100/40">
    <div class="mb-4 flex items-center justify-between border-b border-rose-100 pb-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $partner->name }}</h1>
            <p class="text-slate-500">Live Location Tracking</p>
        </div>
        <div class="text-right">
            <p class="text-xs uppercase text-slate-400">Current Status</p>
            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $partner->is_active ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-700' }}">
                {{ $partner->is_active ? 'Online' : 'Offline' }}
            </span>
        </div>
    </div>

    <div id="single-map" style="height: 450px; width: 100%;" class="rounded-3xl border border-rose-100 shadow-inner"></div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
        <div class="rounded-2xl border border-rose-100 bg-white/80 p-4 shadow-sm">
            <span class="text-xs text-slate-400 block uppercase">Contact Number</span>
            <span class="font-bold text-slate-700">{{ $partner->number }}</span>
        </div>
        <div class="rounded-2xl border border-rose-100 bg-white/80 p-4 shadow-sm">
            <span class="text-xs text-slate-400 block uppercase">Latitude</span>
            <span class="font-bold text-slate-700 font-mono">{{ $partner->latitude }}</span>
        </div>
        <div class="rounded-2xl border border-rose-100 bg-white/80 p-4 shadow-sm">
            <span class="text-xs text-slate-400 block uppercase">Longitude</span>
            <span class="font-bold text-slate-700 font-mono">{{ $partner->longitude }}</span>
        </div>
        <div class="rounded-2xl border border-amber-100 bg-amber-50/80 p-4 shadow-sm">
            <span class="block text-xs uppercase text-amber-500">Last Updated</span>
            <span class="font-bold text-amber-800">{{ $partner->updated_at->diffForHumans() }}</span>
        </div>
    </div>
</div>

<script>
    function initMap() {
        const partnerLoc = { lat: {{ $partner->latitude }}, lng: {{ $partner->longitude }} };
        const map = new google.maps.Map(document.getElementById("single-map"), {
            zoom: 18,
            center: partnerLoc,
            mapTypeId: 'roadmap'
        });

        new google.maps.Marker({
            position: partnerLoc,
            map: map,
            title: "{{ $partner->name }}",
            animation: google.maps.Animation.DROP,
            icon: {
                url: "https://maps.google.com/mapfiles/kml/shapes/motorcycling.png", 
                scaledSize: new google.maps.Size(50, 50),
                anchor: new google.maps.Point(25, 25)
            }
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDI96DcCBEOFbhGydhljmsgLnzb79s-qpM&callback=initMap"></script>
@endsection
