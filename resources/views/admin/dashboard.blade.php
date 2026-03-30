@extends('admin.layout.main')

@section('title', 'Dashboard')
@section('page-title', 'Overview')

@section('content')

<div
    class="flex items-center justify-between mb-6 p-4 rounded-xl bg-gradient-to-r from-white to-gray-50 border border-gray-100 shadow-sm">

    <!-- Left -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
            Dashboard
        </h1>

        <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
            <span>Hello,</span>
            <span class="font-semibold text-gray-800">Super Admin</span>
            <span class="text-lg">👋</span>
        </p>
    </div>

    <!-- Right -->
    <div class="flex items-center gap-3 bg-gray-100 px-4 py-2 rounded-lg">
        <i class="fa-regular fa-calendar text-gray-500"></i>
        <span class="text-sm font-medium text-gray-700">
            {{ \Carbon\Carbon::now()->format('l, d M Y') }}
        </span>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<style>
.progress-circle {
    background: conic-gradient(#e5e7eb 0%, #e5e7eb 100%);
}
</style>

<div class="grid grid-cols-4 gap-6 mb-6">

    <!-- Card 1 -->
    <div
        class="bg-gradient-to-br from-gray-50 to-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition flex items-center justify-between">
        <div>
            <p class="text-xs text-gray-500 tracking-wide font-medium">Total Menu</p>
            <div class="flex items-center gap-2 mt-1">
                <h3 class="text-2xl font-semibold text-gray-900 tracking-tight">325</h3>
                <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-600 font-medium">+12%</span>
            </div>
        </div>
        <div class="w-14 h-14 rounded-full flex items-center justify-center relative progress-circle" data-percent="75">
            <div
                class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-xs font-semibold text-gray-600">
                <span class="percent-text">0%</span>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div
        class="bg-gradient-to-br from-gray-50 to-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition flex items-center justify-between">
        <div>
            <p class="text-xs text-gray-500 tracking-wide font-medium">Total Revenue</p>
            <div class="flex items-center gap-2 mt-1">
                <h3 class="text-2xl font-semibold text-gray-900 tracking-tight">$425k</h3>
                <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-600 font-medium">+8%</span>
            </div>
        </div>
        <div class="w-14 h-14 rounded-full flex items-center justify-center relative progress-circle" data-percent="60">
            <div
                class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-xs font-semibold text-gray-600">
                <span class="percent-text">0%</span>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div
        class="bg-gradient-to-br from-gray-50 to-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition flex items-center justify-between">
        <div>
            <p class="text-xs text-gray-500 tracking-wide font-medium">Total Orders</p>
            <div class="flex items-center gap-2 mt-1">
                <h3 class="text-2xl font-semibold text-gray-900 tracking-tight">415</h3>
                <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-600 font-medium">-5%</span>
            </div>
        </div>
        <div class="w-14 h-14 rounded-full flex items-center justify-center relative progress-circle" data-percent="45">
            <div
                class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-xs font-semibold text-gray-600">
                <span class="percent-text">0%</span>
            </div>
        </div>
    </div>

    <!-- Card 4 -->
    <div
        class="bg-gradient-to-br from-gray-50 to-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition flex items-center justify-between">
        <div>
            <p class="text-xs text-gray-500 tracking-wide font-medium">Total Customers</p>
            <div class="flex items-center gap-2 mt-1">
                <h3 class="text-2xl font-semibold text-gray-900 tracking-tight">985</h3>
                <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-600 font-medium">+18%</span>
            </div>
        </div>
        <div class="w-14 h-14 rounded-full flex items-center justify-center relative progress-circle" data-percent="80">
            <div
                class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-xs font-semibold text-gray-600">
                <span class="percent-text">0%</span>
            </div>
        </div>
    </div>

</div>


<div class="grid grid-cols-12 gap-6 mt-6">

    <div class="col-span-8 bg-white rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Order & Sales Chart</h2>
                <p class="text-xs text-gray-500">Last 7 days orders, sales, and new customers.</p>
            </div>
            <span class="text-xs bg-gray-100 px-3 py-1 rounded-full">Last 7 Days</span>
        </div>

        <div id="mainChart" class="h-64"></div>

        

    <!-- RECENT CUSTOMERS -->
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


    </div>



    <div class="col-span-4 bg-white rounded-xl p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-800">Popular Food Categories</h2>
        <p class="text-xs text-gray-500 mb-4">Top categories by total food items.</p>

        <div class="grid grid-cols-1 gap-4">

            <!-- Card 1 -->
            <div class="bg-gray-50 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                <img src="https://img.freepik.com/free-photo/view-delicious-food-sold-streets-city_23-2151516947.jpg?semt=ais_hybrid&w=740&q=80"
                    class="w-full h-28 object-cover">

                <div class="p-3">
                    <p class="text-sm font-semibold text-gray-800">Fresh Momos </p>
                    <div class="flex items-center justify-between mt-2 text-xs text-gray-500">
                        <span>⭐ 4.8 • 120 reviews</span>
                        <span class="text-orange-500 font-semibold">$12.50</span>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-gray-50 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                <img src="https://images.unsplash.com/photo-1604908176997-125f25cc6f3d"
                    class="w-full h-28 object-cover">

                <div class="p-3">
                    <p class="text-sm font-semibold text-gray-800">Sunny Citrus Cake</p>
                    <div class="flex items-center justify-between mt-2 text-xs text-gray-500">
                        <span>⭐ 4.6 • 95 reviews</span>
                        <span class="text-orange-500 font-semibold">$8.20</span>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-gray-50 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                <img
                    src="https://img.freepik.com/premium-photo/bustling-indian-street-food-stall_167857-77039.jpg?semt=ais_incoming&w=740&q=80">

                <div class="p-3">
                    <p class="text-sm font-semibold text-gray-800">Samosa Delight</p>
                    <div class="flex items-center justify-between mt-2 text-xs text-gray-500">
                        <span>⭐ 4.7 • 80 reviews</span>
                        <span class="text-orange-500 font-semibold">$6.75</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>


<script>
// circle animation (unchanged)
const colors = ["#6366f1", "#22c55e", "#f59e0b", "#ef4444"];

document.querySelectorAll(".progress-circle").forEach((circle, index) => {
    let percent = parseInt(circle.getAttribute("data-percent"));
    let current = 0;
    let text = circle.querySelector(".percent-text");
    let color = colors[index];

    let interval = setInterval(() => {
        if (current >= percent) clearInterval(interval);
        current++;
        circle.style.background = `conic-gradient(${color} ${current}%, #e5e7eb ${current}%)`;
        text.innerText = current + "%";
    }, 15);
});


// ✅ APEX CHART (fixed)
var options = {
    chart: {
        type: 'area',
        height: 260,
        toolbar: {
            show: false
        }
    },

    series: [{
            name: "Orders",
            data: [18, 24, 20, 29, 26, 31, 23]
        },
        {
            name: "Sales",
            data: [23, 18, 27, 22, 32, 24, 34]
        },
        {
            name: "Customers",
            data: [15, 15, 15, 15, 25, 15, 15]
        }
    ],

    colors: ["#6366f1", "#f59e0b", "#22c55e"],

    stroke: {
        curve: 'smooth',
        width: 3
    },

    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.3,
            opacityTo: 0.05
        }
    },

    dataLabels: {
        enabled: false
    },

    grid: {
        borderColor: "#eee",
        strokeDashArray: 4
    },

    xaxis: {
        categories: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]
    },

    legend: {
        position: "top",
        horizontalAlign: "left"
    }
};

new ApexCharts(document.querySelector("#mainChart"), options).render();
</script>

@endsection