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
      $query = $this->db->insert('temp_user', $data);
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
      $this->db->update('temp_user', $data);
      return true;
  }

  // block user
  // 1 = block
  // @return bool true on success, false on failure
  public function blockUser($id)
  {
      $this->db->set('status_id', '1');
      $this->db->where('id', $id);
      $this->db->update('temp_user');
      return true;
  }

  // unblock user
  // 0 = unblock
  // @return bool true on success, false on failure
  public function unblockUser($id)
  {
      $this->db->set('status_id', '0');
      $this->db->where('id', $id);
      $this->db->update('temp_user');
      return true;
  }

  // reset ip address
  // @return bool true on success, false on failure
  public function resetIpAddress($id)
  {
      $this->db->set('ip_address', 'NULL');
      $this->db->where('id', $id);
      $this->db->update('temp_user');
      return true;
  }

  // reset mac address
  // @return bool true on success, false on failure
  public function resetMacAddress($id)
  {
      $this->db->set('mac_address', 'NULL');
      $this->db->where('id', $id);
      $this->db->update('temp_user');
      return true;
  }

  // change password
  // @return bool true on success, false on failure
  public function changePassword($id, $newpassword)
  {
      $this->db->set('password', $newpassword);
      $this->db->where('id', $id);
      $this->db->update('temp_user');
      return true;
  }

  // add cookie
  // @return bool true on success, false on failure
  public function addCookie($id, $cookie)
  {
      $this->db->set('cookie', $cookie);
      $this->db->where('id', $id);
      $this->db->update('temp_user');
      return true;
  }

  // show user by ID
  // @return object, the user object
  public function getUserByID($id)
  {
      return $this->db->get_where('temp_user', array('id' => $id));
  }

  // show all user
  // @return object, the user object
  public function getAllUser()
  {
      $this->datatables->select('temp_user.id as id,nama_user,payment_point_id,group_id,level,mac_address,ip_address,tgl_create,jumlah_saldo,nama_status');
      $this->datatables->from('temp_user');
      $this->datatables->join('temp_saldo_user', 'temp_user.id=temp_saldo_user.user_id');
      $this->datatables->join('temp_user_status', 'temp_user.status_id=temp_user_status.kode_status');
      $this->datatables->add_column('view', '<a href="javascript:void(0);" class="isi_saldo btn btn-info btn-xs" data-id="$1" data-ppid="$2">Isi Saldo</a>','id,payment_point_id');
      return $this->datatables->generate();
  }

  public function getLokasi($kodepos)
  {
      $this->db->select('*');
      $this->db->from('inm_kodepos');
      $this->db->where('kodepos', $kodepos);
      return $this->db->get();
  }

  public function ppidExists($id)
  {
      $query = $this->db->get_where('temp_user', array('username' => $id));
      if ($query->num_rows() > 0){
          return true;
      }
      else
      {
          return false;
      }
  }

}
