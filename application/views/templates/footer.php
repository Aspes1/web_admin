    </div>
    <!-- /.conainer-fluid -->
    </main>
    <?php //$this->load->view('templates/aside_menu'); ?>
  </div>
  <!-- app body close  -->

  <footer class="app-footer">
    <!-- <span><a href="http://coreui.io">CoreUI</a> © 2017 creativeLabs.</span> -->
    <button type="button" class="btn btn-sm btn-danger" name="button" onclick="testPrint()">Tes Print</button>
    <input type="hidden" id="printer_use" class="form-control" style="width:300px;" value="<?php echo $this->session->userdata('printer'); ?>" disabled>
    <div id="qz-alert" style="position: fixed; width: 60%; margin: 0 4% 0 36%; z-index: 900;"></div>
    <div id="printer-msg" style="margin-left:20px;">
      <span class="align-middle">Printer : <?php if($this->session->userdata('printer')) {echo $this->session->userdata('printer'); }else{ echo 'Belum diPilih'; }  ?><span>
    </div>
    <span class="ml-auto">Powered by <a href="http://coreui.io">CoreUI</a></span>
  </footer>
    <!-- <script src="http://code.jquery.com/jquery-1.10.2.js"></script> -->
    <!-- Bootstrap and necessary plugins -->
    <script src="<?php echo base_url('assets/dist/vendors/js/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/dist/vendors/js/popper.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/dist/vendors/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/dist/vendors/js/pace.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/src/js/jquery.maskMoney.min.js') ?>"></script>

    <!-- Plugins and scripts required by all views -->
    <script src="<?php echo base_url('assets/dist/vendors/js/Chart.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/src/js/datatables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/src/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/src/js/jquery-confirm.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="<?php echo base_url('assets/src/js/dataTables.colResize.js') ?>"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


  <!-- CoreUI main scripts -->
  <script src="<?php echo base_url('assets/src/js/app.js') ?>"></script>

  <!-- Custom Scripts -->
  <script src="<?php echo base_url('assets/src/js/globals.js') ?>"></script>
  <script src="<?php echo base_url('assets/src/js/loads.js') ?>"></script>
  <script src="<?php echo base_url('assets/src/js/tables.js') ?>"></script>
  <script>var base_url = '<?php echo base_url() ?>';</script>

  <!-- qz.io scripts  -->
  <script type="text/javascript" src="<?php echo base_url('assets/src/js/qz/dependencies/rsvp-3.1.0.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/src/js/qz/dependencies/sha-256.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/src/js/qz/qz-tray.js') ?>"></script>


</body>
</html>
