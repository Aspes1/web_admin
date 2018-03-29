<div class="col-md-12 mb-4 mt-4">
  <div class="card">
    <div class="card-header">
      <a href="javascript:getPageMaster('vendor')"><strong>Daftar Vendor</strong></a>
      |
      <a href="javascript:getPageMaster('tambah_vendor')"><strong>Input Vendor</strong></a>
    </div>

    <form action="" method="post" id="vendor_form" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body table-responsive col-md-12">
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Nama Vendor</label>
        <div class="col-md-4">
          <input type="text" id="nama_vendor" name="nama_vendor" class="form-control">
        </div>
      </div>      
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Kode Vendor</label>
        <div class="col-md-4">
          <input type="text" id="kode_vendor" name="kode_vendor" class="form-control">
        </div>
      </div>      
    </div>
    </form>

    <div class="card-footer">
      <button type="submit" id="produk_submit" class="btn btn-sm btn-primary" onclick="submit_vendor(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
      <button type="reset" id="produk_reset" class="btn btn-sm btn-danger" onclick="resetVendor(event)"><i class="fa fa-ban"></i> Reset</button>
    </div>
  </div>
</div>
