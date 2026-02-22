@extends('layouts.app')

@section('title', 'Cifrado César')

@section('content')
<div class="max-w-screen-xl mx-auto px-4">
    <!-- header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Cifrado César</h1>
        <p class="text-gray-600 mt-2">
            El cifrado César desplaza cada letra del texto un número fijo de posiciones en el alfabeto.
        </p>
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
        <!-- columna izquierda: información y ejemplos -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg border border-gray-200 shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Información</h2>
                
                <!-- alfabeto -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-700 mb-2">Alfabeto:</h3>
                    <div class="grid grid-cols-9 gap-1">
                        @foreach(str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ') as $index => $letra)
                            <div class="bg-gray-100 text-center p-1 text-sm font-mono rounded">
                                {{ $letra }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- caracteristicas -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-700 mb-2">Características:</h3>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2">•</span>
                            <span>Desplazamiento de 1 a 25 posiciones</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2">•</span>
                            <span>Dirección: izquierda o derecha</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2">•</span>
                            <span>Mantiene espacios y mayúsculas</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2">•</span>
                            <span>Solo letras del alfabeto inglés (A-Z)</span>
                        </li>
                    </ul>
                </div>

                <!-- ejemplos -->
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Ejemplos:</h3>
                    <div class="space-y-3">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm font-medium text-gray-700">Cifrar:</p>
                            <p class="text-xs text-gray-500">Texto: HOLA MUNDO</p>
                            <p class="text-xs text-gray-500">Desplazamiento: 3 (derecha)</p>
                            <p class="text-sm font-mono text-blue-600 mt-1">KROD PXQGR</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm font-medium text-gray-700">Descifrar:</p>
                            <p class="text-xs text-gray-500">Cifrado: KROD PXQGR</p>
                            <p class="text-xs text-gray-500">Desplazamiento: 3 (izquierda)</p>
                            <p class="text-sm font-mono text-green-600 mt-1">HOLA MUNDO</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- columna derecha: formularios -->
        <div class="lg:col-span-2">
            <!-- resultado (si existe) -->
            @if(session('result'))
                <div class="mb-6 bg-white rounded-lg border border-gray-200 shadow-md">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 rounded-t-lg">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ session('action') == 'encrypt' ? 'Resultado del Cifrado' : 'Resultado del Descifrado' }}
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Desplazamiento:</p>
                                <p class="text-sm font-semibold">{{ session('desplazamiento') }} posiciones</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Dirección:</p>
                                <p class="text-sm font-semibold">{{ session('direccion') == 'derecha' ? '→ Derecha' : '← Izquierda' }}</p>
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
                            <div class="p-3 {{ session('action') == 'encrypt' ? 'bg-blue-50 text-blue-800' : 'bg-green-50 text-green-800' }} rounded-lg font-mono font-semibold">
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
                        <button onclick="switchTab('encrypt')" id="tab-encrypt-btn" class="py-4 px-6 text-sm font-medium border-b-2 border-blue-600 text-blue-600" type="button">
                            Cifrar Texto
                        </button>
                        <button onclick="switchTab('decrypt')" id="tab-decrypt-btn" class="py-4 px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" type="button">
                            Descifrar Texto
                        </button>
                    </nav>
                </div>
                
                <div class="p-6">
                    <!-- formulario Cifrar -->
                    <div id="encrypt-form" class="tab-content">
                        <form action="{{ route('cesar.encrypt') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="text" class="block text-sm font-medium text-gray-700 mb-2">
                                    Texto a cifrar:
                                </label>
                                <textarea 
                                    id="text" 
                                    name="text" 
                                    rows="4" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Ejemplo: HOLA MUNDO"
                                >{{ old('text') }}</textarea>
                                @error('text')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="desplazamiento" class="block text-sm font-medium text-gray-700 mb-2">
                                        Desplazamiento (1-25):
                                    </label>
                                    <input 
                                        type="number" 
                                        id="desplazamiento" 
                                        name="desplazamiento" 
                                        min="1" 
                                        max="25" 
                                        value="{{ old('desplazamiento', 3) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    >
                                    @error('desplazamiento')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                                        Dirección:
                                    </label>
                                    <select 
                                        id="direccion" 
                                        name="direccion" 
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    >
                                        <option value="derecha" {{ old('direccion') == 'derecha' ? 'selected' : '' }}>→ Derecha</option>
                                        <option value="izquierda" {{ old('direccion') == 'izquierda' ? 'selected' : '' }}>← Izquierda</option>
                                    </select>
                                    @error('direccion')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                    Cifrar Texto
                                </button>
                                <button type="reset" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">
                                    Limpiar
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Formulario Descifrar -->
                    <div id="decrypt-form" class="tab-content hidden">
                        <form action="{{ route('cesar.decrypt') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="cipher" class="block text-sm font-medium text-gray-700 mb-2">
                                    Texto a descifrar:
                                </label>
                                <textarea 
                                    id="cipher" 
                                    name="cipher" 
                                    rows="4" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Ejemplo: KROD PXQGR"
                                >{{ old('cipher') }}</textarea>
                                @error('cipher')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="desplazamiento" class="block text-sm font-medium text-gray-700 mb-2">
                                        Desplazamiento (1-25):
                                    </label>
                                    <input 
                                        type="number" 
                                        id="desplazamiento" 
                                        name="desplazamiento" 
                                        min="1" 
                                        max="25" 
                                        value="{{ old('desplazamiento', 3) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    >
                                    @error('desplazamiento')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                                        Dirección original del cifrado:
                                    </label>
                                    <select 
                                        id="direccion" 
                                        name="direccion" 
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    >
                                        <option value="derecha" {{ old('direccion') == 'derecha' ? 'selected' : '' }}>→ Derecha</option>
                                        <option value="izquierda" {{ old('direccion') == 'izquierda' ? 'selected' : '' }}>← Izquierda</option>
                                    </select>
                                    @error('direccion')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
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

            <!-- Nota -->
            <div class="mt-4 text-sm text-gray-500 text-center">
                <p>Nota: El cifrado trabaja con letras mayúsculas y mantiene los espacios. Los números y caracteres especiales no están permitidos.</p>
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
    
    //desactivar todos los botones
    document.querySelectorAll('[id$="-btn"]').forEach(btn => {
        btn.classList.remove('border-blue-600', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    //activar el tab seleccionado
    if (tab === 'encrypt') {
        document.getElementById('encrypt-form').classList.remove('hidden');
        document.getElementById('tab-encrypt-btn').classList.add('border-blue-600', 'text-blue-600');
        document.getElementById('tab-encrypt-btn').classList.remove('border-transparent', 'text-gray-500');
    } else {
        document.getElementById('decrypt-form').classList.remove('hidden');
        document.getElementById('tab-decrypt-btn').classList.add('border-blue-600', 'text-blue-600');
        document.getElementById('tab-decrypt-btn').classList.remove('border-transparent', 'text-gray-500');
    }
}
</script>
@endsection