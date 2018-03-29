<div class="col-md-12 mb-4 mt-4" id="add_produk">
  <div class="card">
    <div class="card-header">
      <strong>Daftar Produk</strong>
    </div>

    <div class="card-body table-responsive col-md-8">
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Nama Produk</label>
        <div class="col-md-3">
          <input type="text" id="nama_produk" name="nama_produk" class="form-control">
        </div>

        <label class="col-md-3 col-form-label" for="text-input">Nama Vendor</label>
        <div class="col-md-3">
          <select class="form-control" name="vendor" id="vendor">
            <option value=''>Select</option>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Singkatan</label>
        <div class="col-md-3">
          <input type="text" id="singkatan" name="singkatan" class="form-control">
        </div>

        <label class="col-md-3 col-form-label" for="text-input">Kode Produk Vendor</label>
        <div class="col-md-3">
          <input type="text" id="kd_vendor" name="kd_vendor" class="form-control">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Jenis Produk</label>
        <div class="col-md-3">
          <select class="form-control" name="jenis_produk" id="jenis_produk">
            <option value=''>Select</option>
          </select>
        </div>

        <label class="col-md-3 col-form-label" for="text-input">Kode Produk</label>
        <div class="col-md-3">
          <input type="text" id="kd_produk" name="kd_produk" class="form-control">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Keterangan</label>
        <div class="col-md-9">
          <textarea id="keterangan" name="keterangan" rows="3" class="form-control"></textarea>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-md-3">
          <button type="submit" id="produk_submit" class="btn btn-xs btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
          <button type="reset" id="produk_reset" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Reset</button>
        </div>
      </div>
    </div>

    <div class="card-body table-responsive col-md-8">
      <table class="table table-bordered" id="tabelProduk">
          <thead>
            <tr>
              <th>Nama Produk</th>
              <th>Singkatan</th>
              <th>Jenis Produk</th>
              <th>Vendor</th>
              <th>Status</th>
            </tr>
          </thead>
        </table>
    </div>

    <div class="card-footer">

    </div>
  </div>
</div>
