<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LaboratoriumController extends Controller
{
    public function index()
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        $data = [
            'pemeriksaan_hari_ini' => 15,
            'jenis_pemeriksaan' => [
                'Hematologi' => 5,
                'Kimia Darah' => 4,
                'Urinalisis' => 3,
                'Mikrobiologi' => 3
            ]
        ];

        return view('laboratorium.index', compact('data'));
    }
} 