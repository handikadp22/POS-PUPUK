<!-- Modal -->
<div
    class="modal fade"
    id="modal-form"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
        <form action="" method="post" class="form-horizontal">
        @csrf
        @method('post')
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="produk_name" class="col-md-3 col-md-offset control-label">Nama Produk</label>
                    <div class="col-md-8">
                        <input type="text" name="produk_name" id="produk_name" class="form-control" required autofocus>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_category" class="col-md-3 col-md-offset control-label">Nama Produk</label>
                    <div class="col-md-8">
                        <select name="id_category" id="id_category" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($category as $key=>$item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="merk" class="col-md-3 col-md-offset control-label">Merk</label>
                    <div class="col-md-8">
                        <input type="text" name="merk" id="merk" class="form-control"  autofocus>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga_beli" class="col-md-3 col-md-offset control-label">Harga Beli</label>
                    <div class="col-md-8">
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control" required autofocus>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga_kiloan" class="col-md-3 col-md-offset control-label">Harga Kiloan</label>
                    <div class="col-md-8">
                        <input type="number" name="harga_kiloan" id="harga_kiloan" class="form-control"  autofocus>
                        
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga_botolan" class="col-md-3 col-md-offset control-label">Harga Botolan</label>
                    <div class="col-md-8">
                        <input type="number" name="harga_botolan" id="harga_botolan" class="form-control"  autofocus>
                        
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga_persak" class="col-md-3 col-md-offset control-label">Harga Persak</label>
                    <div class="col-md-8">
                        <input type="number" name="harga_persak" id="harga_persak" class="form-control"  autofocus>
                       
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga_customer" class="col-md-3 col-md-offset control-label">Permintaan Customer</label>
                    <div class="col-md-8">
                        <input type="number" name="harga_customer" id="harga_customer" class="form-control" value="0"  autofocus>
                       
                    </div>
                </div>
                <div class="form-group row">
                    <label for="stok" class="col-md-3 col-md-offset control-label">Stok</label>
                    <div class="col-md-8">
                        <input type="text" name="stok" id="stok" class="form-control" required autofocus>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
            </div>
        </div>
    </form>
    </div> 
</div>

