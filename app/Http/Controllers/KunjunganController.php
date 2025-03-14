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

        $filter = request('filter', 'minggu'); // Default filter minggu
        
        // Query untuk tren kunjungan berdasarkan filter
        $trendQuery = match($filter) {
            'minggu' => "
                SELECT 
                    DATE(reg_periksa.tgl_registrasi) as tanggal,
                    COUNT(CASE WHEN reg_periksa.status_lanjut = 'Ralan' THEN 1 END) as rawat_jalan,
                    COUNT(CASE WHEN reg_periksa.status_lanjut = 'Ranap' THEN 1 END) as rawat_inap,
                    COUNT(CASE WHEN reg_periksa.status_lanjut = 'IGD' THEN 1 END) as igd
                FROM reg_periksa
                WHERE 
                    reg_periksa.tgl_registrasi >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)
                    AND reg_periksa.tgl_registrasi <= CURRENT_DATE()
                GROUP BY DATE(reg_periksa.tgl_registrasi)
                ORDER BY tanggal
            ",
            'bulan' => "
                SELECT 
                    DATE(reg_periksa.tgl_registrasi) as tanggal,
                    COUNT(CASE WHEN reg_periksa.status_lanjut = 'Ralan' THEN 1 END) as rawat_jalan,
                    COUNT(CASE WHEN reg_periksa.status_lanjut = 'Ranap' THEN 1 END) as rawat_inap,
                    COUNT(CASE WHEN reg_periksa.status_lanjut = 'IGD' THEN 1 END) as igd
                FROM reg_periksa
                WHERE 
                    reg_periksa.tgl_registrasi >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)
                    AND reg_periksa.tgl_registrasi <= CURRENT_DATE()
                GROUP BY DATE(reg_periksa.tgl_registrasi)
                ORDER BY tanggal
            ",
            'tahun' => "
                SELECT 
                    DATE_FORMAT(reg_periksa.tgl_registrasi, '%Y-%m') as tanggal,
                    COUNT(CASE WHEN reg_periksa.status_lanjut = 'Ralan' THEN 1 END) as rawat_jalan,
                    COUNT(CASE WHEN reg_periksa.status_lanjut = 'Ranap' THEN 1 END) as rawat_inap,
                    COUNT(CASE WHEN reg_periksa.status_lanjut = 'IGD' THEN 1 END) as igd
                FROM reg_periksa
                WHERE 
                    reg_periksa.tgl_registrasi >= DATE_SUB(CURRENT_DATE(), INTERVAL 12 MONTH)
                    AND reg_periksa.tgl_registrasi <= CURRENT_DATE()
                GROUP BY DATE_FORMAT(reg_periksa.tgl_registrasi, '%Y-%m')
                ORDER BY tanggal
            ",
        };

        $trendData = DB::select($trendQuery);

        // Format data untuk chart
        $labels = [];
        $rawatJalan = [];
        $rawatInap = [];
        $igd = [];

        foreach ($trendData as $data) {
            $labels[] = $filter === 'tahun' 
                ? Carbon::createFromFormat('Y-m', $data->tanggal)->format('M Y')
                : Carbon::createFromFormat('Y-m-d', $data->tanggal)->format('d M');
            $rawatJalan[] = $data->rawat_jalan;
            $rawatInap[] = $data->rawat_inap;
            $igd[] = $data->igd;
        }

        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Rawat Jalan',
                    'data' => $rawatJalan,
                    'borderColor' => 'rgb(34, 197, 94)',
                    'tension' => 0.4
                ],
                [
                    'label' => 'Rawat Inap',
                    'data' => $rawatInap,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'tension' => 0.4
                ],
                [
                    'label' => 'IGD',
                    'data' => $igd,
                    'borderColor' => 'rgb(239, 68, 68)',
                    'tension' => 0.4
                ]
            ]
        ];

        // Aktifkan Query Log
        DB::enableQueryLog();

        // Set timezone untuk memastikan tanggal benar
        date_default_timezone_set('Asia/Jakarta');

        // Query untuk IGD
        $igd = DB::table('reg_periksa')
            ->select([
                DB::raw('COUNT(*) as total_kunjungan'),
                DB::raw('SUM(CASE WHEN status_lanjut = "Ranap" THEN 1 ELSE 0 END) as lanjut_rawat_inap'),
                DB::raw('SUM(CASE WHEN status_lanjut = "Ralan" THEN 1 ELSE 0 END) as pasien_pulang')
            ])
            ->where('kd_poli', 'IGDK')
            ->whereRaw('DATE(tgl_registrasi) = CURDATE()')
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

        // Query untuk Rawat Jalan hari ini
        $rawat_jalan = DB::table('reg_periksa')
            ->select([
                DB::raw('COUNT(*) as total_kunjungan'),
                DB::raw('SUM(CASE WHEN stts_daftar = "Baru" THEN 1 ELSE 0 END) as pasien_baru'),
                DB::raw('SUM(CASE WHEN stts_daftar = "Lama" THEN 1 ELSE 0 END) as pasien_lama')
            ])
            ->where('status_lanjut', 'Ralan')
            ->where('kd_poli', '!=', 'IGDK')
            ->whereRaw('DATE(tgl_registrasi) = CURDATE()')
            ->first();

        // Debug dengan query yang dijalankan
        \Log::info('Debug Query Rawat Jalan:', [
            'tanggal_hari_ini' => date('Y-m-d'),
            'query_executed' => DB::getQueryLog(),
            'hasil' => $rawat_jalan
        ]);

        // Query untuk Rawat Inap
        // Total pasien yang masih dirawat
        $total_pasien = DB::table('kamar_inap')
            ->where('stts_pulang', '-')
            ->count();

        // Pasien masuk hari ini
        $pasien_masuk = DB::table('kamar_inap')
            ->whereRaw('DATE(tgl_masuk) = CURDATE()')
            ->count();

        // Pasien keluar hari ini
        $pasien_keluar = DB::table('kamar_inap')
            ->whereRaw('DATE(tgl_keluar) = CURDATE()')
            ->whereNotNull('tgl_keluar')
            ->count();

        // Debug query
        \Log::info('Debug Query Rawat Inap:', [
            'tanggal_hari_ini' => date('Y-m-d'),
            'queries' => DB::getQueryLog(),
            'hasil' => [
                'total' => $total_pasien,
                'masuk' => $pasien_masuk,
                'keluar' => $pasien_keluar
            ]
        ]);

        // Query untuk menghitung okupansi
        $kamar_stats = DB::select("
            SELECT 
                (SELECT COUNT(*) 
                 FROM kamar_inap ki 
                 WHERE ki.stts_pulang = '-') as terisi,
                (SELECT COUNT(*) 
                 FROM kamar 
                 WHERE statusdata = '1') as total_tt
        ")[0];

        // Hitung persentase okupansi
        $okupansi = $kamar_stats->total_tt > 0 ? round(($kamar_stats->terisi / $kamar_stats->total_tt) * 100, 1) : 0;

        // Query untuk menghitung rata-rata lama rawat
        $avg_los = DB::select("
            SELECT ROUND(AVG(
                CASE 
                    WHEN tgl_keluar IS NOT NULL 
                    THEN DATEDIFF(tgl_keluar, tgl_masuk)
                    ELSE DATEDIFF(CURRENT_DATE(), tgl_masuk)
                END
            ), 1) as avg_los
            FROM kamar_inap 
            WHERE tgl_masuk >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)
        ")[0];

        // Query untuk data kemarin (Rawat Inap)
        $kemarin_ri = DB::select("
            SELECT 
                (SELECT COUNT(*) FROM kamar_inap 
                 WHERE stts_pulang = '-' 
                 AND DATE(tgl_masuk) <= DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)) as total_kemarin,
                (SELECT COUNT(*) FROM kamar_inap 
                 WHERE DATE(tgl_masuk) = DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)) as masuk_kemarin,
                (SELECT COUNT(*) FROM kamar_inap 
                 WHERE DATE(tgl_keluar) = DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)
                 AND tgl_keluar IS NOT NULL) as keluar_kemarin
        ")[0];

        // Debug query
        \Log::info('Data Kemarin Rawat Inap:', [
            'query' => "SELECT total hari kemarin",
            'result' => $kemarin_ri,
            'hari_ini' => [
                'total' => $total_pasien,
                'masuk' => $pasien_masuk,
                'keluar' => $pasien_keluar
            ]
        ]);

        // Hitung persentase perubahan
        $perubahan_ri = [
            'total' => $kemarin_ri->total_kemarin > 0 
                ? round((($total_pasien - $kemarin_ri->total_kemarin) / $kemarin_ri->total_kemarin) * 100, 1)
                : 0,
            'masuk' => $kemarin_ri->masuk_kemarin > 0 
                ? round((($pasien_masuk - $kemarin_ri->masuk_kemarin) / $kemarin_ri->masuk_kemarin) * 100, 1)
                : 0,
            'keluar' => $kemarin_ri->keluar_kemarin > 0 
                ? round((($pasien_keluar - $kemarin_ri->keluar_kemarin) / $kemarin_ri->keluar_kemarin) * 100, 1)
                : 0
        ];

        // Query untuk data kemarin
        $kemarin_rj = DB::table('reg_periksa')
            ->select([
                DB::raw('COUNT(*) as total_kemarin'),
                DB::raw('SUM(CASE WHEN stts_daftar = "Baru" THEN 1 ELSE 0 END) as baru_kemarin'),
                DB::raw('SUM(CASE WHEN stts_daftar = "Lama" THEN 1 ELSE 0 END) as lama_kemarin')
            ])
            ->where('status_lanjut', 'Ralan')
            ->where('kd_poli', '!=', 'IGDK')
            ->whereDate('tgl_registrasi', Carbon::yesterday())
            ->first();

        // Debug query kemarin
        \Log::info('Debug Query Rawat Jalan Kemarin:', [
            'tanggal' => Carbon::yesterday()->toDateString(),
            'query' => DB::getQueryLog(),
            'hasil' => $kemarin_rj
        ]);

        // Hitung perubahan dengan lebih detail
        $perubahan_rj = [
            'total' => $kemarin_rj->total_kemarin > 0 
                ? round((($rawat_jalan->total_kunjungan - $kemarin_rj->total_kemarin) / $kemarin_rj->total_kemarin) * 100, 1)
                : ($rawat_jalan->total_kunjungan > 0 ? 100 : 0),
            'baru' => $kemarin_rj->baru_kemarin > 0
                ? round((($rawat_jalan->pasien_baru - $kemarin_rj->baru_kemarin) / $kemarin_rj->baru_kemarin) * 100, 1)
                : ($rawat_jalan->pasien_baru > 0 ? 100 : 0),
            'lama' => $kemarin_rj->lama_kemarin > 0
                ? round((($rawat_jalan->pasien_lama - $kemarin_rj->lama_kemarin) / $kemarin_rj->lama_kemarin) * 100, 1)
                : ($rawat_jalan->pasien_lama > 0 ? 100 : 0)
        ];

        // Debug hasil perbandingan
        \Log::info('Perbandingan Rawat Jalan:', [
            'hari_ini' => [
                'total' => $rawat_jalan->total_kunjungan,
                'baru' => $rawat_jalan->pasien_baru,
                'lama' => $rawat_jalan->pasien_lama
            ],
            'kemarin' => [
                'total' => $kemarin_rj->total_kemarin,
                'baru' => $kemarin_rj->baru_kemarin,
                'lama' => $kemarin_rj->lama_kemarin
            ],
            'perubahan' => $perubahan_rj
        ]);

        // Query untuk data kemarin (IGD)
        $kemarin_igd = DB::select("
            SELECT COUNT(*) as total_kemarin,
                   SUM(CASE WHEN status_lanjut = 'Ranap' THEN 1 ELSE 0 END) as ranap_kemarin,
                   SUM(CASE WHEN status_lanjut = 'Ralan' THEN 1 ELSE 0 END) as pulang_kemarin
            FROM reg_periksa 
            WHERE kd_poli = 'IGDK'
            AND DATE(tgl_registrasi) = DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)
        ")[0];

        // Hitung perubahan IGD
        $perubahan_igd = [
            'total' => $kemarin_igd->total_kemarin > 0 
                ? round((($igd->total_kunjungan - $kemarin_igd->total_kemarin) / $kemarin_igd->total_kemarin) * 100, 1)
                : 0
        ];

        // Query untuk kunjungan per poli
        $kunjungan_poli = DB::select("
            SELECT 
                p.nm_poli,
                COUNT(rp.no_rawat) as total_kunjungan,
                SUM(CASE WHEN rp.stts IN ('Sudah', 'Sudah Dilayani') THEN 1 ELSE 0 END) as sudah_dilayani,
                SUM(CASE WHEN rp.status_bayar = 'Sudah Bayar' THEN 1 ELSE 0 END) as sudah_bayar
            FROM reg_periksa rp
            JOIN poliklinik p ON rp.kd_poli = p.kd_poli
            WHERE DATE(rp.tgl_registrasi) = CURDATE()
            AND rp.kd_poli != 'IGDK'
            AND rp.stts != 'Batal'
            GROUP BY p.kd_poli, p.nm_poli
            ORDER BY total_kunjungan DESC
            LIMIT 10
        ");

        // Debug query
        \Log::info('Query Kunjungan Poli:', [
            'sql' => "
                SELECT 
                    p.nm_poli,
                    COUNT(rp.no_rawat) as total_kunjungan,
                    SUM(CASE WHEN rp.stts IN ('Sudah', 'Sudah Dilayani') THEN 1 ELSE 0 END) as sudah_dilayani,
                    SUM(CASE WHEN rp.status_bayar = 'Sudah Bayar' THEN 1 ELSE 0 END) as sudah_bayar
                FROM reg_periksa rp
                JOIN poliklinik p ON rp.kd_poli = p.kd_poli
                WHERE DATE(rp.tgl_registrasi) = CURDATE()
                AND rp.stts != 'Batal'
                GROUP BY p.kd_poli, p.nm_poli
                ORDER BY total_kunjungan DESC
                LIMIT 10
            ",
            'hasil' => $kunjungan_poli
        ]);

        // Query untuk cara bayar
        $cara_bayar = DB::table('reg_periksa as rp')
            ->join('penjab as p', 'rp.kd_pj', '=', 'p.kd_pj')
            ->select('p.png_jawab', DB::raw('COUNT(*) as total'))
            ->whereDate('rp.tgl_registrasi', Carbon::today())
            ->groupBy('p.png_jawab')
            ->get();

        // Format data untuk grafik cara bayar
        $bayar_data = [
            'labels' => $cara_bayar->pluck('png_jawab')->toArray(),
            'datasets' => [[
                'data' => $cara_bayar->pluck('total')->toArray(),
                'backgroundColor' => [
                    'rgba(59, 130, 246, 0.9)',  // Biru
                    'rgba(34, 197, 94, 0.9)',   // Hijau
                    'rgba(249, 115, 22, 0.9)',  // Orange
                    'rgba(239, 68, 68, 0.9)',   // Merah
                    'rgba(168, 85, 247, 0.9)',  // Ungu
                    'rgba(236, 72, 153, 0.9)'   // Pink
                ],
                'borderWidth' => 0,
                'cutout' => '75%',
                'borderRadius' => 4,
            ]]
        ];

        // Debug query cara bayar
        \Log::info('Query Cara Bayar:', [
            'query' => DB::getQueryLog(),
            'hasil' => $cara_bayar
        ]);

        // Format data untuk grafik poli dengan 3 bar per poli
        $poli_data = [
            'labels' => array_map(fn($item) => $item->nm_poli, $kunjungan_poli),
            'datasets' => [
                [
                    'label' => 'Total Kunjungan',
                    'data' => array_map(fn($item) => $item->total_kunjungan, $kunjungan_poli),
                    'backgroundColor' => 'rgba(99, 102, 241, 0.8)',
                    'borderRadius' => 8,
                ],
                [
                    'label' => 'Sudah Dilayani',
                    'data' => array_map(fn($item) => $item->sudah_dilayani, $kunjungan_poli),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.8)',
                    'borderRadius' => 8,
                ],
                [
                    'label' => 'Sudah Bayar',
                    'data' => array_map(fn($item) => $item->sudah_bayar, $kunjungan_poli),
                    'backgroundColor' => 'rgba(249, 115, 22, 0.8)',
                    'borderRadius' => 8,
                ]
            ]
        ];

        // Data untuk view
        $data = [
            'update_time' => Carbon::now()->format('H:i'),
            'rawat_inap' => [
                'total_pasien' => $total_pasien,
                'pasien_masuk' => $pasien_masuk,
                'pasien_keluar' => $pasien_keluar,
                'okupansi' => $okupansi,
                'total_tt' => $kamar_stats->total_tt,
                'tt_terisi' => $kamar_stats->terisi,
                'avg_los' => $avg_los->avg_los ?? 0,
                'perubahan' => $perubahan_ri
            ],
            'rawat_jalan' => [
                'total_kunjungan' => $rawat_jalan->total_kunjungan ?? 0,
                'pasien_baru' => $rawat_jalan->pasien_baru ?? 0,
                'pasien_lama' => $rawat_jalan->pasien_lama ?? 0,
                'perubahan' => $perubahan_rj
            ],
            'igd' => [
                'total_kunjungan' => $igd->total_kunjungan ?? 0,
                'lanjut_rawat_inap' => $igd->lanjut_rawat_inap ?? 0,
                'pasien_pulang' => $igd->pasien_pulang ?? 0,
                'perubahan' => $perubahan_igd
            ],
            'filter' => request('filter', 'minggu'),
            'chart_data' => $chartData,
            'poli_chart' => $poli_data,
            'bayar_chart' => $bayar_data
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

        // Debug final data
        \Log::info('Final Data Check:', [
            'tanggal' => date('Y-m-d H:i:s'),
            'rawat_jalan' => $data['rawat_jalan'],
            'rawat_inap' => $data['rawat_inap'],
            'igd' => $data['igd']
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

    public function getCaraBayar()
    {
        try {
            $caraBayar = DB::table('reg_periksa as rp')
                ->join('penjab as p', 'rp.kd_pj', '=', 'p.kd_pj')
                ->whereDate('rp.tgl_registrasi', now())
                ->select('p.png_jawab', DB::raw('COUNT(*) as total'))
                ->groupBy('p.png_jawab')
                ->get();

            // Debug: Lihat hasil query
            \Log::info('Query Result:', $caraBayar->toArray());

            // Transform data untuk format yang dibutuhkan chart
            $formattedData = $caraBayar->map(function($item) {
                return [
                    'name' => $item->png_jawab,
                    'total' => (int)$item->total
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $formattedData
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getCaraBayar: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data cara bayar'
            ], 500);
        }
    }
} 