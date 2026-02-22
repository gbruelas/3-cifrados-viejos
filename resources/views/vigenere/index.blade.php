@extends('layouts.app')

@section('title', 'Cifrado Vigenère')

@section('content')
<div class="max-w-screen-xl mx-auto px-4">
    <!-- header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Cifrado Vigenère</h1>
        <p class="text-gray-600 mt-2">
            El cifrado Vigenère usa una palabra clave para desplazar cada letra de manera diferente.
            Es un cifrado polialfabético más seguro que el César.
        </p>
        <div class="mt-3">
            <a href="{{ route('vigenere.tabla') }}" class="inline-flex items-center text-purple-600 hover:text-purple-800 text-sm">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zM8 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zM15 3a1 1 0 00-1 1v12a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2z"></path>
                </svg>
                Ver tabla de Vigenère
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- columna izquierda: informacion y ejemplos -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg border border-gray-200 shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Información</h2>
                
                <!-- caracteristicas -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-700 mb-2">Características:</h3>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-start">
                            <span class="text-purple-500 mr-2">•</span>
                            <span>Usa una palabra clave para el cifrado</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-purple-500 mr-2">•</span>
                            <span>Cada letra se desplaza según la clave</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-purple-500 mr-2">•</span>
                            <span>La clave se repite cíclicamente</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-purple-500 mr-2">•</span>
                            <span>Solo letras A-Z (mayúsculas)</span>
                        </li>
                    </ul>
                </div>

                <!-- formula -->
                <div class="mb-6 bg-purple-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-purple-800 mb-2">Fórmula:</h3>
                    <p class="text-sm text-purple-700 mb-2">
                        <strong>Cifrar:</strong> C = (M + K) mod 26
                    </p>
                    <p class="text-sm text-purple-700">
                        <strong>Descifrar:</strong> M = (C - K + 26) mod 26
                    </p>
                </div>

                <!-- ejemplos -->
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Ejemplos:</h3>
                    <div class="space-y-3">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm font-medium text-gray-700">Cifrar:</p>
                            <p class="text-xs text-gray-500">Texto: HOLA MUNDO</p>
                            <p class="text-xs text-gray-500">Clave: KEY</p>
                            <p class="text-sm font-mono text-purple-600 mt-1">RSJK QSXHM</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm font-medium text-gray-700">Descifrar:</p>
                            <p class="text-xs text-gray-500">Cifrado: RSJK QSXHM</p>
                            <p class="text-xs text-gray-500">Clave: KEY</p>
                            <p class="text-sm font-mono text-purple-600 mt-1">HOLA MUNDO</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- columna derecha: formularios -->
        <div class="lg:col-span-2">
            <!-- Resultado (si existe) -->
            @if(session('result'))
                <div class="mb-6 bg-white rounded-lg border border-gray-200 shadow-md">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 rounded-t-lg">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ session('action') == 'encrypt' ? 'Resultado del Cifrado' : 'Resultado del Descifrado' }}
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-500 mb-1">Clave utilizada:</p>
                            <div class="p-2 bg-purple-50 rounded-lg font-mono text-purple-700 inline-block">
                                {{ session('clave') }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-500 mb-1">Texto original:</p>
                            <div class="p-3 bg-gray-50 rounded-lg font-mono text-gray-800">
                                {{ session('original') }}
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">
                                {{ session('action') == 'encrypt' ? 'Texto cifrado:' : 'Texto descifrado:' }}
                            </p>
                            <div class="p-3 {{ session('action') == 'encrypt' ? 'bg-purple-50 text-purple-800' : 'bg-green-50 text-green-800' }} rounded-lg font-mono font-semibold">
                                {{ session('result') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- formularios en tabs -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-md">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button onclick="switchTab('encrypt')" id="tab-encrypt-btn" class="py-4 px-6 text-sm font-medium border-b-2 border-purple-600 text-purple-600" type="button">
                            Cifrar Texto
                        </button>
                        <button onclick="switchTab('decrypt')" id="tab-decrypt-btn" class="py-4 px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" type="button">
                            Descifrar Texto
                        </button>
                    </nav>
                </div>
                
                <div class="p-6">
                    <!-- formulario cifrar -->
                    <div id="encrypt-form" class="tab-content">
                        <form action="{{ route('vigenere.encrypt') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="text" class="block text-sm font-medium text-gray-700 mb-2">
                                    Texto a cifrar:
                                </label>
                                <textarea 
                                    id="text" 
                                    name="text" 
                                    rows="4" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5"
                                    placeholder="Ejemplo: HOLA MUNDO"
                                >{{ old('text') }}</textarea>
                                @error('text')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="clave" class="block text-sm font-medium text-gray-700 mb-2">
                                    Palabra clave:
                                </label>
                                <input 
                                    type="text" 
                                    id="clave" 
                                    name="clave" 
                                    value="{{ old('clave', 'KEY') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5"
                                    placeholder="Ejemplo: KEY"
                                >
                                <p class="mt-1 text-xs text-gray-500">Solo letras, sin espacios. Máximo 20 caracteres.</p>
                                @error('clave')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <button type="submit" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                    Cifrar Texto
                                </button>
                                <button type="reset" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">
                                    Limpiar
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- formulario descifrar -->
                    <div id="decrypt-form" class="tab-content hidden">
                        <form action="{{ route('vigenere.decrypt') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="cipher" class="block text-sm font-medium text-gray-700 mb-2">
                                    Texto a descifrar:
                                </label>
                                <textarea 
                                    id="cipher" 
                                    name="cipher" 
                                    rows="4" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5"
                                    placeholder="Ejemplo: RSJK QSXHM"
                                >{{ old('cipher') }}</textarea>
                                @error('cipher')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="clave" class="block text-sm font-medium text-gray-700 mb-2">
                                    Palabra clave:
                                </label>
                                <input 
                                    type="text" 
                                    id="clave" 
                                    name="clave" 
                                    value="{{ old('clave', 'KEY') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5"
                                    placeholder="Ejemplo: KEY"
                                >
                                <p class="mt-1 text-xs text-gray-500">Solo letras, sin espacios. Máximo 20 caracteres.</p>
                                @error('clave')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <button type="submit" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                    Descifrar Texto
                                </button>
                                <button type="reset" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">
                                    Limpiar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- js para tabs -->
<script>
function switchTab(tab) {
    //ocultar todos los contenidos
    document.querySelectorAll('.tab-content').forEach(el => {
        el.classList.add('hidden');
    });
    
    // desactivar todos los botones
    document.querySelectorAll('[id$="-btn"]').forEach(btn => {
        btn.classList.remove('border-purple-600', 'text-purple-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    // activar el tab seleccionado
    if (tab === 'encrypt') {
        document.getElementById('encrypt-form').classList.remove('hidden');
        document.getElementById('tab-encrypt-btn').classList.add('border-purple-600', 'text-purple-600');
        document.getElementById('tab-encrypt-btn').classList.remove('border-transparent', 'text-gray-500');
    } else {
        document.getElementById('decrypt-form').classList.remove('hidden');
        document.getElementById('tab-decrypt-btn').classList.add('border-purple-600', 'text-purple-600');
        document.getElementById('tab-decrypt-btn').classList.remove('border-transparent', 'text-gray-500');
    }
}
</script>
@endsection