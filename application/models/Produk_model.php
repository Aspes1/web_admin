<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model{

    public $TBL_PRODUK = 'inm_produk';
    public $TBL_VENDOR = 'inm_vendor';
    public $TBL_DAFTAR_HARGA = 'inm_daftar_harga';
    public $TBL_JENIS_PRODUK = 'inm_jenis_produk';

    /** VARIABLE STATIC NAME */
    public $VENDOR_ID_IRS = 3;
    public $DEFAULT_STATUS_PRODUCT = 'Aktif';

    public $INM_STATUS_PRODUK_AKTIF = 1;
    public $INM_STATUS_PRODUK_BLOCK = 2;
    public $INM_STATUS_PRODUK_HAPUS = 3;
    public $DEFAULT_STATUS_KONEKSI  = 0;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    /* ----- start function model produk ----- */
    public function getTabelProduk()
    {
        $this->datatables->select('inm_produk.id as id, nama_lengkap, nama_singkat, inm_jenis_produk.nama_jenis as jenis,
        inm_vendor.nama_vendor as vendor, inm_status_produk.nama_status as status, inm_produk.status_id as status_id, inm_produk.kode_produk as kode_produk');
        $this->datatables->from('inm_produk');
        $this->datatables->join('inm_jenis_produk', 'inm_produk.jenis_produk_id=inm_jenis_produk.id');
        $this->datatables->join('inm_vendor', 'inm_produk.vendor_id=inm_vendor.kode_vendor');
        $this->datatables->join('inm_status_produk', 'inm_produk.status_id=inm_status_produk.id');
        // $this->datatables->add_column('view', '<center>
        // <a href="javascript:void(0);" class="editProduk btn btn-warning btn-sm" data-target="#myModal" data-id="$1">Edit</a>
        // <a href="javascript:void(0);" class="hapusProduk btn btn-danger btn-sm" data-id="$1">Hapus</a>
        // <a href="javascript:void(0);" class="blockProduk btn btn-success btn-sm" data-id="$1">Block</a>
        // </center>','id');
        $this->datatables->where('inm_produk.status_id !=', 3);
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
    }

    public function block_produk($id)
    {
        $this->db->set('status_id', 2);
        $this->db->where('id', $id);
        $succ = $this->db->update('inm_produk');
        if($succ){ return true; }
        else{ return false; }
    }

    public function aktif_produk($id)
    {
        $this->db->set('status_id', 1);
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
        $this->datatables->select('inm_admin_bank.id as id, inm_admin_bank.kode_produk as kode_produk, 
                                    inm_admin_bank.nominal_admin_bank as nominal_admin_bank, 
                                    inm_admin_bank.tgl_update as tgl_update, inm_produk.nama_lengkap as nama_lengkap,
                                    inm_jenis_produk.nama_jenis as nama_jenis');
        $this->datatables->from('inm_admin_bank');
        $this->datatables->join('inm_produk', 'inm_admin_bank.kode_produk=inm_produk.kode_produk');
        $this->datatables->join('inm_jenis_produk', 'inm_jenis_produk.id=inm_produk.jenis_produk_id');
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

    public function getTabelKomisi(){
        $this->datatables->select('inm_komisi.id as id, inm_komisi.tgl_update as tgl_update, inm_produk.nama_lengkap as nama_lengkap,
                                    inm_jenis_produk.nama_jenis as nama_jenis, inm_komisi.range_dari as range_dari, inm_komisi.range_sampai as range_sampai,
                                    inm_komisi.komisi as komisi, inm_komisi.status_pinjaman as status');
        $this->datatables->from('inm_komisi');
        $this->datatables->join('inm_produk', 'inm_komisi.id_produk=inm_produk.id');
        $this->datatables->join('inm_jenis_produk', 'inm_jenis_produk.id=inm_produk.jenis_produk_id');
        $this->datatables->add_column('view', '<center>
        <a href="javascript:void(0);" class="editKomisi btn btn-warning btn-sm" data-target="#myModal" data-id="$1">Edit</a>
        <a href="javascript:void(0);" class="hapusKomisi btn btn-danger btn-sm" data-id="$1">Hapus</a>
        </center>','id');
        return $this->datatables->generate();    
    }

    public function get_produk_for_komisi(){
        $this->db->select('a.id, b.nama_vendor, a.nama_lengkap, a.kode_produk');
        $this->db->join('inm_vendor b', 'a.vendor_id = b.id');
        $this->db->from('inm_produk a');
        return $this->db->get()->result();
    }

    public function cek_komisi($idproduk, $komisi){
        $this->db->select('*');
        $this->db->from('inm_komisi');
        $this->db->where('id_produk', $idproduk);
        $this->db->where('komisi', $komisi);
        $row = $this->db->get()->num_rows();
        if($row > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function store_komisi($data){
        $insert = $this->db->insert('inm_komisi', $data);
        if($insert){
            return true;
        }
        else{
            return false;
        }
    }

    public function get_komisi($id){
        $this->db->select('a.id, b.nama_lengkap, c.nama_jenis, nama_vendor, a.komisi, a.range_dari, a.range_sampai, a.status_pinjaman');
        $this->db->join('inm_produk b', 'a.id_produk = b.id');
        $this->db->join('inm_jenis_produk c', 'b.jenis_produk_id = c.id');
        $this->db->join('inm_vendor d', 'b.vendor_id = d.id');
        $this->db->from('inm_komisi a');
        $this->db->where('a.id', $id);
        return $this->db->get()->row();
    }

    public function update_komisi($data, $id){
        $this->db->where('id', $id);
        $update = $this->db->update('inm_komisi', $data);
        if($update){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function delete_komisi($id){
        $this->db->where('id', $id);
        $succ = $this->db->delete('inm_komisi');
        if($succ){
            return true;      
        }
        else{
            return false;
        }  
    }

    public function getTabelDaftarHarga(){
        $this->datatables->select('inm_daftar_harga.id as id, inm_produk.kode_produk as kode_produk, inm_produk.nama_lengkap as nama_lengkap,
        inm_vendor.nama_vendor as nama_vendor, inm_daftar_harga.harga_vendor as harga_vendor, inm_daftar_harga.harga_jual as harga_jual,
        inm_daftar_harga.harga_terakhir as harga_terakhir, inm_daftar_harga.markup as markup, inm_daftar_harga.tgl_update as tgl_update, 
        inm_daftar_harga.status_id as status_id, inm_produk.kode_produk_vendor as kode_produk_vendor, inm_daftar_harga.nominal as nominal_pulsa');
        $this->datatables->from('inm_daftar_harga');
        $this->datatables->join('inm_produk', 'inm_daftar_harga.kode_produk=inm_produk.kode_produk');
        $this->datatables->join('inm_vendor', 'inm_daftar_harga.vendor_id=inm_vendor.id');
        // $this->datatables->where('inm_produk.status_id !=', 3);
        // $this->datatables->order_by('inm_produk.nama_lengkap');
        return $this->datatables->generate();
    }

    public function get_produk_for_daftar_harga(){
        $this->db->select('a.id, b.nama_vendor, a.nama_lengkap, a.kode_produk');
        $this->db->join('inm_vendor b', 'a.vendor_id = b.id');
        $this->db->from('inm_produk a');
        $this->db->where_in('a.jenis_produk_id', array('4', '5'));
        return $this->db->get()->result();
    }

    public function store_daftar_harga($data){
        $insert = $this->db->insert('inm_daftar_harga', $data);
        if($insert){
            return true;
        }
        else{
            return false;
        }        
    }

    public function get_daftar_harga($id){
        $this->db->select('a.id, b.nama_lengkap, c.nama_vendor, a.harga_vendor, a.harga_jual, a.markup, a.nominal');
        $this->db->join('inm_produk b', 'a.kode_produk = b.kode_produk');
        $this->db->join('inm_vendor c', 'a.vendor_id = c.id');
        $this->db->from('inm_daftar_harga a');
        $this->db->where('a.id', $id);
        return $this->db->get()->row();
    }

    public function update_daftar_harga($data, $id){
        $this->db->where('id', $id);
        $update = $this->db->update('inm_daftar_harga', $data);
        if($update){
            return true;
        }
        else{
            return false;
        }
    }

    public function delete_daftar_harga($id){
        $this->db->where('id', $id);
        $delete = $this->db->delete('inm_daftar_harga');
        if($delete){
            return true;
        }
        else{
            return false;
        }
    }

    public function block_daftar_harga($id){
        $this->db->set('status_id', 'Block');
        $this->db->where('id', $id);
        $block = $this->db->update('inm_daftar_harga');
        if($block){
            return true;
        }
        else{
            return false;
        }
    }

    public function aktif_daftar_harga($id){
        $this->db->set('status_id', 'Aktif');
        $this->db->where('id', $id);
        $aktif = $this->db->update('inm_daftar_harga');
        if($aktif){
            return true;
        }
        else{
            return false;
        }
    }


    /** IRS */
    public function setDataProduct($data)
    {
        $arrays = array(
            'jenis_produk_id'    => $data['jenis_id'],
            'vendor_id'          => $data['vendor_id'],
            'nama_singkat'       => $data['nama_singkat'],
            'nama_lengkap'       => $data['nama_lengkap'],
            'kode_produk'        => $data['kode_produk'],
            'kode_produk_vendor' => $data['kode_vendor'],
            'keterangan'         => $data['keterangan'],
            'status_id'          => $data['status_id'],
            'status_koneksi'     => $data['status_koneksi']
        );
        return $arrays;
    }

    public function setDataProductPrices($data)
    {
        $arrays = array(
            'kode_produk'    => $data['kode_produk'],
            'vendor_id'      => $data['vendor_id'],
            'harga_vendor'   => $data['harga_vendor'],
            'harga_jual'     => $data['harga_jual'],
            'markup'         => $data['markup'],
            'nominal'        => $data['nominal'],
            'harga_terakhir' => $data['harga_terakhir'],
            'tgl_create'     => $data['create_date'],
            'tgl_update'     => $data['update_date'],
            'status_id'      => $data['default_status'],
            'admin_id'       => $data['admin_id'],
        );

        return $arrays;
    }

    /** MODEL TO HANDLE FOR IRS */
    public function getMaxCodeInProductIRSByType($id)
    {
        $this->db->select('MAX(kode_produk) AS kode_produk')
                 ->from($this->TBL_PRODUK)
                 ->where('jenis_produk_id',$id);
        $select = $this->db->get();
        return ($select->num_rows() > 0) ? $select->row()->kode_produk : 0;
    }

    public function getProductByType($product_type)
    {
        $select = $this->db->where('jenis_produk_id', $id)->get($this->TBL_PRODUK);
        return ($select->num_rows() > 0) ? $select->result_array() : 0;
    }

    public function checkProductIRSByArray($nominal, $keterangan, $kode_jenis)
    {
        $this->db->select('*')->from($this->TBL_PRODUK.' p');
        $this->db->join($this->TBL_DAFTAR_HARGA.' dh', 'p.vendor_id = dh.vendor_id');
        $this->db->where('p.vendor_id', 3);
        $this->db->where('p.jenis_produk_id', $kode_jenis);
        $this->db->where('dh.nominal', $nominal);

        $select = $this->db->get();

        if($select->num_rows() > 0)
        {
            $bools = false;
            foreach ($select->result_array() as $v) {
                if (strpos($v['keterangan'], $keterangan) !== false) {
                    $bools = true;
                    break;
                }
            }

            return $bools;
        }

        return "0";
    }

    /** MODEL TO HANDLE VENDOR */
    public function insertData($table, $data)
    {
        $insert = $this->db->insert($table, $data);
        if($insert)
            return true;
        return false;
    }

    public function addIRSToProductBase($insert_data)
    {
        $insert_data['default_status']  = $this->DEFAULT_STATUS_PRODUCT;
        $insert_data['vendor_id']       = $this->VENDOR_ID_IRS;
        $insert_data['jenis_id']        = ($insert_data['jenis_produk'] == 'pulsa') ? 4 : 6;
        $insert_data['status_koneksi']  = $this->DEFAULT_STATUS_KONEKSI;
        $insert_data['status_id']       = $this->INM_STATUS_PRODUK_AKTIF;

        $insert_product = $this->insertData($this->TBL_PRODUK, $this->setDataProduct($insert_data));
        if($insert_product == true){
            $insert_harga = $this->insertData($this->TBL_DAFTAR_HARGA, $this->setDataProductPrices($insert_data));
            return ($insert_harga == true) ? true : 'Insert Data Ke Tabel Harga Gagal';  
        }

        return 'Insert Data Ke Tabel Produk Gagal';

    }


    public function editIRSProductPrice($code, $harga_awal, $data)
    {
        $set_update = array(
            'harga_vendor' => $data['harga_produk'],
            'harga_terakhir' => $harga_awal
        );

        $kode_produk = $this->db->select('kode_produk')->from('inm_produk')->where('kode_produk_vendor', $code)->get()->row()->kode_produk;
        $update = $this->db->where('kode_produk', $kode_produk)->update('inm_daftar_harga', $set_update);
        if($update)
            return true;
        else
            return false;
    }

    public function updateHargaProdukIRS($kode_produk, $harga_vendor, $harga_terakhir)
    {
        $set_update = array(
            'harga_vendor'  => $harga_vendor,
            'harga_terakhir' => $harga_terakhir
        );
        $update = $this->db->where('kode_produk', $kode_produk)->update('inm_daftar_harga', $set_update);
        if($update)
            return true;
        else
            return false;

    }

    public function getProductAndPriceByTypeCode($kode_jenis)
    {
        $this->db->select('inp.jenis_produk_id, inp.vendor_id, inh.kode_produk ,inp.kode_produk_vendor, inp.nama_lengkap, inh.harga_vendor, inh.harga_terakhir')->from('inm_produk inp');
        $this->db->join('inm_daftar_harga inh', 'inp.kode_produk = inh.kode_produk');
        $this->db->where('inp.vendor_id', 3);
        $this->db->where('inp.jenis_produk_id', $kode_jenis);
        $select = $this->db->get();
        return ($select->num_rows() > 0) ? $select->result_array() : null;
    }
    

}
