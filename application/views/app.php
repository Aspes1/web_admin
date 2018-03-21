<?php
  $data['title']  = $title;
  $this->load->view('templates/header', $data);
?>
<div class="row">
    <?php $this->load->view($submenu); ?>
</div>

<div class="row">
    <?php $this->load->view($contents); ?>
</div>

<?php $this->load->view('templates/footer'); ?>
