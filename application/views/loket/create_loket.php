<div class="col-md-12 mb-4 mt-4">
  <div class="card">
    <div class="card-header">
      <strong>Form Pendaftaran Loket</strong>
    </div>

    <div class="alert alert-warning" role="alert" id="alert_err"></div>
    <div class="alert alert-success" role="alert" id="alert_scs"></div>
    <form action="" method="post" id="loket_form" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body">
        <div class="form-group row">
          <label class="col-md-1 col-form-label" for="text-input">Nama Loket</label>
          <div class="col-md-3">
            <input type="text" id="nama" name="nama" class="form-control">
            <span class="help-block" id="nama_err">error message</span>
          </div>

          <label class="col-md-1 col-form-label" for="text-input">Group</label>
          <div class="col-md-3">
            <input type="text" id="group" name="group" class="form-control">
            <span class="help-block" id="group_err" style="color:#f44242;font-weight:bold">Group tidak tersedia</span>
            <span class="help-block" id="group_scs" style="color:#a4de9a;font-weight:bold">Group tersedia</span>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-1 col-form-label" for="text-input">Username</label>
          <div class="col-md-3">
            <input type="text" id="username" name="username" class="form-control">
            <span class="help-block" id="user_err" style="color:#f44242;font-weight:bold">Username sudah digunakan</span>
            <span class="help-block" id="user_scs" style="color:#a4de9a;font-weight:bold">Username diperbolehkan</span>
          </div>

          <label class="col-md-1 col-form-label" for="text-input">Saldo</label>
          <div class="col-md-3">
            <input type="text" id="saldo" name="saldo" class="form-control">
            <span class="help-block" id="saldo_err">error message</span>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-1 col-form-label" for="text-input">Password</label>
          <div class="col-md-3">
            <input type="password" id="password" name="password" class="form-control">
            <span class="help-block" id="pass_err">error message</span>
          </div>

          <label class="col-md-1 col-form-label" for="text-input">Kodepos</label>
          <div class="col-md-3">
            <input type="text" id="kodepos" name="kodepos" class="form-control">
            <span class="help-block" id="kodepos_err">error message</span>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-1 col-form-label" for="text-input">No. Telp</label>
          <div class="col-md-3">
            <input type="text" id="telp" name="telp" class="form-control">
            <span class="help-block" id="telp_err">error message</span>
          </div>

          <label class="col-md-1 col-form-label" for="text-input">Kabupaten</label>
          <div class="col-md-3">
            <input type="text" id="kab" name="kab" class="form-control" readonly>
            <span class="help-block"id="kab_err">error message</span>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-1 col-form-label" for="text-input">Email</label>
          <div class="col-md-3">
            <input type="email" id="email" name="email" class="form-control">
            <span class="help-block" id="email_err">error message</span>
          </div>

          <label class="col-md-1 col-form-label" for="text-input">Provinsi</label>
          <div class="col-md-3">
            <input type="text" id="prov" name="prov" class="form-control" readonly>
            <span class="help-block prov_err" id="prov_err">error message</span>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-1 col-form-label" for="textarea-input">Alamat</label>
          <div class="col-md-7">
            <textarea id="alamat" name="alamat" rows="3" class="form-control"></textarea>
          </div>
        </div>
    </div>
    <div class="card-footer">
      <button type="submit" id="loket_submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
      <button type="reset" id="loket_reset" class="btn btn-sm btn-danger" onclick="resetLoketForm(event)"><i class="fa fa-ban"></i> Reset</button>
    </div>
    </form>
  </div>
</div>
