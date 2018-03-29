<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

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

  public function getAllJenisProduk()
  {
      $this->db->select('id,nama_jenis');
      $this->db->from('inm_jenis_produk');
      $query =  $this->db->get();
      return $query->result_array();
  }

  public function getAllVendor()
  {
      $this->db->select('id,nama_vendor');
      $this->db->from('inm_vendor');
      $query =  $this->db->get();
      return $query->result_array();
  }

}
