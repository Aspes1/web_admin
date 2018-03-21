<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('produk_model');
    $this->load->library('datatables');
    $this->load->library('form_validation');
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

  /*------ master produk ------*/
  public function getProdukJson()
  {
      //data user by JSON object
      header('Content-Type: application/json');
      echo $this->produk_model->getTabelProduk();
  }

  public function produkPage()
  {
      $this->load->view('master/list_produk');
  }

  public function AddProdukPage()
  {
      $data['jenisproduk'] = $this->produk_model->all_jenis_produk();
      $data['vendor'] = $this->produk_model->all_vendor();
      $this->load->view('master/add_produk', $data);
  }

    public function CreateProduk()
  {
      $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
      $this->form_validation->set_rules('vendor', 'Vendoe', 'required');
      $this->form_validation->set_rules('singkatan','Singkata', 'required');
      $this->form_validation->set_rules('kd_vendor', 'Kode Vendor', 'required');
      $this->form_validation->set_rules('kd_produk', 'Kode Produk', 'required');
      $this->form_validation->set_rules('jenis_produk', 'Jenis Produk', 'required');
      $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
      
      if($this->form_validation->run() == FALSE)
      {
          $output['msg'] = validation_errors();
          echo json_encode($output);
      }

      else
      {
         $data = array(
            'jenis_produk_id' => $this->input->post('jenis_produk'),
            'vendor_id' => $this->input->post('vendor'),
            'nama_singkat' => $this->input->post('singkatan'),
            'nama_lengkap' => $this->input->post('nama_produk'),
            'kode_produk' => $this->input->post('kd_produk'),
            'kode_produk_vendor' => $this->input->post('kd_vendor'),
            'keterangan' => $this->input->post('keterangan'),
            'status_id' => 1,
          );

          // cek kode produk
         $kode = $this->produk_model->get_produk($this->input->post('kd_produk'));
         if($kode)
         {            
              $output['msg'] = '1';
              echo json_encode($output);            
         }
         else
         {
             $insert = $this->produk_model->store_produk($data);
             if($insert)
             {
                $output['msg'] = 'success';
                echo json_encode($output);
             }
             else
             {
                $output['msg'] = 'failed';
                echo json_encode($output);            
             }
         }

      }

  }
  /*------ master produk ------*/

  /*------ master jenis produk ------*/
  public function jenisPage()
  {
      $this->load->view('master/list_jenis_produk');
  }

  public function AddJeniskPage()
  {
      $this->load->view('master/add_jenis_produk');
  }

  public function getJenisProdukJson()
  {
      header('Content-Type: application/json');
      echo $this->produk_model->getTabelJenisProduk();
  }

  public function CreateJenisProduk()
  {
      $this->form_validation->set_rules('nama_jenis', 'Nama Jenis Produk', 'required');
      if($this->form_validation->run() == FALSE)
      {
          $output['msg'] = validation_errors();
          echo json_encode($output);
      }
      else
      {
          $data = array('nama_jenis' => $this->input->post('nama_jenis'));
          
          $cekjenis = $this->produk_model->cek_jenis_produk($this->input->post('nama_jenis'));
          if($cekjenis)
          {
              $output['msg'] = '1';
              echo json_encode($output);              
          }
          else
          {
              $insert = $this->produk_model->store_jenis_produk($data);
              if($insert)
              {
                  $output['msg'] = 'success';
                  echo json_encode($output);
              }
              else
              {
                  $output['msg'] = 'failed';
                  echo json_encode($output);            
              }
          }
      }

  }  
  /*------ end master jenis produk ------*/

}