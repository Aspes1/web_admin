<div class="col-md-12 mb-4 mt-4">
  <div class="card">
    <div class="card-header">
      <strong>Form Isi Saldo</strong>
    </div>

    <form action="" method="post" id="saldo_form" enctype="multipart/form-data" class="form-horizontal">
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
          <label class="col-md-1 col-form-label" for="text-input">Saldo</label>
          <div class="col-md-3">
            <input type="text" id="saldo_saldo" name="saldo_saldo" class="form-control">
            <span class="help-block" id="saldo_err">error message</span>
          </div>
        </div>
    </div>
    <div class="card-footer">
      <button type="submit" id="saldo_submit" class="btn btn-sm btn-primary" onclick="submitSaldoForm(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
      <button type="reset" id="saldo_reset" class="btn btn-sm btn-danger" onclick="resetSaldoForm(event)"><i class="fa fa-ban"></i> Reset</button>
      <button type="button" class="btn btn-sm btn-danger" name="button" onclick="showPrompt()"><i class="fa fa-print"></i> Setting Printer</button>
    </div>
    </form>
  </div>
</div>
