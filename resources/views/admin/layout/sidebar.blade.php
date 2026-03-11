<aside class="w-64 bg-slate-800 text-white min-h-screen p-4">
    <h2 class="text-xl font-bold mb-6 text-center text-indigo-400">Admin Panel</h2>
    
    <nav class="space-y-2">
        <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded hover:bg-slate-700 transition">
            <i class="fa-solid fa-gauge mr-2"></i> Dashboard
        </a>
        <a href="#" class="block py-2.5 px-4 rounded hover:bg-slate-700 transition">
            <i class="fa-solid fa-users mr-2"></i> Users
        </a>
        <a href="#" class="block py-2.5 px-4 rounded hover:bg-slate-700 transition">
            <i class="fa-solid fa-store mr-2"></i> Vendors
        </a>
        <a href="#" class="block py-2.5 px-4 rounded hover:bg-slate-700 transition">
            <i class="fa-solid fa-truck mr-2"></i> Delivery Partners
        </a>
        
        <hr class="my-4 border-slate-700">
        
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full text-left py-2.5 px-4 rounded hover:bg-red-600 transition text-red-400 hover:text-white">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
            </button>
        </form>
    </nav>
</aside>