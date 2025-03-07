<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

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

        // Query untuk total piutang
        $total_piutang = DB::select("
            SELECT 
                COALESCE(SUM(totalpiutang), 0) as total_piutang
            FROM 
                piutang_pasien
            WHERE 
                status = 'Belum Lunas'
        ")[0]->total_piutang;

        // Query untuk sisa piutang (jatuh tempo)
        $sisa_piutang = DB::select("
            SELECT 
                COALESCE(SUM(
                    totalpiutang - uangmuka - 
                    COALESCE((
                        SELECT SUM(besar_cicilan) 
                        FROM bayar_piutang 
                        WHERE bayar_piutang.no_rawat = piutang_pasien.no_rawat
                    ), 0) -
                    COALESCE((
                        SELECT SUM(diskon_piutang) 
                        FROM bayar_piutang 
                        WHERE bayar_piutang.no_rawat = piutang_pasien.no_rawat
                    ), 0) -
                    COALESCE((
                        SELECT SUM(tidak_terbayar) 
                        FROM bayar_piutang 
                        WHERE bayar_piutang.no_rawat = piutang_pasien.no_rawat
                    ), 0)
                ), 0) as sisa_piutang
            FROM 
                piutang_pasien
            WHERE 
                status = 'Belum Lunas'
        ")[0]->sisa_piutang;

        // Query untuk piutang lunas (total - sisa)
        $piutang_lunas = $total_piutang - $sisa_piutang;

        // Query untuk grafik laba rugi berdasarkan filter
        $filter = request('filter', 'hari');
        $labaRugiQuery = match($filter) {
            'hari' => "
                SELECT 
                    hours.periode,
                    COALESCE(SUM(ts.jumlah_bayar), 0) as pendapatan,
                    COALESCE(SUM(ph.biaya), 0) as pengeluaran
                FROM (
                    SELECT DATE_FORMAT(CURRENT_TIMESTAMP - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) HOUR, '%H:00') AS periode
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
                    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
                    WHERE DATE_FORMAT(CURRENT_TIMESTAMP - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) HOUR, '%H:00') BETWEEN '00:00' AND '23:00'
                ) hours
                LEFT JOIN tagihan_sadewa ts ON DATE(ts.tgl_bayar) = CURDATE() 
                    AND DATE_FORMAT(ts.tgl_bayar, '%H:00') = hours.periode
                LEFT JOIN pengeluaran_harian ph ON DATE(ph.tanggal) = CURDATE() 
                    AND DATE_FORMAT(ph.tanggal, '%H:00') = hours.periode
                GROUP BY hours.periode
                ORDER BY hours.periode
            ",
            'minggu' => "
                SELECT 
                    dates.periode,
                    COALESCE(SUM(ts.jumlah_bayar), 0) as pendapatan,
                    COALESCE(SUM(ph.biaya), 0) as pengeluaran
                FROM (
                    SELECT DATE(CURDATE() - INTERVAL (a.a + (10 * b.a)) DAY) as periode
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
                    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                    WHERE DATE(CURDATE() - INTERVAL (a.a + (10 * b.a)) DAY) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                ) dates
                LEFT JOIN tagihan_sadewa ts ON DATE(ts.tgl_bayar) = dates.periode
                LEFT JOIN pengeluaran_harian ph ON DATE(ph.tanggal) = dates.periode
                GROUP BY dates.periode
                ORDER BY dates.periode
            ",
            'bulan' => "
                SELECT 
                    dates.periode,
                    COALESCE(SUM(ts.jumlah_bayar), 0) as pendapatan,
                    COALESCE(SUM(ph.biaya), 0) as pengeluaran
                FROM (
                    SELECT DATE(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01') + INTERVAL (a.a + (10 * b.a)) DAY) as periode
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
                    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                    WHERE DATE(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01') + INTERVAL (a.a + (10 * b.a)) DAY) <= LAST_DAY(CURRENT_DATE())
                ) dates
                LEFT JOIN tagihan_sadewa ts ON DATE(ts.tgl_bayar) = dates.periode
                LEFT JOIN pengeluaran_harian ph ON DATE(ph.tanggal) = dates.periode
                GROUP BY dates.periode
                ORDER BY dates.periode
            "
        };

        // Debug query laba rugi
        \Log::info('Query Laba Rugi:', [
            'filter' => $filter,
            'query' => $labaRugiQuery
        ]);

        $labaRugiData = DB::select($labaRugiQuery);

        // Debug hasil query
        \Log::info('Hasil Query Laba Rugi:', [
            'data' => $labaRugiData
        ]);

        // Format data untuk chart laba rugi
        $labels = [];
        $pendapatan = [];
        $pengeluaran = [];

        foreach ($labaRugiData as $row) {
            $labels[] = $filter === 'hari' 
                ? $row->periode 
                : Carbon::parse($row->periode)->format('d M');
            $pendapatan[] = (float)$row->pendapatan;
            $pengeluaran[] = (float)$row->pengeluaran;
        }

        $labaRugiChart = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $pendapatan,
                    'borderColor' => 'rgb(34, 197, 94)', // green-500
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'fill' => true,
                    'tension' => 0.4
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $pengeluaran,
                    'borderColor' => 'rgb(239, 68, 68)', // red-500
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'fill' => true,
                    'tension' => 0.4
                ]
            ]
        ];

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

        \Log::info('Debug Query Piutang:', [
            'tanggal' => date('Y-m-d H:i:s'),
            'total_piutang' => [
                'query' => "SELECT SUM(totalpiutang) FROM piutang_pasien WHERE status = 'Belum Lunas'",
                'hasil' => $total_piutang
            ],
            'sisa_piutang' => [
                'query' => "SELECT kompleks query sisa piutang...",
                'hasil' => $sisa_piutang
            ],
            'piutang_lunas' => [
                'kalkulasi' => 'total_piutang - sisa_piutang',
                'hasil' => $piutang_lunas
            ]
        ]);

        // Query untuk kas awal
        $kasAwalQuery = "
            SELECT COALESCE(SUM(rekeningtahun.saldo_awal), 0) as kas_awal
            FROM rekening
            INNER JOIN rekeningtahun ON rekening.kd_rek = rekeningtahun.kd_rek
            WHERE rekening.tipe = 'N' 
            AND rekening.balance = 'D'
            AND rekeningtahun.thn = YEAR(CURDATE())
        ";

        // Query untuk kas masuk dan keluar per periode
        $arusKasQuery = match($filter) {
            'hari' => "
                SELECT 
                    hours.periode,
                    COALESCE(SUM(CASE WHEN r.balance = 'K' THEN dj.kredit - dj.debet ELSE 0 END), 0) as kas_masuk,
                    COALESCE(SUM(CASE WHEN r.balance = 'D' THEN dj.debet - dj.kredit ELSE 0 END), 0) as kas_keluar
                FROM (
                    SELECT DATE_FORMAT(CURRENT_TIMESTAMP - INTERVAL (a.a + (10 * b.a)) HOUR, '%H:00') AS periode
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
                    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                    WHERE DATE_FORMAT(CURRENT_TIMESTAMP - INTERVAL (a.a + (10 * b.a)) HOUR, '%H:00') BETWEEN '00:00' AND '23:00'
                ) hours
                LEFT JOIN jurnal j ON DATE(j.tgl_jurnal) = CURDATE()
                LEFT JOIN detailjurnal dj ON j.no_jurnal = dj.no_jurnal
                LEFT JOIN rekening r ON dj.kd_rek = r.kd_rek AND r.tipe = 'R'
                WHERE DATE_FORMAT(j.tgl_jurnal, '%H:00') = hours.periode
                GROUP BY hours.periode
                ORDER BY hours.periode
            ",
            'minggu' => "
                SELECT 
                    dates.periode,
                    COALESCE(SUM(CASE WHEN r.balance = 'K' THEN dj.kredit - dj.debet ELSE 0 END), 0) as kas_masuk,
                    COALESCE(SUM(CASE WHEN r.balance = 'D' THEN dj.debet - dj.kredit ELSE 0 END), 0) as kas_keluar
                FROM (
                    SELECT DATE(CURDATE() - INTERVAL (a.a) DAY) as periode
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6) AS a
                    WHERE DATE(CURDATE() - INTERVAL a.a DAY) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                ) dates
                LEFT JOIN jurnal j ON DATE(j.tgl_jurnal) = dates.periode
                LEFT JOIN detailjurnal dj ON j.no_jurnal = dj.no_jurnal
                LEFT JOIN rekening r ON dj.kd_rek = r.kd_rek AND r.tipe = 'R'
                GROUP BY dates.periode
                ORDER BY dates.periode
            ",
            'bulan' => "
                SELECT 
                    dates.periode,
                    COALESCE(SUM(CASE WHEN r.balance = 'K' THEN dj.kredit - dj.debet ELSE 0 END), 0) as kas_masuk,
                    COALESCE(SUM(CASE WHEN r.balance = 'D' THEN dj.debet - dj.kredit ELSE 0 END), 0) as kas_keluar
                FROM (
                    SELECT DATE(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01') + INTERVAL (a.a) DAY) as periode
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 
                    UNION ALL SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15 UNION ALL SELECT 16 UNION ALL SELECT 17 UNION ALL SELECT 18 UNION ALL SELECT 19 UNION ALL SELECT 20
                    UNION ALL SELECT 21 UNION ALL SELECT 22 UNION ALL SELECT 23 UNION ALL SELECT 24 UNION ALL SELECT 25 UNION ALL SELECT 26 UNION ALL SELECT 27 UNION ALL SELECT 28 UNION ALL SELECT 29 UNION ALL SELECT 30) AS a
                    WHERE DATE(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01') + INTERVAL a.a DAY) <= LAST_DAY(CURRENT_DATE())
                ) dates
                LEFT JOIN jurnal j ON DATE(j.tgl_jurnal) = dates.periode
                LEFT JOIN detailjurnal dj ON j.no_jurnal = dj.no_jurnal
                LEFT JOIN rekening r ON dj.kd_rek = r.kd_rek AND r.tipe = 'R'
                GROUP BY dates.periode
                ORDER BY dates.periode
            "
        };

        // Eksekusi query
        $kasAwal = DB::select($kasAwalQuery)[0]->kas_awal;
        $arusKasData = collect(DB::select($arusKasQuery));

        // Format data untuk chart arus kas
        $chartLabels = $arusKasData->pluck('periode')->map(function($periode) use ($filter) {
            return $filter === 'hari' ? $periode : Carbon::parse($periode)->format('d M');
        })->toArray();

        $kasMasukChart = $arusKasData->pluck('kas_masuk')->toArray();
        $kasKeluarChart = $arusKasData->pluck('kas_keluar')->toArray();
        
        // Hitung total kas (running balance)
        $totalKasChart = [];
        $runningTotal = $kasAwal;
        
        foreach ($arusKasData as $data) {
            $runningTotal += ($data->kas_masuk - $data->kas_keluar);
            $totalKasChart[] = $runningTotal;
        }

        // Data untuk cards dan grafik
        $data = [
            'pendapatan_hari' => $pendapatan_hari,
            'pendapatan_bulan' => $pendapatan_bulan,
            'pendapatan_tahun' => $pendapatan_tahun,
            'pengeluaran_hari' => $pengeluaran_hari,
            'pengeluaran_bulan' => $pengeluaran_bulan,
            'pengeluaran_tahun' => $pengeluaran_tahun,
            'total_piutang' => $total_piutang,
            'piutang_jatuh_tempo' => $sisa_piutang,
            'piutang_lunas' => $piutang_lunas,
            
            // Data untuk grafik laba rugi
            'laba_rugi_chart' => $labaRugiChart,

            // Data untuk grafik arus kas
            'arus_kas_chart' => [
                'labels' => $chartLabels,
                'datasets' => [
                    [
                        'label' => 'Total Kas',
                        'data' => $totalKasChart,
                        'borderColor' => 'rgb(34, 197, 94)',
                        'borderWidth' => 2,
                        'tension' => 0.4,
                        'pointRadius' => 0
                    ],
                    [
                        'label' => 'Kas Masuk',
                        'data' => $kasMasukChart,
                        'borderColor' => 'rgb(59, 130, 246)',
                        'borderWidth' => 2,
                        'tension' => 0.4,
                        'pointRadius' => 0
                    ],
                    [
                        'label' => 'Kas Keluar',
                        'data' => $kasKeluarChart,
                        'borderColor' => 'rgb(239, 68, 68)',
                        'borderWidth' => 2,
                        'tension' => 0.4,
                        'pointRadius' => 0
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

    public function getArusKasData(Request $request)
    {
        $filter = $request->get('filter', 'hari');
        
        // Query untuk kas awal
        $kasAwalQuery = "
            SELECT COALESCE(SUM(rekeningtahun.saldo_awal), 0) as kas_awal
            FROM rekening
            INNER JOIN rekeningtahun ON rekening.kd_rek = rekeningtahun.kd_rek
            WHERE rekening.tipe = 'N' 
            AND rekening.balance = 'D'
            AND rekeningtahun.thn = YEAR(CURDATE())
        ";

        // Query untuk kas masuk dan keluar per periode
        $arusKasQuery = match($filter) {
            'hari' => "
                SELECT 
                    hours.periode,
                    COALESCE(SUM(CASE WHEN r.balance = 'K' THEN dj.kredit - dj.debet ELSE 0 END), 0) as kas_masuk,
                    COALESCE(SUM(CASE WHEN r.balance = 'D' THEN dj.debet - dj.kredit ELSE 0 END), 0) as kas_keluar
                FROM (
                    SELECT DATE_FORMAT(CURRENT_TIMESTAMP - INTERVAL (a.a + (10 * b.a)) HOUR, '%H:00') AS periode
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
                    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                    WHERE DATE_FORMAT(CURRENT_TIMESTAMP - INTERVAL (a.a + (10 * b.a)) HOUR, '%H:00') BETWEEN '00:00' AND '23:00'
                ) hours
                LEFT JOIN jurnal j ON DATE(j.tgl_jurnal) = CURDATE()
                LEFT JOIN detailjurnal dj ON j.no_jurnal = dj.no_jurnal
                LEFT JOIN rekening r ON dj.kd_rek = r.kd_rek AND r.tipe = 'R'
                WHERE DATE_FORMAT(j.tgl_jurnal, '%H:00') = hours.periode
                GROUP BY hours.periode
                ORDER BY hours.periode
            ",
            'minggu' => "
                SELECT 
                    dates.periode,
                    COALESCE(SUM(CASE WHEN r.balance = 'K' THEN dj.kredit - dj.debet ELSE 0 END), 0) as kas_masuk,
                    COALESCE(SUM(CASE WHEN r.balance = 'D' THEN dj.debet - dj.kredit ELSE 0 END), 0) as kas_keluar
                FROM (
                    SELECT DATE(CURDATE() - INTERVAL (a.a) DAY) as periode
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6) AS a
                    WHERE DATE(CURDATE() - INTERVAL a.a DAY) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                ) dates
                LEFT JOIN jurnal j ON DATE(j.tgl_jurnal) = dates.periode
                LEFT JOIN detailjurnal dj ON j.no_jurnal = dj.no_jurnal
                LEFT JOIN rekening r ON dj.kd_rek = r.kd_rek AND r.tipe = 'R'
                GROUP BY dates.periode
                ORDER BY dates.periode
            ",
            'bulan' => "
                SELECT 
                    dates.periode,
                    COALESCE(SUM(CASE WHEN r.balance = 'K' THEN dj.kredit - dj.debet ELSE 0 END), 0) as kas_masuk,
                    COALESCE(SUM(CASE WHEN r.balance = 'D' THEN dj.debet - dj.kredit ELSE 0 END), 0) as kas_keluar
                FROM (
                    SELECT DATE(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01') + INTERVAL (a.a) DAY) as periode
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 
                    UNION ALL SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15 UNION ALL SELECT 16 UNION ALL SELECT 17 UNION ALL SELECT 18 UNION ALL SELECT 19 UNION ALL SELECT 20
                    UNION ALL SELECT 21 UNION ALL SELECT 22 UNION ALL SELECT 23 UNION ALL SELECT 24 UNION ALL SELECT 25 UNION ALL SELECT 26 UNION ALL SELECT 27 UNION ALL SELECT 28 UNION ALL SELECT 29 UNION ALL SELECT 30) AS a
                    WHERE DATE(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01') + INTERVAL a.a DAY) <= LAST_DAY(CURRENT_DATE())
                ) dates
                LEFT JOIN jurnal j ON DATE(j.tgl_jurnal) = dates.periode
                LEFT JOIN detailjurnal dj ON j.no_jurnal = dj.no_jurnal
                LEFT JOIN rekening r ON dj.kd_rek = r.kd_rek AND r.tipe = 'R'
                GROUP BY dates.periode
                ORDER BY dates.periode
            "
        };

        // Format data untuk chart
        $kasAwal = DB::select($kasAwalQuery)[0]->kas_awal;
        $arusKasData = collect(DB::select($arusKasQuery));

        $chartLabels = $arusKasData->pluck('periode')->map(function($periode) use ($filter) {
            return $filter === 'hari' ? $periode : Carbon::parse($periode)->format('d M');
        })->toArray();

        $kasMasukChart = $arusKasData->pluck('kas_masuk')->toArray();
        $kasKeluarChart = $arusKasData->pluck('kas_keluar')->toArray();
        
        // Hitung total kas (running balance)
        $totalKasChart = [];
        $runningTotal = $kasAwal;
        
        foreach ($arusKasData as $data) {
            $runningTotal += ($data->kas_masuk - $data->kas_keluar);
            $totalKasChart[] = $runningTotal;
        }

        return response()->json([
            'labels' => $chartLabels,
            'datasets' => [
                [
                    'label' => 'Total Kas',
                    'data' => $totalKasChart,
                    'borderColor' => 'rgb(34, 197, 94)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'pointRadius' => 0
                ],
                [
                    'label' => 'Kas Masuk',
                    'data' => $kasMasukChart,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'pointRadius' => 0
                ],
                [
                    'label' => 'Kas Keluar',
                    'data' => $kasKeluarChart,
                    'borderColor' => 'rgb(239, 68, 68)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'pointRadius' => 0
                ]
            ]
        ]);
    }

    public function getLabaRugiData(Request $request)
    {
        $filter = $request->get('filter', 'minggu'); // Default filter minggu ini
        
        $query = match($filter) {
            'minggu' => "
                SELECT 
                    dates.periode as tanggal,
                    COALESCE(SUM(ts.jumlah_bayar), 0) as pendapatan,
                    COALESCE(SUM(ph.biaya), 0) as pengeluaran
                FROM (
                    SELECT DATE(DATE_SUB(CURRENT_DATE(), INTERVAL (a.a) DAY)) as periode
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 
                          UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6) AS a
                ) dates
                LEFT JOIN tagihan_sadewa ts ON DATE(ts.tgl_bayar) = dates.periode
                LEFT JOIN pengeluaran_harian ph ON DATE(ph.tanggal) = dates.periode
                GROUP BY dates.periode
                ORDER BY dates.periode ASC
            ",
            'bulan' => "
                SELECT 
                    dates.periode as tanggal,
                    COALESCE(SUM(ts.jumlah_bayar), 0) as pendapatan,
                    COALESCE(SUM(ph.biaya), 0) as pengeluaran
                FROM (
                    SELECT DATE(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01') + INTERVAL (a.a) DAY) as periode
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
                          UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
                          UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14
                          UNION ALL SELECT 15 UNION ALL SELECT 16 UNION ALL SELECT 17 UNION ALL SELECT 18 UNION ALL SELECT 19
                          UNION ALL SELECT 20 UNION ALL SELECT 21 UNION ALL SELECT 22 UNION ALL SELECT 23 UNION ALL SELECT 24
                          UNION ALL SELECT 25 UNION ALL SELECT 26 UNION ALL SELECT 27 UNION ALL SELECT 28 UNION ALL SELECT 29 
                          UNION ALL SELECT 30) AS a
                    WHERE DATE(DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01') + INTERVAL a.a DAY) <= LAST_DAY(CURRENT_DATE())
                ) dates
                LEFT JOIN tagihan_sadewa ts ON DATE(ts.tgl_bayar) = dates.periode
                LEFT JOIN pengeluaran_harian ph ON DATE(ph.tanggal) = dates.periode
                GROUP BY dates.periode
                ORDER BY dates.periode ASC
            ",
            'tahun' => "
                SELECT 
                    DATE_FORMAT(dates.periode, '%Y-%m') as tanggal,
                    COALESCE(SUM(ts.jumlah_bayar), 0) as pendapatan,
                    COALESCE(SUM(ph.biaya), 0) as pengeluaran
                FROM (
                    SELECT LAST_DAY(DATE_SUB(CURRENT_DATE(), INTERVAL a.a MONTH)) as periode
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 
                          UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7
                          UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11) AS a
                ) dates
                LEFT JOIN tagihan_sadewa ts ON DATE_FORMAT(ts.tgl_bayar, '%Y-%m') = DATE_FORMAT(dates.periode, '%Y-%m')
                LEFT JOIN pengeluaran_harian ph ON DATE_FORMAT(ph.tanggal, '%Y-%m') = DATE_FORMAT(dates.periode, '%Y-%m')
                GROUP BY DATE_FORMAT(dates.periode, '%Y-%m')
                ORDER BY tanggal ASC
            "
        };

        $data = DB::select($query);

        // Format data untuk chart
        $labels = [];
        $pendapatan = [];
        $pengeluaran = [];

        foreach ($data as $row) {
            $labels[] = match($filter) {
                'minggu' => Carbon::parse($row->tanggal)->format('D, d M'),
                'bulan' => Carbon::parse($row->tanggal)->format('d M'),
                'tahun' => Carbon::parse($row->tanggal)->format('M Y')
            };
            $pendapatan[] = (float)$row->pendapatan;
            $pengeluaran[] = (float)$row->pengeluaran;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $pendapatan,
                    'borderColor' => 'rgb(34, 197, 94)', // green-500
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'fill' => true,
                    'tension' => 0.4
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $pengeluaran,
                    'borderColor' => 'rgb(239, 68, 68)', // red-500
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'fill' => true,
                    'tension' => 0.4
                ]
            ]
        ];
    }
} 