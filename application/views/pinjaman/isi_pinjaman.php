<div class="col-md-12 mb-4 mt-4">
  <div class="card">
    <div class="card-header">
      <strong>Form Isi Pinjaman</strong>
    </div>

    <form action="" method="post" id="pinjaman_form" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body">
      <div class="form-group row">
        <label for="user_saldo" class="col-md-1 col-form-label" for="text-input">Username</label>
        <div class="col-md-3">
          <input type="text" id="user_saldo" name="user_saldo" class="form-control" autocomplete="off">
          <span class="help-block" id="user_saldo_err" style="color:#f44242;">User id bukan group master/salah</span>
          <span class="help-block" id="user_saldo_scs" style="color:#a4de9a;">User id valid</span>
        </div>
        <div class="col-md-3">
          <div id="auto_con_div" onclick="isGroupMaster()"></div>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-1 col-form-label" for="text-input">Nama Loket</label>
        <div class="col-md-3">
          <input type="text" id="nama_saldo" name="nama_saldo" class="form-control" readonly>
          <span class="help-block" id="nama_err">error message</span>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-1 col-form-label" for="text-input">Nominal</label>
        <div class="col-md-3">
          <input type="text" id="saldo_saldo" name="saldo_saldo" class="form-control">
          <span class="help-block" id="saldo_err">error message</span>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" id="saldo_submit" class="btn btn-sm btn-primary" onclick="submitPinjamanForm(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
      <button type="reset" id="dbs_reset" class="btn btn-sm btn-danger" onclick=""><i class="fa fa-ban"></i> Reset</button>
    </div>
    </form>
  </div>
</div>
