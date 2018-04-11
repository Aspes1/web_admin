<div class="col-md-12 mb-4 mt-4" id="add_produk">
  <div class="card">
    <div class="card-header">
      <strong>Edit Komisi</strong>
    </div>

    <form action="" method="post" id="form_edit_komisi" enctype="multipart/form-data" class="form-horizontal">
    	<div class="card-body table-responsive col-md-12">

            <div class="form-group row">
            <label class="col-md-3 col-form-label" for="text-input">Nama Produk</label>
                <div class="col-md-6">
                    <input type="hidden" name="idkomisi" value="<?php echo $komisi->id; ?>" class="form-control">
                    <input type="text" value="<?php echo $komisi->nama_lengkap; ?>" class="form-control" readonly>
                </div>
            </div>

            <div class="form-group row">
            <label class="col-md-3 col-form-label" for="text-input">Jenis Produk</label>
                <div class="col-md-6">
                    <input type="text" value="<?php echo $komisi->nama_jenis; ?>" class="form-control" readonly>
                </div>
            </div>

            <div class="form-group row" id="bg-jeniskomisi">
            <label class="col-md-3 col-form-label" for="text-input">Status Pinjaman</label>
                <div class="col-md-4">
                    <select class="form-control" id="statuspinjaman" name="statuspinjaman">
                        <?php
                            if($komisi->status_pinjaman == "Tidak Pinjaman"){
                                echo "<option value='Pinjaman'>Pinjaman</option>";
                                echo "<option value='Tidak Pinjaman' selected>Tidak Pinjaman</option>";
                            }
                            else{
                                echo "<option value='Pinjaman' selected>Pinjaman</option>";
                                echo "<option value='Tidak Pinjaman'>Tidak Pinjaman</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>            

            <div class="form-group row">
            <label class="col-md-3 col-form-label" for="text-input">Komisi</label>
                <div class="col-md-6">
                    <input type="text" name="komisi" value="<?php echo $komisi->komisi; ?>" class="form-control">
                </div>
            </div>

            <div class="form-group row">
            <label class="col-md-3 col-form-label" for="text-input">Tingkatan</label>
            <div class="col-md-3">
                    <input type="text" name="range_dari" value="<?php echo $komisi->range_dari; ?>" class="form-control">
                </div>
                <div class="col-md-3">
                    <?php if($komisi->range_sampai == 1000000){ ?>
                        <input type="text" name="range_sampai" value=">" class="form-control">                        
                    <?php }else{ ?>
                        <input type="text" name="range_sampai" value="<?php echo $komisi->range_sampai; ?>" class="form-control">
                    <?php } ?>
                </div>
            </div>

    	</div>
	</form>

    <div class="card-footer">
      <button type="submit" id="produk_submit" class="btn btn-sm btn-primary" onclick="edit_komisi(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
      <button type="reset" id="produk_reset" class="btn btn-sm btn-danger" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i> Batal</button>
    </div>
  </div>
</div>
