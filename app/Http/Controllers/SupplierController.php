<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        return view('supplier.index');
    }

    public function data()
    {
        $supplier = Supplier::orderBy('id_supplier', 'desc')->get();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->addColumn('kode_supplier', function ($supplier) {
                return '<span class="badge badge-dark">' . $supplier->kode_supplier . '</span>';
            })
            ->addColumn('aksi', function ($supplier) {
                return '
                    <button type="button" onclick="editForm(`' . route('supplier.update', $supplier->id_supplier) . '`)" class="btn btn-xs btn-info "><i class="fa fa-pencil"></i></button>
                    <button ttype="button" onclick="deleteData(`' . route('supplier.destroy', $supplier->id_supplier) . '`)" class="btn btn-xs btn-danger "><i class="fa fa-trash"></i></button>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all'])
            ->make(true);
    }

    public function store(Request $request)
    { {
            $supplier = Supplier::create($request->all());


            return response()->json('Data berhasil disimpan', 200);
        }
    }

    public function show($id)
    {
        $supplier = Supplier::find($id);

        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id)->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id)->delete();

        return response(null, 204);
    }
}
