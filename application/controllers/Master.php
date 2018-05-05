<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/controllers/services/Irs_services.php';

class Master extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('produk_model');
    $this->load->library('datatables');
    $this->load->library('form_validation');
    date_default_timezone_set('Asia/Jakarta');

    if($this->session->userdata('isLog') == FALSE)
    {
        $this->session->set_flashdata('need_login','Anda harus login terlebih dahulu.');
        redirect('login','refresh');
    }
    if($this->session->userdata('adminRole') !== 'Superadmin')
    {
        redirect('error_550','refresh');
    }
  }

    public function index()
    {
        $data['title']      = 'Menu Master';
        $data['submenu']    = 'master/menu_master';
        $data['contents']   = 'master/list_produk';
        $data['myscripts']  = 'assets/src/js/fn-irs.js';
        $this->load->view('templates/app', $data);
    }

  /*------ master produk ------*/
    public function getProdukJson()
    {
        //data user by JSON object
        header('Content-Type: application/json');
        echo $this->produk_model->getTabelProduk();
    }

    public function produkPage()
    {
        $this->load->view('master/list_produk');
    }

    public function AddProdukPage()
    {
        $data['jenisproduk'] = $this->produk_model->all_jenis_produk();
        $data['vendor'] = $this->produk_model->all_vendor();
        $this->load->view('master/add_produk', $data);
    }

    public function CreateProduk()
    {
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
        $this->form_validation->set_rules('vendor', 'Vendoe', 'required');
        $this->form_validation->set_rules('singkatan','Singkatan', 'required');
        $this->form_validation->set_rules('kd_vendor', 'Kode Vendor', 'required');
        $this->form_validation->set_rules('kd_produk', 'Kode Produk', 'required');
        $this->form_validation->set_rules('jenis_produk', 'Jenis Produk', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        
        if($this->form_validation->run() == FALSE)
        {
            $output['msg'] = validation_errors();
            echo json_encode($output);
        }

        else
        {
            $data = array(
                'jenis_produk_id' => $this->input->post('jenis_produk'),
                'vendor_id' => $this->input->post('vendor'),
                'nama_singkat' => $this->input->post('singkatan'),
                'nama_lengkap' => $this->input->post('nama_produk'),
                'kode_produk' => $this->input->post('kd_produk'),
                'kode_produk_vendor' => $this->input->post('kd_vendor'),
                'keterangan' => $this->input->post('keterangan'),
                'status_id' => 1,
            );

            // cek kode produk
            $kode = $this->produk_model->get_produk($this->input->post('kd_produk'));
            if($kode)
            {            
                $output['msg'] = '1';
                echo json_encode($output);            
            }
            else
            {
                $insert = $this->produk_model->store_produk($data);
                if($insert)
                {
                    $output['msg'] = 'success';
                    echo json_encode($output);
                }
                else
                {
                    $output['msg'] = 'failed';
                    echo json_encode($output);            
                }
            }

        }

    }

    public function EditPodukModal()
    {
        $id = $this->input->get('id');
        $data['jenisproduk'] = $this->produk_model->all_jenis_produk();
        $data['vendor'] = $this->produk_model->all_vendor();
        $data['status'] = $this->produk_model->get_status($id);
        $data['product'] = $this->produk_model->get_produk_for_edit($id);
        $this->load->view('master/modal_edit_produk', $data);
    }

    public function UpdateProduk()
    {
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
        $this->form_validation->set_rules('vendor', 'Vendoe', 'required');
        $this->form_validation->set_rules('singkatan','Singkatan', 'required');
        $this->form_validation->set_rules('kd_vendor', 'Kode Vendor', 'required');
        $this->form_validation->set_rules('kd_produk', 'Kode Produk', 'required');
        $this->form_validation->set_rules('jenis_produk', 'Jenis Produk', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        
        if($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            $output['msg'] = 'failed';
            $output['msg_error'] = $error;
            echo json_encode($output);
        }

        else
        {
            $data = array(
                'jenis_produk_id' => $this->input->post('jenis_produk'),
                'vendor_id' => $this->input->post('vendor'),
                'nama_singkat' => $this->input->post('singkatan'),
                'nama_lengkap' => $this->input->post('nama_produk'),
                'kode_produk' => $this->input->post('kd_produk'),
                'kode_produk_vendor' => $this->input->post('kd_vendor'),
                'keterangan' => $this->input->post('keterangan'),
                // 'status_id' => $this->input->post('status'),
            );

                $insert = $this->produk_model->update_produk($data, $this->input->post('idproduk'));
                if($insert)
                {
                    $output['msg'] = 'success';
                    echo json_encode($output);
                }
                else
                {
                    $output['msg'] = 'failed';
                    echo json_encode($output);            
                }
        }      
    }

    public function DeleteProduk()
    {
        $id = $this->input->post('id');
        $delete = $this->produk_model->delete_produk($id);
        if($delete)
        {
            $output['msg'] = 'success';
            echo json_encode($output);
        }
        else
        {
            $output['msg'] = 'failed';
            echo json_encode($output);            
        }
    }

    public function BlockProduk(){
        $id = $this->input->post('id');
        $block = $this->produk_model->block_produk($id);
        if($block){
            $output['msg'] = 'success';
            echo json_encode($output);
        }
        else{
            $output['msg'] = 'success';
            echo json_encode($output);
        }
    }

    public function AktifProduk(){
        $id = $this->input->post('id');
        $aktif = $this->produk_model->aktif_produk($id);
        if($aktif){
            $output['msg'] = 'success';
            echo json_encode($output);
        }
        else{
            $output['msg'] = 'success';
            echo json_encode($output);
        }
    }
  /*------ master produk ------*/

  /*------ master jenis produk ------*/
    public function jenisPage()
    {
        $this->load->view('master/list_jenis_produk');
    }

    public function AddJeniskPage()
    {
        $this->load->view('master/add_jenis_produk');
    }

    public function getJenisProdukJson()
    {
        header('Content-Type: application/json');
        echo $this->produk_model->getTabelJenisProduk();
    }

    public function CreateJenisProduk()
    {
        $this->form_validation->set_rules('nama_jenis', 'Nama Jenis Produk', 'required');
        if($this->form_validation->run() == FALSE)
        {
            $output['msg'] = validation_errors();
            echo json_encode($output);
        }
        else
        {
            $data = array('nama_jenis' => $this->input->post('nama_jenis'));
            
            $cekjenis = $this->produk_model->cek_jenis_produk($this->input->post('nama_jenis'));
            if($cekjenis)
            {
                $output['msg'] = '1';
                echo json_encode($output);              
            }
            else
            {
                $insert = $this->produk_model->store_jenis_produk($data);
                if($insert)
                {
                    $output['msg'] = 'success';
                    echo json_encode($output);
                }
                else
                {
                    $output['msg'] = 'failed';
                    echo json_encode($output);            
                }
            }
        }

    }

    public function EditJenisPodukModal()
    {
        $id = $this->input->get('id');
        $data['jenisproduct'] = $this->produk_model->get_jenis_produk($id);
        $this->load->view('master/modal_edit_jenis_produk', $data);
    }  

    public function UpdateJenisProduk()
    {
        $this->form_validation->set_rules('nama_jenis', 'Nama Jenis Produk', 'required');
        if($this->form_validation->run() == FALSE)
        {
            $output['msg'] = validation_errors();
            echo json_encode($output);
        }
        else
        {
            $data = array('nama_jenis' => $this->input->post('nama_jenis'));

                $insert = $this->produk_model->update_jenis_produk($data, $this->input->post('id'));
                if($insert)
                {
                    $output['msg'] = 'success';
                    echo json_encode($output);
                }
                else
                {
                    $output['msg'] = 'failed';
                    echo json_encode($output);            
                }
        }    
    }

    public function DeleteJenis()
    {
        $id = $this->input->post('id');
        $delete = $this->produk_model->delete_jenis_produk($id);
        if($delete)
        {
            $output['msg'] = 'success';
            echo json_encode($output);
        }
        else
        {
            $output['msg'] = 'failed';
            echo json_encode($output);            
        }
    }
  /*------ end master jenis produk ------*/

  /*------ start master vendor ------*/
    public function vendorPage()
    {
        $this->load->view('master/list_vendor');
    }

    public function getVendorJson()
    {
        //data user by JSON object
        header('Content-Type: application/json');
        echo $this->produk_model->getTabelVendor();
    }

    public function AddVendorPage()
    {
        $this->load->view('master/add_vendor');
    }

   public function CreateVendor()
    {
        $this->form_validation->set_rules('nama_vendor', 'Nama Vendor', 'required');
        $this->form_validation->set_rules('kode_vendor', 'Kode Vendor', 'required');
        if($this->form_validation->run() == FALSE)
        {
            $output['msg'] = validation_errors();
            echo json_encode($output);
        }
        else
        {
            $data = array(
                'nama_vendor' => strtolower($this->input->post('nama_vendor')),
                'kode_vendor' => $this->input->post('kode_vendor'),
            );
            
            $cekvendor = $this->produk_model->cek_nama_vendor($this->input->post('nama_vendor'));
            if($cekvendor)
            {
                $output['msg'] = '1';
                echo json_encode($output);              
            }
            else
            {
                $insert = $this->produk_model->store_vendor($data);
                if($insert)
                {
                    $output['msg'] = 'success';
                    echo json_encode($output);
                }
                else
                {
                    $output['msg'] = 'failed';
                    echo json_encode($output);            
                }
            }
        }      
    }

    public function EditVendorModal()
    {
        $id = $this->input->get('id');
        $data['vendor'] = $this->produk_model->get_vendor($id);
        $this->load->view('master/modal_vendor', $data);
    }

    public function UpdateVendor()
    {
        $this->form_validation->set_rules('nama_vendor', 'Nama Vendor', 'required');
        $this->form_validation->set_rules('kode_vendor', 'Kode Vendor', 'required');
        if($this->form_validation->run() == FALSE)
        {
            $output['msg'] = validation_errors();
            echo json_encode($output);
        }
        else
        {
            $data = array(
                'nama_vendor' => $this->input->post('nama_vendor'),
                'kode_vendor' => $this->input->post('kode_vendor'),
            );
            
                $insert = $this->produk_model->update_vendor($data, $this->input->post('id'));
                if($insert)
                {
                    $output['msg'] = 'success';
                    echo json_encode($output);
                }
                else
                {
                    $output['msg'] = 'failed';
                    echo json_encode($output);            
                }
        }       
    }

    public function DeleteVendor()
    {
        $id = $this->input->post('id');
        $delete = $this->produk_model->delete_vendor($id);
        if($delete)
        {
            $output['msg'] = 'success';
            echo json_encode($output);
        }
        else
        {
            $output['msg'] = 'failed';
            echo json_encode($output);            
        }      
    }
  /*------ end master vendor ------*/

  /*------ start master biaya admin ------*/
    public function BiayaAdminPage()
    {
        $this->load->view('master/list_biaya_admin');
    }

    public function getBiayaAdminJson()
    {
        header('Content-Type: application/json');
        echo $this->produk_model->getTabelBiayaAdmin();
    }

    public function AddBiayaAdminPage()
    {
        $this->load->view('master/add_biaya_admin');
    }

    public function CreateBiayaAdmin()
    {
        $this->form_validation->set_rules('kode_produk', 'Kode Produk', 'required');
        $this->form_validation->set_rules('biaya_admin', 'Biaya Admin', 'required');
        if($this->form_validation->run() == FALSE)
        {
            $output['msg'] = validation_errors();
            echo json_encode($output);
        }
        else
        {
            $data = array(
                'kode_produk' => $this->input->post('kode_produk'),
                'nominal_admin_bank' => $this->input->post('biaya_admin'),
                'tgl_create' => date('Y-m-d h:i:s'),
                'tgl_update' => date('Y-m-d h:i:s')
            );

                $insert = $this->produk_model->store_biaya_admin($data);
                if($insert)
                {
                    $output['msg'] = 'success';
                    echo json_encode($output);
                }
                else
                {
                    $output['msg'] = 'failed';
                    echo json_encode($output);            
                }
        }            
    }

    public function EditBiayaAdminModal()
    {
        $id = $this->input->get('id');
        $data['biayaadmin'] = $this->produk_model->get_biaya_admin($id);
        $this->load->view('master/modal_biaya_admin', $data);
    }

    public function UpdateBiaya()
    {
        $this->form_validation->set_rules('kode_produk', 'Kode Produk', 'required');
        $this->form_validation->set_rules('biaya_admin', 'Biaya Admin', 'required');
        if($this->form_validation->run() == FALSE)
        {
            $output['msg'] = validation_errors();
            echo json_encode($output);
        }
        else
        {
            $data = array(
                'kode_produk' => $this->input->post('kode_produk'),
                'nominal_admin_bank' => $this->input->post('biaya_admin'),
                'tgl_update' => date('Y-m-d h:i:s')
            );

            $update = $this->produk_model->update_biaya_admin($data, $this->input->post('id'));
            if($update)
            {
                $output['msg'] = 'success';
                echo json_encode($output);
            }
            else
            {
                $output['msg'] = 'failed';
                echo json_encode($output);            
            }
        }        
    }

    public function DeleteBiaya()
    {
        $id = $this->input->post('id');
        $delete = $this->produk_model->delete_biaya_admin($id);
        if($delete)
        {
            $output['msg'] = 'success';
            echo json_encode($output);
        }
        else
        {
            $output['msg'] = 'failed';
            echo json_encode($output);            
        }      
    }
  /*------ end master biaya admin ------*/

  /*------ start master pengumuman ------*/
    public function pengumumanPage()
    {
        $this->load->view('master/list_pengumuman');
    }

    public function getPengumumanJson()
    {
        header('Content-Type: application/json');
        echo $this->produk_model->getTabelPengumuman();
    }

    public function AddPengumumanPage()
    {
        $this->load->view('master/add_pengumuman');
    }

    public function CreatePengumuman()
    {
        $this->form_validation->set_rules('judul', 'judul', 'required');
        $this->form_validation->set_rules('isipengumuman', 'Isi Pengumuman', 'required');
        if($this->form_validation->run() == FALSE)
        {
            $output['msg'] = validation_errors();
            echo json_encode($output);
        }
        else
        {
            $data = array(
                'judul' => $this->input->post('judul'),
                'isi' => $this->input->post('isipengumuman'),
                'tgl_update' => date('Y-m-d h:i:s'),
                'tgl_create' => date('Y-m-d h:i:s'),
                'admin_id' => $this->session->userdata('adminId')
            );

                $insert = $this->produk_model->store_pengumuman($data);
                if($insert)
                {
                    $output['msg'] = 'success';
                    echo json_encode($output);
                }
                else
                {
                    $output['msg'] = 'failed';
                    echo json_encode($output);            
                }
        }             
    }

    public function EditPengumumanModal()
    {
        $id = $this->input->get('id');
        $data['pengumuman'] = $this->produk_model->get_pengumuman($id);
        $this->load->view('master/modal_edit_pengumuman', $data);
    }

    public function UpdatePengumuman()
    {
        $this->form_validation->set_rules('judul', 'judul', 'required');
        $this->form_validation->set_rules('isipengumuman', 'Isi Pengumuman', 'required');
        if($this->form_validation->run() == FALSE)
        {
            $output['msg'] = validation_errors();
            echo json_encode($output);
        }
        else
        {
            $data = array(
                'judul' => $this->input->post('judul'),
                'isi' => $this->input->post('isipengumuman'),
                'tgl_update' => date('Y-m-d h:i:s'),
                'admin_id' => $this->session->userdata('adminId')
            );

                $update = $this->produk_model->update_pengumuman($data, $this->input->post('id'));
                if($update)
                {
                    $output['msg'] = 'success';
                    echo json_encode($output);
                }
                else
                {
                    $output['msg'] = 'failed';
                    echo json_encode($output);            
                }
        }            
    }

    public function DeletePengumuman()
    {
        $id = $this->input->post('id');
        $delete = $this->produk_model->delete_pengumuman($id);
        if($delete)
        {
            $output['msg'] = 'success';
            echo json_encode($output);
        }
        else
        {
            $output['msg'] = 'failed';
            echo json_encode($output);            
        }  
    }
  /*------ end master pengumuman ------*/

    public function getKomisiJson(){
        header('Content-Type: application/json');
        echo $this->produk_model->getTabelKomisi();
    }

    public function KomisiPage(){
        $this->load->view('master/list_komisi');
    }

    public function addKomisiPage(){
        $data['produk'] = $this->produk_model->get_produk_for_komisi();
        $this->load->view('master/add_komisi', $data);
    }

    public function CreateKomisi(){
        $this->form_validation->set_rules('produk', 'Produk', 'required');
        $this->form_validation->set_rules('komisi', 'Komisi', 'required');
        $this->form_validation->set_rules('range_dari', 'Range Dari', 'required');
        $this->form_validation->set_rules('range_sampai', 'Range Sampai', 'required');
        if($this->form_validation->run() == FALSE)
        {
            $output['title'] = 'error';
            $output['msg'] = validation_errors();
            echo json_encode($output);
        }
        else{
            if($this->input->post('range_sampai') == '>'){
                $data = array(
                    'id_produk' => $this->input->post('produk'),
                    'komisi' => $this->input->post('komisi'),
                    'range_dari' => $this->input->post('range_dari'),
                    'range_sampai' => 1000000,
                    'tgl_create' => date('Y-m-d h:i:s'),
                    'tgl_update' => date('Y-m-d h:i:s'),
                    // 'jenis_komisi' => $this->input->post('jeniskomisi'),
                    'status_pinjaman' => $this->input->post('statuspinjaman')
                );                
            }
            elseif($this->input->post('range_dari') == 0 && $this->input->post('range_sampai') == 0 ){
                $data = array(
                    'id_produk' => $this->input->post('produk'),
                    'komisi' => $this->input->post('komisi'),
                    'range_dari' => $this->input->post('range_dari'),
                    'range_sampai' => $this->input->post('range_sampai'),
                    'tgl_create' => date('Y-m-d h:i:s'),
                    'tgl_update' => date('Y-m-d h:i:s'),
                    // 'jenis_komisi' => 'Flat',
                    'status_pinjaman' => $this->input->post('statuspinjaman')
                );                            
            }
            else{
                $data = array(
                    'id_produk' => $this->input->post('produk'),
                    'komisi' => $this->input->post('komisi'),
                    'range_dari' => $this->input->post('range_dari'),
                    'range_sampai' => $this->input->post('range_sampai'),
                    'tgl_create' => date('Y-m-d h:i:s'),
                    'tgl_update' => date('Y-m-d h:i:s'),
                    // 'jenis_komisi' => 'Tingkatan',
                    'status_pinjaman' => $this->input->post('statuspinjaman')
                );
            }        
            //cek produk yg sudah diset range nya
            $cek = $this->produk_model->cek_komisi($this->input->post('produk'), $this->input->post('komisi'));
            if($cek){
                $output['msg'] = '1';
                echo json_encode($output);
            }
            else{
                $insert = $this->produk_model->store_komisi($data);
                if($insert){
                    $output['msg'] = 'success';
                    echo json_encode($output);
                }
                else{
                    $output['msg'] = 'failed';
                    echo json_encode($output);
                }
            }
        }
    }

    public function EditKomisiModal(){
        $id = $this->input->get('id');
        $data['komisi'] = $this->produk_model->get_komisi($id);
        $this->load->view('master/modal_edit_komisi', $data);
    }

    public function update_komisi(){
        if($this->input->post('range_sampai') == '>'){
            $data = array(
                'komisi' => $this->input->post('komisi'),
                'range_dari' => $this->input->post('range_dari'),
                'range_sampai' => 1000000,
                'tgl_update' => date('Y-m-d h:i:s'),
                'status_pinjaman' => $this->input->post('statuspinjaman')
            );
        }
        elseif($this->input->post('range_dari') == 0 && $this->input->post('range_sampai') == 0){
            $data = array(
                'komisi' => $this->input->post('komisi'),
                'range_dari' => $this->input->post('range_dari'),
                'range_sampai' => $this->input->post('range_sampai'),
                'tgl_update' => date('Y-m-d h:i:s'),
                // 'jenis_komisi' => 'Flat',
                'status_pinjaman' => $this->input->post('statuspinjaman'),
            );
        }
        else{
            $data = array(
                'komisi' => $this->input->post('komisi'),
                'range_dari' => $this->input->post('range_dari'),
                'range_sampai' => $this->input->post('range_sampai'),
                'tgl_update' => date('Y-m-d h:i:s'),
                'status_pinjaman' => $this->input->post('statuspinjaman')
            );
        }

        $update = $this->produk_model->update_komisi($data, $this->input->post('idkomisi'));
        if($update){
            $output['msg'] = 'success';
            echo json_encode($output);
        }
        else{
            $output['msg'] = 'failed';
            echo json_encode($output);
        }
    }

    public function delete_komisi(){
        $id = $this->input->post('id');
        $delete = $this->produk_model->delete_komisi($id);
        if($delete)
        {
            $output['msg'] = 'success';
            echo json_encode($output);
        }
        else
        {
            $output['msg'] = 'failed';
            echo json_encode($output);            
        }  
    }

    public function DaftarHarga(){
        $data['jenis_produk'] = array(
            'pulsa' => 'VOUCHER PULSA',
            'paket_data' => 'PAKET DATA'
        );
        $this->load->view('master/list_daftar_harga', $data);
    }

    public function getDaftarHargaJson(){
        //data user by JSON object
        header('Content-Type: application/json');
        echo $this->produk_model->getTabelDaftarHarga();
    }

    public function TambahDaftarHarga(){
        $data['vendor'] = $this->produk_model->all_vendor();
        $data['produk'] = $this->produk_model->get_produk_for_daftar_harga();
        $this->load->view('master/add_daftar_harga', $data);
    }

    public function CreateDaftarHarga(){
        $this->form_validation->set_rules('kode_produk', 'Nama Produk', 'required');
        $this->form_validation->set_rules('harga_vendor', 'Harga Vendor', 'required');
        $this->form_validation->set_rules('harga_inm', 'Harga INM', 'required');
        $this->form_validation->set_rules('markup', 'Markup', 'required');
        if($this->form_validation->run() == FALSE)
        {
            $output['title'] = 'error';
            $output['msg'] = validation_errors();
            echo json_encode($output);
        }
        else{
            $data = array(
                'kode_produk' => $this->input->post('kode_produk'),
                'vendor_id' => $this->input->post('vendor_id'),
                'nominal' => $this->input->post('nominal'),
                'harga_vendor' => $this->input->post('harga_vendor'),
                'harga_jual' => $this->input->post('harga_inm'),
                'markup' => $this->input->post('markup'),
                'harga_terakhir' => $this->input->post('harga_vendor'),
                'tgl_create' => date('Y-m-d h:i:s'),
                'tgl_update' => date('Y-m-d h:i:s'),
                'status_id' => 'Aktif',
                'admin_id' => $this->session->userdata('adminId'),
            );

            $insert = $this->produk_model->store_daftar_harga($data);
            if($insert){
                $output['msg'] = 'success';
                echo json_encode($output);                    
            }
            else{
                $output['msg'] = 'failed';
                echo json_encode($output);                    
            }
        }
        
    }

    public function EditHarga(){
        $id = $this->input->get('id');
        $data['harga'] = $this->produk_model->get_daftar_harga($id);
        $this->load->view('master/modal_edit_harga', $data);        
    }

    public function UpdateHarga(){
        $data = array(
            'nominal' => $this->input->post('nominal'),
            'harga_vendor' => $this->input->post('harga_vendor'),
            'harga_jual' => $this->input->post('harga_inm'),
            'markup' => $this->input->post('markup'),
            'tgl_update' => date('Y-m-d h:i:s'),
            'admin_id' => $this->session->userdata('adminId'),
        );
        $update = $this->produk_model->update_daftar_harga($data, $this->input->post('id'));
        if($update){
            $output['msg'] = 'success';
            echo json_encode($output);                    
        }
        else{
            $output['msg'] = 'failed';
            echo json_encode($output);                    
        }
    }

    public function DeleteHarga(){
        $id = $this->input->post('id');
        $delete = $this->produk_model->delete_daftar_harga($id);
        if($delete){
            $output['msg'] = 'success';
            echo json_encode($output);                    
        }
        else{
            $output['msg'] = 'failed';
            echo json_encode($output);                    
        }
    }

    public function BlockHarga(){
        $id = $this->input->post('id');
        $block = $this->produk_model->block_daftar_harga($id);
        if($block){
            $output['msg'] = 'success';
            echo json_encode($output);                    
        }
        else{
            $output['msg'] = 'failed';
            echo json_encode($output);                    
        }
    }

    public function AktifHarga(){
        $id = $this->input->post('id');
        $aktif = $this->produk_model->aktif_daftar_harga($id);
        if($aktif){
            $output['msg'] = 'success';
            echo json_encode($output);                    
        }
        else{
            $output['msg'] = 'failed';
            echo json_encode($output);                    
        }
    }


    /** KHUSUS IRS */
    public function getListIRSOperatorByCategory($jenis_produk)
    {
        $data = $this->getListOperatorIRS($jenis_produk);

        if($data != null && !empty($data))
            $this->setResponse(true, $data);
        else
            $this->setResponse(false, 'Data Tidak Tersedia');
        
    }


    public function getListOperatorIRS($type)
    {
        $objects  = new IRS_Services();
        $operator = $objects->getListIRSOperatorByCategory($type);

        $data = array();
        if(count($operator) > 0)
        {
            foreach ($operator as $key => $value) 
            {    
                $str = '';
                for ($i=0; $i < count($value); $i++) { 
                    $str .= $value[$i];
                    if($i < count($value)-1)
                        $str .= ',';
                }
                $data[$key] = $str;
            }
        }
        return $data;
    }


    /** PRODUCT IRS */
    public function getListProductByOperator()
    {
        $objects  = new IRS_Services();
        $operator_id = json_decode(file_get_contents('php://input'), true)['operator_id'];
        $response = $objects->getListIRSProductByOperator($operator_id);

        if(is_array($response) && count($response) > 0)
            $this->setResponse(true, $response);
        else
            $this->setResponse(false, $response);
    }

    public function TambahDataProdukIRS()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $kode_jenis = ($input['jenis_produk'] == 'pulsa') ? 4 : 6;
        $where = $this->produk_model->checkProductIRSByArray($input['nominal'], $input['nama_operator'], $kode_jenis);
        
        if($where == true)
        {
            $this->setResponse(false, 'Tambah Produk '.$input['nama_operator'].' Nominal '.$input['nominal'].'K Gagal. Produk Dengan Operator Tersebut Sudah Pernah Ditambahkan Sebelumnya');
        }
        else
        {


            $max_kode_produk = 0;
            $kode_produk = 0;

            if($input['jenis_produk'] == 'pulsa')
            {
                $max_kode_produk = $this->produk_model->getMaxCodeInProductIRSByType('4');
                $kode_produk = ($max_kode_produk != 0) ? $max_kode_produk + 1 : 401;
            }
            else
            {
                $max_kode_produk = $this->produk_model->getMaxCodeInProductIRSByType('6');
                $kode_produk = ($max_kode_produk != 0) ? $max_kode_produk + 1 : 601;
            }

            $insert_data = array(
                'jenis_produk'   => $input['jenis_produk'],
                'nama_singkat'   => $input['nama_alias_kode'],
                'nama_lengkap'   => $input['nama_lain_produk'],
                'kode_produk'    => $kode_produk,
                'kode_vendor'    => $input['kode_produk_irs'],
                'harga_vendor'   => $input['harga_produk'],
                'harga_jual'     => $input['harga_jual'],
                'markup'         => $input['harga_markup'],
                'nominal'        => $input['nominal'],
                'harga_terakhir' => $input['harga_produk'],
                'create_date'    => date('Y-m-d h:i:s'),
                'update_date'    => date('Y-m-d h:i:s'),
                'admin_id'       => $this->session->userdata('adminId'),
                'keterangan'     => $input['nama_operator'].','.$input['nama_produk_irs'].','.$input['kode_produk_irs']
            );

            $insert = $this->produk_model->addIRSToProductBase($insert_data);

            if($insert == true)
                $this->setResponse(true, 'Insert Data Produk Berhasil');
            else
                $this->setResponse(false, $insert);

        }
    }

    public function setResponse($status=null, $data=null, $optional=null, $code=200)
    {
        $array = array(
            'status' => ($status==null) ? false : $status,
            'messages' => ($data != null) ? $data : 'No Response Data'
        );

        if($optional != null)
            $array['optional'] = $optional;

        return $this->output->set_content_type('application/json')->set_status_header($code)->set_output(json_encode($array));
    }


    public function SingleUpdateProductIRS()
    {
        $objects  = new IRS_Services();
        $input   = json_decode(file_get_contents('php://input'), true);
        $harga_awal = $input['harga_awal'];
        $kode_vendor = $input['kode_produk_vendor'];

        if($kode_vendor != null && !empty($kode_vendor)){
            $records = $objects->getListProductIRSByCode($kode_vendor)[0];
            $update = $this->produk_model->editIRSProductPrice($kode_vendor, $harga_awal, $records);
        
            if($update == true)
                $this->setResponse(true, 'Update Harga Produk IRS Berhasil');
            else
                $this->setResponse(false, 'Update Harga Produk IRS Gagal');
        }
        else
            $this->setResponse(true, 'Tidak Ada Data Sesuai Kode IRS '. $kode_vendor . ' Tersebut');
    }

    public function UpdateAllPriceProductIRS()
    {
        $objects    = new IRS_Services();
        $input      = json_decode(file_get_contents('php://input'), true)['jenis_produk'];
        
        $kode_jenis = (strtoupper($input) == 'PULSA') ? 4 : 6;

        $data_produk = $this->produk_model->getProductAndPriceByTypeCode($kode_jenis);

        if(is_array($data_produk) && count($data_produk) > 0)
        {
            $produk_irs = $objects->getDataProductIRSByCategory($input);
            $update = $this->getCompareAndUpdateProduct($data_produk, $produk_irs);
            
            if($update == true)
                $this->setResponse(true, 'Proses Update Data Produk '.$input .' IRS Berhasil');
            else
                $this->setResponse(false, 'Proses Updata Produk Dari '.$input. ' Gagal');
        }
        else{
            $this->setResponse(false, 'Daftar Produk Dari Kategori Produk '. ($input). ' Kosong');
        }

    }

    public function getCompareAndUpdateProduct($produk_lama, $produk_irs)
    {
        foreach ($produk_lama as $old) 
        {
            $kode_vendor = $old['kode_produk_vendor'];
            $harga_vendor = $old['harga_vendor'];
            $kode_produk = $old['kode_produk'];
            
            $i = 0; $find = false; $update = false;
            while ($i <= count($produk_irs)-1 && $find == false) 
            {    
                if($produk_irs[$i]['kode_produk'] == $kode_vendor)
                {
                    if($produk_irs[$i]['harga_produk'] != $harga_vendor)
                    {
                        $update = $this->produk_model->updateHargaProdukIRS(
                            $kode_produk, $produk_irs[$i]['harga_produk'], $harga_vendor
                        );
                    }
                    else
                        $update = true;

                    $find = true;
                }

                $i++;
            }

            if($find == true && $update == false)
                return false;
        }

        return true;
    }

    public function AddProdukIRS(){
        $data['jenis_produk'] = array(
            'pulsa' => 'VOUCHER PULSA',
            'paket_data' => 'PAKET DATA'
        );
        //$data['operator_pulsa'] = $this->getListOperatorPulsa();
        $this->load->view('master/add_produk_irs', $data);
    }

    
}
