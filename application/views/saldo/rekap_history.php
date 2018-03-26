<div class="col-md-12 mb-4 mt-4">
  <div class="card">
    <div class="card-header">
      <strong>Rekapitulasi Deposit</strong>
    </div>

    <div class="card-body table-responsive col-md-6">
      <div class="form-group row">
        <label class="col-md-2 col-form-label" for="text-input">From</label>
        <div class="col-md-5">
          <input type="text" id="rekapDate" name="rekapDate" class="form-control rekapDate">
        </div>

        <div class="col-md-2">
          <button type="submit" id="loket_submit" class="btn btn-xs btn-primary" onclick="showRekap()"><i class="fa fa-dot-circle-o"></i> Submit</button>
        </div>
      </div>
      <table class="table-striped table-sm table table-bordered table-condensed table-hover" cellspacing="0" width="100%" id="tabelRekapHistory">
          <thead style="background-color:#bfe7bf">
            <tr>
              <th>Tanggal</th>
              <th>Total Deposit</th>
              <th>Jumlah Deposit</th>
            </tr>
          </thead>
        </table>
    </div>

    <div class="card-footer">
    </div>
  </div>
</div>
