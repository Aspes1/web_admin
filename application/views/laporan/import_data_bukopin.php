<div id="import_file_bukopin">
    <!-- <?php echo form_open_multipart('laporan/upload_file_bukopin', ['class' => 'form-horizontal']); ?> -->
    <form action="" method="post" id="form_file_bukopin" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-md-1 col-form-label" for="text-input">Upload file</label>
            <div class="col-md-4">
                <input type="file" id="userfile" name="userfile" class="form-control" onchange="checkExtension3()">
          </div>
        </div>
        <div class="form-group row">
        	<div class="col-md-4">
                <button type="submit" id="submit_bukopin" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Import</button>
                    <img id="loading-image" src="<?php echo site_url('assets/src/img/Rolling.gif'); ?>" style="width:35px;height:35px; display: none; "/>
                <button type="reset" id="saldo_reset" class="btn btn-sm btn-danger" onclick="resetUploadCSV(event)"><i class="fa fa-ban"></i> Reset</button>
        	</div>
        </div>
    </div>
    </form>
</div>
