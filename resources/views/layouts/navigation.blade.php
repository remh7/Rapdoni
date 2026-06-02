<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    
    <!-- Primary Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between h-16">

            <!-- LEFT SIDE -->
            <div class="flex items-center">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"/>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden sm:flex sm:items-center space-x-8 sm:ms-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>
                </div>

            </div>


            <!-- RIGHT SIDE -->
            <div class="flex items-center">

                <!-- Guest Desktop Buttons -->
                @guest
                <div class="hidden sm:flex items-center gap-3">

                    <a href="{{ route('login') }}"
                       class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        ورود
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-5 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition">
                        ثبت نام
                    </a>

                </div>
                @endguest


                <!-- User Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">

                    @auth
                    <x-dropdown align="right" width="48">

                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300">

                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>

                            </button>
                        </x-slot>

                        <x-slot name="content">

                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>

                        </x-slot>

                    </x-dropdown>
                    @endauth

                </div>


                <!-- Hamburger -->
                <div class="flex items-center sm:hidden ml-3">

                    <button @click="open = !open"
                            class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">

                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">

                            <path :class="{'hidden': open, 'inline-flex': !open }"
                                  class="inline-flex"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>

                            <path :class="{'hidden': !open, 'inline-flex': open }"
                                  class="hidden"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>

                        </svg>

                    </button>

                </div>

            </div>

        </div>

    </div>


    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

        </div>


        <!-- Guest Mobile -->
        @guest
        <div class="pt-4 pb-3 border-t border-gray-200 space-y-2 px-4">

            <a href="{{ route('login') }}"
               class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-lg">
                ورود
            </a>

            <a href="{{ route('register') }}"
               class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-800 rounded-lg">
                ثبت نام
            </a>

        </div>
        @endguest


        <!-- User Mobile -->
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">

            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    {{ Auth::user()->name }}
                </div>

                <div class="font-medium text-sm text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>

                </form>

            </div>

        </div>
        @endauth

    </div>

</nav>