<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('produk_model');
    $this->load->library('datatables');
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
      $data['contents']   = 'master/add_produk';
      $this->load->view('templates/app', $data);
  }

  public function produkPage()
  {
      $this->load->view('master/add_produk');
  }

  public function jenisPage()
  {
      $this->load->view('master/jenis_produk');
  }

  public function getProdukJson()
  {
      //data user by JSON object
      header('Content-Type: application/json');
      echo $this->produk_model->getTabelProduk();
  }

  public function setJenisProdukOption()
  {
    if($this->produk_model->getAllJenisProduk() !== 0)
    {
        $data = $this->produk_model->getAllJenisProduk();
        foreach($data as $row)
        {
          echo "<option value='".$row['id']."'>".$row['nama_jenis']."</option>";
        }
    }
  }

  public function setVendorOption()
  {
    if($this->produk_model->getAllVendor() !== 0)
    {
        $data = $this->produk_model->getAllVendor();
        foreach($data as $row)
        {
          echo "<option value='".$row['id']."'>".$row['nama_vendor']."</option>";
        }
    }
  }

}
