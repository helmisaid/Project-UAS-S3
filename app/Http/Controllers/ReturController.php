<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReturController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        return view('retur.index', compact('menus'));
    }

    public function loadDetail(Request $request)
    {
        // Validasi ID Pengadaan
        $idPengadaan = $request->input('idpengadaan');

        if (!$idPengadaan) {
            return response()->json(['message' => 'ID Pengadaan tidak ditemukan'], 400);
        }

        // Query gabungan untuk mengambil data penerimaan dan detail penerimaan dalam satu query
        $data = DB::table('penerimaan')
            ->join('detail_penerimaan', 'penerimaan.idpenerimaan', '=', 'detail_penerimaan.idpenerimaan')
            ->join('barang', 'detail_penerimaan.barang_idbarang', '=', 'barang.idbarang')
            ->join('karyawan', 'penerimaan.id_karyawan', '=', 'karyawan.id_karyawan')
            ->where('penerimaan.idpengadaan', $idPengadaan)
            ->select(
                'penerimaan.idpenerimaan',
                'penerimaan.created_at',
                'penerimaan.status',
                'karyawan.nama_karyawan as nama_user',
                'detail_penerimaan.iddetail_penerimaan',
                'detail_penerimaan.jumlah_terima',
                'detail_penerimaan.harga_satuan_terima',
                'detail_penerimaan.sub_total_terima',
                'barang.nama as nama_barang',
                'detail_penerimaan.barang_idbarang'
            )
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'Detail penerimaan tidak ditemukan untuk ID Pengadaan ini'], 404);
        }

        // Memisahkan data penerimaan dan detail penerimaan
        $penerimaanData = [];

        foreach ($data as $row) {
            if (!isset($penerimaanData[$row->idpenerimaan])) {
                $penerimaanData[$row->idpenerimaan] = [
                    'idpenerimaan' => $row->idpenerimaan,
                    'tanggal_penerimaan' => $row->created_at,
                    'status' => $row->status,
                    'nama_user' => $row->nama_user,
                    'details' => []
                ];
            }

            $penerimaanData[$row->idpenerimaan]['details'][] = [
                'iddetail_penerimaan' => $row->iddetail_penerimaan,
                'nama_barang' => $row->nama_barang,
                'jumlah_terima' => $row->jumlah_terima,
                'harga_satuan' => $row->harga_satuan_terima,
                'sub_total' => $row->sub_total_terima,
                'idbarang' => $row->barang_idbarang
            ];
        }

        return response()->json([
            'penerimaan' => array_values($penerimaanData),
        ], 200);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'idpenerimaan' => 'required|exists:penerimaan,idpenerimaan',
            'barang' => 'required|array|min:1',
            'barang.*.iddetail_penerimaan' => 'required|exists:detail_penerimaan,iddetail_penerimaan',
            'barang.*.jumlah_retur' => 'required|integer|min:1',
            'alasan' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Create a new retur record
            $returId = DB::table('retur')->insertGetId([
                'idpenerimaan' => $request->input('idpenerimaan'),
                'id_karyawan' => Auth::id(),
                'created_at' => now()
            ]);

            // Loop through each selected barang and handle the return logic
            foreach ($request->input('barang') as $item) {
                $detailPenerimaan = DB::table('detail_penerimaan')
                    ->where('iddetail_penerimaan', $item['iddetail_penerimaan'])
                    ->first();

                if (!$detailPenerimaan || $item['jumlah_retur'] > $detailPenerimaan->jumlah_terima) {
                    throw new \Exception('Jumlah retur melebihi jumlah yang diterima.');
                }

                // Insert details into detail_retur table
                DB::table('detail_retur')->insert([
                    'idretur' => $returId,
                    'iddetail_penerimaan' => $item['iddetail_penerimaan'],
                    'jumlah' => $item['jumlah_retur'],
                    'alasan' => $request->input('alasan'),
                ]);

                DB::table('detail_penerimaan')
                    ->where('iddetail_penerimaan', $item['iddetail_penerimaan'])
                    ->decrement('jumlah_terima', $item['jumlah_retur']);
                    
                // Update the stock (if needed)
                // This part can include logic to update the stock in the Kartu Stok or other tables
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Retur barang berhasil diproses.']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
        }
    }
}

