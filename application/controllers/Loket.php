<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loket extends CI_Controller{

  public $ca_id = "101inm";

  public function __construct()
  {
    parent::__construct();
    $this->load->model('user_model');
    $this->load->model('saldo_model');
    $this->load->helper('login_helper');
    $this->load->helper('date_helper');
    $this->load->library('form_validation');
    $this->load->library('datatables');
    if($this->session->userdata('isLog') == FALSE)
    {
        $this->session->set_flashdata('need_login','Anda harus login terlebih dahulu.');
        redirect('login','refresh');
    }
  }

  public function index()
  {
      $data['title']      = 'Admin Dashboard';
      $data['submenu']    = 'loket/menu_loket';
      $data['contents']   = 'loket/create_loket';
      $this->load->view('templates/app', $data);
  }

  public function addLoketPage()
  {
      $this->load->view('loket/create_loket');
  }

  public function listLoketPage()
  {
      $this->load->view('loket/list_loket');
  }

  public function createLoket()
  {
      $this->form_validation->set_rules('nama', 'Nama', 'trim|required|min_length[5]|max_length[50]');
      $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[8]|max_length[20]');
      $this->form_validation->set_rules('email', 'Email', 'trim|required');
      $this->form_validation->set_rules('telp', 'No Telepon', 'trim|required|min_length[8]|max_length[12]');
      $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
      $this->form_validation->set_rules('password','Password', 'required|max_length[20]');
      $this->form_validation->set_rules('group', 'Group', 'trim|min_length[8]|max_length[20]');
      $this->form_validation->set_rules('saldo', 'Saldo', 'trim|max_length[10]');
      $this->form_validation->set_rules('kab', 'Kabupaten', 'trim|required');
      $this->form_validation->set_rules('prov', 'Provinsi', 'trim|required');
      if($this->form_validation->run() == FALSE)
      {
        $output['msg'] = validation_errors();
        echo json_encode($output);
      }
      else
      {
          if($this->input->post('group', TRUE) == NULL)
          {
              $group = $this->input->post('username', TRUE);
              $level = 'loket';
          }
          else if($this->user_model->usernameExists($this->input->post('group', TRUE)) == TRUE)
          {
              $group = $this->input->post('group', TRUE);
              $level = 'group';
          }
          else
          {
              $output['msg'] = 'group id tidak valid';
              echo json_encode($output);
          }

          date_default_timezone_set('Asia/Jakarta');
          $now = date('Y-m-d H:i:s');

          $data = array(
              'username' => $this->input->post('username', TRUE),
              'email' => $this->input->post('email', TRUE),
              'no_telp' => $this->input->post('telp', TRUE),
              'alamat' => $this->input->post('alamat', TRUE),
              'group_id' => $group,
              'password' => get_hash($this->input->post('password'), TRUE),
              'ca_id' => $this->ca_id,
              'level' => $level,
              'status_id' => 1,
              'mac_address' => '00-00-00-00-00-00',
              'nama_user' => $this->input->post('nama', TRUE),
              'ip_address' => NULL,
              'cookie' => NULL,
              'kabupaten' => $this->input->post('kab', TRUE),
              'provinsi' => $this->input->post('prov', TRUE),
              'tgl_create' => $now,
              'tgl_update' => $now
          );

          $this->db->trans_start();
          $this->user_model->addUser($data);
          $insert_id = $this->session->userdata('insert_id');


          // insert saldo baru jika group id tidak diisi
          if($this->input->post('group', TRUE) == NULL)
          {
              // buat saldo baru
              $saldoData = array(
                  'user_id' => $insert_id,
                  'jumlah_saldo' => $this->input->post('saldo', TRUE),
                  'tgl_update' => $now
              );
              $this->saldo_model->addSaldo($saldoData);
          }
          else
          {
              // update saldo induk
              $group = $this->input->post('group', TRUE);
              $saldoData = array(
                  'username' => $group,
                  'jumlah_saldo' => $this->input->post('saldo', TRUE),
                  'tgl_update' => now()
              );
              $this->saldo_model->updateSaldoByUsername($saldoData);

          }


          $this->db->trans_complete();
          if ($this->db->trans_status() === FALSE)
          {
              $output['msg'] = 'failed';
              echo json_encode($output);
          }
          else
          {
              $output['msg'] = 'success';
              echo json_encode($output);
          }

      }
  }


  public function search()
  {
      $kodepos = $this->input->post('kodepos');

      if($this->user_model->getLokasi($kodepos)->num_rows() !== 0)
      {
          $data = $this->user_model->getLokasi($kodepos)->row();
          foreach($data as $row)
      	  {
            $output["provinsi"] = $data->provinsi;
      		  $output["kabupaten"] = $data->kabupaten;
          }
          echo json_encode($output);
      }
      else
      {
          $data = $this->user_model->getLokasi($kodepos)->row();

          $output["provinsi"] = '';
    	    $output["kabupaten"] = '';

          echo json_encode($output);
      }
  }

  public function getUserJson()
  {
      //data user by JSON object
      header('Content-Type: application/json');
      echo $this->user_model->getAllUser();
  }

  public function infoExtra()
  {
      $username = $this->input->post('username', TRUE);

      if($this->user_model->getExtraInfo($username)->num_rows() !== 0)
      {
        $data = $this->user_model->getExtraInfo($username)->row();
        foreach($data as $row)
        {
          $output["nama"] = $data->nama_user;
          $output["kab"] = $data->kabupaten;
          $output["prov"] = $data->provinsi;
          $output["no_telp"] = $data->no_telp;
          $output['alamat'] = $data->alamat;
          $output['ip_address'] = $data->ip_address;
          $output['mac_address'] = $data->mac_address;
          $output['tgl_create'] = $data->tgl_create;
        }
        echo json_encode($output);
      }
  }

  public function block()
  {
    $username = $this->input->post('username', TRUE);
    $this->user_model->blockUser($username);
  }

  public function unblock()
  {
    $username = $this->input->post('username', TRUE);
    $this->user_model->unblockUser($username);
  }

  public function reset_mac()
  {
    $username = $this->input->post('username', TRUE);
    $this->user_model->resetMacAddress($username);
  }

  public function reset_pass()
  {
    $username = $this->input->post('username', TRUE);
    $this->user_model->resetPassword($username);
  }

  public function username_exists()
  {
      $user = $this->input->post('user', TRUE);

      if($this->user_model->usernameExists($user))
      {
          echo $msg = 'suc';
      }
      else
      {
          echo $msg = 'err';
      }
  }

  public function is_group_master()
  {
      $user = $this->input->post('user', TRUE);

      if($this->user_model->isGroupMaster($user))
      {
          echo $msg = 'suc';
      }
      else
      {
          echo $msg = 'err';
      }
  }

  public function get_loket_name()
  {
    $user = $this->input->post('user', TRUE);

    if($this->user_model->getNamaLoket($user)->num_rows() !== 0){
      $data = $this->user_model->getNamaLoket($user)->row();
      foreach($data as $row)
      {
        $output["nama"] = $data->nama_user;
      }
      echo json_encode($output);
    }

  }

}
