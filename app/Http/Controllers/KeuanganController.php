<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KeuanganController extends Controller
{
    public function index()
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }
        
        // Redirect ke dashboard keuangan
        return redirect()->route('keuangan.dashboard');
    }

    public function dashboard()
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        // Data untuk cards
        $data = [
            'pendapatan_hari' => 0,
            'pendapatan_bulan' => 2000000,
            'pendapatan_tahun' => 2000000,
            'pengeluaran_hari' => 0,
            'pengeluaran_bulan' => 31000,
            'pengeluaran_tahun' => 99000,
            'total_piutang' => 1531884,
            'piutang_jatuh_tempo' => 1775208,
            'piutang_lunas' => 0,
            
            // Data untuk grafik laba rugi
            'chart_data' => [
                'labels' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
                'datasets' => [
                    [
                        'label' => 'Laba Bersih',
                        'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        'borderColor' => 'rgb(34, 197, 94)',
                        'borderWidth' => 2,
                        'tension' => 0.4
                    ],
                    [
                        'label' => 'Total Beban',
                        'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        'borderColor' => 'rgb(234, 179, 8)',
                        'borderWidth' => 2,
                        'tension' => 0.4
                    ],
                    [
                        'label' => 'Total Pendapatan',
                        'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        'borderColor' => 'rgb(59, 130, 246)',
                        'borderWidth' => 2,
                        'tension' => 0.4
                    ]
                ]
            ],

            // Data untuk grafik arus kas
            'arus_kas_data' => [
                'labels' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
                'datasets' => [
                    [
                        'label' => 'Saldo Keseluruhan',
                        'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        'borderColor' => 'rgb(34, 197, 94)',
                        'borderWidth' => 1.5,
                        'tension' => 0.4
                    ],
                    [
                        'label' => 'Saldo Kas Keluar',
                        'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        'borderColor' => 'rgb(239, 68, 68)',
                        'borderWidth' => 1.5,
                        'tension' => 0.4
                    ],
                    [
                        'label' => 'Saldo Kas Masuk',
                        'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        'borderColor' => 'rgb(59, 130, 246)', 
                        'borderWidth' => 1.5,
                        'tension' => 0.4
                    ]
                ]
            ]
        ];

        return view('keuangan.dashboard', compact('data'));
    }

    public function bukukas()
    {
        return view('keuangan.bukukas');
    }

    public function penerimaan()
    {
        return view('keuangan.penerimaan');
    }

    public function pengeluaran()
    {
        return view('keuangan.pengeluaran');
    }

    public function laporan()
    {
        return view('keuangan.laporan');
    }

    public function akun()
    {
        return view('keuangan.akun');
    }
} 