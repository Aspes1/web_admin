<?php $this->load->view('templates/header'); ?>
<div class="row">
    <?php
      if(!empty($submenu)){
        $this->load->view($submenu);
      }
    ?>
</div>

<div class="row" id="isi">
    <?php $this->load->view($contents); ?>
</div>
<?php $this->load->view('templates/footer'); ?>
