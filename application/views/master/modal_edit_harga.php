<div class="col-md-12 mb-4 mt-4" id="add_daftar_harga">
    <div class="card">
        <div class="card-header">
            <strong>Edit Harga</strong>
        </div>

        <form action="" method="post" id="form_edit_daftar_harga" enctype="multipart/form-data" class="form-horizontal">
            <div class="card-body table-responsive col-md-12">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Nama Produk</label>
                    <div class="col-md-4">
                        <input type="hidden" name="id" value="<?php echo $harga->id; ?>" class="form-control" readonly>
                        <input type="text" value="<?php echo $harga->nama_lengkap; ?>" class="form-control" readonly>
                    </div>

                    <label class="col-md-2 col-form-label" for="text-input">Harga INM</label>
                    <div class="col-md-4">
                        <input type="text" name="harga_inm" id="harga_inm" value="<?php echo $harga->harga_jual; ?>" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input" class="form-control">Nama Vendor</label>
                    <div class="col-md-4">
                        <input type="text" value="<?php echo strtoupper($harga->nama_vendor); ?>" class="form-control" readonly>
                    </div>

                    <label class="col-md-2 col-form-label" for="text-input">Markup</label>
                    <div class="col-md-4">
                        <input type="text" name="markup" id="markup" value="<?php echo $harga->markup; ?>" class="form-control">
                    </div>
                </div>             

                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Harga Vendor</label>
                    <div class="col-md-4">
                        <input type="text" name="harga_vendor" id="harga_vendor" value="<?php echo $harga->harga_vendor; ?>" class="form-control">
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Harga INM</label>
                    <div class="col-md-5">
                        <input type="text" name="harga_inm" id="harga_inm" value="<?php echo $harga->harga_jual; ?>" class="form-control">
                    </div>
                </div> -->

                <!-- <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">Markup</label>
                    <div class="col-md-5">
                        <input type="text" name="markup" id="markup" value="<?php echo $harga->markup; ?>" class="form-control">
                    </div>
                </div>                 -->

            </div>
        </form>

        <div class="card-footer">
            <button type="submit" id="produk_submit" class="btn btn-sm btn-primary" onclick="edit_harga_produk(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
            <button type="reset" id="produk_reset" class="btn btn-sm btn-danger" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i> Batal</button>
        </div>
    </div>
</div>
