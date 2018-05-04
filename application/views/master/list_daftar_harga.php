<div class="col-md-12 mb-4 mt-4">
    <div class="card">
        <div class="card-header">
            <a href="javascript:getPageMaster('daftar_harga')"><strong>Daftar Harga Produk</strong></a>
            |
            <a href="javascript:getPageMaster('tambah_daftar_harga')"><strong>Input Harga Produk</strong></a>
        </div>

        <div class="card-body table-responsive col-md-12">
            <table id="tabelDaftarHarga" class="table-striped table-sm table table-bordered table-condensed table-hover " cellspacing="0" width="100%">
                <thead style="background-color:#bfe7bf">
                    <tr>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Vendor</th>
                        <th>Kode Produk Vendor</th>
                        <th>Nominal</th>
                        <th>Harga Vendor</th>
                        <th>Harga Jual</th>
                        <th>Profit</th>
                        <th>Tanggal Update</th>
                        <th width="180" style="text-align:center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="card-footer">
            <div class="col-md-12">
                <form class="form-inlin">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="text-input">Update Produk IRS</label>
                        <div class="col-md-2">
                            <select class="form-control" name="pilihJenisProduk" id="pilihJenisProduk">
                                <option value="-">-- PILIH JENIS PRODUK --</option>
                            <?php foreach ($jenis_produk as $k => $v) { ?>
                                <option value="<?php echo $k; ?>"><?php echo strtoupper($v); ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="btnUpdateAll" class="btn btn-primary" disabled>Update All</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="bg-modal">
            <div class="modal-body">
                <div id="result"></div>
            </div>        
        </div>
    </div>
</div>

