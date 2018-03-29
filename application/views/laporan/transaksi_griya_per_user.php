    <div class="card-body">

        <div class="form-group row">
          <label class="col-md-1 col-form-label" for="text-input">From</label>
          <div class="col-md-3">
            <input type="text" id="fromT" name="fromT" class="form-control fromT">
          </div>

<!--           <label class="col-md-1 col-form-label" for="text-input">To</label>
          <div class="col-md-3">
            <input type="text" id="toT" name="toT" class="form-control toT">
          </div>
 -->
          <div class="col-md-3">
            <button type="submit" onclick="laporaGriyaPerUser()" id="loket_submit" class="btn btn-xs btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
            <button type="reset" onclick="resetDate(event)" id="reset" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Reset</button>
          </div>
        </div>
        
     <div class="table-responsive">
        <table id="tabelTransaksiGriyaBayarPerUser" class="table-sm table table-bordered table-condensed table-hover " cellspacing="0" width="100%">
        <thead style="background-color:#bfe7bf">
            <tr>
              <th rowspan="2" class="text-center" style="vertical-align:middle;height:10px;width:108px;">#</th>
              <th rowspan="2" class="text-center" style="vertical-align:middle;height:10px">Loket</th>
              <th colspan="2" class="text-center" style="height:10px">Total PDAM</th>
              <th colspan="2" class="text-center" style="height:10px">Total PLN</th>
            </tr>
            <tr>
              <th class="text-left" style="height:10px">Jumlah</th>
              <th class="text-right" style="height:10px">Rupiah</th>
              <th class="text-left" style="height:10px">Jumlah</th>
              <th class="text-right" style="height:10px">Rupiah</th>
            </tr>
          </thead>
          <tfoot>
              <tr>
                  <th>TOTAL</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
              </tr>
          </tfoot>
      </table>
    </div>
        <!-- </div> -->
        <!-- <div> -->
    </div>
