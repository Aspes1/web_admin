<div class="col-md-12 mb-4 mt-4" id="upload_mutasi_pg">
  <div class="card">
    <div class="card-header">
      <strong>Upload Mutasi</strong>
    </div>

    <form action="" method="post" id="mutasi_form" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body table-responsive col-md-8">
      <div class="form-group">
          <label for="userfile" class="col-sm-3 control-label">File Mutasi</label>
          <div class="col-sm-7">
              <input type="file" class="form-control" id="userfile" name="userfile">
          </div>
      </div>
      <div class="form-group">
          <label for="bank" class="col-sm-3 control-label">Jenis Bank</label>
          <div class="col-sm-7">
              <select class="form-control" id="bank" name="bank">
                  <option value="">Select</option>
                  <option value="BRI">BRI</option>
                  <option value="MANDIRI">MANDIRI</option>
                  <option value="BNI">BNI</option>
                  <option value="Bukopin">Bukopin</option>
              </select>
          </div>
      </div>
    </div>

    <div class="card-footer">
      <button type="submit" id="mutasi_submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
      <button type="reset" id="mutasi_reset" class="btn btn-sm btn-danger" onclick=""><i class="fa fa-ban"></i> Reset</button>
    </div>
    </form>
  </div>
</div>
