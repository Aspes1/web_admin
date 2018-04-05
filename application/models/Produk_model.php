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
      $this->datatables->select('inm_produk.id as id, nama_lengkap, nama_singkat, inm_jenis_produk.nama_jenis as jenis,
       inm_vendor.nama_vendor as vendor, inm_status_produk.nama_status as status');
      $this->datatables->from('inm_produk');
      $this->datatables->join('inm_jenis_produk', 'inm_produk.jenis_produk_id=inm_jenis_produk.id');
      $this->datatables->join('inm_vendor', 'inm_produk.vendor_id=inm_vendor.kode_vendor');
      $this->datatables->join('inm_status_produk', 'inm_produk.status_id=inm_status_produk.id');
      $this->datatables->add_column('view', '<center>
      <a href="javascript:void(0);" class="editProduk btn btn-warning btn-sm" data-target="#myModal" data-id="$1">Edit</a>
      <a href="javascript:void(0);" class="hapusProduk btn btn-danger btn-sm" data-id="$1">Hapus</a>
      </center>','id');
      $this->datatables->where('inm_produk.status_id', 1);
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

  public function get_produk_for_edit($id)
  {
      $this->db->select('*');
      $this->db->from('inm_produk');
      $this->db->where('id', $id);
      return $this->db->get()->row();
  }

  public function get_status()
  {
      $this->db->select('*');
      $this->db->from('inm_status_produk');
      return $this->db->get()->result();      
  }

  public function update_produk($data, $id)
  {
      $this->db->where('id', $id);
      $this->db->update('inm_produk', $data);
      return true;
  }

  public function delete_produk($id)
  {
      $this->db->set('status_id', 3);
      $this->db->where('id', $id);
      $succ = $this->db->update('inm_produk');
      if($succ){ return true; }
      else{ return false; }
  }
  /* ----- end function model produk ----- */

  /* ----- start function model jenis produk ----- */
  public function getTabelJenisProduk()
  {
      $this->datatables->select('id, nama_jenis,');
      $this->datatables->from('inm_jenis_produk');
      $this->datatables->add_column('view', '<center>
      <a href="javascript:void(0);" class="editJenisProduk btn btn-warning btn-sm" data-target="#myModal" data-id="$1">Edit</a>
      <a href="javascript:void(0);" class="hapusJenisProduk btn btn-danger btn-sm" data-id="$1">Hapus</a>
      </center>','id');
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

  public function get_jenis_produk($id)
  {
      $this->db->select('*');
      $this->db->from('inm_jenis_produk');
      $this->db->where('id', $id);
      return $this->db->get()->row();
  }

  public function update_jenis_produk($data, $id)
  {
      $this->db->where('id', $id);
      $this->db->update('inm_jenis_produk', $data);
      return true;      
  }

  public function delete_jenis_produk($id)
  {
      $this->db->where('id', $id);
      $succ = $this->db->delete('inm_jenis_produk');
      if($succ){
        return true;
      }
      else{
        return false;
      }
  }
  /* ----- end function model jenis produk ----- */

  /* ----- start function model vendor ----- */
  public function getTabelVendor()
  {
      $this->datatables->select('id, nama_vendor, kode_vendor');
      $this->datatables->from('inm_vendor');
      $this->datatables->add_column('view', '<center>
      <a href="javascript:void(0);" class="editVendor btn btn-warning btn-sm" data-target="#myModal" data-id="$1">Edit</a>
      <a href="javascript:void(0);" class="hapusVendor btn btn-danger btn-sm" data-id="$1" data-nama="$2">Hapus</a>
      </center>','id, nama_vendor');
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

  public function get_vendor($id)
  {
      $this->db->select('*');
      $this->db->from('inm_vendor');
      $this->db->where('id', $id);
      return $this->db->get()->row();
  }

  public function update_vendor($data, $id)
  {
      $this->db->where('id', $id);
      $this->db->update('inm_vendor', $data);
      return true;      
  }

  public function delete_vendor($id)
  {
      $this->db->where('id', $id);
      $succ = $this->db->delete('inm_vendor');
      if($succ){
        return true;      
      }
      else{
        return false;
      }
  }
  /* ----- end function model vendor ----- */

  /* ----- start function model biaya admin ----- */
  public function getTabelBiayaAdmin()
  {
      $this->datatables->select('id, kode_produk, nominal_admin_bank, tgl_create');
      $this->datatables->from('inm_admin_bank');
      $this->datatables->add_column('view', '<center>
      <a href="javascript:void(0);" class="editBiaya btn btn-warning btn-sm" data-target="#myModal" data-id="$1">Edit</a>
      <a href="javascript:void(0);" class="hapusBiaya btn btn-danger btn-sm" data-id="$1">Hapus</a>
      </center>','id');
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

  public function get_biaya_admin($id)
  {
      $this->db->select('*');
      $this->db->from('inm_admin_bank');
      $this->db->where('id', $id);
      return $this->db->get()->row();
  }

  public function update_biaya_admin($data, $id)
  {
      $this->db->where('id', $id);
      $succ = $this->db->update('inm_admin_bank', $data);
      if($succ){
        return true;
      }
      else{
        return false;
      }
  }

  public function delete_biaya_admin($id)
  {
      $this->db->where('id', $id);
      $succ = $this->db->delete('inm_admin_bank');
      if($succ){
        return true;      
      }
      else{
        return false;
      }      
  }
  /* ----- start function model biaya admin ----- */

  /* ----- end function model pengumuman ----- */
  public function getTabelPengumuman()
  {
      $this->datatables->select('id, isi, judul, tgl_update, tgl_create, admin_id');
      $this->datatables->from('inm_pengumuman');
      $this->datatables->add_column('view', '<center>
      <a href="javascript:void(0);" class="editPengumuman btn btn-warning btn-sm" data-target="#myModal" data-id="$1">Edit</a>
      <a href="javascript:void(0);" class="hapusPengumuman btn btn-danger btn-sm" data-id="$1" data-judul="$2">Hapus</a>
      </center>','id, judul');
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

  public function get_pengumuman($id)
  {
      $this->db->select('*');
      $this->db->from('inm_pengumuman');
      $this->db->where('id', $id);
      return $this->db->get()->row();
  }

  public function update_pengumuman($data, $id)
  {
      $this->db->where('id', $id);
      $update = $this->db->update('inm_pengumuman', $data);
      if($update){
        return true;
      }
      else{
        return false;
      }
  }

  public function delete_pengumuman($id)
  {
      $this->db->where('id', $id);
      $succ = $this->db->delete('inm_pengumuman');
      if($succ){
        return true;      
      }
      else{
        return false;
      }      

  }
  /* ----- end function model pengumuman ----- */


}
