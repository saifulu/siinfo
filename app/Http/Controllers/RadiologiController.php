<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RadiologiController extends Controller
{
    public function index()
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        $data = [
            'pemeriksaan_hari_ini' => 10,
            'jenis_pemeriksaan' => [
                'X-Ray' => 5,
                'USG' => 3,
                'CT Scan' => 2
            ]
        ];

        return view('radiologi.index', compact('data'));
    }
} 