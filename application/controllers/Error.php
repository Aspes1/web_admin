<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends CI_Controller{

  public function __construct()
  {
      parent::__construct();
  }

  public function index()
  {
      $data['title'] = 'Error 505 Permission Denied';
      $this->load->view('errors/550_error', $data);
  }

}
