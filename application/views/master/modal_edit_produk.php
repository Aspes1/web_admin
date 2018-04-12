<div class="col-md-12 mb-4 mt-4" id="add_produk">
  <div class="card">
    <div class="card-header">
      <strong>Edit Produk</strong>
    </div>

    <form action="" method="post" id="form_edit_produk" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body table-responsive col-md-12">
      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="text-input">Nama Produk</label>
        <div class="col-md-9">
          <input type="hidden" id="idproduk" name="idproduk" value="<?php echo $product->id; ?>" class="form-control">
          <input type="text" id="nama_produk" name="nama_produk" value="<?php echo $product->nama_lengkap; ?>" class="form-control">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="text-input">Singkatan</label>
        <div class="col-md-9">
          <input type="text" id="singkatan" name="singkatan" value="<?php echo $product->nama_singkat; ?>" class="form-control">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="text-input">Jenis Produk</label>
        <div class="col-md-9">
          <select class="form-control" name="jenis_produk" id="jenis_produk">
            <option value=''>Select</option>
            <?php
              foreach($jenisproduk as $result)
              {
                if($result->id == $product->jenis_produk_id){
                  echo "<option value='".$result->id."' selected>".$result->nama_jenis."</option>";
                }
                else{
                  echo "<option value='".$result->id."'>".$result->nama_jenis."</option>";
                }
              }
            ?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="text-input">Kode Produk</label>
        <div class="col-md-9">
          <input type="text" id="kd_produk" name="kd_produk" value="<?php echo $product->kode_produk; ?>" class="form-control">
        </div>
      </div>      

      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="text-input">Nama Vendor</label>
        <div class="col-md-9">
          <select class="form-control" name="vendor" id="vendor">
            <option value=''>Select</option>
            <?php
              foreach($vendor as $result)
              {
                if($result->id == $product->vendor_id){
                  echo "<option value='".$result->id."' selected>".$result->nama_vendor."</option>";
                }
                else{
                  echo "<option value='".$result->id."'>".$result->nama_vendor."</option>";
                }
              }
            ?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="text-input">Kode Produk Vendor</label>
        <div class="col-md-9">
          <input type="text" id="kd_vendor" name="kd_vendor" value="<?php echo $product->kode_produk_vendor; ?>" class="form-control">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="text-input">Keterangan</label>
        <div class="col-md-9">
          <textarea id="keterangan" name="keterangan" rows="1" class="form-control"><?php echo $product->keterangan; ?></textarea>
        </div>
      </div>
      
    </div>
    </form>

    <div class="card-footer">
      <button type="submit" id="produk_submit" class="btn btn-sm btn-primary" onclick="edit_produk(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
      <button type="reset" id="produk_reset" class="btn btn-sm btn-danger" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i> Batal</button>
    </div>
  </div>
</div>
