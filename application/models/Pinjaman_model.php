<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjaman_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function setDbs($data)
  {
      $this->db->insert('inm_dbs', $data);
      return true;
  }

  public function getListDBS()
  {
      $this->datatables->select('inm_users.group_id,inm_users.no_telp,nominal,inm_dbs.tgl_create as tgl,inm_dbs.id,inm_dbs.user_id');
      $this->datatables->from('inm_dbs');
      $this->datatables->join('inm_users', 'inm_users.id=inm_dbs.user_id');
      $this->datatables->where('inm_dbs.status_id', '1');
      $this->datatables->where('inm_dbs.admin_id', $this->session->userdata('adminId'));
      // $this->datatables->add_column('view', '<center>
      // <a href="javascript:void(0);" class="dbs_ubah btn btn-info btn-sm" data-id="$1" data-group_id="$2">Bayar</a>
      // </center>','id,group_id');
      return $this->datatables->generate();
  }

  public function getListPinjaman()
  {
      $this->datatables->select('inm_users.group_id,inm_users.no_telp,inm_pinjaman.nominal,inm_pinjaman.tgl_create as tgl,inm_pinjaman.id,inm_pinjaman.user_id');
      $this->datatables->from('inm_pinjaman');
      $this->datatables->join('inm_users', 'inm_users.id=inm_pinjaman.user_id');
      $this->datatables->where('inm_pinjaman.status_id', '1');
      return $this->datatables->generate();
  }

  public function ubahStatus($id)
  {
      $this->db->set('status_id', '2');
      $this->db->set('tgl_update', now());
      $this->db->where('id', $id);
      $this->db->update('inm_dbs');
      return true;
  }

  public function isDbsExist($user_id)
  {
    $query = $this->db->get_where('inm_dbs', array('user_id' => $user_id, 'status_id' => '1'));
    if ($query->num_rows() > 0){
        return true;
    }
    else
    {
        return false;
    }
  }

  public function isPinjamanExist($user_id)
  {
      $query = $this->db->get_where('inm_pinjaman', array('user_id' => $user_id, 'status_id' => '1'));
      if ($query->num_rows() > 0){
          return true;
      }
      else
      {
          return false;
      }
  }

  public function autoPotong($user_id, $nominal)
  {
    $query = $this->db->query("CALL potong_dbs('".$user_id."','".$nominal."')");
    //return $query->result();
    return $query->row('@amount');
  }

  public function setPinjamanSP($username, $nominal, $admin_id)
  {
      $query = $this->db->query("CALL SetPinjaman('".$username."','".$nominal."','".$admin_id."')");
      return $query->result_array();
  }

}
