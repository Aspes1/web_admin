<div class="col-md-12 mb-4 mt-4">
   <div class="card">
      <div class="card-header">
         <strong>Laporan transaksi</strong>
      </div>
      <div class="card-body" style="margin-bottom:15px;">
        <div class="form-group row">
          <div id="laporan_form" class="form-inline" style="margin-left:10px;">
              <div class="form-group" >
                <label for="fromT"class="lf-rg-5px lbl-weight-700">From</label>
                <input type="text" id="fromT" name="inptDari" class="form-control fromT lf-rg-5px">
              </div>
              <div class="form-group">
                <button type="submit" onclick="laporanHarianDetail()" id="loket_submit" class="lf-rg-5px btn btn-xs btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                <button type="reset" onclick="resetDate(event)" id="reset" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Reset</button>
              </div>
          </div>
         </div>

         <table id="tabelTransaksiHarianDetail"  class="table-striped table-sm table table-bordered table-condensed table-hover " cellspacing="0" width="100%">
            <thead style="background-color:#bfe7bf">
               <tr>
                  <th style="height:10px">Id Pelanggan</th>
                  <th style="height:10px">Nama Pelanggan</th>
                  <th style="height:10px">Tanggal Transaksi</th>
                  <th style="height:10px">Lembar</th>
                  <th style="height:10px" align="right">Tagihan</th>
                  <th align="right" style="height:10px">Admin Fee</th>
                  <th align="right" style="height:10px">Total Tagihan </th>
                  <th style="height:10px">Jenis Transaksi </th>
                  <!-- <th>#</th> -->
               </tr>
            </thead>
            <!-- <tbody>
               <tr>
                   <td>1</td>
                   <td>123456789</td>
                   <td>Pelanggan Pertama</td>
                   <td>No. Token  102.00</td>
                   <td>Rp. 200.000</td>
                   <td>Rp. 200.000</td>
                   <td>Rp. 2000</td>
                   <td>Rp. 200.000</td>
                   <td>PREPAID</td>
               </tr>
               </tbody> -->
         </table>
         <!-- </div> -->
         <!-- <div> -->
      </div>
      <div class="card-body">
         <table id="flex1" style="display:none"></table>
      </div>
      <div class="card-footer">
      </div>
   </div>
</div>
<script type="text/javascript"></script>