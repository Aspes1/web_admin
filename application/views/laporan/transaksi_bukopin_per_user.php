<?php $CI =& get_instance(); $CI->load->model('Laporan_model'); $produk = $this->laporan_model->get_name_product_bukopin();?>
<div class="card-body">

    <div class="form-group row">
        <div id="laporan_form" class="form-inline" style="margin-left:10px;">
            <div class="form-group" >
                <label for="fromT"class="lf-rg-5px lbl-weight-700">From</label>
                <input type="text" id="fromT" name="fromT" class="form-control fromT lf-rg-5px">
            </div>

            <div class="form-group" >
                <label for="fromT"class="lf-rg-5px lbl-weight-700">To</label>
                <input type="text" id="toT" name="toT" class="form-control fromT lf-rg-5px">
            </div>

            <div class="form-group">
                <button type="submit" onclick="TablePerUserBukopin()" id="loket_submit" class="lf-rg-5px btn btn-xs btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                <button type="reset" onclick="resetDate(event)" id="reset" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Reset</button>
            </div>
        </div>
    </div>

    <!-- <div class="table-responsive"> -->
    <table id="tabelTransaksiPerUserBukopin" class="table-striped table-sm table table-bordered table-condensed table-hover table-scroll" cellspacing="0" width="100%">
        <thead style="background-color:#bfe7bf">
            <tr>
                <th rowspan="2" class="text-center" style="vertical-align:middle; height:10px; width:20px;">-</th>
                <th rowspan="2" class="text-center" style="vertical-align:middle; height:10px; width:150px;">Loket</th>
                <?php
                    foreach ($produk as $result) {
                        echo "<th colspan='2' class='text-center' style='vertical-align:middle; width:200px;'>".$result->nama_produk."</th>";
                    }
                ?>
            </tr>
            <tr>
                <?php
                    for ($i=0; $i < count($produk); $i++) {
                        echo "<th class='text-center' style='width:130px'>Jumlah</th>";
                        echo "<th class='text-center' style='width:130px'>Rupiah</th>";
                    }
                ?>
            </tr>
        </thead>
        <!-- <tfoot>
            <tr>
                <th>Total</th>
                <?php
                    $a = count($produk);
                    $b = $a * 2; 
                    for ($i=0; $i < $b; $i++){
                        echo "<th></th>";
                    }
                ?>
            </tr>
        </tfoot> -->
    </table>
    <!-- </div> -->
</div>
