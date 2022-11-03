@extends('layouts.master')

@section('title')
Transaksi Pembelian
@endsection

@push('css')
    <style>
        .tampil-bayar{
            font-size: 5em;
            text-align: center;
            height: 100px;

        }
        .tampil-terbilang{
            padding: 10px;
            background: #dceaec;
        }
        .table-pembelian tbody tr:last-child{
            display: none;
        }
        @media(max-width:768px){
            .tampil-bayar{
                font-size: 3em;
                height: 70px;
                padding-top: 5px;

            }
        }
    </style>
@endpush
@section('breadcrumb')
@parent 
<li class = "active" > Transaksi Pembelian</li>
@endsection

@section('konten') <div class = "row" > <div class="col-md-12">
    <div class="box">
        <div class="box-header with-border">
            <table>
                <tr>
                    <td>Supplier &nbsp</td>
                    <td>: {{ $supplier->supplier_name }}</td>
                </tr>
                <tr>
                    <td>Alamat &nbsp</td>
                    <td>: {{ $supplier->alamat }}</td>
                </tr>
                <tr>
                    <td>Telepon &nbsp</td>
                    <td>: {{ $supplier->telepon }}</td>
                </tr>
            </table>
        </div>
        <div class="box-body">
            <form action="" class="form-produk">
                @csrf
                <div class="form-group row">
                    <label for="kode_produk" class="col-lg-3">Kode Produk</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ $id_pembelian }}">
                                <input type="hidden" name="id_produk" id="id_produk">
                                <input type="text" class="form-control" name="kode_produk" id="kode_produk">
                            <span class="input-group-btn">
                                <button onclick="tampilProduk()" class="btn btn-info" type="button"><i class="fa fa-arrow-right"></i></button>
                            </span>
                        </div>
                    </div>  
                </div>  
            </form>
            <table class="table table-striped table-hover table-bordered table-pembelian">                                                  
                <thead class="text-center">
                    <th width="5%" class="text-center">No</th>
                    <th class="text-center">Kode Produk</th>
                    <th class="text-center">Nama Produk</th>
                    <th class="text-center">Harga</th>
                    <th width="15%" class="text-center">Jumlah</th>
                    <th class="text-center">Sub Total</th>
                    <th width="8%" class="text-center">
                        <i class="fa fa-cog"></i>
                        Aksi</th>
                </thead>
                <tbody class="text-center"></tbody>
            </table>
            <div class="row">
                <div class="col-lg-8">
                    <div class="tampil-bayar bg-primary"></div>
                    <div class="tampil-terbilang"></div>
                </div>
                <div class="col-lg-4">
                    <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="POST">
                        @csrf
                        <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}" id="">
                        <input type="hidden" name="total" id="total">
                        <input type="hidden" name="total_item" id="total_item">
                        <input type="hidden" name="bayar" id="bayar">

                        <div class="form-group row">
                            <label for="totalrp" class="col-lg-2 control-label">Total</label>
                            <div class="col-lg-8">
                                <input type="text" id="totalrp" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                            <div class="col-lg-8">
                                <input type="text" id="bayarrp" class="form-control" readonly>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="boc-footer">
                <button type="submit" class="btn btn-primary btn-sm pull-right btn-simpan"><i class="fa fa-flappy-o">Simpan Transaksi</i></button>
            </div>
        </div>
    </div>
</div>
@includeIf('pembelian_detail.produk')
@endsection

@push('scripts') 
<script> 
let table, table2;
$(function () {
    table = $('.table-pembelian').DataTable({
         processing: true, 
        autoWidth: false,
        ajax:{
            url:'{{ route('pembelian_detail.data',$id_pembelian) }}', 
        },
        columns:[
            {data: 'DT_RowIndex',searchable:false, sortable:false},
            {data: 'kode_produk'},
            {data: 'produk_name'},
            {data: 'harga_beli'},
            {data: 'jumlah'},
            {data: 'sub_total'},
            {data: 'aksi', searchable:false,sortable:false},
        ],
        dom:'Brt',
        bSort:false,
    })
    .on('draw.dt', function(){
        loadForm();
    });    

    table2  =   $('.table-produk').DataTable();

    $(document).on('input', '.quantity', function () {
        
        let id = $(this).data('id');
        let jumlah = parseInt($(this).val());

        
        if (jumlah < 1){
            alert('Jumlah tidak boleh kurang dari 1');
            $(this).val(1)
            return;
        }

        if (jumlah >10000){
            alert('Jumlah tidak boleh lebih dari 10.000');
            $(this).val(10000)
            return;
        }
        
        $.post(`{{ url('/pembelian_detail') }}/${id}`,{
            '_token' : $('[name=csrf-token]').attr('content'),
            '_method' : 'put',
            'jumlah':jumlah
        })
            .done(response=>{
                $(this).on('mouseout', function () {
                table.ajax.reload();
                });
            })
            .fail(errors=>{
                alert('Tidak dapat menyimpan data');
                return;
            });
    });

    $('.btn-simpan').on('click',function(){
        $('.form-pembelian').submit();
    });
});

function tampilProduk() {
    $('#modal-produk').modal('show');

}

function hideProduk() {
    $('#modal-produk').modal('hide');

}

function pilihProduk(id,kode) {
   $('#id_produk').val(id);
   $('#kode_produk').val(kode);
   hideProduk();
   tambahProduk();
}

function tambahProduk(){
    $.post('{{ route('pembelian_detail.store')}}', $('.form-produk').serialize())
        .done(response => {
            $('#kode_produk').focus();
            table.ajax.reload();
        })
        .fail(errors=>{
            alert('Tidak menyimpan data');
            return;
        });
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

function loadForm(){
    $('#total').val($('.total').text());
    $('#total_item').val($('.total_item').text());

    $.get(`{{ url('/pembelian_detail/loadform') }}/${$('.total').text()}`)
        .done(response =>{
             $('#totalrp').val('Rp. '+ response.totalrp);
             $('#bayarrp').val('Rp. '+ response.bayarrp);
             $('#bayar').val(response.bayar);
             $('.tampil-bayar').text('Rp. '+response.bayarrp);
             $('.tampil-terbilang').text('Terbilang : '+response.terbilang);
        })
        .fail(errors =>{
            alert('Tidak dapat menampilkan data');
            return;
        })
        
}
</script>
@endpush
