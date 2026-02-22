<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VigenereController extends Controller
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
        return view('vigenere.index');
    }

    //procesa el cifrado
    public function encrypt(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'clave' => 'required|string|min:1|max:20'
        ]);

        $texto = $request->input('text');
        $clave = $request->input('clave');

        // verificar que el texto solo contenga letras y espacios
        if (preg_match('/[^A-Za-z\s]/', $texto)) {
            return redirect()->route('vigenere.index')
                ->with('error', 'El texto solo puede contener letras y espacios. No se permiten números ni caracteres especiales.')
                ->withInput();
        }

        // verificar que la clave solo contenga letras
        if (preg_match('/[^A-Za-z]/', $clave)) {
            return redirect()->route('vigenere.index')
                ->with('error', 'La clave solo puede contener letras (A-Z) y no debe de tener espacios.')
                ->withInput();
        }

        $cifrado = $this->cifrarVigenere($texto, $clave, 'cifrar');

        return redirect()->route('vigenere.index')
            ->with('success', 'Texto cifrado correctamente')
            ->with('result', $cifrado)
            ->with('original', $texto)
            ->with('clave', $clave)
            ->with('action', 'encrypt');
    }

    // procesa el descifrado
    public function decrypt(Request $request)
    {
        $request->validate([
            'cipher' => 'required|string',
            'clave' => 'required|string|min:1|max:20'
        ]);

        $texto = $request->input('cipher');
        $clave = $request->input('clave');

        //verificar que el texto cifrado solo contenga letras mayusculas y espacios
        if (preg_match('/[^A-Z\s]/', strtoupper($texto))) {
            return redirect()->route('vigenere.index')
                ->with('error', 'El texto cifrado solo puede contener letras mayúsculas y espacios.')
                ->withInput();
        }

        //verificar que la clave solo contenga letras
        if (preg_match('/[^A-Za-z]/', $clave)) {
            return redirect()->route('vigenere.index')
                ->with('error', 'La clave solo puede contener letras (A-Z).')
                ->withInput();
        }

        $descifrado = $this->cifrarVigenere($texto, $clave, 'descifrar');

        return redirect()->route('vigenere.index')
            ->with('success', 'Texto descifrado correctamente')
            ->with('result', $descifrado)
            ->with('original', $texto)
            ->with('clave', $clave)
            ->with('action', 'decrypt');
    }

    //metodo interno para cifrar/descifrar con Vigenère
    private function cifrarVigenere($texto, $clave, $operacion)
    {
        $texto = strtoupper($texto);
        $clave = strtoupper($clave);
        $resultado = '';
        $claveIndex = 0;
        $claveLongitud = strlen($clave);

        for ($i = 0; $i < strlen($texto); $i++) {
            $caracter = $texto[$i];

            //si es una letra del alfabeto
            if (strpos($this->alfabeto, $caracter) !== false) {
                $posTexto = strpos($this->alfabeto, $caracter);
                
                //obtener el caracter de la clave (ciclicamente)
                $caracterClave = $clave[$claveIndex % $claveLongitud];
                $posClave = strpos($this->alfabeto, $caracterClave);
                
                if ($operacion == 'cifrar') {
                    //cifrar: (posTexto + posClave) mod 26
                    $nuevaPos = ($posTexto + $posClave) % $this->longitud;
                } else {
                    //descifrar: (posTexto - posClave + 26) mod 26
                    $nuevaPos = ($posTexto - $posClave + $this->longitud) % $this->longitud;
                }
                
                $resultado .= $this->alfabeto[$nuevaPos];
                $claveIndex++;
            } else {
                //mantener espacios
                $resultado .= $caracter;
            }
        }

        return $resultado;
    }

    //genera la tabla de Vigenere
    private function generarTablaVigenere()
    {
        $tabla = [];
        for ($i = 0; $i < $this->longitud; $i++) {
            $fila = '';
            for ($j = 0; $j < $this->longitud; $j++) {
                $pos = ($i + $j) % $this->longitud;
                $fila .= $this->alfabeto[$pos];
            }
            $tabla[] = str_split($fila);
        }
        return $tabla;
    }

    
    //muestra la tabla de vigenere
    
    public function tabla()
    {
        $tabla = $this->generarTablaVigenere();
        $alfabeto = str_split($this->alfabeto);
        
        return view('vigenere.tabla', compact('tabla', 'alfabeto'));
    }
}