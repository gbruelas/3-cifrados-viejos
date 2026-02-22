@extends('layouts.app')

@section('title', 'Cifrado de Polybios')

@section('content')
<div class="max-w-screen-xl mx-auto px-4">
    <!-- header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Cifrado de Polybios</h1>
        <p class="text-gray-600 mt-2">
            El cifrado de Polybios utiliza una cuadrícula de 5x5 para convertir cada letra en un par de números (fila, columna).
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

    @if($errors->any())
        <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <span class="font-medium">Error:</span>
            <ul class="mt-1 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- columna izquierda: grid y explicación -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg border border-gray-200 shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Cuadrícula Polybios</h2>
                
                <!-- Grid -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-center text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3"></th>
                                <th class="px-4 py-3">1</th>
                                <th class="px-4 py-3">2</th>
                                <th class="px-4 py-3">3</th>
                                <th class="px-4 py-3">4</th>
                                <th class="px-4 py-3">5</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $grid = [
                                    1 => ['A', 'B', 'C', 'D', 'E'],
                                    2 => ['F', 'G', 'H', 'I/J', 'K'],
                                    3 => ['L', 'M', 'N', 'O', 'P'],
                                    4 => ['Q', 'R', 'S', 'T', 'U'],
                                    5 => ['V', 'W', 'X', 'Y', 'Z']
                                ];
                            @endphp
                            @for($row = 1; $row <= 5; $row++)
                                <tr class="bg-white border-b">
                                    <th class="px-4 py-3 font-medium text-gray-900 bg-gray-50">{{ $row }}</th>
                                    @for($col = 1; $col <= 5; $col++)
                                        <td class="px-4 py-3 font-mono text-lg">
                                            {{ $grid[$row][$col-1] }}
                                        </td>
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                    <h3 class="font-semibold text-blue-800 mb-2">Características:</h3>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Matriz de 5x5 (25 celdas para 26 letras)</li>
                        <li>• I y J comparten la celda (2,4)</li>
                        <li>• Cada letra se representa como: [fila][columna]</li>
                        <li>• Ejemplo: H = 23, O = 34, L = 31</li>
                    </ul>
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
                            <div class="p-3 bg-blue-50 rounded-lg font-mono text-blue-800 font-semibold">
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
                    <!-- Formulario Cifrar -->
                    <div id="encrypt-form" class="tab-content">
                        <form action="{{ route('polybios.encrypt') }}" method="POST">
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

                    <!-- formulario Descifrar -->
                    <div id="decrypt-form" class="tab-content hidden">
                        <form action="{{ route('polybios.decrypt') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="cipher" class="block text-sm font-medium text-gray-700 mb-2">
                                    Texto cifrado (números separados por espacios):
                                </label>
                                <textarea 
                                    id="cipher" 
                                    name="cipher" 
                                    rows="4" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Ejemplo: 23 34 31 11 32 45 33 14 34"
                                >{{ old('cipher') }}</textarea>
                                @error('cipher')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
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

            <!-- ejemplos -->
            <div class="mt-6 bg-gray-50 rounded-lg border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Ejemplos rápidos</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-lg">
                        <p class="font-medium text-gray-700 mb-2">Cifrar:</p>
                        <ul class="space-y-2 text-sm">
                            <li><span class="text-gray-500">Texto:</span> <code class="bg-gray-100 px-2 py-1 rounded">HOLA</code></li>
                            <li><span class="text-gray-500">Cifrado:</span> <code class="bg-blue-100 text-blue-800 px-2 py-1 rounded">23 34 31 11</code></li>
                        </ul>
                    </div>
                    <div class="bg-white p-4 rounded-lg">
                        <p class="font-medium text-gray-700 mb-2">Descifrar:</p>
                        <ul class="space-y-2 text-sm">
                            <li><span class="text-gray-500">Cifrado:</span> <code class="bg-gray-100 px-2 py-1 rounded">11 12 13 14 15</code></li>
                            <li><span class="text-gray-500">Texto:</span> <code class="bg-blue-100 text-blue-800 px-2 py-1 rounded">ABCDE</code></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- js para tabs -->
<script>
function switchTab(tab) {
    // ocultar todos los contenidos
    document.querySelectorAll('.tab-content').forEach(el => {
        el.classList.add('hidden');
    });
    
    // desactivar todos los botones
    document.querySelectorAll('[id$="-btn"]').forEach(btn => {
        btn.classList.remove('border-blue-600', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    // activar el tab seleccionado
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