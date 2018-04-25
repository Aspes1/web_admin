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
                <button type="submit" onclick="TablePerTglBukopin()" id="loket_submit" class="lf-rg-5px btn btn-xs btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                <button type="reset" onclick="resetDate(event)" id="reset" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Reset</button>
            </div>
        </div>
    </div>

    <!-- <div class="table-responsive"> -->
    <table id="tabelTransaksiPerTglBukopin" class="table-striped table-sm table table-bordered table-condensed table-hover table-scroll" cellspacing="0" width="100%">
        <thead style="background-color:#bfe7bf">
            <tr>
                <th rowspan="2" class="text-center" style="vertical-align:middle;height:10px; width:200px;">Tanggal</th>
                <th colspan="2" class="text-center" style="vertical-align:middle; width:200px;">BPJS Kesehatan</th>
                <th colspan="2" class="text-center" style="vertical-align:middle; width:200px;">PDAM TIRTAULI KOTA PEMATANGSIANTAR</th>
                <th colspan="2" class="text-center" style="vertical-align:middle; width:200px;">PDAM TIRTA UMBU KAB. NIAS</th>
                <th colspan="2" class="text-center" style="vertical-align:middle; width:200px;">PDAM TIRTANADI</th>
                <th colspan="2" class="text-center" style="vertical-align:middle; width:200px;">PDAM TIRTA BULIAN TB.TINGGI SUMUT</th>
                <th colspan="2" class="text-center" style="vertical-align:middle; width:200px;">PLN Non Taglis</th>
                <th colspan="2" class="text-center" style="vertical-align:middle; width:200px;">PLN Postpaid</th>
                <th colspan="2" class="text-center" style="vertical-align:middle; width:200px;">Pulsa Listrik</th>
                <th colspan="2" class="text-center" style="vertical-align:middle; width:200px;">Telkom</th>
                <th colspan="2" class="text-center" style="vertical-align:middle; width:200px;">V Pulsa Telkomsel</th>
            </tr>
            <tr>
                <?php
                    for ($i=1; $i <= 10 ; $i++) { 
                        echo "<th class='text-center' style='width:130px'>Jumlah</th>";
                        echo "<th class='text-center' style='width:130px'>Rupiah</th>";
                    }
                ?>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Total</th>
                <?php for ($i=0; $i <= 19 ; $i++) { 
                    echo "<th></th>";
                }
                ?>
            </tr>
        </tfoot>
    </table>
    <!-- </div> -->
</div>
