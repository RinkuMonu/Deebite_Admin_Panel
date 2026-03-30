@extends('admin.layout.main')

@section('title', 'Admin Insights')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<div class="p-6 space-y-8 bg-gray-50/50 min-h-screen">
    <!-- welcome header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard Overview</h1>
            <p class="text-gray-500 mt-1">Welcome back, <span class="text-blue-500 font-semibold">Super Admin</span>.
                Here is your business at a glance.</p>
        </div>
        <div class="flex items-center gap-3">
            <button
                class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
               <i class="fa-regular fa-calendar"></i>
                Mar 30, 2026
            </button>
            <button
                class="px-4 py-2 bg-rose-400 text-white rounded-lg shadow-md shadow-rose-500 hover:bg-rose-500 transition text-sm font-medium">
                Download Report
            </button>
        </div>
    </div>

    <!-- stats cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

<div class="group bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 flex justify-between items-center ring-2 ring-transparent hover:ring-blue-500 cursor-default">
    <div>
        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Revenue</p>
        <h2 class="text-2xl font-black text-gray-800 mt-1">₹41,234</h2>
        <div class="flex items-center gap-1 mt-1">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
            </span>
            <span class="text-[10px] text-green-500 font-bold">+12.5% vs last month</span>
        </div>
    </div>
    <div class="w-16 h-16 rounded-2xl bg-green-50 flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition duration-300">
        <img src="{{ asset('images/backgrounds/coins.png') }}" class="w-13 h-13 object-contain" alt="Revenue">
    </div>
</div>

<div class="group bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 flex justify-between items-center ring-2 ring-transparent hover:ring-blue-500 cursor-default">
    <div>
        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Orders</p>
        <h2 class="text-2xl font-black text-gray-800 mt-1">1,204</h2>
        <div class="flex items-center gap-1 mt-1">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
            </span>
            <span class="text-[10px] text-blue-500 font-bold">48 new today</span>
        </div>
    </div>
    <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center group-hover:scale-110 group-hover:-rotate-6 transition duration-300">
        <img src="{{ asset('images/backgrounds/totalOrdes.png') }}" class="w-13 h-13 object-contain" alt="Orders">
    </div>
</div>

        <div
            class="group bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 flex justify-between items-center ring-2 ring-transparent hover:ring-blue-500">
            <div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Active Customers</p>
                <h2 class="text-2xl font-black text-gray-800 mt-1">540</h2>
                <div class="flex items-center gap-1 mt-1">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    <span class="text-[10px] text-purple-500 font-bold">82% retention rate</span>
                </div>
            </div>

            <div class="relative">
                <div
                    class="w-16 h-16 rounded-2xl bg-purple-50 flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition duration-300">
                    <img src="{{ asset('images/backgrounds/vendor.png') }}" class="w-12 h-12 object-contain"
                        alt="Customers">
                </div>

                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                </span>
            </div>
        </div>

        <div
            class="group bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 flex justify-between items-center ring-2 ring-transparent hover:ring-blue-500">
            <div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Active Riders</p>
                <h2 class="text-2xl font-black text-gray-800 mt-1">28</h2>
                <div class="flex items-center gap-1 mt-1">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-[10px] text-gray-400 font-medium">12 currently on delivery</span>
                </div>
            </div>
            <div class="relative">
                <div
                    class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center group-hover:rotate-6 transition duration-300">
                    <img src="{{ asset('images/backgrounds/rider.png') }}" class="w-12 h-12 object-contain" alt="Rider">
                </div>
                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                </span>
            </div>
        </div>

</div>

    <!-- Charts -->

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">Revenue Analytics</h3>
                <select class="text-sm border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option>Last 7 Days</option>
                    <option>Last 30 Days</option>
                </select>
            </div>
            <div id="revenueChart" class="min-h-75"></div>
        </div>
        <!-- Order distribution -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Order Distribution</h3>

            <div id="distributionChart" class="w-full min-h-75"></div>

            <div class="mt-4 space-y-3">
                <div class="flex justify-between text-sm text-gray-600">
                    <span class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                        Delivery
                    </span>
                    <span class="font-bold">65%</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-400"></span>
                        Dine-in
                    </span>
                    <span class="font-bold">25%</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-gray-200"></span>
                        Cancelled
                    </span>
                    <span class="font-bold">10%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Customers -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Top Customers</h3>
                <a href="#" class="text-sm text-rose-400 font-semibold hover:text-rose-600">View Report</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50/50">
                        <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Total Orders</th>
                            <th class="px-6 py-4 text-right">Spent</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <!-- Row 1 -->
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                                        RS</div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">Rahul Sharma</div>
                                        <div class="text-xs text-gray-500">rahul@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">VIP</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">42 Orders</td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900">₹8,420</td>
                        </tr>
                        <!-- Row 2 -->
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold">
                                        AV</div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">Anjali Verma</div>
                                        <div class="text-xs text-gray-500">anjali.v@gmail.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">Regular</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">18 Orders</td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900">₹3,250</td>
                        </tr>
                        <!-- Row 3 -->
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-bold">
                                        VS</div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">Vikram Singh</div>
                                        <div class="text-xs text-gray-500">vikram.s@outlook.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">VIP</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">35 Orders</td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900">₹6,180</td>
                        </tr>
                        <!-- Row 4 -->
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold">
                                        PD</div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">Priya Das</div>
                                        <div class="text-xs text-gray-500">priyadas@live.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full">New</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">2 Orders</td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900">₹450</td>
                        </tr>
                        <!-- Row 5 -->
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                                        SK</div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">Sameer Khan</div>
                                        <div class="text-xs text-gray-500">skhan@techmail.in</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">Regular</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">12 Orders</td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900">₹2,100</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Trending items -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">Trending Items</h3>
                <button
                    class="text-xs font-semibold text-rose-600 bg-rose-50 px-3 py-1 rounded-full hover:bg-rose-100 transition">
                    View Analytics
                </button>
            </div>

            <div class="grid grid-cols-2 gap-4">
                @php
                // Map the items 
                $trendingItems = [
                ['name' => 'Pizza', 'price' => '299', 'file' => 'pizza.png', 'sales' => '24'],
                ['name' => 'Burger', 'price' => '150', 'file' => 'burger.png', 'sales' => '18'],
                ['name' => 'GolGappe', 'price' => '60', 'file' => 'golgappe.png', 'sales' => '56'],
                ['name' => 'Paties', 'price' => '40', 'file' => 'paties.png', 'sales' => '32'],
                ];
                @endphp

                @foreach($trendingItems as $food)
                <div
                    class="group relative overflow-hidden rounded-xl border border-gray-100 hover:border-blue-300 hover:shadow-md transition-all duration-300">
                    <div class="relative h-32 overflow-hidden bg-gray-50">
                        <img src="{{ asset('images/backgrounds/' . $food['file']) }}" alt="{{ $food['name'] }}"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <span
                                class="px-3 py-1 bg-white/90 backdrop-blur text-[10px] font-bold rounded-lg shadow-sm cursor-pointer">EDIT
                                ITEM</span>
                        </div>
                    </div>

                    <div class="p-3 bg-white">
                        <div class="flex justify-between items-start">
                            <h4 class="font-bold text-gray-800 text-sm tracking-tight">{{ $food['name'] }}</h4>
                            <span class="text-[10px] font-bold text-green-600">
                                <i class="fas fa-arrow-up mr-1"></i>{{ $food['sales'] }}%
                            </span>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-blue-600 font-extrabold text-sm">₹{{ $food['price'] }}</span>
                            <span class="text-[10px] text-gray-400 font-medium italic">Today</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



<script>
document.addEventListener("DOMContentLoaded", function() {

    // 1. REVENUE ANALYTICS (The one currently working)
    var revenueOptions = {
        series: [{
            name: 'Revenue',
            data: [31000, 40000, 28000, 51000, 42000, 109000, 100000]
        }],
        chart: {
            type: 'area',
            height: 300,
            toolbar: {
                show: false
            }
        },
        colors: ['#2563eb'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.2
            }
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        xaxis: {
            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        }
    };
    var revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueOptions);
    revenueChart.render();

    // 2. ORDER DISTRIBUTION 
    var distOptions = {
        series: [65, 25, 10], 
        chart: {
            type: 'donut',
            height: 280, 
        },
        labels: ['Delivery', 'Dine-in', 'Cancelled'],
        colors: ['#3b82f6', '#fb7185', '#e2e8f0'],
        legend: {
            show: false 
        },
        dataLabels: {
            enabled: false
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '75%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            formatter: function(w) {
                                return '1,204'
                            }
                        }
                    }
                }
            }
        }
    };
    var distributionChart = new ApexCharts(document.querySelector("#distributionChart"), distOptions);
    distributionChart.render();
});
</script>
@endsection