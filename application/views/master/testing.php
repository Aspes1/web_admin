<div class="col-md-12 mb-4 mt-4">
    <div class="card">
        <div class="card-header">
            <a href="javascript:getPageMaster('produk'); "><strong>Daftar Produk</strong></a> | 
            <a href="javascript:getPageMaster('tambah'); "><strong>Tambah Produk</strong></a> | 
            <a href="javascript:getPageMaster('tambah_produk_irs'); "><strong>Tambah Produk IRS</strong></a>
        </div>

       

        <div class="card-body">
            <ol class="breadcrumb">
                <li><button id="btnAutoInsert" class="btn btn-link" type="button">Auto Insert</button></li>
                <li><button id="btnManualInsert" class="btn btn-link" type="button">Manual Insert</button></li>
            </ol>

            <div id="pageAutoInsert" class="row">
                <div class="col-md-12">
                    <form id="frmAutoInsert" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="pilihKategoriProduk">Kategori Produk</label>
                            <div class="col-md-4">
                                <select class="form-control" name="pilihKategoriProduk" id="pilihKategoriProduk">
                                    <option value="-">-- PILIH KATEGORI PRODUK  --</option>
                                <?php foreach ($jenis_produk as $k => $v) { ?>
                                    <option value="<?php echo $k; ?>"><?php echo strtoupper($v); ?></option>
                                <?php }?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-4" for="pilihOperatorIRS">Nama Operator</label> &nbsp;
                            <div class="col-md-4">
                                <select class="form-control" name="pilihOperatorIRS" id="pilihOperatorIRS" disabled>
                                    <option value="-">-- NAMA OPERATOR --</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-4" for="txtSetMarkup">Set Global Markup (IDR)</label>
                            <div class="col-md-3">
                                <input type="text" id="txtSetMarkup" class="form-control" value="0">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="pageManualInsert" class="row">
                <div class="col-md-12">
                    
                </div>
            </div>

            
        </div>

        <div class="card-footer">
            <button type="submit" id="tambahProdukIRS" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
            <button type="reset" id="resetProdukIRS" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/src/js/fn-irs.js') ?>"></script>


    