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
                    <label for="deskripsi" class="col-md-3 col-md-offset control-label">Deskripsi</label>
                    <div class="col-md-8">
                        <input type="text" name="deskripsi" id="deskripsi" class="form-control" required autofocus>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nominal" class="col-md-3 col-md-offset control-label">Nominal</label>
                    <div class="col-md-8">
                        <input type="number" name="nominal" id="nominal" class="form-control"  autofocus>
                        <span class="help-block with-errors"></span>
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

