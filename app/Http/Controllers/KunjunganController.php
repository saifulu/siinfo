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
        
        // Langsung arahkan ke dashboard
        return $this->dashboard();
    }

    public function dashboard()
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        // Ambil parameter filter (default: hari)
        $filter = request('filter', 'hari');

        // Query untuk IGD
        $igd = DB::table('reg_periksa')
            ->select([
                DB::raw('COUNT(*) as total_kunjungan'),
                DB::raw('SUM(CASE WHEN status_lanjut = "Ranap" THEN 1 ELSE 0 END) as lanjut_rawat_inap'),
                DB::raw('SUM(CASE WHEN status_lanjut = "Ralan" THEN 1 ELSE 0 END) as pasien_pulang')
            ])
            ->where('kd_poli', 'IGDK')
            ->whereDate('tgl_registrasi', Carbon::today())
            ->first();

        // Debug query IGD
        \Log::info('Debug Query IGD:', [
            'query' => "SELECT 
                COUNT(*) as total_kunjungan,
                SUM(CASE WHEN status_lanjut = 'Ranap' THEN 1 ELSE 0 END) as lanjut_rawat_inap,
                SUM(CASE WHEN status_lanjut = 'Ralan' THEN 1 ELSE 0 END) as pasien_pulang
            FROM reg_periksa 
            WHERE kd_poli = 'IGDK'
            AND DATE(tgl_registrasi) = '" . Carbon::today()->toDateString() . "'",
            'result' => $igd
        ]);

        // Query untuk Rawat Jalan
        $rawat_jalan = DB::table('reg_periksa')
            ->select([
                DB::raw('COUNT(*) as total_kunjungan'),
                DB::raw('SUM(CASE WHEN stts_daftar = "Baru" THEN 1 ELSE 0 END) as pasien_baru'),
                DB::raw('SUM(CASE WHEN stts_daftar = "Lama" THEN 1 ELSE 0 END) as pasien_lama')
            ])
            ->where('status_lanjut', 'Ralan')
            ->where('kd_poli', '!=', 'IGDK')
            ->whereDate('tgl_registrasi', Carbon::today())
            ->first();

        // Debug query
        \Log::info('Debug Query Rawat Jalan:', [
            'query' => "SELECT 
                COUNT(*) as total_kunjungan,
                SUM(CASE WHEN stts_daftar = 'Baru' THEN 1 ELSE 0 END) as pasien_baru,
                SUM(CASE WHEN stts_daftar = 'Lama' THEN 1 ELSE 0 END) as pasien_lama
            FROM reg_periksa 
            WHERE status_lanjut = 'Ralan' 
            AND kd_poli != 'IGDK'
            AND DATE(tgl_registrasi) = '" . Carbon::today()->toDateString() . "'",
            'result' => $rawat_jalan
        ]);

        // Query untuk Rawat Inap
        // Total pasien yang masih dirawat
        $total_pasien = DB::table('kamar_inap')
            ->where('stts_pulang', '-')
            ->count();

        // Pasien masuk hari ini
        $pasien_masuk = DB::table('kamar_inap')
            ->whereDate('tgl_masuk', Carbon::today())
            ->count();

        // Pasien keluar hari ini
        $pasien_keluar = DB::table('kamar_inap')
            ->whereDate('tgl_keluar', Carbon::today())
            ->whereNotNull('tgl_keluar')
            ->count();

        // Debug query
        \Log::info('Debug Query Rawat Inap:', [
            'total_pasien_query' => [
                'sql' => "SELECT COUNT(*) AS total_pasien FROM kamar_inap WHERE stts_pulang = '-'",
                'count' => $total_pasien
            ],
            'date' => Carbon::today()->toDateString()
        ]);

        // Data untuk grafik tren kunjungan
        $chart_data = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'datasets' => [
                [
                    'label' => 'Rawat Inap',
                    'data' => [3, 2, 2, 1, 5, 3],
                    'borderColor' => 'rgb(59, 130, 246)',
                    'tension' => 0.4
                ],
                [
                    'label' => 'Rawat Jalan',
                    'data' => [5, 4, 3, 2, 4, 3],
                    'borderColor' => 'rgb(34, 197, 94)',
                    'tension' => 0.4
                ],
                [
                    'label' => 'IGD',
                    'data' => [2, 3, 4, 3, 2, 1],
                    'borderColor' => 'rgb(239, 68, 68)',
                    'tension' => 0.4
                ]
            ]
        ];

        // Data untuk view
        $data = [
            'rawat_inap' => [
                'total_pasien' => $total_pasien,
                'pasien_masuk' => $pasien_masuk,
                'pasien_keluar' => $pasien_keluar
            ],
            'rawat_jalan' => [
                'total_kunjungan' => $rawat_jalan->total_kunjungan ?? 0,
                'pasien_baru' => $rawat_jalan->pasien_baru ?? 0,
                'pasien_lama' => $rawat_jalan->pasien_lama ?? 0
            ],
            'igd' => [
                'total_kunjungan' => $igd->total_kunjungan ?? 0,
                'lanjut_rawat_inap' => $igd->lanjut_rawat_inap ?? 0,
                'pasien_pulang' => $igd->pasien_pulang ?? 0
            ],
            'current_filter' => $filter,
            'chart_data' => $chart_data
        ];

        // Debug untuk memastikan data IGD
        \Log::info('Data IGD:', [
            'raw_data' => $igd,
            'formatted_data' => $data['igd']
        ]);

        // Debug sebelum kirim ke view
        \Log::info('Data sebelum dikirim ke view:', [
            'rawat_inap' => $data['rawat_inap']
        ]);

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