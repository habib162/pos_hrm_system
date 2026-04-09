<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0">

    {{-- Page Title --}}
    <div>
        <h1 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
    </div>

    {{-- Right Side --}}
    <div class="flex items-center gap-4">

        {{-- Role Badge --}}
        @auth
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
            @if(auth()->user()->hasRole('super-admin')) bg-purple-100 text-purple-800
            @elseif(auth()->user()->hasRole('manager')) bg-blue-100 text-blue-800
            @elseif(auth()->user()->hasRole('cashier')) bg-green-100 text-green-800
            @elseif(auth()->user()->hasRole('hr-manager')) bg-yellow-100 text-yellow-800
            @elseif(auth()->user()->hasRole('employee')) bg-gray-100 text-gray-800
            @else bg-gray-100 text-gray-600
            @endif">
            {{ ucfirst(str_replace('-', ' ', auth()->user()->getRoleNames()->first() ?? 'No Role')) }}
        </span>
        @endauth

        {{-- User Dropdown --}}
        @auth
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                    class="flex items-center gap-2 text-gray-700 hover:text-gray-900 focus:outline-none">
                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open"
                 @click.away="open = false"
                 x-transition
                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                <div class="px-4 py-2 border-b border-gray-100">
                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
        @endauth

    </div>

</header>
