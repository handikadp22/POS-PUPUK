@extends('layouts.master')

@section('title')
Daftar Pembelian
@endsection

@section('breadcrumb')
@parent 
<li class = "active" > Daftar Pembelian</li>
@endsection

@section('konten') <div class = "row" > <div class="col-md-12">
    <div class="box">
        <div class="box-header with-border">
            <button onclick="addForm()"class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Transaksi Baru</button>
            @empty(!session('id_pembelian'))
            <a href="{{ route('pembelian_detail.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Transaksi Aktif </a>
            @endempty
        </div>
        <div class="box-body table-responsive">
            <table class="table table-striped table-hover table-bordered table-pembelian">                                                  
                <thead class="text-center">
                    <th width="5%" class="text-center">No</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Supplier</th>
                    <th class="text-center">Total Item</th>
                    <th class="text-center">Total Harga</th>
                    <th class="text-center">Total Bayar</th>
                    <th class="text-center">
                        <i class="fa fa-cog"></i>
                        Aksi</th>
                </thead>
                <tbody class="text-center"></tbody>
            </table>
        </div>
    </div>
</div>
@includeIf('pembelian.supplier')
@includeIf('pembelian.detail')
@endsection

@push('scripts') 
<script> 
let table, table1;
$(function () {
    table = $('.table-pembelian').DataTable({
        processing: true, 
        autoWidth: false,
        ajax:{
            url:'{{ route('pembelian.data') }}', 
        },
        columns:[
            {data: 'DT_RowIndex',searchable:false, sortable:false},
            {data: 'tanggal'},
            {data: 'supplier_name'},
            {data: 'total_item'},
            {data: 'total_harga'},
            {data: 'bayar'},
            {data: 'aksi', searchable:false,sortable:false},
        ]
    });    

    $('.table-supplier').DataTable();
    table1 = $('.table-detail').DataTable({
        processing: true,
        bSort: false,
        dom:'Brt',
        columns:[
            {data: 'DT_RowIndex',searchable:false, sortable:false},
            {data: 'kode_produk'},
            {data: 'produk_name'},
            {data: 'harga_beli'},
            {data: 'jumlah'},
            {data: 'sub_total'},
        ]
    });
});

function addForm() {
    $('#modal-supplier').modal('show');

}
function showDetail(url) {
    $('#modal-detail').modal('show');

    table1.ajax.url(url);
    table1.ajax.reload();

}

function deleteData(url) {
    if(confirm('Yakin ingin menghapus data ini?')){
        $.post(url,{
        '_token' : $('[name=csrf-token]').attr('content'),
        '_method' : 'delete'
    })
    .done((response)=>{
        table.ajax.reload();
    })
    .fail((errors)=>{
        alert('Tidak dapat menghapus data');

        return;
    });
    }
}
</script>
@endpush
