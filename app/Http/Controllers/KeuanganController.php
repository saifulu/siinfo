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

        // Menggunakan data yang sama dengan dashboard
        $pendapatanHariIni = DB::table('tagihan_sadewa')
            ->whereRaw('DATE(tgl_bayar) = CURDATE()')
            ->sum('jumlah_bayar');

        // Query pendapatan bulan ini
        $pendapatanBulanIni = DB::table('tagihan_sadewa')
            ->whereRaw('MONTH(tgl_bayar) = MONTH(CURRENT_DATE())')
            ->whereRaw('YEAR(tgl_bayar) = YEAR(CURRENT_DATE())')
            ->sum('jumlah_bayar');

        // Query pendapatan tahun ini
        $pendapatanTahunIni = DB::table('tagihan_sadewa')
            ->whereRaw('YEAR(tgl_bayar) = YEAR(CURRENT_DATE())')
            ->sum('jumlah_bayar');

        // Query pengeluaran hari ini
        $pengeluaranHariIni = DB::table('pengeluaran_harian')
            ->whereRaw('DATE(tanggal) = CURDATE()')
            ->sum('biaya');

        // Query pengeluaran bulan ini
        $pengeluaranBulanIni = DB::table('pengeluaran_harian')
            ->whereRaw('MONTH(tanggal) = MONTH(CURRENT_DATE())')
            ->whereRaw('YEAR(tanggal) = YEAR(CURRENT_DATE())')
            ->sum('biaya');

        // Query pengeluaran tahun ini
        $pengeluaranTahunIni = DB::table('pengeluaran_harian')
            ->whereRaw('YEAR(tanggal) = YEAR(NOW())')
            ->sum('biaya');

        // Query total piutang
        $totalPiutang = DB::table('piutang_pasien')
            ->whereRaw('YEAR(tgl_piutang) = YEAR(CURDATE())')
            ->sum('sisapiutang');

        // Query piutang jatuh tempo (30 hari)
        $piutangJatuhTempo = DB::table('piutang_pasien')
            ->whereRaw('DATEDIFF(CURDATE(), tgl_piutang) >= 30')
            ->whereRaw('sisapiutang > 0')
            ->sum('sisapiutang');

        // Query piutang lunas
        $piutangLunas = DB::table('piutang_pasien')
            ->whereRaw('YEAR(tgl_piutang) = YEAR(CURDATE())')
            ->whereRaw('sisapiutang = 0')
            ->sum('totalpiutang');

        $data = [
            'pendapatan' => [
                'hari_ini' => $pendapatanHariIni,
                'bulan_ini' => $pendapatanBulanIni,
                'tahun_ini' => $pendapatanTahunIni
            ],
            'pengeluaran' => [
                'hari_ini' => $pengeluaranHariIni,
                'bulan_ini' => $pengeluaranBulanIni,
                'tahun_ini' => $pengeluaranTahunIni
            ],
            'piutang' => [
                'total' => $totalPiutang,
                'jatuh_tempo' => $piutangJatuhTempo,
                'lunas' => $piutangLunas
            ],
            'transaksi_terakhir' => [
                [
                    'tanggal' => '2024-02-16',
                    'keterangan' => 'Pembayaran Rawat Inap',
                    'jumlah' => 2500000,
                    'tipe' => 'masuk'
                ],
                [
                    'tanggal' => '2024-02-16',
                    'keterangan' => 'Pembayaran Obat',
                    'jumlah' => 1500000,
                    'tipe' => 'masuk'
                ],
                [
                    'tanggal' => '2024-02-16',
                    'keterangan' => 'Pembelian Supplies',
                    'jumlah' => 3000000,
                    'tipe' => 'keluar'
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