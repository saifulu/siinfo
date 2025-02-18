<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KunjunganController extends Controller
{
    public function index()
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        $data = [
            'kunjungan_hari_ini' => 25,
            'rata_rata_kunjungan' => 30,
            'total_kunjungan_bulan' => 750,
            'jenis_kunjungan' => [
                'Umum' => 15,
                'BPJS' => 8,
                'Asuransi' => 2
            ]
        ];

        return view('kunjungan.index', compact('data'));
    }

    public function dashboard()
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        $data = [
            'rawat_inap' => [
                'total_pasien' => 25,
                'pasien_masuk' => 3,
                'pasien_keluar' => 2
            ],
            'rawat_jalan' => [
                'total_kunjungan' => 50,
                'pasien_baru' => 10,
                'pasien_lama' => 40
            ]
        ];

        return view('kunjungan.dashboard', compact('data'));
    }

    public function rawatJalan()
    {
        return view('kunjungan.rawat-jalan');
    }

    public function rawatInap()
    {
        return view('kunjungan.rawat-inap');
    }

    public function laporanHarian()
    {
        return view('kunjungan.laporan.harian');
    }

    public function laporanBulanan()
    {
        return view('kunjungan.laporan.bulanan');
    }

    public function laporanTahunan()
    {
        return view('kunjungan.laporan.tahunan');
    }
} 