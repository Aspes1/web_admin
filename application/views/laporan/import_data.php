<div id="import_csv_per_tgl">
    <!-- <?php echo form_open_multipart('laporan/upload_csv', ['class' => 'form-horizontal']); ?> -->
    <form action="" method="post" id="form_csv" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-md-1 col-form-label" for="text-input">Upload file</label>
            <div class="col-md-4">
                <input type="file" id="file_csv" name="file_csv" class="form-control" onchange="checkExtension2();">
          </div>
        </div>
        <div class="form-group row">
        	<div class="col-md-4">
                <button type="submit" id="submit_scv" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Import</button>
                    <img id="loading-image" src="<?php echo site_url('assets/src/img/Rolling.gif'); ?>" style="width:35px;height:35px; display: none; "/>
                <button type="reset" id="saldo_reset" class="btn btn-sm btn-danger" onclick="resetUploadCSV(event)"><i class="fa fa-ban"></i> Reset</button>
        	</div>
        </div>
    </div>
    </form>
</div>
