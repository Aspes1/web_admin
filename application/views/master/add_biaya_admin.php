<div class="col-md-12 mb-4 mt-4">
  <div class="card">
    <div class="card-header">
      <a href="javascript:getPageMaster('biaya')"><strong>Daftar Biaya Admin</strong></a>
      |
      <a href="javascript:getPageMaster('tambah_biaya')"><strong>Input Biaya Admin</strong></a>
    </div>

    <form action="" method="post" id="biaya_admin_form" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body table-responsive col-md-12">
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Kode Produk</label>
        <div class="col-md-4">
          <input type="text" id="kode_produk" name="kode_produk" class="form-control">
        </div>
      </div>      
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Biaya Admin</label>
        <div class="col-md-4">
          <input type="text" id="biaya_admin" name="biaya_admin" class="form-control">
        </div>
      </div>      
    </div>
    </form>

    <div class="card-footer">
      <button type="submit" id="produk_submit" class="btn btn-sm btn-primary" onclick="submit_biaya_admin(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
      <button type="reset" id="produk_reset" class="btn btn-sm btn-danger" onclick="resetBiaya(event)"><i class="fa fa-ban"></i> Reset</button>
    </div>
  </div>
</div>
