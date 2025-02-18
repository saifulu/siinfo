<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        // Hitung total pasien rawat inap (status pulang = '-')
        $total_pasien = DB::table('kamar_inap')
            ->where('stts_pulang', '-')
            ->count();

        // Hitung pasien masuk hari ini
        $pasien_masuk = DB::table('kamar_inap')
            ->whereDate('tgl_masuk', Carbon::today())
            ->count();

        // Hitung pasien keluar hari ini
        $pasien_keluar = DB::table('kamar_inap')
            ->whereDate('tgl_keluar', Carbon::today())
            ->whereNotNull('tgl_keluar')
            ->count();

        $data = [
            'pendapatan' => [
                'hari_ini' => 0,
                'bulan_ini' => 0,
                'tahun_ini' => 0
            ],
            'pengeluaran' => [
                'hari_ini' => 0,
                'bulan_ini' => 0,
                'tahun_ini' => 0
            ],
            'piutang' => [
                'total' => 0,
                'jatuh_tempo' => 0,
                'lunas' => 0
            ],
            'rawat_inap' => [
                'total_pasien' => $total_pasien,
                'pasien_masuk' => $pasien_masuk,
                'pasien_keluar' => $pasien_keluar
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

    public function igd()
    {
        return view('kunjungan.igd');
    }

    public function operasi()
    {
        return view('kunjungan.operasi');
    }
} 