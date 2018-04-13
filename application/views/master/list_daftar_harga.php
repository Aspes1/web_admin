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
                    <th>Harga Vendor</th>
                    <th>Harga INM</th>
                    <th>Markup</th>
                    <th>Tanggal Update</th>
                    <th width="150" style="text-align:center">Action</th>
                </tr>
                </thead>
            </table>
        </div>

        <div class="card-footer">

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

