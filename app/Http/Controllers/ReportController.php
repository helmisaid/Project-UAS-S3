<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function profitReport()
{
    $user = Auth::user(); // Dapatkan user yang sedang login

    // Ambil daftar menu berdasarkan user
    $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
        $query->select('menu_id')
            ->from('setting_menu_user')
            ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
    })->orderBy('parent_id')->get();

    // Hitung total penjualan
    $totalSales = DB::table('penjualan')->sum('total_nilai');

    // Hitung total service
    $totalService = DB::table('service')->sum('total_nilai');

    // Hitung biaya operasional dari tabel pengadaan
    $biayaOperasional = DB::table('pengadaan')->sum('total_nilai');

    // Hitung pendapatan bersih
    $pendapatanBersih = $totalSales + $totalService;

    // Hitung laba bersih
    $labaBersih = $pendapatanBersih - $biayaOperasional;

    // Kirim data ke view
    return view('laporan.profit_report', [
        'menus' => $menus,
        'totalSales' => $totalSales,
        'totalService' => $totalService,
        'pendapatanBersih' => $pendapatanBersih,
        'biayaOperasional' => $biayaOperasional,
        'labaBersih' => $labaBersih,
    ]);
}

// public function downloadProfitReport()
//     {
//         $totalSales = DB::table('penjualan')->sum('total_nilai');
//         $totalService = DB::table('service')->sum('total_nilai');
//         $biayaOperasional = DB::table('pengadaan')->sum('total_nilai');

//         $pendapatanBersih = $totalSales + $totalService;
//         $labaBersih = $pendapatanBersih - $biayaOperasional;

//         $pdf = Pdf::loadView('laporan.pdf_profit_report', compact(
//             'totalSales', 'totalService', 'pendapatanBersih', 'biayaOperasional', 'labaBersih'
//         ));

//         return $pdf->download('laporan_profit.pdf');
//     }

public function showSalesReport()
{
    $user = Auth::user(); // Dapatkan user yang sedang login

    // Ambil daftar menu berdasarkan user
    $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
        $query->select('menu_id')
            ->from('setting_menu_user')
            ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
    })->orderBy('parent_id')->get();

    $today = Carbon::today()->toDateString();

    // Fetch today's total sales and invoices
    $todaySales = DB::table('penjualan')
        ->whereDate('created_at', $today)
        ->sum('total_nilai');

    // Cek jika tidak ada data, beri nilai default
    $todaySales = $todaySales ?: 0;

    $todayInvoices = DB::table('penjualan')
        ->whereDate('created_at', $today)
        ->count();

    // Cek jika tidak ada data, beri nilai default
    $todayInvoices = $todayInvoices ?: 0;

    // Fetch sales statistics
    $totalItemsSold = DB::table('detail_penjualan')
        ->join('penjualan', 'penjualan.idpenjualan', '=', 'detail_penjualan.penjualan_idpenjualan')
        ->whereDate('penjualan.created_at', $today)
        ->sum('detail_penjualan.jumlah');

    // Cek jika tidak ada data, beri nilai default
    $totalItemsSold = $totalItemsSold ?: 0;

    $totalInvoices = DB::table('penjualan')
        ->whereDate('created_at', $today)
        ->count();

    // Cek jika tidak ada data, beri nilai default
    $totalInvoices = $totalInvoices ?: 0;

    // Calculate monthly sales and cost
    $monthlyData = DB::table('penjualan')
        ->join('detail_penjualan', 'penjualan.idpenjualan', '=', 'detail_penjualan.penjualan_idpenjualan')
        ->select(
            DB::raw('MONTH(penjualan.created_at) as month'),
            DB::raw('SUM(penjualan.total_nilai) as total_sales')
        )
        ->whereYear('penjualan.created_at', Carbon::now()->year) // Filter berdasarkan tahun berjalan
        ->groupBy(DB::raw('MONTH(penjualan.created_at)'))
        ->orderBy('month')
        ->get();

    // Calculate total cost from pengadaan
    $monthlyCosts = DB::table('pengadaan')
        ->join('detail_pengadaan', 'pengadaan.idpengadaan', '=', 'detail_pengadaan.idpengadaan')
        ->select(
            DB::raw('MONTH(pengadaan.timestamp) as month'),
            DB::raw('SUM(detail_pengadaan.harga_satuan * detail_pengadaan.jumlah) as total_cost')
        )
        ->whereYear('pengadaan.timestamp', Carbon::now()->year)
        ->groupBy(DB::raw('MONTH(pengadaan.timestamp)'))
        ->orderBy('month')
        ->get()
        ->keyBy('month'); // Key by month for easier mapping

    // Combine sales and costs
    $profitData = $monthlyData->map(function($item) use ($monthlyCosts) {
        $totalCost = $monthlyCosts->get($item->month)->total_cost ?? 0; // Default to 0 if no cost data
        return [
            'month' => $item->month,
            'month_name' => Carbon::createFromDate(null, $item->month)->translatedFormat('F'), // Ubah angka bulan menjadi nama bulan
            'total_sales' => $item->total_sales,
            'total_cost' => $totalCost,
            'profit' => $item->total_sales - $totalCost // Hitung laba
        ];
    });

    // Prepare the sales data for the chart
    $salesData = $profitData->map(function($item) {
        return [
            'month' => $item['month'],
            'total_sales' => $item['total_sales']
        ];
    });

  
    return view('reports.sales', compact(
        'todaySales',
        'todayInvoices',
        'totalItemsSold',
        'totalInvoices',
        'menus',
        'salesData',
        'profitData'
    ));
}

}

