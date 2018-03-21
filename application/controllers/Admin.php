<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{

  public function __construct()
  {
      parent::__construct();
      $this->load->library('datatables');
      $this->load->model('admin_model');
      $this->load->helper('login_helper');
      $this->load->helper('date_helper');
      $this->load->library('form_validation');
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
      $data['title']      = 'Menu Admin';
      $data['submenu']    = 'admin/menu_admin';
      $data['contents']   = 'admin/create_admin';
      $this->load->view('templates/app', $data);
  }

  public function createAdminPage()
  {
      $this->load->view('admin/create_admin');
  }

  public function listAdminPage()
  {
      $this->load->view('admin/list_admin');
  }

  public function setJenisAdminOption()
  {
    if($this->admin_model->getAllJenisAdmin() !== 0)
    {
        $data = $this->admin_model->getAllJenisAdmin();
        foreach($data as $row)
        {
          echo "<option value='".$row['id']."'>".$row['nama_jenis']."</option>";
        }
    }
  }

  public function useradmin_exists()
  {
      $username = $this->input->post('username', TRUE);

      if($this->admin_model->useradminExists($username))
      {
          echo $msg = 'suc';
      }
      else
      {
          echo $msg = 'err';
      }
  }

  public function getAdminJson()
  {
      //data user by JSON object
      header('Content-Type: application/json');
      echo $this->admin_model->getAdminSaldo();
  }

  public function setAdmin()
  {
    $this->form_validation->set_rules('nama_admin', 'Nama', 'trim|required|min_length[5]|max_length[50]');
    $this->form_validation->set_rules('user_admin', 'Username', 'trim|required|min_length[5]|max_length[20]');
    $this->form_validation->set_rules('password','Password', 'required|max_length[20]');
    $this->form_validation->set_rules('jenis_admin', 'Group', 'trim|required');
    if($this->form_validation->run() == FALSE)
    {
        $output['msg'] = validation_errors();
        echo json_encode($output);
    }
    else
    {
        $data = array(
          'nama_admin' => $this->input->post('nama_admin', TRUE),
          'jenis_admin_id' => $this->input->post('jenis_admin', TRUE),
          'username' => $this->input->post('user_admin', TRUE),
          'password' => get_hash($this->input->post('password', TRUE)),
          'mac_address' => '00-00-00-00-00-00',
          'tgl_create' => now(),
          'status_id' => 1
        );

        $this->db->trans_start();
        $this->admin_model->addAdmin($data);
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

  public function block()
  {
    $username = $this->input->post('username', TRUE);
    $this->admin_model->blockAdmin($username);
  }

  public function unblock()
  {
    $username = $this->input->post('username', TRUE);
    $this->admin_model->unblockAdmin($username);
  }

  public function reset_mac()
  {
    $username = $this->input->post('username', TRUE);
    $this->admin_model->resetMacAddress($username);
  }

  public function reset_pass()
  {
    $username = $this->input->post('username', TRUE);
    $this->admin_model->resetPassword($username);
  }

}
