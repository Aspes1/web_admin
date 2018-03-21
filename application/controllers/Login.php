<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('admin_model');
    $this->load->helper('login_helper');
    $this->load->library('form_validation');
    if($this->session->userdata('isLog')==TRUE)
    {
      redirect('dashboard','refresh');
    }
  }

  public function index()
  {
    $data['title'] = 'Web Admin';
    $data['subtitle'] = 'login';
    $this->load->view('login', $data);
  }

  public function auth()
  {
      $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[20]');
      $this->form_validation->set_rules('password','Password','required|max_length[20]');
      $this->form_validation->set_rules('mac_address','Mac Address','required');
      if($this->form_validation->run() == FALSE)
      {
          $data['title'] = 'Web Admin';
          $data['subtitle'] = 'login';
          $this->load->view('login', $data);
      }
      else
      {
          if($this->admin_model->cek()->num_rows()==1)
          {
              $secure = $this->admin_model->cek()->row();
              if($this->admin_model->statusId($secure->username) == '2')
              {
                  $this->session->set_flashdata('login_error','Diblock, Silahkan Hubungi Admin');
                  redirect('login','refresh');
              }
              if(hash_verified($this->input->post('password'),$secure->password))
              {
                  $kode_role = $secure->jenis_admin_id;
                  $role = $this->admin_model->role($kode_role)->row();

                  $sessionArray = array(
                      'isLog'=>TRUE,
                      'adminId'=>$secure->id,
                      'adminRole'=>$role->nama_jenis
                  );
                  $mac = $this->admin_model->getMac($secure->username)->row('mac_address');
                  if($mac == $this->input->post('mac_address', TRUE))
                  {
                    $this->session->set_userdata($sessionArray);
                    redirect('dashboard','refresh');
                  }
                  else if ($mac == '00-00-00-00-00-00')
                  {
                    $this->admin_model->setMac($secure->username, $this->input->post('mac_address', TRUE)); //save mac address
                    $this->session->set_userdata($sessionArray);
                    redirect('dashboard','refresh');
                  }
                  else
                  {
                    $this->session->set_flashdata('login_error','Mac Address tidak cocok');
                    redirect('login','refresh');
                  }

              }
              else
              {
                  $this->session->set_flashdata('login_error','Password Salah');
                  redirect('login','refresh');
              }
          }
          else
          {
              $this->session->set_flashdata('login_error','Username tidak terdaftar');
              redirect('login','refresh');
          }
      }
  }

}
