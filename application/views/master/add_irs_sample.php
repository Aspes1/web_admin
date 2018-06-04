<div class="col-md-12 mb-4 mt-4">
    <div class="card">
        <div class="card-header">
            <a href="javascript:getPageMaster('produk'); "><strong>Daftar Produk</strong></a> | 
            <a href="javascript:getPageMaster('tambah'); "><strong>Tambah Produk</strong></a> | 
            <a href="javascript:getPageMaster('tambah_produk_irs'); "><strong>Tambah Produk IRS</strong></a>
        </div>

        <form id="frmAddProduk" class="form-horizontal">
            <div class="card-body col-md-12">
                <div class="row">
                    <div class="col-md-6">
                    
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="text-input">Kategori Produk</label>
                            <div class="col-md-7">
                                <select class="form-control" name="pilihKategoriProduk" id="pilihKategoriProduk">
                                    <option value="-">-- PILIH KATEGORI PRODUK  --</option>
                                <?php foreach ($jenis_produk as $k => $v) { ?>
                                    <option value="<?php echo $k; ?>"><?php echo strtoupper($v); ?></option>
                                <?php }?>
                                </select>
                            </div>                 
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="text-input">Nama Operator</label>
                            <div class="col-md-7">
                                <select class="form-control" name="pilihOperatorIRS" id="pilihOperatorIRS" disabled>
                                </select>
                            </div>                 
                        </div>

                        <!-- DAFTAR NAMA PRODUK IRS BERDASARKAN OPERATOR -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="text-input">Daftar Produk IRS</label>
                            <div class="col-md-7">
                                <select class="form-control" name="pilihDaftarProdukIRS" id="pilihDaftarProdukIRS" disabled>
                                </select>
                            </div>                 
                        </div>

                        <!-- NAMA PRODUK IRS -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="text-input">Nama Produk IRS</label>
                            <div class="col-md-7">
                                <input type="text" id="txtNamaProdukIRS" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- NAMA LAIN DARI PRODUK -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="text-input">Nama Lain Produk</label>
                            <div class="col-md-7">
                                <input type="text" id="txtNamaLainProduk" class="form-control" placeholder="contoh : Simpati 5000 atau Axis 5K">
                            </div>
                        </div>

                        <!-- KODE PRODUK DARI IRS -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="text-input">Kode Produk IRS</label>
                            <div class="col-md-7">
                                <input type="text" id="txtKodeProdukIRS" class="form-control" readonly>
                            </div>
                        </div>   
                    </div>

                    <div class="col-md-6">
                        <!-- NAMA SINGKAT (ALIAS NAME) DARI PRODUK -->
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label" for="text-input">Alias Kode Produk</label>
                            <div class="col-md-4">
                                <input type="text" id="txtAliasKodeProduk" class="form-control" placeholder="contoh : S5, A5">
                            </div>
                        </div>   
                        

                        <!-- NOMINAL PRODUK DARI IRS -->
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label" for="text-input">Nominal Produk</label>
                            <div class="col-md-4">
                                <input type="text" id="txtNominalProduk" class="form-control" value="0" readonly>
                            </div>
                        </div>
                        

                        <!-- HARGA PRODUK DARI IRS -->
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label" for="text-input">Harga Produk IRS (IDR)</label>
                            <div class="col-md-4">
                                <input type="text" id="txtHargaProdukIRS" class="form-control" value="0" readonly>
                            </div>
                        </div>
                        
                        <!-- SET HARGA MARKUP  -->
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label" for="text-input">Set Markup (IDR)</label>
                            <div class="col-md-4">
                                <input type="text" id="txtSetMarkup" class="form-control" value="0">
                            </div>
                        </div>

                        <!-- HARGA JUAL KE LOKET -->
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label" for="text-input">Harga Jual (IDR)</label>
                            <div class="col-md-4">
                                <input type="text" id="txtHargaJual" class="form-control" readonly>
                            </div>
                        </div>

                    </div>
                </div>
            </div> 
        </form>

        <div class="card-footer">
            <button type="submit" id="tambahProdukIRS" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
            <button type="reset" id="resetProdukIRS" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/src/js/fn-irs.js') ?>"></script>


    