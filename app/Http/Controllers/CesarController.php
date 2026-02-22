<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CesarController extends Controller
{
    public function index()
    {
        return view('cesar');
    }

    public function cifrar(Request $request)
    {
        $texto = $request->input('texto');
        $desplazamiento = (int) $request->input('desplazamiento');

        $resultado = $this->cifradoCesar($texto, $desplazamiento);

        return view('cesar', [
            'resultado' => $resultado
        ]);
    }

    private function cifradoCesar($texto, $desplazamiento)
    {
        $resultado = '';

        foreach (str_split($texto) as $char) {
            if (ctype_alpha($char)) {
                $ascii = ord($char);
                $base = ctype_upper($char) ? ord('A') : ord('a');

                $resultado .= chr(($ascii - $base + $desplazamiento) % 26 + $base);
            } else {
                $resultado .= $char;
            }
        }

        return $resultado;
    }
}
