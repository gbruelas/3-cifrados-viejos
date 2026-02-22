<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CesarController extends Controller
{
    public function index()
    {
        return view('cesar');
    }

    public function procesar(Request $request)
    {
        $texto = strtolower($request->input('texto'));
        $desplazamiento = (int)$request->input('desplazamiento');
        $direccion = $request->input('direccion');
        $accion = $request->input('accion');

        if ($direccion == 'izquierda') {
            $desplazamiento = -$desplazamiento;
        }

        if ($accion == 'descifrar') {
            $desplazamiento = -$desplazamiento;
        }

        $resultado = $this->cifrarCesar($texto, $desplazamiento);

        return view('cesar', compact('resultado'));
    }

    private function cifrarCesar($texto, $desplazamiento)
    {
        $resultado = '';
        $alfabeto = 'abcdefghijklmnopqrstuvwxyz';
        $longitud = strlen($alfabeto);

        for ($i = 0; $i < strlen($texto); $i++) {
            $letra = $texto[$i];

            if (strpos($alfabeto, $letra) !== false) {
                $posicion = strpos($alfabeto, $letra);
                $nuevaPosicion = ($posicion + $desplazamiento) % $longitud;

                if ($nuevaPosicion < 0) {
                    $nuevaPosicion += $longitud;
                }

                $resultado .= $alfabeto[$nuevaPosicion];
            } else {
                $resultado .= $letra;
            }
        }

        return $resultado;
    }
}
