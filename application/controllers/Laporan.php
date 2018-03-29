<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    ini_set('max_execution_time', 86400);
    $this->load->library('datatables');
    $this->load->model('laporan_model');
    if($this->session->userdata('isLog') == FALSE)
    {
        $this->session->set_flashdata('need_login','Anda harus login terlebih dahulu.');
        redirect('login','refresh');
    }
  }

  public function index()
  {
      $data['title']      = 'Admin Dashboard';
      $data['submenu']    = 'laporan/menu_laporan';
      $data['contents']   = 'laporan/transaksi';
      $this->load->view('templates/app', $data);
  }

  public function addTransaksiPage()
  {
      $this->load->view('laporan/transaksi');
  }

  public function addTransaksiPagePeriode()
  {
      $this->load->view('laporan/transaksi_per_periode');
  }

  public function addTransaksiPageHarianDetail()
  {
      $this->load->view('laporan/transaksi_harian_detail');
  }

  public function addTransaksiPageGriyaBayar()
  {
      $data['contents'] = 'laporan/transaksi_griya_per_tanggal';
      $this->load->view('laporan/page_transaksi_griya', $data);
  }

  public function transaksi_per_tanggal()
  {
      $data['contents'] = 'laporan/transaksi_griya_per_tanggal';
      $this->load->view('laporan/page_transaksi_griya', $data);
  }

  public function transaksi_per_user()
  {
      $data['contents'] = 'laporan/transaksi_griya_per_user';
      $this->load->view('laporan/page_transaksi_griya', $data);
  }

  public function import_data()
  {
      $data['contents'] = 'laporan/import_data';
      $this->load->view('laporan/page_transaksi_griya', $data);
  }

  public function addHistoryPage()
  {
      $this->load->view('laporan/history');
  }

  public function setColumn()
  {
      $columns = array();

      if($this->laporan_model->getProdukName()->num_rows() !== 0)
      {

        $data = $this->laporan_model->getProdukName()->result();
        $counter = 0;
        foreach($data as $row)
        {
          $columns[] = array(
            'display' => $row->nama_jenis,
            'name' => strtolower($row->nama_jenis),
            'width' => 143,
            'sortable' =>  true,
            'align' => 'center'
          );
          $counter++;
        }
        echo json_encode($columns);
      }

  }

  public function laporanHarian(){
    $dari_   = $this->input->post('dari');
    $sampai_ = $this->input->post('sampai');

    if(($dari_==null||$dari_=='') && ($sampai_==null || $sampai_=='')){
      $dari_=date('Y-m-d');
      $sampai_=date('Y-m-d');
    }

    $output = array(
                    "data" => $this->laporan_model->allLaporan($dari_)->result(),
                  );

    echo json_encode($output);
  }  

  public function laporanPeriode(){
    $dari_   = $this->input->post('dari');
    $sampai_ = $this->input->post('sampai');

    if(($dari_==null||$dari_=='') && ($sampai_==null || $sampai_=='')){
      $dari_=date('Y-m-d');
      $sampai_=date('Y-m-d');
    }
    // $dari,$sampai
    $output = array(
                    "data" => $this->laporan_model->allLaporanPeriode($dari_)->result(),
                   );

    //output to json format
    echo json_encode($output);
  }
  
  public function laporanHarianDetail(){
    $dari_   = $this->input->post('dari');
    $sampai_ = $this->input->post('sampai');

    if(($dari_==null||$dari_=='') && ($sampai_==null || $sampai_=='')){
      $dari_=date('Y-m-d');
      $sampai_=date('Y-m-d');
    }

    // output to json format
    header('Content-Type: application/json');
    $output=$this->laporan_model->getAllLaporanToday($dari_);
    echo $output;
  }

  public function transaksiGriyaBayarPerTgl(){
    $dari_   = $this->input->post('dari');
    $sampai_ = $this->input->post('sampai');

    if(($dari_==null||$dari_=='') && ($sampai_==null || $sampai_=='')){
      $dari_=date('Y-m-d');
      $sampai_=date('Y-m-d');
    }

    $output = array(
                    "data" => $this->laporan_model->laporan_giry_bayar_per_tanggal($dari_)->result(),
                   );

    echo json_encode($output);
  }

  public function transaksiGriyaBayarPerUser(){
    $dari_   = $this->input->post('dari');
    $sampai_ = $this->input->post('sampai');

    if(($dari_==null||$dari_=='') && ($sampai_==null || $sampai_=='')){
      $dari_=date('Y-m-d');
      $sampai_=date('Y-m-d');
    }

    $output = array(
                    "data" => $this->laporan_model->laporan_giry_bayar_per_user($dari_)->result(),
                   );

    echo json_encode($output);
  }  

  public function infoExtra()
  {
      $nama = $this->input->post('nama', TRUE);
      // foreach($names->result() as $name){
      //   $output['tablenya'] .= "
      //   <th colspan='2' class='text-center' style='height:10px'>".$name->nama_lengkap."</th>";
      // }

        $data = $this->laporan_model->getExtraInfo($nama);
        $names = $this->laporan_model->get_nama_produk();
        $output["tablenya"] =
          "<table cellpadding='5' cellspacing='0' width='100%' style='background-color:#f8f8f8'>
            <tr style='background-color:#bfe7bf'>
            <th rowspan='2' class='text-center' style='vertical-align:middle;height:10px;width:107px;'>#</th>
            <th rowspan='2' class='text-center' style='vertical-align:middle;height:10px;width:344px;'>Username</th>
              <th colspan='2' class='text-center' style='height:10px;'>Total PDAM</th>
              <th colspan='2' class='text-center' style='height:10px'>Total PLN</th>
            </tr>
            <tr style='background-color:#bfe7bf'>
              <th class='text-left' style='height:10px;width:155px;'>Jumlah</th>
              <th class='text-right' style='height:10px;width:177px;'>Rupiah</th>
              <th class='text-left' style='height:10px;width:155px;'>Jumlah</th>
              <th class='text-right' style='height:10px'>Rupiah</th>
            </tr>";
            $totaljumlahpdam = 0;
            $totalrupiahpdam = 0;
            $totaljumlahpln = 0;
            $totalrupiahpln = 0;
            $no = 1;
            foreach($data->result() as $row){
              $totalrupiahpdam += $row->TotalTagihan_PDAM;
              $totaljumlahpdam += $row->PDAM;
              $totaljumlahpln += $row->PLN;
              $totalrupiahpln += $row->TotalTagihan_PLN;
              $output['tablenya'] .= "
                <tr>
                  <td align='center'>".$no."</td>
                  <td>".$row->username."</td>
                  <td>".$row->PDAM."</td>
                  <td align='right'>".number_format($row->TotalTagihan_PDAM, 0, ",", ".")."</td>
                  <td>".$row->PLN."</td>
                  <td align='right'>".number_format($row->TotalTagihan_PLN, 0, ",", ".")."</td>
                </tr>";
              $no++;
            }
          $output['tablenya'] .= "
            <tr>
              <td colspan='2'><b>Total</b></td>
              <td align='left'><b>".$totaljumlahpdam."</b></td>
              <td align='right'><b>".number_format($totalrupiahpdam, 0, ",", ".")."</b></td>
              <td align='left'><b>".$totaljumlahpln."</b></td>
              <td align='right'><b>".number_format($totalrupiahpln, 0, ",", ".")."</b></td>
            </tr";
          $output['tablenya'] .= "</table>";

        echo json_encode($output);
  }

  public function upload_csv()
  {

      $config['upload_path']          = './uploads/csv_griya/';
      $config['allowed_types']        = 'csv';
      $config['max_size']             = 90000000;
      $new_name                       = time().$_FILES["file_csv"]['name'];
      $config['file_name']            = $new_name;

      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('file_csv'))
      {
          $error = $this->upload->display_errors();
          $output['title'] = 'failed';
          $output['msg'] = $error;
          echo json_encode($output);
      }

      else
      {
          $upload_data = $this->upload->data();
          $file_name = $upload_data['file_name'];
          $path = './uploads/csv_griya/';
          $file = $path.''.$file_name;

          $daritgl_ = substr($file_name, 53, 8);
          $sampaitgl_ = substr($file_name, 62, 8);
          $daritgl = date('Y-m-d',strtotime($daritgl_));
          $sampaitgl = date('Y-m-d',strtotime($sampaitgl_));

          $this->load->library('CSVReader');
          $keys = array();

          $data = $this->csvreader->csvToArrayLaporanPerUser($file);

          $count = count($data) - 1;

          $labels = array_shift($data);

          foreach ($labels as $k => $value){
            if(in_array($value, $keys))
            {
              $keys[] = $value.'2';
            }
            else
            {
              $keys[] = $value;
            }
          }

          for ($j = 0; $j < $count; $j++) {
            $d = array_combine($keys, $data[$j]);
            $newArray[$j] = $d;
          }

          $dataArr = $newArray;
          $new_arr = array();
          for ($i=0; $i < count($dataArr); $i++) {
            foreach($dataArr[$i] as $key => $value){

              if(isset($dataArr[$i]['Jumlah PLN Paskabayar'])){
                $dataArr[$i]['Jumlah PLN POSTPAID'] = $dataArr[$i]['Jumlah PLN Paskabayar'];
                unset($dataArr[$i]['Jumlah PLN Paskabayar']);
              }
              if(isset($dataArr[$i]['Rupiah PLN Paskabayar'])){
                $dataArr[$i]['Rupiah PLN POSTPAID'] = $dataArr[$i]['Rupiah PLN Paskabayar'];
                unset($dataArr[$i]['Rupiah PLN Paskabayar']);
              }
              if(isset($dataArr[$i]['Jumlah PLN Prabayar'])){
                $dataArr[$i]['Jumlah PLN PREPAID'] = $dataArr[$i]['Jumlah PLN Prabayar'];
                unset($dataArr[$i]['Jumlah PLN Prabayar']);
              }
              if(isset($dataArr[$i]['Rupiah PLN Prabayar'])){
                $dataArr[$i]['Rupiah PLN PREPAID'] = $dataArr[$i]['Rupiah PLN Prabayar'];
                unset($dataArr[$i]['Rupiah PLN Prabayar']);
              }
              if(isset($dataArr[$i]['Jumlah PLN Nontaglis'])){
                $dataArr[$i]['Jumlah PLN NONTAGLIS'] = $dataArr[$i]['Jumlah PLN Nontaglis'];
                unset($dataArr[$i]['Jumlah PLN Nontaglis']);
              }
              if(isset($dataArr[$i]['Rupiah PLN Nontaglis'])){
                $dataArr[$i]['Rupiah PLN NONTAGLIS'] = $dataArr[$i]['Rupiah PLN Nontaglis'];
                unset($dataArr[$i]['Rupiah PLN Nontaglis']);
              }
              $dataArr[$i]['Tanggal'] = $daritgl;
              // $dataArr[$i]['Ke Tanggal'] = $sampaitgl;

              $new_arr = $dataArr;
            }
          }

          // echo "<pre>";
          // print_r($dataArr);
          // echo "</pre>";

          $no = 0;
          $insert = array();
          $grup_id = false;
          for ($i=0; $i < count($new_arr); $i++) {
            foreach($new_arr[$i] as $key => $value){

              if($new_arr[$i]['Nama'] !== '' && $new_arr[$i]['Child'] == '')
              {
                //simpan nama loket ke session
                $this->session->unset_userdata('namaLOket');
                $this->session->set_userdata('namaLOket', $new_arr[$i]['Nama']);
                $grup_id = false;
                continue;
              }

              if($grup_id)
              {
                // scrap all data;
                if(substr($key,0,6) == 'Jumlah'){
                  $produk_inm = $this->laporan_model->get_produk_inm(substr($key, +7));
                  if($produk_inm->num_rows() > 0){
                      $id = $produk_inm->row()->id;
                      $tgl = date('Y-m-d', strtotime($new_arr[$i]['Tanggal']));
                      $griya = $this->laporan_model->cek_data_transaksi_griya($id, $tgl);
                      if($griya->num_rows() == 0 ){
                        $insert[$no]['username'] = $dataArr[$i]['Child'];
                        $insert[$no]['nama'] = $this->session->userdata('namaLOket');
                        $insert[$no]['group_id'] = $this->session->userdata('group'); //child yg pertama diambil sebagai group_id
                        $insert[$no]['produk_id'] = $produk_inm->row()->id;
                        $insert[$no]['jumlah_transaksi'] = $new_arr[$i]['Jumlah '.$produk_inm->row()->nama_lengkap];
                        $insert[$no]['rupiah_transaksi'] = $new_arr[$i]['Rupiah '.$produk_inm->row()->nama_lengkap];
                        $insert[$no]['tanggal'] = $tgl;
                        $no++;
                        $hasil = 0;
                      }
                      else{
                        $hasil = 1;
                      }
                    }
                  }
                  continue;
              }

              if($new_arr[$i]['Nama'] == '' && $new_arr[$i]['Child'] !== '')
              {
                //simpan usename ke session
                $this->session->unset_userdata('group');
                $this->session->set_userdata('group', $new_arr[$i]['Child']);

                //scap all data;
                if(substr($key,0,6) == 'Jumlah'){
                  $produk_inm = $this->laporan_model->get_produk_inm(substr($key, +7));
                  if($produk_inm->num_rows() > 0){
                      $id = $produk_inm->row()->id;
                      $tgl = date('Y-m-d', strtotime($new_arr[$i]['Tanggal']));
                      $griya = $this->laporan_model->cek_data_transaksi_griya($id, $tgl);
                      if($griya->num_rows() == 0 ){
                        $insert[$no]['username'] = $dataArr[$i]['Child'];
                        $insert[$no]['nama'] = $this->session->userdata('namaLOket');
                        $insert[$no]['group_id'] = $dataArr[$i]['Child']; //child yg pertama diambil sebagai group_id
                        $insert[$no]['produk_id'] = $produk_inm->row()->id;
                        $insert[$no]['jumlah_transaksi'] = $new_arr[$i]['Jumlah '.$produk_inm->row()->nama_lengkap];
                        $insert[$no]['rupiah_transaksi'] = $new_arr[$i]['Rupiah '.$produk_inm->row()->nama_lengkap];
                        $insert[$no]['tanggal'] = $tgl;
                        $no++;
                        $hasil = 0;
                      }
                      else{
                        $hasil = 1;
                      }
                  }
                }
                $grup_id = true;
                continue;
              }

            }
          }

          // echo "<pre>";
          // print_r($insert);
          // echo "</pre>";

          if($hasil == 0){
            $insertdata = $this->laporan_model->insert_laporan_transaksi_griya($insert);
            if($insertdata){
              $output['title'] = 'success';
              $output['msg'] = 'Sukses upload file';
            }
            else{
              $output['title'] = 'failed';
              $output['msg'] = 'Gagal upload file';
            }
          }
          if($hasil == 1){
            $output['title'] = 'failed';
            $output['msg'] = 'File sudah pernah diupload';
          }
          echo json_encode($output);
      }
  }
}
