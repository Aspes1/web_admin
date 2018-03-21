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
    	$this->db->from('inm_admin');
    	$this->db->where('username',$this->input->post('username'));
    	return $this->db->get();
  }

  public function getMac($username)
  {
    	$this->db->select('mac_address');
    	$this->db->from('inm_admin');
    	$this->db->where('username', $username);
    	return $this->db->get();
  }

  public function setMac($username, $mac_address)
  {
      $this->db->set('mac_address', $mac_address);
      $this->db->where('username', $username);
      $this->db->update('inm_admin');
      return true;
  }

  public function statusId($username)
  {
      return $this->db->select('status_id')->where('username', $username)->limit(1)->get('inm_admin')->row('status_id');
  }

  public function role($id)
  {
      $this->db->select('*');
      $this->db->from('inm_jenis_admin');
      $this->db->where('id', $id);
      return $this->db->get();
  }

  public function getAllJenisAdmin()
  {
      $this->db->select('id,nama_jenis');
      $this->db->from('inm_jenis_admin');
      $query =  $this->db->get();
      return $query->result_array();
  }

  public function useradminExists($username)
  {
      $query = $this->db->get_where('inm_admin', array('username' => $username));
      if ($query->num_rows() > 0){
          return true;
      }
      else
      {
          return false;
      }
  }

  public function getAdminSaldo()
  {
      $this->datatables->select('inm_admin.id as id,nama_admin,username,nama_jenis,mac_address,nama_status');
      $this->datatables->from('inm_admin');
      $this->datatables->join('inm_jenis_admin', 'inm_admin.jenis_admin_id=inm_jenis_admin.id');
      $this->datatables->join('inm_status_admin', 'inm_admin.status_id=inm_status_admin.id');
      $this->datatables->add_column('view', '<center>
      <a href="javascript:void(0);" class="resetAdminMac btn btn-info btn-sm" data-id="$1" data-username="$2">Reset MAC</a>
      <a href="javascript:void(0);" class="blockAdmin btn btn-success btn-sm" data-id="$1" data-username="$2">Block</a>
      <a href="javascript:void(0);" class="unblockAdmin btn btn-success btn-sm" data-id="$1" data-username="$2">Unblock</a>
      <a href="javascript:void(0);" class="resetAdminPass btn btn-info btn-sm" data-id="$1" data-username="$2">Reset Pass</a>
      </center>','id,username');
      return $this->datatables->generate();
  }

  // block admin
  // 2 = block
  // @return bool true on success, false on failure
  public function blockAdmin($username)
  {
      $this->db->set('status_id', '2');
      $this->db->where('username', $username);
      $this->db->update('inm_admin');
      return true;
  }

  // unblock admin
  // 1 = unblock
  // @return bool true on success, false on failure
  public function unblockAdmin($username)
  {
      $this->db->set('status_id', '1');
      $this->db->where('username', $username);
      $this->db->update('inm_admin');
      return true;
  }

  // reset mac address
  // @return bool true on success, false on failure
  public function resetMacAddress($username)
  {
      $this->db->set('mac_address', '00-00-00-00-00-00');
      $this->db->where('username', $username);
      $this->db->update('inm_admin');
      return true;
  }

  public function resetPassword($username)
  {
      $password = get_hash('12345');
      $this->db->set('password', $password);
      $this->db->where('username', $username);
      $this->db->update('inm_admin');
      return true;
  }


}
