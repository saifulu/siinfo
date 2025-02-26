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

        // Set timezone dan aktifkan query log
        date_default_timezone_set('Asia/Jakarta');
        DB::enableQueryLog();

        // Query pendapatan hari ini
        $pendapatan_hari = DB::select("
            SELECT 
                COALESCE(SUM(jumlah_bayar), 0) AS total_pembayaran 
            FROM 
                tagihan_sadewa 
            WHERE 
                DATE(tgl_bayar) = CURDATE()
        ")[0]->total_pembayaran;

        // Query pendapatan bulan ini (dari tanggal 1)
        $pendapatan_bulan = DB::select("
            SELECT 
                COALESCE(SUM(jumlah_bayar), 0) AS total_pembayaran 
            FROM 
                tagihan_sadewa 
            WHERE 
                DATE(tgl_bayar) >= DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01')
                AND DATE(tgl_bayar) <= CURRENT_DATE()
        ")[0]->total_pembayaran;

        // Query pendapatan tahun ini (dari 1 Januari)
        $pendapatan_tahun = DB::select("
            SELECT 
                COALESCE(SUM(jumlah_bayar), 0) AS total_pembayaran 
            FROM 
                tagihan_sadewa 
            WHERE 
                DATE(tgl_bayar) >= DATE_FORMAT(CURRENT_DATE(), '%Y-01-01')
                AND DATE(tgl_bayar) <= CURRENT_DATE()
        ")[0]->total_pembayaran;

        // Query pengeluaran hari ini
        $pengeluaran_hari = DB::select("
            SELECT 
                COALESCE(SUM(pengeluaran_harian.biaya), 0) AS total_pengeluaran
            FROM 
                pengeluaran_harian
            INNER JOIN 
                petugas ON pengeluaran_harian.nip = petugas.nip
            INNER JOIN 
                kategori_pengeluaran_harian ON pengeluaran_harian.kode_kategori = kategori_pengeluaran_harian.kode_kategori
            WHERE 
                DATE(pengeluaran_harian.tanggal) = CURDATE()
        ")[0]->total_pengeluaran;

        // Query pengeluaran bulan ini (dari tanggal 1)
        $pengeluaran_bulan = DB::select("
            SELECT 
                COALESCE(SUM(pengeluaran_harian.biaya), 0) AS total_pengeluaran
            FROM 
                pengeluaran_harian
            INNER JOIN 
                petugas ON pengeluaran_harian.nip = petugas.nip
            INNER JOIN 
                kategori_pengeluaran_harian ON pengeluaran_harian.kode_kategori = kategori_pengeluaran_harian.kode_kategori
            WHERE 
                DATE(pengeluaran_harian.tanggal) >= DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01')
                AND DATE(pengeluaran_harian.tanggal) <= CURRENT_DATE()
        ")[0]->total_pengeluaran;

        // Query pengeluaran tahun ini (dari 1 Januari)
        $pengeluaran_tahun = DB::select("
            SELECT 
                COALESCE(SUM(pengeluaran_harian.biaya), 0) AS total_pengeluaran
            FROM 
                pengeluaran_harian
            INNER JOIN 
                petugas ON pengeluaran_harian.nip = petugas.nip
            INNER JOIN 
                kategori_pengeluaran_harian ON pengeluaran_harian.kode_kategori = kategori_pengeluaran_harian.kode_kategori
            WHERE 
                DATE(pengeluaran_harian.tanggal) >= DATE_FORMAT(CURRENT_DATE(), '%Y-01-01')
                AND DATE(pengeluaran_harian.tanggal) <= CURRENT_DATE()
        ")[0]->total_pengeluaran;

        // Debug query
        \Log::info('Debug Query Pendapatan:', [
            'tanggal' => date('Y-m-d H:i:s'),
            'hari_ini' => [
                'query' => "SELECT SUM(jumlah_bayar) FROM tagihan_sadewa WHERE DATE(tgl_bayar) = CURDATE()",
                'hasil' => $pendapatan_hari
            ],
            'bulan_ini' => [
                'query' => "SELECT SUM(jumlah_bayar) FROM tagihan_sadewa WHERE DATE(tgl_bayar) >= DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01')",
                'hasil' => $pendapatan_bulan
            ],
            'tahun_ini' => [
                'query' => "SELECT SUM(jumlah_bayar) FROM tagihan_sadewa WHERE DATE(tgl_bayar) >= DATE_FORMAT(CURRENT_DATE(), '%Y-01-01')",
                'hasil' => $pendapatan_tahun
            ]
        ]);

        \Log::info('Debug Query Pengeluaran:', [
            'tanggal' => date('Y-m-d H:i:s'),
            'hari_ini' => [
                'query' => "SELECT SUM(biaya) FROM pengeluaran_harian WHERE DATE(tanggal) = CURDATE()",
                'hasil' => $pengeluaran_hari
            ],
            'bulan_ini' => [
                'query' => "SELECT SUM(biaya) FROM pengeluaran_harian WHERE DATE(tanggal) >= DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01')",
                'hasil' => $pengeluaran_bulan
            ],
            'tahun_ini' => [
                'query' => "SELECT SUM(biaya) FROM pengeluaran_harian WHERE DATE(tanggal) >= DATE_FORMAT(CURRENT_DATE(), '%Y-01-01')",
                'hasil' => $pengeluaran_tahun
            ]
        ]);

        // Data untuk cards
        $data = [
            'pendapatan_hari' => $pendapatan_hari,
            'pendapatan_bulan' => $pendapatan_bulan,
            'pendapatan_tahun' => $pendapatan_tahun,
            'pengeluaran_hari' => $pengeluaran_hari,
            'pengeluaran_bulan' => $pengeluaran_bulan,
            'pengeluaran_tahun' => $pengeluaran_tahun,
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