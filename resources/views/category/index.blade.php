@extends('layouts.master')

@section('title')
Kategori
@endsection

@section('breadcrumb')
@parent 
<li class = "active" > Kategori</li>
@endsection

@section('konten') <div class = "row" > <div class="col-md-12">
    <div class="box">
        <div class="box-header with-border">
            <button onclick="addForm('{{ route('category.store') }}')" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Tambah</button>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-striped table-hover table-bordered">                                                  
                <thead class="text-center">
                    <th width="5%" class="text-center">No</th>
                    <th class="text-center">Kategori</th>
                    <th class="text-center">
                        <i class="fa fa-cog"></i>
                        Aksi</th>
                </thead>
                <tbody class="text-center"></tbody>
            </table>
        </div>
    </div>
</div>
@includeIf('category.form')
@endsection

@push('scripts') 
<script> 
let table;
$(function () {
    table = $('.table').DataTable({
        processing: true, 
        autoWidth: false,
        ajax:{
            url:'{{ route('category.data') }}', 
        },
        columns:[
            {data: 'DT_RowIndex',searchable:false, sortable:false},
            {data: 'category_name'},
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
    })
});

function addForm(url) {
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Tambah Kategori');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('post');
    $('#modal_form [name=category_name]').focus();
}
function editForm(url) {
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Edit Kategori');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('put');
    $('#modal_form [name=category_name]').focus();

    $.get(url)
    .done((response)=>{
        $('#modal-form [name=category_name]').val(response.category_name);
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
</script>
@endpush
