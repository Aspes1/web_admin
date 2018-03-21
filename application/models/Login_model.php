<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  // add new admin
  public function addAdmin($data)
  {
      $this->db->insert('inm_admin', $data);
      return true;
  }

  // change password by superadmin
  public function changePassword($id, $newpassword)
  {
      $this->db->set('password', $newpassword);
      $this->db->where('id', $id);
      $this->db->update('inm_admin');
      return true;
  }

  // show all admin
  public function getAllAdmin()
  {
      return $this->db->get('inm_admin');
  }

  // show admin by id
  public function getAdminByID($id)
  {
      return $this->db->get_where('inm_admin', array('id' => $id));
  }

  public function cek()
  {
    	$this->db->select('*');
    	$this->db->from('temp_admin');
    	$this->db->where('username',$this->input->post('username'));
    	return $this->db->get();
  }

  public function role($id)
  {
      $this->db->select('*');
      $this->db->from('temp_jenis_admin');
      $this->db->where('kode_jenis', $id);
      return $this->db->get();
  }


}
