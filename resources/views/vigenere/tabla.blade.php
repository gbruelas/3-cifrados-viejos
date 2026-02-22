@extends('layouts.app')

@section('title', 'Tabla de Vigenère')

@section('content')
<div class="max-w-screen-xl mx-auto px-4">
    <!-- header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Tabla de Vigenère</h1>
        <p class="text-gray-600 mt-2">
            El cuadrado de Vigenère muestra cómo se cifra cada letra según la clave.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- columna izquierda: explicación -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg border border-gray-200 shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Cómo usar la tabla</h2>
                
                <div class="space-y-4">
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Instrucciones:</h3>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li class="flex items-start">
                                <span class="text-purple-500 mr-2">1.</span>
                                <span>La fila superior (azul) es el texto original</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-purple-500 mr-2">2.</span>
                                <span>La columna izquierda (verde) es la clave</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-purple-500 mr-2">3.</span>
                                <span>La intersección es el texto cifrado</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-purple-800 mb-2">Ejemplo:</h3>
                        <p class="text-sm text-purple-700 mb-2">
                            Para cifrar la letra <strong>H</strong> con clave <strong>K</strong>:
                        </p>
                        <ul class="text-sm text-purple-700 space-y-1">
                            <li>• Busca H en la fila superior</li>
                            <li>• Busca K en la columna izquierda</li>
                            <li>• Encuentra la intersección: <strong class="text-lg">R</strong></li>
                        </ul>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-blue-800 mb-2">Fórmula:</h3>
                        <p class="text-sm text-blue-700">
                            <strong>Cifrado:</strong> (letra + clave) mod 26<br>
                            <strong>Descifrado:</strong> (cifrado - clave + 26) mod 26
                        </p>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('vigenere.index') }}" class="text-purple-600 hover:text-purple-800 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Volver al cifrado Vigenère
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- columna derecha: tabla -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg border border-gray-200 shadow-md p-6 overflow-x-auto">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Cuadrado de Vigenère</h2>
                
                <table class="min-w-full text-sm text-center font-mono">
                    <!-- encabezado: texto original -->
                    <thead>
                        <tr>
                            <th class="px-2 py-2 bg-gray-100 border"></th>
                            @foreach($alfabeto as $letra)
                                <th class="px-2 py-2 bg-blue-100 border text-blue-800 font-bold">{{ $letra }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tabla as $index => $fila)
                            <tr>
                                <!-- columna izquierda: clave -->
                                <th class="px-2 py-2 bg-green-100 border text-green-800 font-bold">{{ $alfabeto[$index] }}</th>
                                
                                <!-- cuerpo de la tabla -->
                                @foreach($fila as $letra)
                                    <td class="px-2 py-2 border {{ $letra == 'A' ? 'bg-yellow-50' : '' }} hover:bg-purple-50 transition-colors">
                                        {{ $letra }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- leyenda -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-100 border border-blue-300 rounded mr-2"></div>
                        <span class="text-gray-600">Fila superior: Texto original</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-100 border border-green-300 rounded mr-2"></div>
                        <span class="text-gray-600">Columna izquierda: Clave</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-yellow-50 border border-yellow-300 rounded mr-2"></div>
                        <span class="text-gray-600">Destacado: Letra 'A' (desplazamiento 0)</span>
                    </div>
                </div>

                <!-- nota -->
                <div class="mt-4 p-3 bg-gray-50 rounded-lg text-xs text-gray-600">
                    <p class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        Cada celda muestra el resultado de cifrar la letra de la columna con la clave de la fila.
                        Por ejemplo, para cifrar 'H' con clave 'K' (fila K, columna H), el resultado es 'R'.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ejemplo interactivo -->
    <div class="mt-8 bg-white rounded-lg border border-gray-200 shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Probador rápido</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Letra del texto:
                </label>
                <select id="letraTexto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5">
                    @foreach($alfabeto as $letra)
                        <option value="{{ $letra }}">{{ $letra }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Letra de la clave:
                </label>
                <select id="letraClave" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5">
                    @foreach($alfabeto as $letra)
                        <option value="{{ $letra }}">{{ $letra }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4 p-4 bg-purple-50 rounded-lg text-center">
            <p class="text-gray-700 mb-2">Resultado del cifrado:</p>
            <p id="resultadoEjemplo" class="text-3xl font-bold text-purple-600">R</p>
        </div>
    </div>
</div>

<!-- js para el probador interactivo -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const letraTexto = document.getElementById('letraTexto');
    const letraClave = document.getElementById('letraClave');
    const resultado = document.getElementById('resultadoEjemplo');
    
    const alfabeto = @json($alfabeto);
    
    function actualizarResultado() {
        const texto = letraTexto.value;
        const clave = letraClave.value;
        
        const posTexto = alfabeto.indexOf(texto);
        const posClave = alfabeto.indexOf(clave);
        const nuevaPos = (posTexto + posClave) % 26;
        
        resultado.textContent = alfabeto[nuevaPos];
    }
    
    letraTexto.addEventListener('change', actualizarResultado);
    letraClave.addEventListener('change', actualizarResultado);
    
    // actualizar al cargar
    actualizarResultado();
});
</script>
@endsection