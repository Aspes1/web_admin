<div class="col-md-12 mb-4 mt-4" id="add_produk">
  <div class="card">
    <div class="card-header">
      <strong>Edit Vendor</strong>
    </div>

    <form action="" method="post" id="form_edit_vendor" enctype="multipart/form-data" class="form-horizontal">
    	<div class="card-body table-responsive col-md-12">
          <div class="form-group row">
            <label class="col-md-3 col-form-label" for="text-input">Nama Vendor</label>
            <div class="col-md-9">
                <input type="hidden" id="id" name="id" value="<?php echo $vendor->id; ?>" class="form-control">
                <input type="text" id="nama_jenis" name="nama_vendor" value="<?php echo $vendor->nama_vendor; ?>" class="form-control">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label" for="text-input">Kode Vendor</label>
            <div class="col-md-9">
                <input type="text" id="kode_vendor" name="kode_vendor" value="<?php echo $vendor->kode_vendor; ?>" class="form-control">
            </div>
          </div>
    	</div>
	</form>

    <div class="card-footer">
      <button type="submit" id="produk_submit" class="btn btn-sm btn-primary" onclick="edit_vendor(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
      <button type="reset" id="produk_reset" class="btn btn-sm btn-danger" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i> Batal</button>
    </div>
  </div>
</div>
