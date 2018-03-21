<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  /* ----- start function model produk ----- */
  public function getTabelProduk()
  {
      $this->datatables->select('nama_lengkap, nama_singkat, inm_jenis_produk.nama_jenis as jenis,
       inm_vendor.nama_vendor as vendor, inm_status_produk.nama_status as status');
      $this->datatables->from('inm_produk');
      $this->datatables->join('inm_jenis_produk', 'inm_produk.jenis_produk_id=inm_jenis_produk.id');
      $this->datatables->join('inm_vendor', 'inm_produk.vendor_id=inm_vendor.kode_vendor');
      $this->datatables->join('inm_status_produk', 'inm_produk.status_id=inm_status_produk.id');
      return $this->datatables->generate();
  }

  public function all_jenis_produk()
  {
      $this->db->select('*');
      $this->db->from('inm_jenis_produk');
      return $this->db->get()->result();
  }

  public function all_vendor()
  {
      $this->db->select('*');
      $this->db->from('inm_vendor');
      return $this->db->get()->result();
  }

  public function get_produk($kode)
  {
      $this->db->select('kode_produk');
      $this->db->from('inm_produk');
      $this->db->where('kode_produk', $kode);
      $row = $this->db->get()->num_rows();
      if($row > 0){
        return true;
      }
      else{
        return false;
      }
  }

  public function store_produk($data)
  {
     $store = $this->db->insert('inm_produk', $data);
     if($store)
     {
        return true;
     }
     else
     {
        return false;
     }
  }
  /* ----- end function model produk ----- */

  /* ----- start function model jenis produk ----- */
  public function getTabelJenisProduk()
  {
      $this->datatables->select('nama_jenis,');
      $this->datatables->from('inm_jenis_produk');
      return $this->datatables->generate();    
  }

  public function cek_jenis_produk($param)
  {
      $this->db->select('nama_jenis');
      $this->db->from('inm_jenis_produk');
      $this->db->where('nama_jenis', $param);
      $row = $this->db->get()->num_rows();
      if($row > 0){
        return true;
      }
      else{
        return false;
      }
  }

  public function store_jenis_produk($data)
  {
     $store = $this->db->insert('inm_jenis_produk', $data);
     if($store)
     {
        return true;
     }
     else
     {
        return false;
     }
  }
  /* ----- end function model jenis produk ----- */

  /* ----- start function model vendor ----- */
  public function getTabelVendor()
  {
      $this->datatables->select('id, nama_vendor, kode_vendor');
      $this->datatables->from('inm_vendor');
      return $this->datatables->generate();     
  } 

  public function cek_nama_vendor($param)
  {
      $this->db->select('nama_vendor');
      $this->db->from('inm_vendor');
      $this->db->where('nama_vendor', $param);
      $row = $this->db->get()->num_rows();
      if($row > 0){
        return true;
      }
      else{
        return false;
      }    
  }

  public function store_vendor($data)
  {
     $store = $this->db->insert('inm_vendor', $data);
     if($store)
     {
        return true;
     }
     else
     {
        return false;
     }
  }  
  /* ----- end function model vendor ----- */

  /* ----- start function model biaya admin ----- */
  public function getTabelBiayaAdmin()
  {
      $this->datatables->select('id, kode_produk, nominal_admin_bank, tgl_create');
      $this->datatables->from('inm_admin_bank');
      return $this->datatables->generate();    
  }

  public function store_biaya_admin($data)
  {
     $store = $this->db->insert('inm_admin_bank', $data);
     if($store)
     {
        return true;
     }
     else
     {
        return false;
     }
  }
  /* ----- start function model biaya admin ----- */

  /* ----- end function model pengumuman ----- */
  public function getTabelPengumuman()
  {
      $this->datatables->select('id, isi, judul, tgl_update, tgl_create, admin_id');
      $this->datatables->from('inm_pengumuman');
      return $this->datatables->generate();    
  }

  public function store_pengumuman($data)
  {
     $store = $this->db->insert('inm_pengumuman', $data);
     if($store)
     {
        return true;
     }
     else
     {
        return false;
     }
  }
  /* ----- end function model pengumuman ----- */


}