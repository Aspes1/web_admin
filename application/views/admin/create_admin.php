<div class="col-md-12 mb-4 mt-4" id="create_admin">
  <div class="card">
    <div class="card-header">
      <strong>Form Pendaftaran Admin</strong>
    </div>

    <form action="" method="post" id="admin_form" enctype="multipart/form-data" class="form-horizontal">
      <div class="card-body">
        <div class="form-group row">
          <label class="col-md-1 col-form-label" for="text-input">Nama</label>
          <div class="col-md-3">
            <input type="text" id="nama_admin" name="nama_admin" class="form-control">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-1 col-form-label" for="text-input">Username</label>
          <div class="col-md-3">
            <input type="text" id="user_admin" name="user_admin" class="form-control">
            <span class="help-block" id="user_admin_err" style="color:#f44242;">Username sudah digunakan</span>
            <span class="help-block" id="user_admin_scs" style="color:#a4de9a;">Username tersedia</span>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-1 col-form-label" for="text-input">Password</label>
          <div class="col-md-3">
            <input type="password" id="password_admin" name="password" class="form-control">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-1 col-form-label" for="text-input">Jenis Admin</label>
          <div class="col-md-3">
            <select class="form-control" name="jenis_admin" id="jenis_admin">
              <option value=''>Select</option>
            </select>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" id="admin_submit" class="btn btn-sm btn-primary" onclick="submitAdminForm(event)"><i class="fa fa-dot-circle-o"></i> Submit</button>
        <button type="reset" id="admin_reset" class="btn btn-sm btn-danger" onclick="resetAdminForm(event)"><i class="fa fa-ban"></i> Reset</button>
      </div>
    </form>

  </div>
</div>
