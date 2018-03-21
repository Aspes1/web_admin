<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    // $this->load->model('produk_model');
    // $this->load->library('datatables');
    // $this->load->library('form_validation');
    date_default_timezone_set('Asia/Jakarta');

    if($this->session->userdata('isLog') == FALSE)
    {
        $this->session->set_flashdata('need_login','Anda harus login terlebih dahulu.');
        redirect('login','refresh');
    }
    if($this->session->userdata('adminRole') !== 'Superadmin')
    {
        redirect('error_550','refresh');
    }
  }

  public function index()
  {
      $data['title']      = 'Menu Master';
      $data['submenu']    = 'master/menu_master';
      $data['contents']   = 'master/list_produk';
      $this->load->view('templates/app', $data);
  }


}