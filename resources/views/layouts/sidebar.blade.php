<aside class="w-64 bg-gray-900 text-white flex flex-col flex-shrink-0">

    {{-- Logo --}}
    <div class="flex items-center justify-center h-16 bg-gray-800 border-b border-gray-700">
        <span class="text-xl font-bold tracking-wide text-white">
            &#128722; POS &amp; HRM
        </span>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        {{-- POS Section --}}
        @canany(['pos.view', 'pos.create-sale', 'pos.manage-products'])
        <div class="mt-4 mb-2 px-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Point of Sale</p>
        </div>

        @can('pos.create-sale')
        <a href="{{ route('pos.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('pos.*') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            POS Terminal
        </a>
        @endcan

        @can('pos.manage-products')
        <a href="{{ route('products.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('products.*') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Products
        </a>
        @endcan

        @can('pos.manage-inventory')
        <a href="{{ route('inventory.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('inventory.*') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Inventory
        </a>
        @endcan

        @can('pos.manage-customers')
        <a href="{{ route('customers.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('customers.*') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Customers
        </a>
        @endcan

        @can('pos.reports')
        <a href="{{ route('pos.reports') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('pos.reports') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Sales Reports
        </a>
        @endcan
        @endcanany

        {{-- HRM Section --}}
        @canany(['hrm.view', 'hrm.manage-employees', 'hrm.manage-payroll'])
        <div class="mt-4 mb-2 px-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Human Resources</p>
        </div>

        @can('hrm.manage-employees')
        <a href="{{ route('employees.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('employees.*') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Employees
        </a>
        @endcan

        @can('hrm.manage-attendance')
        <a href="{{ route('attendance.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('attendance.*') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Attendance
        </a>
        @endcan

        @can('hrm.manage-leaves')
        <a href="{{ route('leaves.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('leaves.*') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Leave Management
        </a>
        @endcan

        @can('hrm.manage-payroll')
        <a href="{{ route('payroll.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('payroll.*') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Payroll
        </a>
        @endcan

        @can('hrm.reports')
        <a href="{{ route('hrm.reports') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('hrm.reports') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            HRM Reports
        </a>
        @endcan
        @endcanany

        {{-- System Section --}}
        @canany(['system.manage-users', 'system.manage-roles', 'system.settings'])
        <div class="mt-4 mb-2 px-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">System</p>
        </div>

        @can('system.manage-users')
        <a href="{{ route('users.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('users.*') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            User Management
        </a>
        @endcan

        @can('system.manage-roles')
        <a href="{{ route('roles.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('roles.*') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Roles & Permissions
        </a>
        @endcan

        @can('system.settings')
        <a href="{{ route('settings.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg mb-1 text-gray-300 hover:bg-gray-700 hover:text-white transition {{ request()->routeIs('settings.*') ? 'bg-gray-700 text-white' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Settings
        </a>
        @endcan
        @endcanany

    </nav>

    {{-- Sidebar Footer --}}
    <div class="border-t border-gray-700 p-4">
        <p class="text-xs text-gray-500 text-center">&copy; {{ date('Y') }} POS &amp; HRM</p>
    </div>

</aside>
