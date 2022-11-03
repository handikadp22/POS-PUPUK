<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\PenjualanDetail;
use App\Models\Penjualan;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('produk_name')->get();
        $setting = Setting::first();

        //cek apakah ada transaksi sedang berjalan
        if ($id_penjualan = session('id_penjualan')) {
            return view('penjualan_detail.index', compact('produk', 'id_penjualan', 'setting'));
        } else {
            if (auth()->user()->level == 1) {
                return redirect()->route('transaksi.baru');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function data($id)
    {
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', $id)
            ->get();
        $data   = array();
        $total  = 0;
        $total_item = 0;

        foreach ($detail as  $item) {
            $row = array();

            $row['kode_produk'] = $item->produk['kode_produk'];
            $row['produk_name'] = $item->produk['produk_name'];
            $row['harga_jual']  = '<select>
            <option>
            </option></select>';
            $row['jumlah']  = '<input type="number" class="form-control input-sm quantity" data-id="' . $item->id_penjualanDetail . '" value="' . $item->jumlah . '">';
            $row['sub_total']   = 'Rp.' . format_uang($item->sub_total);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`' . route('transaksi.destroy', $item->id_penjualanDetail) . '`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;


            $total += $item->harga_jual * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'kode_produk' => '<div class="total hide">' . $total . '</div>
                              <div class="total_item hide">' . $total_item . '</div>',
            'produk_name' => '',
            'harga_jual'  => '',
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

    // public function store(Request $request)
    // {
    //     $produk =   Produk::where('id_produk', $request->id_produk)->first();
    //     if (!$produk) {
    //         return response()->json('Data gagal disimpan', 400);
    //     }

    //     $detail =   new PenjualanDetail();
    //     $detail->id_pembelian = $request->id_pembelian;
    //     $detail->id_produk = $produk->id_produk;
    //     $detail->harga_jual = $produk->harga_jual;
    //     $detail->jumlah = 1;
    //     $detail->sub_total = $produk->harga_jual;
    //     $detail->save();

    //     return response()->json('Data berhasil disimpan', 200);
    // }

    public function loadForm($total = 0, $diterima = 0)
    {
        $bayar  = $total;
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;
        $data   = [
            'totalrp'   => format_uang($total),
            'bayar'     => $bayar,
            'bayarrp'   => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar) . ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembaliterbilang' => ucwords(terbilang($kembali) . ' Rupiah'),
        ];
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $produk =   Produk::where('id_produk', $request->id_produk)->first();
        if (!$produk) {
            return response()->json('Data gagal disimpan', 400);
        }

        $detail =   new PenjualanDetail();
        $detail->id_penjualan = $request->id_penjualan;
        $detail->id_produk = $produk->id_produk;
        $detail->harga_jual = $produk->harga_jual;
        $detail->jumlah = 1;
        $detail->sub_total = $produk->harga_jual;
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }
}
