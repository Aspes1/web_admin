<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function getProdukName()
  {
    // $this->db->select('nama_jenis');
    // $this->db->from('inm_jenis_produk');
    // return $this->db->get();
    return $this->db->get('inm_jenis_produk');
  }

}
