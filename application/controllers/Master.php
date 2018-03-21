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

  /*------ start master vendor ------*/
  public function vendorPage()
  {
      $this->load->view('master/list_vendor');
  }

  public function getVendorJson()
  {
      //data user by JSON object
      header('Content-Type: application/json');
      echo $this->produk_model->getTabelVendor();
  }

  public function AddVendorPage()
  {
      $this->load->view('master/add_vendor');
  }

   public function CreateVendor()
  {
      $this->form_validation->set_rules('nama_vendor', 'Nama Vendor', 'required');
      $this->form_validation->set_rules('kode_vendor', 'Kode Vendor', 'required');
      if($this->form_validation->run() == FALSE)
      {
          $output['msg'] = validation_errors();
          echo json_encode($output);
      }
      else
      {
          $data = array(
            'nama_vendor' => $this->input->post('nama_vendor'),
            'kode_vendor' => $this->input->post('kode_vendor'),
          );
          
          $cekvendor = $this->produk_model->cek_nama_vendor($this->input->post('nama_vendor'));
          if($cekvendor)
          {
              $output['msg'] = '1';
              echo json_encode($output);              
          }
          else
          {
              $insert = $this->produk_model->store_vendor($data);
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
  /*------ end master vendor ------*/

  /*------ start master biaya admin ------*/
  public function BiayaAdminPage()
  {
      $this->load->view('master/list_biaya_admin');
  }

  public function getBiayaAdminJson()
  {
      header('Content-Type: application/json');
      echo $this->produk_model->getTabelBiayaAdmin();
  }

  public function AddBiayaAdminPage()
  {
      $this->load->view('master/add_biaya_admin');
  }

  public function CreateBiayaAdmin()
  {
      $this->form_validation->set_rules('kode_produk', 'Kode Produk', 'required');
      $this->form_validation->set_rules('biaya_admin', 'Biaya Admin', 'required');
      if($this->form_validation->run() == FALSE)
      {
          $output['msg'] = validation_errors();
          echo json_encode($output);
      }
      else
      {
          $data = array(
            'kode_produk' => $this->input->post('kode_produk'),
            'nominal_admin_bank' => $this->input->post('biaya_admin'),
            'tgl_create' => date('Y-m-d h:i:s')
          );

              $insert = $this->produk_model->store_biaya_admin($data);
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
  /*------ end master biaya admin ------*/

  /*------ start master pengumuman ------*/
  public function pengumumanPage()
  {
      $this->load->view('master/list_pengumuman');
  }

  public function getPengumumanJson()
  {
      header('Content-Type: application/json');
      echo $this->produk_model->getTabelPengumuman();
  }

  public function AddPengumumanPage()
  {
      $this->load->view('master/add_pengumuman');
  }

  public function CreatePengumuman()
  {
      $this->form_validation->set_rules('judul', 'judul', 'required');
      $this->form_validation->set_rules('isipengumuman', 'Isi Pengumuman', 'required');
      if($this->form_validation->run() == FALSE)
      {
          $output['msg'] = validation_errors();
          echo json_encode($output);
      }
      else
      {
          $data = array(
            'judul' => $this->input->post('judul'),
            'isi' => $this->input->post('isipengumuman'),
            'tgl_update' => date('Y-m-d h:i:s'),
            'tgl_create' => date('Y-m-d h:i:s'),
            'admin_id' => $this->session->userdata('adminId')
          );

              $insert = $this->produk_model->store_pengumuman($data);
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
  /*------ end master pengumuman ------*/

}