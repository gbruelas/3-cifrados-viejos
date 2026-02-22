<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolybiosController extends Controller
{
    private $grid = [];
    private $map = [];
    private $size = 5;

    //inicializa al cuadricula del polybios
    public function __construct()
    {
        $this->initializeGrid();
    }

    //inicializa la cuadricula del polybios 5x5
    private function initializeGrid()
    {
        //alfabeto sin la J (I/J combinadas)
        $alphabet = 'ABCDEFGHIKLMNOPQRSTUVWXYZ';
        
        $index = 0;
        for ($row = 1; $row <= $this->size; $row++) {
            for ($col = 1; $col <= $this->size; $col++) {
                $letter = $alphabet[$index] ?? '';
                $this->grid[$row][$col] = $letter;
                $this->map[$letter] = ['row' => $row, 'col' => $col];
                $index++;
            }
        }
    }

    //muestra el formulario de cifrado/descifrado    
    public function index()
    {
        $grid = $this->displayGrid();
        return view('polybios.index', compact('grid'));
    }

    //procesa el cifrado
    public function encrypt(Request $request)
    {
        $request->validate([
            'text' => 'required|string'
        ]);

        $text = $request->input('text');
        $encrypted = $this->encryptText($text);
        
        return redirect()->route('polybios.index')
            ->with('success', 'Texto cifrado correctamente')
            ->with('result', $encrypted)
            ->with('original', $text)
            ->with('action', 'encrypt');
    }

    //procesa el descifrado
    public function decrypt(Request $request)
    {
        $request->validate([
            'cipher' => 'required|string'
        ]);

        $cipher = $request->input('cipher');
        $decrypted = $this->decryptText($cipher);
        
        return redirect()->route('polybios.index')
            ->with('success', 'Texto descifrado correctamente')
            ->with('result', $decrypted)
            ->with('original', $cipher)
            ->with('action', 'decrypt');
    }

    //metodo interno para cifrar el txeto
    private function encryptText($text)
    {
        $text = strtoupper($text);
        $text = str_replace('J', 'I', $text); //reemplazar J por I
        $text = preg_replace('/[^A-Z]/', '', $text); //eliminar caracteres no alfabeticos
        
        $result = [];
        
        for ($i = 0; $i < strlen($text); $i++) {
            $letter = $text[$i];
            if (isset($this->map[$letter])) {
                $coord = $this->map[$letter];
                $result[] = $coord['row'] . $coord['col'];
            }
        }
        
        return implode(' ', $result);
    }

    //metodo interno para descrifrar el texto
    private function decryptText($cipher)
    {
        $pairs = explode(' ', trim($cipher));
        $result = '';
        
        foreach ($pairs as $pair) {
            if (strlen($pair) == 2 && is_numeric($pair)) {
                $row = (int)$pair[0];
                $col = (int)$pair[1];
                
                if (isset($this->grid[$row][$col])) {
                    $result .= $this->grid[$row][$col];
                }
            }
        }
        
        return $result;
    }

    //genera la tabla html de la cuadricula
    private function displayGrid()
    {
        $html = '<table class="table table-bordered text-center">';
        $html .= '<tr><th></th>';
        for ($i = 1; $i <= $this->size; $i++) {
            $html .= "<th>$i</th>";
        }
        $html .= '</tr>';
        
        for ($row = 1; $row <= $this->size; $row++) {
            $html .= "<tr><th>$row</th>";
            for ($col = 1; $col <= $this->size; $col++) {
                $html .= "<td>" . $this->grid[$row][$col] . "</td>";
            }
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        
        return $html;
    }

}
