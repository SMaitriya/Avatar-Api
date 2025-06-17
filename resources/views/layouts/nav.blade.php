<nav x-data="{ open: false }" class="bg-white shadow-md p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <!-- Logo -->
            <img src="" alt="Logo" class="h-10">
            <span class="text-xl font-semibold">Avatar API</span>
        </div>

        <div class="flex space-x-6 items-center">
            <!-- Liens classiques -->
            <a href="/" class="text-gray-600 hover:text-blue-500">Accueil</a>
            <a href="{{ route('bibliotheque') }}" class="text-gray-600 hover:text-blue-500">Bibliothèque</a>


            <!-- Gestion Auth -->
            @if (Route::has('login'))
                @auth
                @if (Auth::user()->is_admin)
                    <!-- Admin -->
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-500">Admin</a>
                    @endif


                    <!-- Settings Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = ! open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->first_name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </div>

                        <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-48 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5" style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Profil
                                </a>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Connexion -->
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-500">Connexion</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-blue-500">Inscription</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>