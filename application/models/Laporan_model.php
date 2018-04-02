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

  public function allLaporan($dari, $sampai){

    $str="SELECT
            Sum(IF( inm_produk.jenis_produk_id = 1, inm_transaksi_detail.lembar, 0)) AS PLN,
            Sum(IF( inm_produk.jenis_produk_id = 1, inm_transaksi_detail.total_tagihan, 0)) AS TotalTagihan_PLN,
            Sum(IF( inm_produk.jenis_produk_id = 2, inm_transaksi_detail.lembar, 0)) AS PDAM,
            Sum(IF( inm_produk.jenis_produk_id = 2, inm_transaksi_detail.total_tagihan, 0)) AS TotalTagihan_PDAM,

            inm_transaksi.user_id,
            inm_users.username
          FROM
            inm_transaksi_detail
          INNER JOIN inm_transaksi_detail_status ON inm_transaksi_detail_status.id = inm_transaksi_detail.status_id
          INNER JOIN inm_transaksi ON inm_transaksi_detail.transaksi_id = inm_transaksi.id
          INNER JOIN inm_produk ON inm_transaksi_detail.produk_id = inm_produk.id
          INNER JOIN inm_users ON inm_transaksi.user_id = inm_users.id
          WHERE DATE(inm_transaksi.tgl_transaksi)>='".$dari."' AND DATE(inm_transaksi.tgl_transaksi) <= '".$sampai."'
          GROUP BY
            inm_transaksi.user_id";
            // inm_transaksi.tgl_transaksi,
      return $this->db->query($str);
  }
  
  public function allLaporanPeriode($dari_, $sampai_){

  $str="SELECT
        Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_detail.lembar,0)) AS PLN,
        Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_detail.total_tagihan,0)) AS TotalTagihan_PLN,
        Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_detail.lembar,0)) AS PDAM,
        Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_detail.total_tagihan,0)) AS TotalTagihan_PDAM,
        inm_transaksi.tgl_transaksi
      FROM
        inm_transaksi_detail
      INNER JOIN inm_transaksi_detail_status ON inm_transaksi_detail_status.id = inm_transaksi_detail.status_id
      INNER JOIN inm_transaksi ON inm_transaksi_detail.transaksi_id = inm_transaksi.id
      INNER JOIN inm_produk ON inm_transaksi_detail.produk_id = inm_produk.id
      INNER JOIN inm_users ON inm_transaksi.user_id = inm_users.id
      WHERE
      DATE(inm_transaksi.tgl_transaksi) >= '".$dari_."' AND DATE(inm_transaksi.tgl_transaksi) <= '".$sampai_."'
      GROUP BY
        inm_transaksi.tgl_transaksi";
      return $this->db->query($str);
  }

  public function getAllLaporanToday($dari)
  {
      $this->datatables->select('td.id_pelanggan,p.nama_lengkap,td.nama_pelanggan,t.tgl_transaksi,td.lembar,td.jumlah_tagihan,td.total_tagihan,td.biaya_admin');
      $this->datatables->from('inm_transaksi_detail'. ' td');
      $this->datatables->join('inm_transaksi'. ' t', 'td.transaksi_id = t.id');
      $this->datatables->join('inm_produk'. ' p', 'td.produk_id = p.id');
      $this->datatables->where('DATE(t.tgl_transaksi) >=', $dari);
      return $this->datatables->generate();

  }  

  public function laporan_giry_bayar_per_tanggal($dari_, $sampai_){

  $str="SELECT
        Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_griya.jumlah_transaksi,0)) AS PLN,
        Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_griya.rupiah_transaksi,0)) AS TotalTagihan_PLN,
        Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_griya.jumlah_transaksi,0)) AS PDAM,
        Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_griya.rupiah_transaksi,0)) AS TotalTagihan_PDAM,
        inm_transaksi_griya.tanggal
      FROM
        inm_transaksi_griya
      INNER JOIN inm_produk ON inm_transaksi_griya.produk_id = inm_produk.id
      WHERE
      DATE(inm_transaksi_griya.tanggal) >= '".$dari_."' AND DATE(inm_transaksi_griya.tanggal) <= '".$sampai_."'
      GROUP BY
        inm_transaksi_griya.tanggal";
      return $this->db->query($str);
  }

  public function laporan_giry_bayar_per_user($dari_, $sampai_){
    $str="SELECT
            Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_griya.jumlah_transaksi,0)) AS PLN,
            Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_griya.rupiah_transaksi,0)) AS TotalTagihan_PLN,
            Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_griya.jumlah_transaksi,0)) AS PDAM,
            Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_griya.rupiah_transaksi,0)) AS TotalTagihan_PDAM,
            inm_transaksi_griya.nama
          FROM
            inm_transaksi_griya
          INNER JOIN inm_produk ON inm_transaksi_griya.produk_id = inm_produk.id
          WHERE
          DATE(inm_transaksi_griya.tanggal) >= '".$dari_."' AND DATE(inm_transaksi_griya.tanggal) <= '".$sampai_."'
          GROUP BY
            inm_transaksi_griya.nama";
          return $this->db->query($str);
  }

  public function getExtraInfo($nama)
  {

    $str ="SELECT
                Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_griya.jumlah_transaksi,0)) AS PLN,
                Sum(IF(inm_produk.jenis_produk_id = 1,inm_transaksi_griya.rupiah_transaksi,0)) AS TotalTagihan_PLN,
                Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_griya.jumlah_transaksi,0)) AS PDAM,
                Sum(IF(inm_produk.jenis_produk_id = 2,inm_transaksi_griya.rupiah_transaksi,0)) AS TotalTagihan_PDAM,
                inm_transaksi_griya.username
              FROM
                inm_transaksi_griya
              INNER JOIN inm_produk ON inm_transaksi_griya.produk_id = inm_produk.id
              WHERE
                inm_transaksi_griya.nama = '".$nama."'
              GROUP BY
                inm_transaksi_griya.username";

      return $this->db->query($str);
  }  

  public function get_nama_produk()
  {
      $this->db->select('*');
      $this->db->from('inm_produk');
      $this->db->where('status_id', 1);
      return $this->db->get();
  }    

  public function get_produk_inm($nama){
      $this->db->select('*');
      $this->db->from('inm_produk');
      $this->db->where('nama_lengkap', $nama);
      $this->db->where('status_id', 1);
      $this->db->not_like('nama_lengkap', 'PDAM Tirtanadi Medan');
      $this->db->not_like('nama_lengkap', 'PDAM Tirtabulian Tebing Tinggi');
      $this->db->not_like('nama_lengkap', 'PDAM Tirtauli Pematang Siantar');
      return $this->db->get();
  }

  public function cek_data_transaksi_griya($id, $tgl){
      $this->db->select('*');
      $this->db->from('inm_transaksi_griya');
      $this->db->where('produk_id', $id);
      $this->db->where('tanggal', $tgl);
      return $this->db->get();
  }

  public function insert_laporan_transaksi_griya($data){
      $insert = $this->db->insert_batch('inm_transaksi_griya', $data);
      if($insert){
        return true;
      }
      else{
        return false;
      }
  }

}
