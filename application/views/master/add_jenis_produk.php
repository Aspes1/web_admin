<div class="col-md-12 mb-4 mt-4">
  <div class="card">
    <div class="card-header">
      <a href="javascript:getPageMaster('jenis')"><strong>Daftar Jenis</strong></a>
      |
      <a href="javascript:getPageMaster('tambah_jenis_produk')"><strong>Input Jenis</strong></a>
    </div>

    <form action="" method="post" id="jenis_produk_form" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body table-responsive col-md-12">
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Nama Jenis Produk</label>
        <div class="col-md-4">
          <input type="text" id="nama_jenis" name="nama_jenis" class="form-control">
        </div>
      </div>      
    </div>
    </form>
    
    <div class="card-footer">
          <button type="submit" id="produk_submit" class="btn btn-sm btn-primary" onclick="submit_jenis_produk(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
          <button type="reset" id="produk_reset" class="btn btn-sm btn-danger" onclick="resetJenisProduk(event)"><i class="fa fa-ban"></i> Reset</button>
    </div>
  </div>
</div>
