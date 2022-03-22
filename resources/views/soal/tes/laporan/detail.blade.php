<div class="row">
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <h5>Info</h5>
                <div class="row d-flex align-items-between">
                    <div class="p-2">
                        <div><small class="text-muted">Nama Produk</small></div>
                        <div><b>

                            </b></div>
                    </div>
                    <div class="p-2">
                        <div><small class="text-muted">Nama Customer</small></div>
                        <div><b></b></div>
                    </div>
                    <div class="p-2">
                        <div><small class="text-muted">Instansi</small></div>
                        <div><b>

                            </b></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-body">
                <h5>Data Penjualan</h5>
                <form action="" method="POST" id="formsubmit">
                    @csrf
                    <div class="form-group row">
                        <div class="table-responsive">
                            <table class="table table-hover" id="realtable">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="check_all" id="check_all" name="check_all" />
                                                <label class="form-check-label" for="check_all">
                                                </label>
                                            </div>
                                        </th>
                                        <th>No SO</th>
                                        <th>No AKN</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6 float-left">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-warning float-right" id="btnsubmit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
