<!-- Modal -->
<div
    class="modal fade"
    id="modal-produk"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-produk">
    <div class="modal-dialog" role="document">
       
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pilih Produk</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover table-bordered table-produk">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Pilih Harga</th>
                        <th><i class="fa fa-cog"></i> Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($produk as $key => $item)
                            <tr>
                                <td width="5%">{{ $key+1 }}</td>
                                <td>{{ $item->kode_produk}}</td>
                                <td>{{ $item->produk_name }}</td>
                                <td>
                                    <select class="select-control" name="jenis_harga" id="jenis_harga">
                                        <option value="" selected>pilih harga</option>
                                        <option value="{{ $item->harga_kiloan }}">Kiloan</option>
                                        <option value="{{ $item->harga_botolan }}">Botolan</option>
                                        <option value="{{ $item->harga_persak }}">Persak</option>
                                        <option value="{{ $item->harga_customer }}">Customer</option>
                                        <option value=""></option>
                                    </select>
                                </td>
                                <td>
                                    <a class="btn btn-info btn-xs" href="#" onclick="pilihProduk('{{ $item->id_produk }}','{{ $item->kode_produk }}')"><i class="fa fa-check-circle"> pilih</i></a>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>

