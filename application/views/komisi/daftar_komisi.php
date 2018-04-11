<div class="col-md-12 mb-4 mt-4" id="page_komisi">
    <div class="card">
        <div class="card-header">
            <strong>Daftar Komisi</strong>
        </div>

        <div class="card-body col-md-12">
            <div class="form-group row">
                <div id="laporan_form" class="form-inline" style="margin-left:10px;">
                    <div class="form-group" >
                        <label for="fromT"class="lf-rg-5px lbl-weight-700">From</label>
                        <input type="text" id="fromT" name="inptDari" class="form-control fromT lf-rg-5px">
                    </div>

                    <div class="form-group" >
                        <label for="fromT"class="lf-rg-5px lbl-weight-700">To</label>
                        <input type="text" id="toT" name="inptSampai" class="form-control fromT lf-rg-5px">
                    </div>

                    <div class="form-group">
                        <button type="submit" onclick="LaporanKomisi()" id="loket_submit" class="lf-rg-5px btn btn-xs btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                        <button type="reset" onclick="resetDate(event)" id="reset" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Reset</button>
                    </div>
                </div>
            </div>

            <table class="table-striped table-sm table table-bordered table-condensed table-hover" cellspacing="0" width="100%" id="tableCountKomisi">
                <thead style="background-color:#bfe7bf">
                    <tr>
                        <th>Loket</th>
                        <th>Produk</th>
                        <th>Priode</th>
                        <th>Total Lembar</th>
                        <th>Total Komisi</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>