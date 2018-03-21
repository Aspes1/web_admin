<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjaman extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->model('saldo_model');
    $this->load->model('pinjaman_model');
    $this->load->helper('date_helper');
    $this->load->helper('global_helper');
    $this->load->library('datatables');
    if($this->session->userdata('isLog') == FALSE)
    {
        $this->session->set_flashdata('need_login','Anda harus login terlebih dahulu.');
        redirect('login','refresh');
    }
    if($this->session->userdata('adminRole') == 'Helpdesk' || $this->session->userdata('adminRole') == 'Administrator')
    {
        redirect('error_550','refresh');
    }
  }

  public function index()
  {
      $data['title']      = 'Menu Pinjaman';
      $data['submenu']    = 'pinjaman/menu_pinjaman';
      $data['contents']   = 'pinjaman/isi_dbs';
      $this->load->view('templates/app', $data);
  }

  public function isiDbsPage()
  {
      $this->load->view('pinjaman/isi_dbs');
  }

  public function listDbsPage()
  {
      $this->load->view('pinjaman/list_dbs');
  }

  public function isiPinjamanPage()
  {
      $this->load->view('pinjaman/isi_pinjaman');
  }

  public function listPinjamanPage()
  {
    $this->load->view('pinjaman/list_pinjaman');
  }

  public function setDbs()
  {
      $this->form_validation->set_rules('user_saldo', 'Username', 'trim|required|min_length[8]|max_length[20]');
      $this->form_validation->set_rules('saldo', 'Saldo', 'trim|max_length[10]');
      if($this->form_validation->run() == FALSE)
      {
          $output['msg'] = 'failed';
          $output['print'] = validation_errors();
          echo json_encode($output);
          exit();
      }
      $username = $this->input->post('user_saldo', TRUE);
      $nominal = $this->input->post('saldo', TRUE);
      // cek jika username tidak valid
      if($this->saldo_model->getUserByUsername($username)->num_rows() == '')
      {
          $output['msg'] = 'failed';
          $output['print'] = 'Username tidak terdaftar';

          echo json_encode($output);
          exit();
      }
      $user_id = $this->saldo_model->getUserByUsername($username)->row()->id;
      // cek jika ada pinjaman
      if($this->pinjaman_model->isPinjamanExist($user_id))
      {
          $output['msg'] = 'failed';
          $output['print'] = 'Gagal, Loket masih memiliki Pinjaman !!';

          echo json_encode($output);
          exit();
      }
      // cek jika sudah pernah meminjam
      if($this->pinjaman_model->isDbsExist($user_id))
      {
          $output['msg'] = 'failed';
          $output['print'] = 'Gagal, DBS sebelumnya belum dibayar !!';

          echo json_encode($output);
          exit();
      }
      $this->db->trans_start();
      // set dbs
      $arrayDbs = array(
        'user_id' => $user_id,
        'nominal' => $nominal,
        'tgl_update' => now(),
        'tgl_create' => now(),
        'status_id' => '1',
        'admin_id' => $this->session->userdata('adminId')
      );
      $this->pinjaman_model->setDbs($arrayDbs);
      // isi saldo
      if(!$this->saldo_model->updateSaldo($user_id, $nominal))
      {
          $this->db->trans_rollback();
          continue;
      }
      $this->db->trans_complete();
      if ($this->db->trans_status() === FALSE)
      {
          $this->db->trans_rollback();
          $output['msg'] = 'failed';
          $output['print'] = 'Gagal Isi DBS';
          echo json_encode($output);
      }
      if ($this->db->trans_status() === TRUE)
      {
          $output['msg'] = 'success';
          $output['print'] = 'Berhasil Isi DBS';
          echo json_encode($output);
      }
  }

  public function setPinjaman()
  {
      $this->form_validation->set_rules('user_saldo', 'Username', 'trim|required|min_length[8]|max_length[20]');
      $this->form_validation->set_rules('saldo', 'Saldo', 'trim|max_length[10]');
      if($this->form_validation->run() == FALSE)
      {
          $output['msg'] = 'failed';
          $output['print'] = validation_errors();
          echo json_encode($output);
          exit();
      }
      $username = $this->input->post('user_saldo', TRUE);
      $nominal = $this->input->post('saldo', TRUE);
      $admin_id = $this->session->userdata('adminId');

      $data = $this->pinjaman_model->setPinjamanSP($username, $nominal, $admin_id);
      $output = array();
      foreach($data as $row)
      {
          $output['msg'] = $row['@msg'];
          $output['print'] = $row['@print'];
      }
      echo json_encode($output);
  }

  public function getDbsJson()
  {
      //data user by JSON object
      header('Content-Type: application/json');
      echo $this->pinjaman_model->getListDBS();
  }

  public function getPinjamanJson()
  {
      //data user by JSON object
      header('Content-Type: application/json');
      echo $this->pinjaman_model->getListPinjaman();
  }

  public function setLunas()
  {
      $id = $this->input->post('id', TRUE);
      if($this->pinjaman_model->ubahStatus($id))
      {
          $output['msg'] = 'success';
          $output['print'] = 'DBS berhasil dilunasi..';
          echo json_encode($output);
      }
  }

  public function tes()
  {
      // echo '<pre>';
      // echo print_r($this->pinjaman_model->autoPotong('4','15000'));
      // echo '</pre>';
      echo $this->pinjaman_model->autoPotong('4','4000');
  }

}
