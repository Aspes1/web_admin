<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saldo_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  // add Saldo
  // isi array $data (user_id, jumlah_saldo, tgl_update)
  public function addSaldo($data)
  {
      $this->db->insert('inm_saldo_loket', $data);
      return true;
  }

  // update Saldo
  // isi array $data (jumlah_saldo, tgl_update)
  public function updateSaldo($user_id, $nominal)
  {
      // date_default_timezone_set('Asia/Jakarta');
      // $now = date('Y-m-d H:i:s');

      $this->db->set('jumlah_saldo', 'jumlah_saldo+'.$nominal, FALSE);
      $this->db->set('tgl_update', now());
      $this->db->where('user_id', $user_id);
      $this->db->update('inm_saldo_loket');
      return true;
  }

  public function updateSaldoByUsername($data)
  {
      extract($data);
      $user_id = $this->getUserByUsername($username)->row('id');
      $this->db->set('jumlah_saldo', 'jumlah_saldo+'.$jumlah_saldo, FALSE);
      $this->db->set('tgl_update', $tgl_update);
      $this->db->where('user_id', $user_id);
      $this->db->update('inm_saldo_loket');
      return true;
  }

  public function getUserByUsername($username)
  {
    $this->db->select('id,nama_user');
    $this->db->from('inm_users');
    $this->db->where('username', $username);
    return $this->db->get();
  }

  public function getUserIdByGroupId($username)
  {
    $this->db->select('id');
    $this->db->from('inm_users');
    $this->db->where('username', $username);
    $this->db->where('group_id', $username);
    return $this->db->get();
  }


  // show saldo by user
  public function getSaldoByUser($user_id)
  {
      return $this->db->get_where('inm_saldo_loket', array('user_id' => $user_id));
  }

  // show all saldo
  public function getAllSaldo()
  {
      return $this->db->get('inm_saldo_loket');
  }

  public function getTabelSaldo()
  {
      $this->datatables->select('inm_users.id as id,nama_user,username,group_id,jumlah_saldo,inm_users.tgl_update as tgl');
      $this->datatables->from('inm_users');
      $this->datatables->join('inm_saldo_loket', 'inm_users.id=inm_saldo_loket.user_id');
      $this->datatables->add_column('icon', '
      <a href="javascript:void(0);" class="info" data-id="$1" data-group_id="$2">
      <i class="fa fa-plus-square" aria-hidden="true"></i>
      </a>', 'id,group_id');
      return $this->datatables->generate();
  }

  public function getExtraInfo($group)
  {
      $this->db->select('*');
      $this->db->from('inm_users');
      $this->db->where('group_id', $group);
      $query = $this->db->get();
      return $query->result_array();
  }

  public function getHistoryDeposit()
  {
      $this->datatables->select('inm_deposit_langsung.id as id,no_kwitansi,nominal,username,nama_user,inm_deposit_langsung.tgl_create as tgl,print_out');
      $this->datatables->from('inm_users');
      $this->datatables->join('inm_deposit_langsung', 'inm_users.id=inm_deposit_langsung.user_id');
      $this->datatables->add_column('view', '<center>
      <a href="javascript:void(0);" class="print btn btn-info btn-sm" data-id="$1" data-no_kwitansi="$2">Print</a>
      </center>','id,no_kwitansi');
      return $this->datatables->generate();
  }

  public function getRekapDeposit($now)
  {
      $this->datatables->add_column('view', $now, $now);
      $this->datatables->select('count(nominal) as total, sum(nominal) as jumlah');
      $this->datatables->from('inm_deposit_langsung');
      $this->datatables->where('DATE(tgl_create)', $now);
      //$this->datatables->group_by('date(tgl_create)');
      return $this->datatables->generate();
  }

  public function getLastKwitansiNo()
  {
      return $this->db->select('no_kwitansi')->order_by('id','desc')->limit(1)->get('inm_deposit_langsung')->row('no_kwitansi');
  }

  public function getDepositByNoKwitansi($no_kwitansi)
  {
      return $this->db->select('print_out')->where('no_kwitansi', $no_kwitansi)->limit(1)->get('inm_deposit_langsung')->row('print_out');
  }

  public function insertDepositLangsung($data)
  {
      $this->db->insert('inm_deposit_langsung', $data);
      return true;
  }

  public function getUsername($match)
  {
      $this->db->select('username,group_id');
      $this->db->from('inm_users');
      $this->db->like('username', $match, 'both');
      $query = $this->db->get();
      return $query->result_array();
  }

  public function depositLangsung($username, $admin_id, $nominal)
  {
    $query = $this->db->query("CALL DepositLangsung('".$username."','".$admin_id."','".$nominal."')");
    return $query->result_array();
  }

}
