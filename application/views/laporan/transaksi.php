<div class="col-md-12 mb-4 mt-4">
  <div class="card">
    <div class="card-header">
      <strong>Laporan transaksi</strong>
    </div>

    <form action="" method="post" id="laporan_form" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body">
        <div class="form-group row">
          <label class="col-md-1 col-form-label" for="text-input">From</label>
          <div class="col-md-3">
            <input type="text" id="fromT" name="fromT" class="form-control fromT">
          </div>

          <label class="col-md-1 col-form-label" for="text-input">To</label>
          <div class="col-md-3">
            <input type="text" id="toT" name="toT" class="form-control toT">
          </div>

          <div class="col-md-3">
            <button type="submit" id="loket_submit" class="btn btn-xs btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
            <button type="reset" id="reset" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Reset</button>
          </div>
        </div>
    </div>

    <div class="card-body">
      <table id="flex1" style="display:none"></table>
    </div>

    <div class="card-footer">

    </div>
    </form>
  </div>
</div>

<script type="text/javascript">

</script>
