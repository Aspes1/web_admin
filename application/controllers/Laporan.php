<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Google\Cloud\Storage\StorageClient;
use League\Flysystem\Filesystem;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;

class Laporan extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    ini_set('max_execution_time', 86400);
    $this->load->library('datatables');
    $this->load->model('laporan_model');
    date_default_timezone_set('Asia/Jakarta');
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
                    "data" => $this->laporan_model->allLaporan($dari_, $sampai_)->result(),
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
                    "data" => $this->laporan_model->allLaporanPeriode($dari_, $sampai_)->result(),
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
                    "data" => $this->laporan_model->laporan_giry_bayar_per_tanggal($dari_, $sampai_)->result(),
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
                    "data" => $this->laporan_model->laporan_giry_bayar_per_user($dari_, $sampai_)->result(),
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

          $storageClient = new StorageClient([
            'projectId'   => 'ascendant-volt-161906',
            'keyFilePath' => APPPATH. '/libraries/json_key.json',
          ]);
        
          $bucket     = $storageClient->bucket('payinm_db');
    
          $adapter    = new GoogleStorageAdapter($storageClient, $bucket);
          $filesystem = new Filesystem($adapter);
              
          $stream = fopen($file, 'r+'); 
          $filesystem->writeStream('backups/'.$file_name, $stream);

          $exists = $filesystem->has('backups/'.$file_name);
          // print_r($exists);

          unlink('./uploads/csv_griya/'.$file_name);

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

          unlink('./uploads/csv_griya/'.$file_name);
         
      }
  }

  public function TransaksiBukopin(){
    // $data['produkbukopin'] = $this->laporan_model->get_name_product_bukopin();
    $datas['contents'] = 'laporan/transaksi_bukopin_per_tanggal';
    $this->load->view('laporan/page_transaksi_bukopin', $datas);
  }

  public function LoadTrxPertglBukopin(){
    $dari_   = $this->input->post('dari');
    $sampai_ = $this->input->post('sampai');

    if(($dari_==null||$dari_=='') && ($sampai_==null || $sampai_=='')){
      $dari_ = date('Y-m-d');
      $sampai_ = date('Y-m-d');
    }

    $output = array('data' => $this->laporan_model->get_trx_per_tgl_bukopin($dari_, $sampai_)->result());
    echo json_encode($output);
  }

  public function LoadTrxPerUserBukopin(){
    $dari_   = $this->input->post('dari');
    $sampai_ = $this->input->post('sampai');

    if(($dari_==null||$dari_=='') && ($sampai_==null || $sampai_=='')){
      $dari_ = date('Y-m-d');
      $sampai_ = date('Y-m-d');
    }

    $output = array('data' => $this->laporan_model->get_trx_per_user_bukopin($dari_, $sampai_)->result());
    echo json_encode($output);
  }

  public function DetailTrxLoketBukopin(){
    $dari_   = $this->input->post('dari');
    $sampai_ = $this->input->post('sampai');
    $loket = $this->input->post('nama', TRUE);

        $data = $this->laporan_model->get_detail_trx_loket_bukopin($loket,$dari_, $sampai_);
        $names = $this->laporan_model->get_nama_produk();
        $output["tablenya"] =
          "<table cellpadding='5' cellspacing='0' style='background-color:#f8f8f8'>
            <tr style='background-color:#bfe7bf'>
              <th width='180'>Tgl. Transaksi</th>
              <th width='400'>Produk</th>
              <th width='150'>No. Pelanggan</th>
              <th width='50'>Lembar</th>
              <th width='100' class='text-right'>Biaya Admin</th>
              <th width='100' class='text-right'>Tigihan</th>
              <th width='100' class='text-right'>Total</th>
            </tr>";
            foreach($data as $row){
              $output['tablenya'] .= "
                <tr>
                  <td>".$row->tgl_transaksi."</td>
                  <td>".$row->nama_produk."</td>
                  <td>".$row->no_pelanggan."</td>
                  <td>".$row->lembar."</td>
                  <td align='right'>".number_format($row->biaya_admin, 0, ",", ".")."</td>
                  <td align='right'>".number_format($row->nilai, 0, ",", ".")."</td>
                  <td align='right'>".number_format($row->total, 0, ",", ".")."</td>
                </tr>";
            }
            $output['tablenya'] .= "</table>";

        echo json_encode($output);
  }

  public function TransaksiPerTglBukopin(){
    $data['contents'] = 'laporan/transaksi_bukopin_per_tanggal';
    $this->load->view('laporan/page_transaksi_bukopin', $data);
  }

  public function TransaksiPerUserBukopin(){
    $data['contents'] = 'laporan/transaksi_bukopin_per_user';
    $this->load->view('laporan/page_transaksi_bukopin', $data);
  }

  public function ImportFile(){
    $data['contents'] = 'laporan/import_data_bukopin';
    $this->load->view('laporan/page_transaksi_bukopin', $data);
  }

  public function upload_file_bukopin(){
    $this->load->helper("file");
    $config['upload_path']          = './uploads/bukopin/';
    $config['allowed_types']        = 'xlsx|xls';
    $config['max_size']             = 1000;
    $new_name                       = time().$_FILES["userfile"]['name'];
    $config['file_name']            = $new_name;

    $this->load->library('upload', $config);

      if (!$this->upload->do_upload('userfile'))
      {
          $error = $this->upload->display_errors();
          $output['title'] = 'failed';
          $output['msg'] = $error;
          echo json_encode($output);
      }

      else{
          $upload_data = $this->upload->data();
          $file_name = $upload_data['file_name'];
          $path = './uploads/bukopin/';
          $file = $path.''.$file_name;

          $storageClient = new StorageClient([
            'projectId'   => 'ascendant-volt-161906',
            'keyFilePath' => APPPATH. '/libraries/json_key.json',
          ]);
        
          $bucket     = $storageClient->bucket('payinm_db');
    
          $adapter    = new GoogleStorageAdapter($storageClient, $bucket);
          $filesystem = new Filesystem($adapter);
              
          $stream = fopen($file, 'r+'); 
          $filesystem->writeStream('backups/'.$file_name, $stream);

          $exists = $filesystem->has('backups/'.$file_name);
          // print_r($exists);
          
          $this->load->library('Excel_reader');

          //tentukan file
          $this->excel_reader->setOutputEncoding('230787');
          // $file = $upload_data['full_path'];
          $this->excel_reader->read($file);
          error_reporting(E_ALL ^ E_NOTICE);

          // array data
          $data = $this->excel_reader->sheets[0];

          $cTable = $this->getRecordColumnTitle($data['cells'][6]);
          $rdTable = $this->setDataRowExcel($data['cells']);
          $mydata = $this->ExploreExcel($rdTable, $cTable);

          $tgl_laporan = $data['cells'][3][6];
          $findtgl = $this->splitFormatDueDate($data['cells'][3][6]);
          $databukopin = $this->laporan_model->cek_data_bukopin($findtgl);
          if($databukopin->num_rows() > 0){
            $output['title'] = 'failed';
            $output['msg'] = 'File sudah diupload';
          }
          else{
            foreach ($mydata as $k => $v) 
            {
                $tmp_data = array();
                $loket = $k;
                for ($i=0; $i < count($v); $i++) { 
                    array_push($tmp_data, $this->setDataInsert($loket, $v[$i], $tgl_laporan));
                }
                // echo "<br>";
                // echo "<pre>";
                // print_r($tmp_data);
                // echo "</pre>";
                $insert = $this->laporan_model->insert_laporan_bukopin($tmp_data);
            }
            if($insert){
              $output['title'] = 'success';
              $output['msg'] = 'Sukses upload file';  
            }
            else{
              $output['title'] = 'fail';
              $output['msg'] = 'Gagal upload file';
            }
          }
      }
      echo json_encode($output);
      unlink('./uploads/bukopin/'.$file_name);
  }

  protected function convertStrDateTime($s){
    $s = str_replace('/','-',$s);
    return date('Y-m-d', strtotime($s));
  }

  private function splitFormatDueDate($format)
  {
      $s = explode('-', $format);
      return array(
        'from_date' => $this->convertStrDateTime(trim($s[0])),
        "to_date"   => $this->convertStrDateTime(trim($s[1]))
      );
  }

  private function setDataInsert($loket, $data, $tgllap)
  {
      $tgllap = $this->splitFormatDueDate($tgllap);

      $data = array(
          "loket"         => $loket,
          "nama_produk"   => $data['JENIS_TRANSAKSI'],
          "no_pelanggan"  => $data['NO_PELANGGAN'],
          "lembar"        => 1,
          "harga_modal"   => $data['HARGA_MODAL'],
          "biaya_admin"   => $data['BIAYA_ADMIN'],
          "nilai"         => $data['NILAI'],
          "total"         => $data['TOTAL'],
          "tgl_transaksi" => date_format(date_create($data['TGL_JAM']), 'Y-m-d H:i:s'),
          "tgl_dari"      => $tgllap['from_date'],
          "tgl_sampai"    => $tgllap['to_date']
      );
      return $data;
  }

  private function setDataRowExcel($data)
  {
      $tmp = array();
      $i=0;
      foreach ($data as $k => $v) 
      {
          if($k >= 7){
            $tmp[$i] = $v;
            $i++;
          }
      }
      return $tmp;
  }

  private function getRecordColumnTitle($data)
  {
      $column = array();
      foreach ($data as $v) 
      {
          $split = explode(" ", $v);
          $combine = implode("_", $split);
          array_push($column, $combine);
      }
      return $column;
  }

  private function splitName($name){
      return trim(explode(":", $name)[1]);
  }

  private function getDefaultArray($d)
  {
      $t = array();
      for ($i=0; $i < count($d); $i++) 
      { 
          if(count($d[$i]) == 1 && strpos($d[$i][1], 'LOKET') !== false)
              $t[$this->splitName($d[$i][1])] = array();
      }
      return $t;
  }

  public function ExploreExcel($data, $column)
  {
      $tmp = $this->getDefaultArray($data);
      $logname = '';

      //forlop
      for ($i=0; $i < count($data); $i++) 
      { 
          if(strpos($data[$i][1], 'LOKET') !== false)
          {
              $logname = $this->splitName($data[$i][1]);
              continue;
          }
          else if(strpos($data[$i][1], 'SUB TOTAL') !== false)
          {
              continue;
          }
          else if(strpos($data[$i][1], 'GRAND TOTAL') !== false){
              continue;
          }
          else
          {
              $tmp[$logname][] = array(
                  $column[0] => $data[$i][1],
                  $column[1] => $data[$i][2],
                  $column[2] => $data[$i][3],
                  $column[3] => $data[$i][4],
                  $column[4] => $data[$i][5],
                  $column[5] => $data[$i][6],
                  $column[6] => $data[$i][7]
              );	
          }
      }
      return $tmp;
  }
}
