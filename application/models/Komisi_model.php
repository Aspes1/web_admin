<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komisi_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_komisi_by_user($from, $to){
        $this->datatables->select('u.nama_user, p.nama_lengkap, sum(td.lembar) as lembar, sum(k.komisi) as komisi, t.tgl_transaksi');
        $this->datatables->from('inm_transaksi_detail'. ' td');
        $this->datatables->join('inm_transaksi'. ' t', 'td.transaksi_id = t.id');
        $this->datatables->join('inm_users'. ' u', 'u.id = t.user_id');
        $this->datatables->join('inm_produk'. ' p', 'td.produk_id = p.id');
        $this->datatables->join('inm_komisi'. ' k', 'k.id_produk = p.id');
        $this->datatables->where('DATE(t.tgl_transaksi) >=', $from);
        $this->datatables->where('DATE(t.tgl_transaksi) <=', $to);
        $this->datatables->group_by('p.nama_lengkap');
        return $this->datatables->generate();
    }

}