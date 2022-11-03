<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PembelianDetail;
use Illuminate\Support\Arr;

class PembelianDetailController extends Controller
{
    public function index()
    {
        $id_pembelian   =   session('id_pembelian');
        $produk =   Produk::orderBy('produk_name')->get();
        $supplier   =   Supplier::find(session('id_supplier'));
        if (!$supplier) {
            return response()->json('Data gagal disimpan', 400);
        }

        return view('pembelian_detail.index', compact('id_pembelian', 'produk', 'supplier'));
    }
    public function data($id)
    {
        $detail = PembelianDetail::with('produk')
            ->where('id_pembelian', $id)
            ->get();
        $data   = array();
        $total  = 0;
        $total_item = 0;

        foreach ($detail as  $item) {
            $row = array();

            $row['kode_produk'] = $item->produk['kode_produk'];
            $row['produk_name'] = $item->produk['produk_name'];
            $row['harga_beli']  = 'Rp.' . format_uang($item->harga_beli);
            $row['jumlah']  = '<input type="number" class="form-control input-sm quantity" data-id="' . $item->id_pembelianDetail . '" value="' . $item->jumlah . '">';
            $row['sub_total']   = 'Rp.' . format_uang($item->sub_total);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`' . route('pembelian_detail.destroy', $item->id_pembelianDetail) . '`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;

            $total += $item->harga_beli * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'kode_produk' => '<div class="total hide">' . $total . '</div>
                              <div class="total_item hide">' . $total_item . '</div>',
            'produk_name' => '',
            'harga_beli'  => '',
            'jumlah'      => '',
            'sub_total'   => '',
            'aksi'        => '',
        ];


        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'jumlah'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $produk =   Produk::where('id_produk', $request->id_produk)->first();
        if (!$produk) {
            return response()->json('Data gagal disimpan', 400);
        }

        $detail =   new PembelianDetail();
        $detail->id_pembelian = $request->id_pembelian;
        $detail->id_produk = $produk->id_produk;
        $detail->harga_beli = $produk->harga_beli;
        $detail->jumlah = 1;
        $detail->sub_total = $produk->harga_beli;
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }


    public function update(Request $request, $id)
    {
        $detail =   PembelianDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->sub_total = $detail->harga_beli * $request->jumlah;
        $detail->save();
    }


    function destroy($id)
    {
        $detail =   PembelianDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($total)
    {
        $bayar  = $total;
        $data   = [
            'totalrp'   => format_uang($total),
            'bayar'     => $bayar,
            'bayarrp'   => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar) . ' Rupiah')
        ];
        return response()->json($data);
    }
}
