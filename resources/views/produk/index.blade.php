@extends('layouts.master')

@section('title')
Produk
@endsection

@section('breadcrumb')
@parent 
<li class = "active" > Produk</li>
@endsection

@section('konten') <div class = "row" > <div class="col-md-12">
    <div class="box">
        <div class="box-header with-border">
            <button onclick="addForm('{{ route('produk.store') }}') " class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Tambah</button>
            <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
            <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-primary btn-sm"><i class="fa fa-barcode"></i> Barcode</button>
        </div>
        <div class="box-body table-responsive">
            <form action="" method="post" class="form-produk">
                @csrf
                <table class="table table-striped table-hover table-bordered">                                                  
                    <thead class="text-center">
                        <th>
                            <input type="checkbox" name="select_all" id="select_all">
                        </th>
                        <th width="5%" class="text-center">No</th>
                        <th class="text-center">Kode Produk</th>
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Merk</th>
                        <th class="text-center">Harga Beli</th>
                        <th class="text-center">Harga Kiloan</th>
                        <th class="text-center">Harga Botolan</th>
                        <th class="text-center">Harga Persak</th>
                        <th class="text-center">Permintaan Customer</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">
                            <i class="fa fa-cog"></i>
                            Aksi</th>
                    </thead>
                    <tbody class="text-center"></tbody>
                </table>
            </form>
        </div>
    </div>
</div>
@includeIf('produk.form')
@endsection

@push('scripts') 
<script> 
let table;
$(function () {
    table = $('.table').DataTable({
        processing: true, 
        autoWidth: false,
        ajax:{
            url:'{{ route('produk.data') }}', 
        },
        columns:[
            {data: 'select_all'},
            {data: 'DT_RowIndex',searchable:false, sortable:false},
            {data: 'kode_produk'},
            {data: 'produk_name'},
            {data: 'category_name'},
            {data: 'merk'},
            {data: 'harga_beli'},
            {data: 'harga_kiloan'},
            {data: 'harga_botolan'},
            {data: 'harga_persak'},
            {data: 'harga_customer'},
            {data: 'stok'},
            {data: 'aksi', searchable:false,sortable:false},
        ]
    });

    $('#modal-form').validator().on('submit',function (e){
        if (! e.preventDefault()){
            $.ajax({
                url:$('#modal-form form').attr('action'),
                type: 'post',
                data: $('#modal-form form').serialize()
            })
            .done((response)=>{
                $('#modal-form').modal('hide');
                table.ajax.reload();
            })
            .fail((errors)=>{
                alert('Tidak dapat menyimpan data');
                return;
            });
        }
    });
    $('[name=select_all]').on('click', function(){
        $(':checkbox').prop('checked',this.checked);
    });
});

function addForm(url) {
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Tambah Produk');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('post');
    $('#modal_form [name=produk_name]').focus();
}
function editForm(url) {
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Edit Kategori');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('put');
    $('#modal_form [name=produk_name]').focus();

    $.get(url)
    .done((response)=>{
        $('#modal-form [name=produk_name]').val(response.produk_name);
        $('#modal-form [name=id_category]').val(response.id_category);
        $('#modal-form [name=merk]').val(response.merk);
        $('#modal-form [name=harga_beli]').val(response.harga_beli);
        $('#modal-form [name=harga_kiloan]').val(response.harga_kiloan);
        $('#modal-form [name=harga_botolan]').val(response.harga_botolan);
        $('#modal-form [name=harga_persak]').val(response.harga_persak);
        $('#modal-form [name=harga_customer]').val(response.harga_customer);
        $('#modal-form [name=stok]').val(response.stok);
    })
    .fail((errors)=>{
        alert('Tidak dapat menampilkan data');

        return;
    })
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

function deleteSelected(url){
    if($('input:checked').length > 1){
        if(confirm('Yakin mau menghapus data terpilih?')){
            $.post(url, $('.form-produk').serialize())
        .done((response)=>{
            table.ajax.reload(); 
        })
        .fail((errors)=>{
            alert('Tidak dapat menghapus data');
            return;
        });
        }
    }else{
        alert('Pilih data yang akan dihapus lebih dari 1');
        return;
    }
}
function cetakBarcode(url){
    if($('input:checked').length < 1){
        alert('Pilih data yang akan di scan barcode');
        return;
    }else if($('input:checked').length <3){
        alert('Pilih data minimal 3');
        return;
    }else{
        $('.form-produk')
        .attr('target','_blank')
        .attr('action',url)
        .submit();
    }
}
</script>
@endpush
