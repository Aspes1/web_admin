<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komisi extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('date_helper');
        $this->load->helper('global_helper');
        $this->load->library('datatables');
        $this->load->model('Komisi_model');
        if($this->session->userdata('isLog') == FALSE){
            $this->session->set_flashdata('need_login','Anda harus login terlebih dahulu.');
            redirect('login','refresh');                
        }
        if($this->session->userdata('adminRole') == 'Helpdesk' || $this->session->userdata('adminRole') == 'Administrator'){
            redirect('error_550','refresh');
        }
    }

    public function index(){
        $data['title']      = 'Menu Komisi';
        $data['submenu']    = 'komisi/menu_komisi';
        $data['contents']   = 'komisi/daftar_komisi';
        $this->load->view('templates/app', $data);          
    }

    public function DaftarKomisi(){
        $this->load->view('komisi/daftar_komisi');
    }

    public function getJsonLaporanKomisi(){
        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');

        if(($dari == NULL || $dari == '') && ($sampai == NULL || $sampai == '')){
            $dari = date('Y-m-d');
            $sampai = date('Y-m-d');
        }

        header('Content-Type: application/json');
        $output=$this->Komisi_model->get_komisi_by_user($dari, $sampai);
        echo $output;
    }
}