<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CesarController extends Controller
{
    private $alfabeto = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private $longitud;

    public function __construct()
    {
        $this->longitud = strlen($this->alfabeto);
    }

    //muestra el formulario de cifrado/descifrado
    public function index()
    {
        return view('cesar.index');
    }

    //procesa el cifrado
    public function encrypt(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'desplazamiento' => 'required|integer|min:1|max:25',
            'direccion' => 'required|in:izquierda,derecha'
        ]);

        $texto = $request->input('text');
        $desplazamiento = (int)$request->input('desplazamiento');
        $direccion = $request->input('direccion');

        //aplicar direccion
        if ($direccion == 'izquierda') {
            $desplazamiento = -$desplazamiento;
        }

        //verificar que el texto solo contenga letras y espacios
        if (preg_match('/[^A-Za-z\s]/', $texto)) {
            return redirect()->route('cesar.index')
                ->with('error', 'El texto solo puede contener letras y espacios. No se permiten números ni caracteres especiales.')
                ->withInput();
        }

        $cifrado = $this->cifrarCesar($texto, $desplazamiento);

        return redirect()->route('cesar.index')
            ->with('success', 'Texto cifrado correctamente')
            ->with('result', $cifrado)
            ->with('original', $texto)
            ->with('desplazamiento', $request->input('desplazamiento'))
            ->with('direccion', $direccion)
            ->with('action', 'encrypt');
    }

    //procesa el descifrado
    public function decrypt(Request $request)
    {
        $request->validate([
            'cipher' => 'required|string',
            'desplazamiento' => 'required|integer|min:1|max:25',
            'direccion' => 'required|in:izquierda,derecha'
        ]);

        $texto = $request->input('cipher');
        $desplazamiento = (int)$request->input('desplazamiento');
        $direccion = $request->input('direccion');

        //para descifrar, invertimos la dirección
        if ($direccion == 'derecha') {
            $desplazamiento = -$desplazamiento;
        } else {
            //si era izquierda para cifrar, para descifrar es derecha
            $desplazamiento = $desplazamiento;
        }

        //verificar que el texto solo contenga letras mayusculas y espacios
        if (preg_match('/[^A-Z\s]/', strtoupper($texto))) {
            return redirect()->route('cesar.index')
                ->with('error', 'El texto cifrado solo puede contener letras mayúsculas y espacios.')
                ->withInput();
        }

        $descifrado = $this->cifrarCesar($texto, $desplazamiento);

        return redirect()->route('cesar.index')
            ->with('success', 'Texto descifrado correctamente')
            ->with('result', $descifrado)
            ->with('original', $texto)
            ->with('desplazamiento', $request->input('desplazamiento'))
            ->with('direccion', $direccion)
            ->with('action', 'decrypt');
    }

    
    // meotdo interno para cifrar/descifrar con cesar
    private function cifrarCesar($texto, $desplazamiento)
    {
        $texto = strtoupper($texto);
        $resultado = '';

        for ($i = 0; $i < strlen($texto); $i++) {
            $caracter = $texto[$i];

            //si es una letra del alfabeto
            if (strpos($this->alfabeto, $caracter) !== false) {
                $posicion = strpos($this->alfabeto, $caracter);
                $nuevaPosicion = ($posicion + $desplazamiento) % $this->longitud;

                //manejar desplazamiento negativo
                if ($nuevaPosicion < 0) {
                    $nuevaPosicion += $this->longitud;
                }

                $resultado .= $this->alfabeto[$nuevaPosicion];
            } else {
                //mantener espacios y otros caracteres permitidos
                $resultado .= $caracter;
            }
        }

        return $resultado;
    }

    //metodo para obtener información del cifrado
    public function info()
    {
        $alfabeto = str_split($this->alfabeto);
        return response()->json([
            'alfabeto' => $alfabeto,
            'longitud' => $this->longitud
        ]);
    }
}
