<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cifrados Clásicos')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- navbar -->
    <nav class="bg-white border-b border-gray-200 fixed w-full z-20 top-0 start-0">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-blue-600">Cifrados Clásicos</span>
            </a>
            
            <!-- mobile menu button -->
            <button data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-dropdown" aria-expanded="false">
                <span class="sr-only">Abrir menú</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
            
            <!-- menu items -->
            <div class="hidden w-full lg:block lg:w-auto" id="navbar-dropdown">
                <ul class="flex flex-col font-medium p-4 lg:p-0 mt-4 border border-gray-100 rounded-lg lg:space-x-8 rtl:space-x-reverse lg:flex-row lg:mt-0 lg:border-0 lg:bg-white">
                    <li>
                        <a href="{{ route('home') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-600 lg:p-0 {{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : '' }}">
                            Inicio
                        </a>
                    </li>
                    
                    <!-- dropdown de los cifrados -->
                    <li>
                        <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-600 lg:p-0 lg:w-auto {{ request()->routeIs('polybios.*') || request()->routeIs('cesar.*') || request()->routeIs('vigenere.*') ? 'text-blue-600' : '' }}">
                            Cifrados 
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        
                        <!-- dropdown menu -->
                        <div id="dropdownNavbar" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownLargeButton">
                                <li>
                                    <a href="{{ route('cesar.index') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('cesar.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                                        César
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('polybios.index') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('polybios.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                                        Polybios
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('vigenere.index') }}" class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('vigenere.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                                        Vigenère
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>

    <!-- main content -->
    <main class="pt-20">
        @yield('content')
    </main>
    
    <!-- footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="{{ route('home') }}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap text-blue-600">Cifrados Clásicos</span>
                </a>
                <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0">
                    <li>
                        <p href="#" class="me-4 md:me-6">Encriptación de datos</p>
                    </li>
                    <li>
                        <p href="#" class="me-4 md:me-6">(Laboratorio 1) Métodos de cifra en la historia</p>
                    </li>
                </ul>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
            <span class="block text-sm text-gray-500 sm:text-center">©2026 Equipo 4: Guillermo Ruelas Buenrostro, Arturo Damian Espino Martinez y Jesús Valenzuela Pineda.</span>
        </div>
    </footer>

    <!-- flowbite js -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>