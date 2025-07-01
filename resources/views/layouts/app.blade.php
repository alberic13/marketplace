<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Marketplace Game')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-white text-xl font-bold">
                            <i class="fas fa-gamepad mr-2"></i>GameMarket
                        </a>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">
                            Home
                        </a>
                        <a href="{{ route('games.index') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">
                            Games
                        </a>
                        <a href="{{ route('listings.index') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">
                            Listings
                        </a>
                        <a href="{{ route('categories.index') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">
                            Categories
                        </a>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 flex items-center justify-center px-2 lg:ml-6 lg:justify-end">
                    <div class="max-w-lg w-full lg:max-w-xs">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" placeholder="Search games..." 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="relative">
                            <button class="flex text-sm rounded-full text-white focus:outline-none">
                                <i class="fas fa-user-circle text-2xl"></i>
                            </button>
                            <div class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <a href="{{ route('my-listings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Listings</a>
                                @if(auth()->user()->role === 'admin')
                                    <hr class="my-1">
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium">
                                        <span class="text-red-600">🛡️ Admin Panel</span>
                                    </a>
                                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <span class="text-red-600">Manage Users</span>
                                    </a>
                                @endif
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Register
                        </a>
                        <a href="{{ route('my-listings.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Start Selling
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8 xl:col-span-1">
                    <div class="flex items-center">
                        <i class="fas fa-gamepad text-2xl mr-2"></i>
                        <span class="text-xl font-bold">GameMarket</span>
                    </div>
                    <p class="text-gray-300 text-base">
                        Your trusted marketplace for buying and selling games. Find the best deals and connect with fellow gamers.
                    </p>
                </div>
                <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Browse</h3>
                            <ul class="mt-4 space-y-4">
                                <li><a href="{{ route('games.index') }}" class="text-base text-gray-300 hover:text-white">All Games</a></li>
                                <li><a href="{{ route('categories.index') }}" class="text-base text-gray-300 hover:text-white">Categories</a></li>
                                <li><a href="{{ route('listings.index') }}" class="text-base text-gray-300 hover:text-white">Listings</a></li>
                            </ul>
                        </div>
                        <div class="mt-12 md:mt-0">
                            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Account</h3>
                            <ul class="mt-4 space-y-4">
                                @auth
                                    <li><a href="{{ route('dashboard') }}" class="text-base text-gray-300 hover:text-white">Dashboard</a></li>
                                    <li><a href="{{ route('my-listings.index') }}" class="text-base text-gray-300 hover:text-white">My Listings</a></li>
                                @else
                                    <li><a href="{{ route('login') }}" class="text-base text-gray-300 hover:text-white">Login</a></li>
                                    <li><a href="{{ route('register') }}" class="text-base text-gray-300 hover:text-white">Register</a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8">
                <p class="text-base text-gray-400 xl:text-center">
                    &copy; {{ date('Y') }} GameMarket. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Simple dropdown toggle
        document.addEventListener('DOMContentLoaded', function() {
            const userButton = document.querySelector('button.flex.text-sm');
            const dropdown = document.querySelector('.hidden.absolute');
            
            if (userButton && dropdown) {
                userButton.addEventListener('click', function() {
                    dropdown.classList.toggle('hidden');
                });
                
                document.addEventListener('click', function(event) {
                    if (!userButton.contains(event.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>
