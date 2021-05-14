<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    @guest
        <script>
            window.isLogin = "0"
        </script>
    @else
        <script>
            window.isLogin = "{{Auth::user()->id }}"
        </script>
    @endguest
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('shop') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('shop')" :active="request()->routeIs('shop')">
                        {{ __('Обзор') }}
                    </x-nav-link>
                    <x-nav-link :href="route('shop.shop')" :active="request()->routeIs('shop.shop')">
                        {{ __('Магазин') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @guest
                        {{Form::open(['route'=>'cart','method'=>'POST'])}}
                        <input type="text" name="products" value="[]" class="hidden">
                        <x-nav-submit :active="request()->routeIs('cart')" class="navCart">
                           {{ __('Корзина') }}
                        </x-nav-submit>
                        {{Form::close()}}
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div><img class="w-5" src="{{asset('storage/images/icons/user.svg')}}" title="Войти"></div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('login')" :active="request()->routeIs('login')">
                                    {{ __('Вход') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('register')" :active="request()->routeIs('register')">
                                    {{ __('Регистрация') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endguest
                    @auth
                        {{Form::open(['route'=>'cart','method'=>'POST'])}}
                            <input type="text" name="products" value="[]" class="hidden">
                            <x-nav-submit :active="request()->routeIs('cart')" class="navCart">
                                {{ __('Корзина') }}
                            </x-nav-submit>
                        {{Form::close()}}
                        @canany(['product-create','product-edit','product-delete'])
                            <x-nav-link :href="route('products')" :active="request()->routeIs('products')">
                                {{ __('Продукты') }}
                            </x-nav-link>
                        @endcanany
                        @can('order-edit')
                            <x-nav-link :href="route('orders')" :active="request()->routeIs('orders')">
                                {{ __('Заказы') }}
                            </x-nav-link>
                        @endcan
                        @can('role-list')
                            <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                                {{ __('Роли') }}
                            </x-nav-link>
                        @endcan
                        @can('user-list')
                            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                                {{ __('Пользователи') }}
                            </x-nav-link>
                        @endcan
                    @endauth
                </div>
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>
                                <x-nav-link :href="route('lk')" :active="request()->routeIs('lk')">
                                    {{ Auth::user()->name }}
                                </x-nav-link>
                            </div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Выйти') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('shop')" :active="request()->routeIs('shop')">
                {{ __('Обзор') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('shop.shop')" :active="request()->routeIs('shop.shop')">
                {{ __('Магазин') }}
            </x-responsive-nav-link>
            {{Form::open(['route'=>'cart','method'=>'POST'])}}
                <input type="text" name="products" value="[]" class="hidden">
                <x-responsive-nav-submit :active="request()->routeIs('cart')" class="navCart">
                    {{ __('Корзина') }}
                </x-responsive-nav-submit>
            {{Form::close()}}
            @auth
                @canany(['product-create','product-edit','product-delete'])
                    <x-responsive-nav-link :href="route('products')" :active="request()->routeIs('products')">
                        {{ __('Продукты') }}
                    </x-responsive-nav-link>
                @endcanany
                @can('order-edit')
                    <x-responsive-nav-link :href="route('orders')" :active="request()->routeIs('orders')">
                        {{ __('Заказы') }}
                    </x-responsive-nav-link>
                @endcan
                @can('role-list')
                    <x-responsive-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                        {{ __('Роли') }}
                    </x-responsive-nav-link>
                @endcan
                @can('user-list')
                    <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                        {{ __('Пользователи') }}
                    </x-responsive-nav-link>
                @endcan
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @auth
                    <x-responsive-nav-link :href="route('lk')" :active="request()->routeIs('lk')">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </x-responsive-nav-link>
                @endauth
                <div class="ml-3">
                    @guest
                        <div class="font-medium text-base text-gray-800">
                            <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                                {{ __('Вход') }}
                            </x-responsive-nav-link>
                        </div>
                        <div class="font-medium text-sm text-gray-500">
                            <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                                {{ __('Регистрация') }}
                            </x-responsive-nav-link>
                        </div>
                    @endguest
                    @auth
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    @endauth
                </div>
            </div>
            @auth
            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Выйти') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @endauth
        </div>
    </div>
</nav>
