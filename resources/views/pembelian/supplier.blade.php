<!-- Modal -->
<div
    class="modal fade"
    id="modal-supplier"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-supplier">
    <div class="modal-dialog" role="document">
       
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pilih Supplier</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover table-bordered table-supplier">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody>
                        @foreach ($supplier as $key=>$item)
                            <tr>
                                <td width="5%">{{ $key+1 }}</td>
                                <td>{{ $item->supplier_name}}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>
                                    <a class="btn btn-info btn-xs" href="{{ route('pembelian.create', $item->id_supplier) }}"><i class="fa fa-check-circle"> pilih</i></a>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>

