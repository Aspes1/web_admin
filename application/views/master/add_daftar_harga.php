<div class="col-md-12 mb-4 mt-4" id="add_daftar_harga">
    <div class="card">
        <div class="card-header">
            <a href="javascript:getPageMaster('daftar_harga')"><strong>Daftar Harga Produk</strong></a>
            |
            <a href="javascript:getPageMaster('tambah_daftar_harga')"><strong>Input Harga Produk</strong></a>
        </div>

        <form action="" method="post" id="form_daftar_harga" enctype="multipart/form-data" class="form-horizontal">
            <div class="card-body table-responsive col-md-12">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Nama Produk</label>
                    <div class="col-md-4">
                        <select class="form-control" name="kode_produk" id="kode_produk">
                            <option value="">Select</option>
                            <?php 
                                foreach($produk as $result){
                                    echo "<option value='".$result->kode_produk."'>".$result->nama_lengkap." - ".strtoupper($result->nama_vendor)."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Nama Produk</label>
                    <div class="col-md-4">
                        <select class="form-control" name="vendor_id" id="vendor_id">
                            <option value="">Select</option>
                            <?php 
                                foreach($vendor as $result){
                                    echo "<option value='".$result->id."'>".strtoupper($result->nama_vendor)."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>             

                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Harga Vendor</label>
                    <div class="col-md-4">
                        <input type="text" name="harga_vendor" id="harga_vendor" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Harga INM</label>
                    <div class="col-md-4">
                        <input type="text" name="harga_inm" id="harga_inm" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Markup</label>
                    <div class="col-md-4">
                        <input type="text" name="markup" id="markup" class="form-control">
                    </div>
                </div>                

            </div>
        </form>

        <div class="card-footer">
            <button type="submit" id="produk_submit" class="btn btn-sm btn-primary" onclick="submit_harga_produk(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
            <button type="reset" id="produk_reset" class="btn btn-sm btn-danger" onclick="resetDaftarHarga(event)"><i class="fa fa-ban"></i> Reset</button>
        </div>
    </div>
</div>
