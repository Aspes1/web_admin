<div class="col-md-12 mb-4 mt-4">
  <div class="card">
    <div class="card-header">
      <a href="javascript:getPageMaster('komisi')"><strong>Daftar Komisi</strong></a>
      |
      <a href="javascript:getPageMaster('tambah_komisi')"><strong>Input Komisi</strong></a>
    </div>

    <form action="" method="post" id="komisi_form" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body table-responsive col-md-12">
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Nama Produk</label>
        <div class="col-md-4">
            <select class="form-control" id="produk" name="produk">
                <option value="">Select</option>
                <?php
                    foreach($produk as $result)
                    {
                        echo "<option value='".$result->id."'>".$result->nama_lengkap." - ".$result->nama_vendor."</option>";
                    }
                ?>            
            </select>
        </div>
      </div>      
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Komisi</label>
        <div class="col-md-4">
          <input type="text" id="komisi" name="komisi" class="form-control">
        </div>
      </div>      
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">Range</label>
        <div class="col-md-2">
            <input type="text" id="range_dari" name="range_dari" class="form-control" placeholder="Dari">
        </div>
        <div class="col-md-2">
            <input type="text" id="range_sampai" name="range_sampai" class="form-control" placeholder="Sampai" onchange="changenumber();">
        </div>
      </div>      
    </div>
    </form>

    <div class="card-footer">
      <button type="submit" id="komisi_submit" class="btn btn-sm btn-primary" onclick="submit_komisi(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
      <button type="reset" id="komisi_reset" class="btn btn-sm btn-danger" onclick="resetKomisi(event)"><i class="fa fa-ban"></i> Reset</button>
    </div>
  </div>
</div>
