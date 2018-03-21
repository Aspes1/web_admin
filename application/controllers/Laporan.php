<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('laporan_model');
    if($this->session->userdata('isLog') == FALSE)
    {
        $this->session->set_flashdata('need_login','Anda harus login terlebih dahulu.');
        redirect('login','refresh');
    }
  }

  public function index()
  {
      $data['title']      = 'Admin Dashboard';
      $data['submenu']    = 'laporan/menu_laporan';
      $data['contents']   = 'laporan/transaksi';
      $this->load->view('templates/app', $data);
  }

  public function addTransaksiPage()
  {
      $this->load->view('laporan/transaksi');
  }

  public function addHistoryPage()
  {
      $this->load->view('laporan/history');
  }

  public function setColumn()
  {
      $columns = array();

      if($this->laporan_model->getProdukName()->num_rows() !== 0)
      {

        $data = $this->laporan_model->getProdukName()->result();
        $counter = 0;
        foreach($data as $row)
        {
          $columns[] = array(
            'display' => $row->nama_jenis,
            'name' => strtolower($row->nama_jenis),
            'width' => 143,
            'sortable' =>  true,
            'align' => 'center'
          );
          $counter++;
        }
        echo json_encode($columns);
      }

  }

}
