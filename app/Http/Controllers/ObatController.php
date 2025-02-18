<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ObatController extends Controller
{
    public function index()
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        $data = [
            'stok_obat' => [
                'total' => 1500,
                'hampir_habis' => 25,
                'kadaluarsa' => 10
            ],
            'obat_terlaris' => [
                ['nama' => 'Paracetamol', 'jumlah' => 150],
                ['nama' => 'Amoxicillin', 'jumlah' => 120],
                ['nama' => 'Omeprazole', 'jumlah' => 100]
            ]
        ];

        return view('obat.index', compact('data'));
    }
} 