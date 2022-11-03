@extends('layouts.master')

@section('title')
Transaksi Penjualan
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
        .table-penjualan tbody tr:last-child{
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
<li class = "active" > Transaksi Penjualan</li>
@endsection

@section('konten') <div class = "row" > <div class="col-md-12">
    <div class="box">
        <div class="box-body">
            <form class="form-produk">
                @csrf
                <div class="form-group row">
                    <label for="kode_produk" class="col-lg-3">Kode Produk</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                                <input type="hidden" name="id_produk" id="id_produk">
                                <input type="text" class="form-control" name="kode_produk" id="kode_produk">
                            <span class="input-group-btn">
                                <button onclick="tampilProduk()" class="btn btn-info" type="button"><i class="fa fa-arrow-right"></i></button>
                            </span>
                        </div>
                    </div>  
                </div>  
            </form>
            <table class="table table-striped table-hover table-bordered table-penjualan">                                                  
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
                    <form action="{{ route('transaksi.store') }}" class="form-penjualan" method="POST">
                        @csrf
                        <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}" id="">
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
                        <div class="form-group row">
                            <label for="diterima" class="col-lg-2 control-label">Diterima</label>
                            <div class="col-lg-8">
                                <input type="text" id="diterima" name="diterima" value="0" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kembali" class="col-lg-2 control-label">Kembali</label>
                            <div class="col-lg-8">
                                <input type="text" id="kembali" name="kembali" value="0" class="form-control" readonly>
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
@includeIf('penjualan_detail.produk')
@endsection

@push('scripts') 
<script> 
let table, table2;
$(function () {
    $('body').addClass('sidebar-collapse');

    table = $('.table-penjualan').DataTable({
        processing: true,
        responsive:true, 
        autoWidth: false,
        ajax:{
            url:'{{ route('transaksi.data',$id_penjualan) }}', 
        },
        columns:[
            {data: 'DT_RowIndex',searchable:false, sortable:false},
            {data: 'kode_produk'},
            {data: 'produk_name'},
            {data: 'harga_kiloan'},
            {data: 'jumlah'},
            {data: 'sub_total'},
            {data: 'aksi', searchable:false,sortable:false},
        ],
        dom:'Brt',
        bSort:false,
        paginate: false
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
        
        $.post(`{{ url('/transaksi') }}/${id}`,{
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

    // $('#diterima')on('input', function(){
    //     if ($(this).val()==""){
    //         $(this).val(0).select();
    //     }

    //     loadForm($(this).val());
    // }).focus(function(){
    //     $(this).select();
    // });

    $('.btn-simpan').on('click',function(){
        $('.form-penjualan').submit();
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
    $.post('{{ route('transaksi.store')}}', $('.form-produk').serialize())
        .done(response => {
            $('#kode_produk').focus();
            table.ajax.reload();
        })
        .fail(errors=>{
            alert('Tidak dapat menyimpan data gaes');
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

function loadForm(diterima=0){
    $('#total').val($('.total').text());
    $('#total_item').val($('.total_item').text());

    $.get(`{{ url('/transaksi/loadform') }}/${$('.total').text()}/${diterima}`)
        .done(response =>{
             $('#totalrp').val('Rp. '+ response.totalrp);
             $('#bayarrp').val('Rp. '+ response.bayarrp);
             $('#bayar').val(response.bayar);
             $('.tampil-bayar').text('Rp. '+response.bayarrp);
             $('.tampil-terbilang').text('Terbilang : '+response.terbilang);

             $('#kembali').val('Rp. '+response.kembalirp);
             if($('#diterima').val() != 0){
                $('.tampil-bayar').text('Kembali : Rp. '+ response.kembalirp);
                $('.tampil-terbilang').text(response.kembali_terbilang);
             }
        })
        .fail(errors =>{
            alert('Tidak dapat menampilkan data');
            return;
        })
        
}
</script>
@endpush
