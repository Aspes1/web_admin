<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function index()
  {
      $this->session->sess_destroy();
      $this->session->set_flashdata('pesan', 'Logout berhasil.');
      redirect('login','refresh');
  }

}
