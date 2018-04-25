<div class="col-md-12 mb-4 mt-4">
    <div class="card">
        <div class="card-header">
            <a href="javascript:getPageMaster('produk')"><strong>Daftar Produk</strong></a>
            |
            <a href="javascript:getPageMaster('tambah')"><strong>Tambah Produk</strong></a>
            |
            <a href="javascript:getPageMaster('tambah_produk_irs')"><strong>Tambah Produk IRS</strong></a>
        </div>

        <form action="" method="post" id="form_produk_irs" enctype="multipart/form-data" class="form-horizontal">
            <div class="card-body table-responsive col-md-12">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Nama Produk</label>
                    <div class="col-md-4">
                        <select class="form-control" name="nama_produk" id="nama_produk">
                            <option value="">Select</option>
                        </select>
                    </div>                 
                </div>
                
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Kode Produk Vendor</label>
                    <div class="col-md-4">
                        <input type="text" name="kodeprodukvendor" id="kodeprodukvendor" class="form-control" onkeyup="profitfunction()">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Harga Vendor</label>
                    <div class="col-md-4">
                        <input type="text" name="harga_vendor" id="harga_vendor" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Nominal Pulsa</label>
                    <div class="col-md-4">
                        <input type="text" name="nominal" id="nominal" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Status</label>
                    <div class="col-md-4">
                        <input type="text" name="status" id="status" class="form-control">
                    </div>
                </div>

            </div>
        </form>

        <div class="card-footer">
            <button type="submit" id="produk_submit" class="btn btn-sm btn-primary" onclick="submit_produk_irs(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
            <button type="reset" id="produk_reset" class="btn btn-sm btn-danger" onclick="reset(event)"><i class="fa fa-ban"></i> Reset</button>
        </div>
    </div>
</div>
