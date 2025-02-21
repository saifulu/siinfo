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

        // Debug query lengkap
        \Log::info('IGD Query Debug: ', [
            'raw_query' => DB::table('reg_periksa')
                ->select([
                    DB::raw('COUNT(*) as total_kunjungan'),
                    DB::raw('SUM(CASE WHEN status_lanjut = "Ranap" THEN 1 ELSE 0 END) as lanjut_rawat_inap'), 
                    DB::raw('SUM(CASE WHEN status_lanjut = "Ralan" THEN 1 ELSE 0 END) as pasien_pulang')
                ])
                ->where('kd_poli', 'IGDK')
                ->whereDate('tgl_registrasi', Carbon::today())
                ->toSql(),
            'bindings' => [Carbon::today()],
            'result' => [
                'total_kunjungan' => $igd->total_kunjungan,
                'lanjut_rawat_inap' => $igd->lanjut_rawat_inap,
                'pasien_pulang' => $igd->pasien_pulang
            ]
        ]);

        // Query untuk detail kasus gawat darurat dan non-darurat
        $igd_detail = DB::table('reg_periksa')
            ->select([
                // Kasus gawat darurat: status Dirawat, Dirujuk, atau Meninggal
                DB::raw('SUM(CASE WHEN stts IN ("Dirawat", "Dirujuk", "Meninggal") THEN 1 ELSE 0 END) as kasus_darurat'),
                // Kasus non-darurat: status lainnya
                DB::raw('SUM(CASE WHEN stts IN ("Sudah", "Belum", "Berkas Diterima", "Pulang Paksa", "Batal") THEN 1 ELSE 0 END) as kasus_non_darurat')
            ])
            ->where('kd_poli', 'IGDK')
            ->whereDate('tgl_registrasi', Carbon::today())
            ->first();

        // Debug query
        \Log::info('IGD Total Query: ', [
            'sql' => DB::table('reg_periksa')
                ->where('kd_poli', 'IGDK')
                ->whereDate('tgl_registrasi', Carbon::today())
                ->toSql(),
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
        \Log::info('Rawat Jalan Query: ', [
            'sql' => DB::table('reg_periksa')
                ->where('status_lanjut', 'Ralan')
                ->where('kd_poli', '!=', 'IGDK')
                ->whereDate('tgl_registrasi', Carbon::today())
                ->toSql(),
            'result' => $rawat_jalan
        ]);

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

        // Ambil parameter filter (default: hari)
        $filter = request('filter', 'hari');
        
        // Query untuk tren kunjungan
        $tren_query = DB::table('reg_periksa')
            ->select([
                'tgl_registrasi',
                DB::raw('SUM(CASE WHEN status_lanjut = "Ranap" THEN 1 ELSE 0 END) as rawat_inap'),
                DB::raw('SUM(CASE WHEN status_lanjut = "Ralan" AND kd_poli != "IGDK" THEN 1 ELSE 0 END) as rawat_jalan'),
                DB::raw('SUM(CASE WHEN kd_poli = "IGDK" THEN 1 ELSE 0 END) as igd')
            ])
            ->groupBy('tgl_registrasi');

        // Sesuaikan range tanggal berdasarkan filter
        switch($filter) {
            case 'minggu':
                $tren_query->whereBetween('tgl_registrasi', [
                    Carbon::now()->subDays(7), 
                    Carbon::now()
                ]);
                break;
            case 'bulan':
                $tren_query->whereBetween('tgl_registrasi', [
                    Carbon::now()->startOfMonth(), 
                    Carbon::now()
                ]);
                break;
            default: // hari
                $tren_query->whereDate('tgl_registrasi', Carbon::today());
        }

        $tren_kunjungan = $tren_query->get();

        // Format data untuk chart
        $chart_data = [
            'labels' => $tren_kunjungan->pluck('tgl_registrasi')->map(function($date) use ($filter) {
                $carbon_date = Carbon::parse($date);
                switch($filter) {
                    case 'minggu':
                        // Ubah format hari ke Bahasa Indonesia
                        return [
                            'Sun' => 'Minggu',
                            'Mon' => 'Senin',
                            'Tue' => 'Selasa',
                            'Wed' => 'Rabu',
                            'Thu' => 'Kamis',
                            'Fri' => 'Jumat',
                            'Sat' => 'Sabtu'
                        ][$carbon_date->format('D')];
                    case 'bulan':
                        return $carbon_date->format('d');
                    default:
                        return $carbon_date->format('H:i');
                }
            }),
            'datasets' => [
                [
                    'label' => 'Rawat Inap (Pasien yang dirawat di rumah sakit)',
                    'data' => $tren_kunjungan->pluck('rawat_inap'),
                    'borderColor' => 'rgb(59, 130, 246)', // Biru
                    'tension' => 0.4
                ],
                [
                    'label' => 'Rawat Jalan (Pasien yang berobat jalan/poli)',
                    'data' => $tren_kunjungan->pluck('rawat_jalan'),
                    'borderColor' => 'rgb(34, 197, 94)', // Hijau
                    'tension' => 0.4
                ],
                [
                    'label' => 'IGD (Pasien gawat darurat)',
                    'data' => $tren_kunjungan->pluck('igd'),
                    'borderColor' => 'rgb(239, 68, 68)', // Merah
                    'tension' => 0.4
                ]
            ]
        ];

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
                'total_kunjungan' => $rawat_jalan->total_kunjungan ?? 0,
                'pasien_baru' => $rawat_jalan->pasien_baru ?? 0,
                'pasien_lama' => $rawat_jalan->pasien_lama ?? 0
            ],
            'igd' => [
                'kasus_darurat' => $igd->lanjut_rawat_inap ?? 0,
                'kasus_non_darurat' => $igd->pasien_pulang ?? 0,
                'total_kunjungan' => $igd->total_kunjungan ?? 0
            ],
            'chart_data' => $chart_data,
            'current_filter' => $filter
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