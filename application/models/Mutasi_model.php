<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  // show all mutasi
  // status mutasi
  // proses = 1
  // sukses = 2
  public function getAllMutasiProses()
  {
      return $this->db->get_where('temp_mutasi_bank', array('status_id' => '1'));
  }

  // insert mutasi
  // isi array $data (raw, nama_bank, no_rekening, tgl_create, tgl_transfer, waktu_transfer, keterangan, debit, kredit, status_id = 1, ca_id, admin_id)
  public function insertMutasi($data)
  {
      // $this->db->insert_batch('temp_mutasi_bank', $data);
      $insert_query = $this->db->insert_string('inm_mutasi_bank', $data);
	    $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
	    $this->db->query($insert_query);
      return true;
  }

  // update mutasi
  // ubah status mutasi menjadi sukses = 2
  public function updateStatusMutasi($id)
  {
      $this->db->set('status_id', '2');
      $this->db->where('id', $id);
      $this->db->update('inm_mutasi_bank');
      return true;
  }

  public function updateStatusTiket($id)
  {
      $this->db->set('status_id', '2');
      $this->db->where('id', $id);
      $this->db->update('inm_deposit_tiket');
      return true;
  }

  public function getUserIdByTiket($id)
  {
    $this->db->select('user_id');
    $this->db->from('inm_deposit_tiket');
    $this->db->where('id', $id);
    return $this->db->get();
  }

  public function getSaldoByMutasiID($id)
  {
    $this->db->select('nominal');
    $this->db->from('inm_mutasi_bank');
    $this->db->where('id', $id);
    return $this->db->get();
  }

  public function ubahNominalTiket($id, $nominal)
  {
      $this->db->set('nominal', $nominal);
      $this->db->where('id', $id);
      $this->db->update('inm_deposit_tiket');
      return true;
  }

  public function komparasi()
  {
      $query = $this->db->query(
        "SELECT id as tiket_id
        FROM inm_deposit_tiket
        WHERE nominal IN
        (SELECT nominal FROM inm_mutasi_bank)
        UNION
        SELECT id as mutasi_id
        FROM inm_mutasi_bank
        WHERE nominal IN
        (SELECT nominal FROM inm_deposit_tiket);"
      );
      //
      // foreach ($query->result_array() as $row)
      // {
      //     echo $row['tiket_id'];
      //     //echo $row['mutasi_id']
      // }
      $now = nowDateOnly();
      return $query->result_array();
  }

  public function getMutasiByNominal($nominal)
  {
      $this->db->select('id,nominal');
      $this->db->from('inm_mutasi_bank');
      $this->db->where('nominal', $nominal);
      $this->db->where('admin_id', $this->session->userdata('adminId'));
      $this->db->where('status_id', '1');
      $this->db->where('DATE(tgl_create)', nowDateOnly());
      return $query = $this->db->get();
  }

  public function getTiket()
  {
      $this->db->select('id,nominal,user_id');
      $this->db->from('inm_deposit_tiket');
      $this->db->where('status_id', '1');
      $this->db->where('admin_id', $this->session->userdata('adminId'));
      $this->db->where('DATE(tgl_create)', nowDateOnly());
      $query = $this->db->get();
      return $query->result_array();
  }

  public function getAllMutasi()
  {
      $this->db->select('id,nominal');
      $this->db->from('inm_mutasi_bank');
      $this->db->where('status_id', '1');
      $this->db->where('DATE(tgl_create)', nowDateOnly());
      $query = $this->db->get();
      return $query->result_array();
  }

  public function countAllMutasi()
  {
    $this->db->where('status_id', '1');
    $this->db->where('DATE(tgl_create)', nowDateOnly());
    $query = $this->db->get('inm_mutasi_bank');
    return $query->num_rows();
  }

  public function isLoketExist($user_id)
  {
    $query = $this->db->get_where('inm_users', array('id' => $user_id));
    if ($query->num_rows() > 0){
        return true;
    }
    else
    {
        return false;
    }
  }

  public function getTabelMutasi()
  {
      $this->datatables->select('nama_bank,nominal,keterangan,tgl_transfer,id');
      $this->datatables->from('inm_mutasi_bank');
      $this->datatables->where('status_id', '1');
      $this->datatables->where('admin_id', $this->session->userdata('adminId'));
      $this->datatables->add_column('icon', '
      <a href="javascript:void(0);" class="info" data-id="$1">
      <i class="fa fa-plus-square" aria-hidden="true"></i>
      </a>', 'id');
      return $this->datatables->generate();
  }

  public function getDataTiket($match)
  {
      $this->db->select('inm_deposit_tiket.id as idT,username,nama_bank,nominal,inm_deposit_tiket.tgl_create as tgl');
      $this->db->from('inm_deposit_tiket');
      $this->db->join('inm_users', 'inm_deposit_tiket.user_id=inm_users.id');
      $this->db->join('inm_akun_bank', 'inm_deposit_tiket.akun_bank_id=inm_akun_bank.id');
      $this->db->like('inm_users.username', $match, 'both');
      $this->db->where('inm_deposit_tiket.status_id','1');
      $query = $this->db->get();
      return $query->result_array();
  }

  public function autoCompareSP()
  {
      $query = $this->db->query("CALL AutoCompare()");
      return $query->result_array();
  }

  public function rekonMutasiSP($username,$mutasi_id)
  {
      $query = $this->db->query("CALL RekonMutasi('".$username."','".$mutasi_id."')");
      return $query->result_array();
  }


}
