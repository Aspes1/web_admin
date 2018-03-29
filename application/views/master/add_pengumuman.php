<div class="col-md-12 mb-4 mt-4">
  <div class="card">
    <div class="card-header">
      <a href="javascript:getPageMaster('pengumuman')"><strong>Daftar Pengumuman</strong></a>
      |
      <a href="javascript:getPageMaster('tambah_pengumuman')"><strong>Input Pengumuman</strong></a>
    </div>

    <form action="" method="post" id="pengumuman_form" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body table-responsive col-md-12">
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Judul</label>
        <div class="col-md-4">
          <input type="text" id="judul" name="judul" class="form-control">
        </div>
      </div>      
      
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Isi Pengumuman</label>
        <div class="col-md-10">
          <textarea id="isipengumuman" name="isipengumuman" rows="3" class="form-control"></textarea>
        </div>
      </div>      
    </div>
    </form>

    <div class="card-footer">
      <button type="submit" id="produk_submit" class="btn btn-sm btn-primary" onclick="submit_pengumuman(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
      <button type="reset" id="produk_reset" class="btn btn-sm btn-danger" onclick="resetPengumumanForm(event)"><i class="fa fa-ban"></i> Reset</button>
    </div>

  </div>
</div>
