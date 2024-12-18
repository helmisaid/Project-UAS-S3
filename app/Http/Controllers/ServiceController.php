<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Barang;
use App\Models\Layanan;
use App\Models\Service;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\DetailService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        $layanans = Layanan::all();
        $mekaniks = Karyawan::where('id_jenis_karyawan', 4)->get();
        $barangs = Barang::all();
        return view('service.index', compact('layanans', 'mekaniks', 'barangs', 'menus'));
    }


    public function store(Request $request)
{
    $request->validate([
        'id_mekanik' => 'required|integer',
        'nama_pelanggan' => 'required|string',
        'no_telp' => 'required|string',
        'jenis_kendaraan' => 'required|string',
        'no_pol' => 'required|string',
        'items' => 'required|array|min:1',
        'items.*.id_layanan' => 'nullable|integer',
        'items.*.id_barang' => 'nullable|integer',
        'items.*.jumlah' => 'required|integer|min:1',
    ]);

    $userId = Auth::id();
    $items = $request->input('items');

    $harga_barang = 0;
    $harga_layanan = 0;

    foreach ($items as $item) {
        if (isset($item['id_layanan'])) {
            $layanan = Layanan::find($item['id_layanan']);
            $harga_layanan += $layanan ? $layanan->harga_layanan * $item['jumlah'] : 0;
        }

        if (isset($item['id_barang'])) {
            $barang = Barang::find($item['id_barang']);
            $harga_barang += $barang ? $barang->harga * $item['jumlah'] : 0;
        }
    }

// Menjumlahkan total harga barang dan harga layanan
$subtotal = $harga_barang + $harga_layanan;

// Menghitung diskon dan PPN
$discountPercentage = $request->input('discount', 0);
$discountAmount = $subtotal * ($discountPercentage / 100);  // Diskon berdasarkan subtotal
$ppnPercentage = $request->input('ppn', 0);
$ppntotal = $subtotal * ($ppnPercentage / 100);  // PPN berdasarkan subtotal

// Menghitung total nilai setelah diskon dan PPN
$total = $subtotal + $ppntotal - $discountAmount;

    if ($request->input('payment', 0) < $total) {
        return response()->json(['success' => false, 'message' => 'Jumlah pembayaran kurang dari total.']);
    }

    // Generate custom id_service
    $todayDate = now()->format('Ymd'); // Format tanggal: Ymd (20241217)
    $lastService = Service::whereDate('tanggal', now()->toDateString())
                        ->orderBy('nomor_antrian', 'desc')
                        ->first();
    $nomorAntrian = $lastService ? $lastService->nomor_antrian + 1 : 1;
    $idService = "SVC-{$todayDate}-{$nomorAntrian}";

    $service = null;

    DB::transaction(function () use ($request, $userId, $items, $subtotal, $total, $discountAmount, $ppntotal, $idService, &$service) {
        // Create service record
        $service = Service::create([
            'id_service' => $idService, // Use custom ID here
            'id_karyawan' => $userId,
            'id_mekanik' => $request->input('id_mekanik'),
            'nomor_antrian' => explode('-', $idService)[2], // Get nomor antrian from ID
            'nama_pelanggan' => $request->input('nama_pelanggan'),
            'no_telp' => $request->input('no_telp'),
            'jenis_kendaraan' => $request->input('jenis_kendaraan'),
            'no_pol' => $request->input('no_pol'),
            'tanggal' => now(),
            'subtotal_nilai' => $subtotal,
            'total_nilai' => $total,
            'total_bayar' => $request->input('payment'),
            'diskon' => $discountAmount,
            'ppn' => $ppntotal,
            'status' => 'not started',
            'keterangan' => $request->input('keterangan'),
        ]);


        foreach ($items as $item) {
            if (isset($item['id_layanan'])) {
                $id_layanan = $item['id_layanan'];
                $id_barang = null;
                $harga = Layanan::find($id_layanan)->harga_layanan;
            } else {
                $id_layanan = null;
                $id_barang = $item['id_barang'];
                $harga = Barang::find($id_barang)->harga;
            }

            DetailService::create([
                'id_service' => $service->id_service,
                'id_layanan' => $id_layanan,
                'id_barang' => $id_barang,
                'jumlah' => $item['jumlah'],
                'subtotal' => $harga * $item['jumlah'],
            ]);
        }
    });

    if ($request->ajax()) {
        return response()->json(['success' => true, 'service' => $service]);
    }

    return redirect()->route('service.index')->with('success', 'Transaksi service berhasil ditambahkan');
}

public function listjob()
{
    $user = Auth::user(); // Dapatkan user yang sedang login
    $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
        $query->select('menu_id')
            ->from('setting_menu_user')
            ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
    })->orderBy('parent_id')->get();

    $mekanik_id = Auth::id();  // Ambil ID mekanik yang sedang login

    // Ambil semua service yang dikerjakan oleh mekanik ini dengan detail_service-nya
    $services = Service::with('detailService')->where('id_mekanik', $mekanik_id)->get();

    return view('service.job', compact('services', 'menus'));
}


    public function updateStatus(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->status = $request->status;
        $service->save();

        return redirect()->route('service.job')->with('success', 'Status service berhasil diupdate.');
    }
}


