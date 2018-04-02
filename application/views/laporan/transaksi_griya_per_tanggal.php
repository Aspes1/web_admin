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
                <button type="submit" onclick="laporaGriyaPerTgl()" id="loket_submit" class="lf-rg-5px btn btn-xs btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                <button type="reset" onclick="resetDate(event)" id="reset" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Reset</button>
              </div>
          </div>
        </div>

        <table id="tabelTransaksiGriyaPerTgl" class="table-striped table-sm table table-bordered table-condensed table-hover " cellspacing="0" width="100%">
        <thead style="background-color:#bfe7bf">
        <!-- <thead> -->
          <tr>
            <th rowspan="2" class="text-center" style="vertical-align:middle;height:10px">Tanggal</th>
            <th colspan="2" class="text-center" style="height:10px">Total PDAM</th>
            <th colspan="2" class="text-center" style="height:10px">Total PLN</th>
          </tr>
          <tr>
            <th class="text-center" style="height:10px">Jumlah</th>
            <th class="text-center" style="height:10px">Rupiah</th>
            <th class="text-center" style="height:10px">Jumlah</th>
            <th class="text-center" style="height:10px">Rupiah</th>
          </tr>
        </thead>
        <tfoot>
              <tr>
                  <th>
                    TOTAL
                  </th>
                  <th>

                  </th>
                  <th>

                  </th>
                  <th>

                  </th>
                  <th>

                  </th>
              </tr>
          </tfoot>
      </table>
        <!-- </div> -->
        <!-- <div> -->
    </div>
