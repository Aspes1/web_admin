<div class="col-md-12 mb-4 mt-4">
  <div class="card">
    <div class="card-header" id="menu-griya">
      <a href="javascript:getPageLaporan('transaksipertanggal')" class="griya active"><strong>Transaksi Per Tanggal</strong></a>
      |
      <a href="javascript:getPageLaporan('transaksiperuser')" class="griya"><strong>Transaksi Per User</strong></a>
      |
      <a href="javascript:getPageLaporan('importdata')" class="griya"><strong>Upload Data</strong></a>
    </div>

    <?php $this->load->view($contents); ?>

    <div class="card-body">
      <table id="flex1" style="display:none"></table>
    </div>

    <div class="card-footer">
    </div>
  </div>
</div>

<script type="text/javascript">
</script>