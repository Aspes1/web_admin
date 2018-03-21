<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    if($this->session->userdata('isLog') == FALSE)
    {
        $this->session->set_flashdata('need_login','Anda harus login terlebih dahulu.');
        redirect('login','refresh');
    }
  }

  public function index()
  {
      $data['title']      = 'Admin Dashboard';
      //$data['submenu']    = 'loket/menu_loket';
      $data['contents']   = 'dashboard';
      $this->load->view('templates/app', $data);
  }

}
