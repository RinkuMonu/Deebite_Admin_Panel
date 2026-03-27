@extends('admin.layout.main')
@section('title', 'Global Delivery Tracking')

@section('content')
<div class="rounded-3xl border border-rose-100/80 bg-gradient-to-br from-rose-50 via-[#fffdf8] to-amber-50 p-4 shadow-lg shadow-rose-100/40">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-slate-900">Live Delivery Network (All Partners)</h2>
        <a href="{{ route('admin.delivery-partners') }}" class="text-sm font-bold text-[#f5185a] transition hover:text-slate-900">&larr; Back to List</a>
    </div>

    <div id="global-map" style="height: 600px; width: 100%;" class="rounded-3xl border border-rose-100 shadow-inner"></div>
</div>

<script>
    function initMap() {
        const partners = @json($partners);
        
        // Agar koi partner nahi hai toh default Jaipur dikhao, warna pehle partner ki location par center karo
        const defaultCenter = partners.length > 0 
            ? { lat: parseFloat(partners[0].latitude), lng: parseFloat(partners[0].longitude) }
            : { lat: 26.9124, lng: 75.7873 };

        const map = new google.maps.Map(document.getElementById("global-map"), {
            zoom: 13, // Global view ke liye 13-14 zoom sahi rehta hai
            center: defaultCenter,
        });

        const infoWindow = new google.maps.InfoWindow();

        partners.forEach(partner => {
            // Sahi Icon URLs: Online ke liye Green aur Offline ke liye Red Marker
            const iconUrl = partner.is_active 
                ? "http://maps.google.com/mapfiles/ms/icons/green-dot.png" 
                : "http://maps.google.com/mapfiles/ms/icons/red-dot.png";

            const marker = new google.maps.Marker({
                position: { lat: parseFloat(partner.latitude), lng: parseFloat(partner.longitude) },
                map: map,
                title: partner.name,
                icon: {
                    url: iconUrl,
                    scaledSize: new google.maps.Size(40, 40) // Size set karna zaroori hai
                }
            });

            marker.addListener("click", () => {
                infoWindow.setContent(`
                    <div style="padding:10px; line-height:1.6;">
                        <b style="font-size:16px; color:#F5185A;">${partner.name}</b><br>
                        <b>Phone:</b> ${partner.number || 'N/A'}<br>
                        <b>Status:</b> <span style="color: ${partner.is_active ? '#92400E' : '#BE123C'}">${partner.is_active ? 'Online' : 'Offline'}</span><br>
                        <hr style="margin: 5px 0;">
                        <a href="/admin/delivery-partners/${partner.id}/track" 
                        style="display:inline-block; margin-top:5px; background:#F5185A; color:white; padding:4px 8px; border-radius:4px; text-decoration:none; font-size:12px;">
                        Track Live
                        </a>
                    </div>
                `);
                infoWindow.open(map, marker);
            });
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDI96DcCBEOFbhGydhljmsgLnzb79s-qpM&callback=initMap"></script>
@endsection
