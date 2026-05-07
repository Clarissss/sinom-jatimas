<aside class="fixed left-0 top-0 h-full w-64 bg-gradient-to-b from-primary-800 to-primary-900 text-white z-40 overflow-y-auto" aria-label="Admin sidebar">
    {{-- Logo Section --}}
    <div class="p-6">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                <i class="fa-solid fa-building text-primary-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold tracking-tight">SINOM JATI MAS</h2>
                <p class="text-xs text-primary-200">Admin Portal</p>
            </div>
        </a>
    </div>
    
    {{-- Navigation --}}
    <nav class="mt-6 px-4 space-y-1" aria-label="Admin navigation">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-700 text-white shadow-md' : 'text-primary-100 hover:bg-primary-700 hover:text-white hover:shadow-sm' }}"
           aria-current="{{ request()->routeIs('admin.dashboard') ? 'page' : 'false' }}">
            <i class="fa-solid fa-grid-2 w-5 text-center"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        
        {{-- Projects --}}
        <a href="{{ route('admin.projects.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.projects.*') ? 'bg-primary-700 text-white shadow-md' : 'text-primary-100 hover:bg-primary-700 hover:text-white hover:shadow-sm' }}"
           aria-current="{{ request()->routeIs('admin.projects.*') ? 'page' : 'false' }}">
            <i class="fa-solid fa-building-user w-5 text-center"></i>
            <span class="font-medium">Proyek</span>
        </a>
        
        {{-- Daily Reports --}}
        <a href="{{ route('admin.daily-reports.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.daily-reports.*') ? 'bg-primary-700 text-white shadow-md' : 'text-primary-100 hover:bg-primary-700 hover:text-white hover:shadow-sm' }}"
           aria-current="{{ request()->routeIs('admin.daily-reports.*') ? 'page' : 'false' }}">
            <i class="fa-solid fa-clipboard-list w-5 text-center"></i>
            <span class="font-medium">Laporan Harian</span>
        </a>
        
        {{-- Documents --}}
        <a href="{{ route('admin.documents.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.documents.*') ? 'bg-primary-700 text-white shadow-md' : 'text-primary-100 hover:bg-primary-700 hover:text-white hover:shadow-sm' }}"
           aria-current="{{ request()->routeIs('admin.documents.*') ? 'page' : 'false' }}">
            <i class="fa-solid fa-file-lines w-5 text-center"></i>
            <span class="font-medium">Dokumen</span>
        </a>
        
        {{-- Invoices --}}
        <a href="{{ route('admin.invoices.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.invoices.*') ? 'bg-primary-700 text-white shadow-md' : 'text-primary-100 hover:bg-primary-700 hover:text-white hover:shadow-sm' }}"
           aria-current="{{ request()->routeIs('admin.invoices.*') ? 'page' : 'false' }}">
            <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i>
            <span class="font-medium">Invoice</span>
        </a>
        
        {{-- Users --}}
        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-primary-700 text-white shadow-md' : 'text-primary-100 hover:bg-primary-700 hover:text-white hover:shadow-sm' }}"
           aria-current="{{ request()->routeIs('admin.users.*') ? 'page' : 'false' }}">
            <i class="fa-solid fa-users w-5 text-center"></i>
            <span class="font-medium">Data Klien</span>
        </a>
        
        {{-- Activity Logs --}}
        <a href="{{ route('admin.activity-logs.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-primary-700 text-white shadow-md' : 'text-primary-100 hover:bg-primary-700 hover:text-white hover:shadow-sm' }}"
           aria-current="{{ request()->routeIs('admin.activity-logs.*') ? 'page' : 'false' }}">
            <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i>
            <span class="font-medium">Activity Log</span>
        </a>
    </nav>
    
    {{-- User Profile Section --}}
    <div class="absolute bottom-0 left-0 right-0 p-4">
        <div class="bg-primary-800/80 backdrop-blur-sm rounded-lg p-3 border border-primary-700">
            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary-400 flex-shrink-0">
                    <img src="{{ auth()->user()->photo_url }}" 
                         alt="{{ auth()->user()->name }}"
                         class="w-full h-full object-cover">
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-primary-200 truncate">{{ auth()->user()->email }}</p>
                </div>
                <i class="fa-solid fa-gear text-primary-300 group-hover:text-white transition-colors"></i>
            </a>
        </div>
    </div>
</aside>
