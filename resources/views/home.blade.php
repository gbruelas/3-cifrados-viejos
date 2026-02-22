@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="max-w-screen-xl mx-auto px-4">
    <!-- Hero Section -->
    <div class="text-center py-12">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
            <span class="block">Cifrados Clásicos</span>
            <span class="block text-blue-600">con Laravel</span>
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
            Implementación de algunos de los métodos de cifrado más famosos de la historia de la criptografía: César, Polybios y Vigenère.
        </p>
    </div>

    <!-- cards de cifrados -->
    <div id="cifrados" class="grid grid-cols-1 md:grid-cols-3 gap-6 py-12">
        <!-- césar card -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Cifrado César</h3>
                <p class="text-gray-600 mb-4">
                    Desplaza cada letra un número fijo de posiciones en el alfabeto.
                </p>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Desplazamiento variable • 26 letras</span>
                    <a href="{{ route('cesar.index') }}" class="inline-flex items-center text-green-600 hover:text-green-800">
                        Probar 
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- polybios card -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Cifrado de Polybios</h3>
                <p class="text-gray-600 mb-4">
                    Utiliza una cuadrícula de 5x5 para convertir letras en coordenadas numéricas.
                </p>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">5x5 grid • I/J combinadas</span>
                    <a href="{{ route('polybios.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                        Probar 
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- vigenere card -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Cifrado Vigenère</h3>
                <p class="text-gray-600 mb-4">
                    Usa una palabra clave para desplazar cada letra de manera diferente.
                </p>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Palabra clave • Cifrado polialfabético</span>
                    <a href="{{ route('vigenere.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-800">
                        Probar 
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection