<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }

  // add new user
  // @return last insert id
  public function addUser($data)
  {
      $query = $this->db->insert('inm_users', $data);
      if($query)
      {
          $insert_id = $this->db->insert_id();
          $newdata = array('insert_id' => $insert_id);
          $this->session->set_userdata($newdata);
          return $insert_id;
      }
      else
      {
          return false;
      }
  }

  // edit user
  // @return bool true on success, false on failure
  public function update($id, $data)
  {
      $this->db->where('id', $id);
      $this->db->update('inm_users', $data);
      return true;
  }

  // block user
  // 1 = block
  // @return bool true on success, false on failure
  public function blockUser($username)
  {
      $this->db->set('status_id', '2');
      $this->db->where('username', $username);
      $this->db->update('inm_users');
      return true;
  }

  // unblock user
  // 0 = unblock
  // @return bool true on success, false on failure
  public function unblockUser($username)
  {
      $this->db->set('status_id', '1');
      $this->db->where('username', $username);
      $this->db->update('inm_users');
      return true;
  }

  // reset ip address
  // @return bool true on success, false on failure
  public function resetIpAddress($id)
  {
      $this->db->set('ip_address', 'NULL');
      $this->db->where('id', $id);
      $this->db->update('inm_users');
      return true;
  }

  // reset mac address
  // @return bool true on success, false on failure
  public function resetMacAddress($username)
  {
      $this->db->set('mac_address', '00-00-00-00-00-00');
      $this->db->where('username', $username);
      $this->db->update('inm_users');
      return true;
  }

  public function resetPassword($username)
  {
    $password = get_hash('12345');
    $this->db->set('password', $password);
    $this->db->where('username', $username);
    $this->db->update('inm_users');
    return true;
  }

  // change password
  // @return bool true on success, false on failure
  public function changePassword($id, $newpassword)
  {
      $this->db->set('password', $newpassword);
      $this->db->where('id', $id);
      $this->db->update('inm_users');
      return true;
  }

  // add cookie
  // @return bool true on success, false on failure
  public function addCookie($id, $cookie)
  {
      $this->db->set('cookie', $cookie);
      $this->db->where('id', $id);
      $this->db->update('inm_users');
      return true;
  }

  // show user by ID
  // @return object, the user object
  public function getUserByID($id)
  {
      return $this->db->get_where('inm_users', array('id' => $id));
  }

  // show all user
  // @return datatable object, the user object
  public function getAllUser()
  {
      $this->datatables->select('inm_users.id as id,nama_user,username,group_id,level,no_telp,nama_status');
      $this->datatables->from('inm_users');
      //$this->datatables->join('inm_saldo_loket', 'inm_users.id=inm_saldo_loket.user_id');
      $this->datatables->join('inm_users_status', 'inm_users.status_id=inm_users_status.id');
      $this->datatables->add_column('icon', '
      <a href="javascript:void(0);" class="info" data-id="$1" data-username="$2">
      <i class="fa fa-plus-square" aria-hidden="true"></i>
      </a>', 'id,username');
      $this->datatables->add_column('view', '<center>
      <a href="javascript:void(0);" class="resetMac btn btn-info btn-sm" data-id="$1" data-username="$2">Reset MAC</a>
      <a href="javascript:void(0);" class="block btn btn-success btn-sm" data-id="$1" data-username="$2">Block</a>
      <a href="javascript:void(0);" class="unblock btn btn-success btn-sm" data-id="$1" data-username="$2">Unblock</a>
      <a href="javascript:void(0);" class="resetPass btn btn-info btn-sm" data-id="$1" data-username="$2">Reset Pass</a>
      </center>','id,username');
      return $this->datatables->generate();
  }

  public function getExtraInfo($username)
  {
      $this->db->select('*');
      $this->db->from('inm_users');
      $this->db->where('username', $username);
      return $this->db->get();
  }

  public function getLokasi($kodepos)
  {
      $this->db->select('*');
      $this->db->from('inm_kodepos');
      $this->db->where('kodepos', $kodepos);
      return $this->db->get();
  }

  public function usernameExists($username)
  {
      $query = $this->db->get_where('inm_users', array('username' => $username));
      if ($query->num_rows() > 0){
          return true;
      }
      else
      {
          return false;
      }
  }

  public function isGroupMaster($username)
  {
    $this->db->select('username,group_id');
    $this->db->from('inm_users');
    $this->db->where('username', $username);
    $this->db->where('group_id', $username);
    $query = $this->db->get();
    if ($query->num_rows() > 0){
        return true;
    }
    else
    {
        return false;
    }
  }

  public function getNamaLoket($username)
  {
      $this->db->select('nama_user');
      $this->db->from('inm_users');
      $this->db->where('username', $username);
      return $this->db->get();
  }

  public function getGroupId($match)
  {
      $this->db->select('username,group_id');
      $this->db->from('inm_users');
      $this->db->like('username', $match, 'both');
      $query = $this->db->get();
      return $query->result_array();
  }

}
