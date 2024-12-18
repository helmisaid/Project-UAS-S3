<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Barang;
use App\Models\Service;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function indexlogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ]);
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function dashboard()
{
    $user = Auth::user(); // Get the currently logged-in user
    $menus = DB::table('menu')
        ->whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })
        ->orderBy('parent_id')
        ->get();

    $today = Carbon::today()->toDateString();

    // Today's sales and invoices
    $todaySales = DB::table('penjualan')
        ->whereDate('created_at', $today)
        ->sum('total_nilai');

    $todayInvoices = DB::table('penjualan')
        ->whereDate('created_at', $today)
        ->count();

    // Statistics
    $totalItemsSold = DB::table('detail_penjualan')
        ->join('penjualan', 'penjualan.idpenjualan', '=', 'detail_penjualan.penjualan_idpenjualan')
        ->whereDate('penjualan.created_at', $today)
        ->sum('detail_penjualan.jumlah');

    $totalItems = DB::table('barang')->count();

    $totalInvoices = DB::table('penjualan')
        ->whereDate('created_at', $today)
        ->count();

    // Service statistics
    $newServices = DB::table('service')
        ->whereDate('tanggal', $today)
        ->where('status', 'not started')
        ->count();

    $inProcessServices = DB::table('service')
        ->where('status', 'pending')
        ->count();

    $readyServices = DB::table('service')
        ->where('status', 'completed')
        ->count();

    $completedServices = DB::table('service')
        ->whereDate('tanggal', $today)
        ->where('status', 'completed')
        ->count();

    // Popular items
    $popularItems = DB::table('detail_penjualan')
        ->select('barang.nama', DB::raw('SUM(detail_penjualan.jumlah) as total_sold'))
        ->join('barang', 'barang.idbarang', '=', 'detail_penjualan.barang_idbarang')
        ->groupBy('barang.idbarang', 'barang.nama')
        ->orderByDesc('total_sold')
        ->limit(5)
        ->get();

    // Low stock items
    $lowStockItems = DB::table('barang')
        ->select('barang.nama', 'kartu_stok.stock')
        ->joinSub(
            DB::table('kartu_stok')
                ->select('idbarang', 'stock')
                ->whereIn('idkartu_stk', function($query) {
                    $query->select(DB::raw('MAX(idkartu_stk)'))
                        ->from('kartu_stok')
                        ->groupBy('idbarang');
                }),
            'kartu_stok',
            'barang.idbarang',
            '=',
            'kartu_stok.idbarang'
        )
        ->orderBy('kartu_stok.stock', 'asc')
        ->limit(5)
        ->get();

    return view('dashboard', compact(
        'todaySales',
        'todayInvoices',
        'totalItemsSold',
        'totalItems',
        'totalInvoices',
        'newServices',
        'inProcessServices',
        'readyServices',
        'completedServices',
        'popularItems',
        'lowStockItems',
        'menus'
    ));
}
}
