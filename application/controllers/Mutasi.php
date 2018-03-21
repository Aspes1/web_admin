<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->model('mutasi_model');
    $this->load->model('saldo_model');
    $this->load->model('user_model');
    $this->load->helper('date_helper');
    $this->load->library('datatables');
    //$this->output->enable_profiler(TRUE);
    if($this->session->userdata('isLog') == FALSE)
    {
        $this->session->set_flashdata('need_login','Anda harus login terlebih dahulu.');
        redirect('login','refresh');
    }
    if($this->session->userdata('adminRole') == 'Helpdesk' || $this->session->userdata('adminRole') == 'Administrator')
    {
        redirect('error_550','refresh');
    }
  }

  public function index()
  {
      $data['title']      = 'Menu Mutasi';
      $data['submenu']    = 'mutasi/menu_mutasi';
      $data['contents']   = 'mutasi/upload_mutasi';
      $this->load->view('templates/app', $data);
  }

  public function uploadPage()
  {
      $this->load->view('mutasi/upload_mutasi');
  }

  public function listPage()
  {
      $this->load->view('mutasi/list_mutasi');
  }

  public function getMutasiJson()
  {
      //data user by JSON object
      header('Content-Type: application/json');
      echo $this->mutasi_model->getTabelMutasi();
  }

  public function do_upload()
  {
      $this->form_validation->set_rules('userfile', 'Mutasi file', 'callback_file_selected_test');
      $this->form_validation->set_rules('bank', 'Jenis Bank', 'required');
      if($this->form_validation->run() == FALSE)
      {
          $output['title'] = 'failed';
          $output['msg'] = validation_errors();
          echo json_encode($output);
      }
      else
      {

          $config['upload_path']          = './uploads/';
          $config['allowed_types']        = 'csv|txt';
          $config['max_size']             = 100;
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
          else
          {
              $upload_data = $this->upload->data();
              $file_name = $upload_data['file_name'];
              $path = './uploads/';
              $file = $path.''.$file_name;

              if($this->input->post('bank', TRUE) == 'MANDIRI')
              {
                if($this->getCsvMandiri($file) == 'failed')
                {
                    $output['title'] = 'failed';
                    $output['msg'] = 'gagal upload file';
                    echo json_encode($output);
                }
                else
                {
                    $data = $this->mutasi_model->autoCompareSP();
                    $output = array();
                    foreach($data as $row)
                    {
                        $output['title'] = $row['@title'];
                        $output['msg'] = $row['@msg'];
                    }
                    echo json_encode($output);
                }
              }
              if($this->input->post('bank', TRUE) == 'BNI')
              {
                  if($this->getCsvBNI($file) == 'failed')
                  {
                      $output['title'] = 'failed';
                      $output['msg'] = 'gagal upload file';
                      echo json_encode($output);
                  }
                  else
                  {
                      $data = $this->mutasi_model->autoCompareSP();
                      $output = array();
                      foreach($data as $row)
                      {
                          $output['title'] = $row['@title'];
                          $output['msg'] = $row['@msg'];
                      }
                      echo json_encode($output);
                  }
              }
              if($this->input->post('bank', TRUE) == 'BRI')
              {
                  if($this->getCsvBRI($file) == 'failed')
                  {
                      $output['title'] = 'failed';
                      $output['msg'] = 'gagal upload file';
                      echo json_encode($output);
                  }
                  else
                  {
                      $data = $this->mutasi_model->autoCompareSP();
                      $output = array();
                      foreach($data as $row)
                      {
                          $output['title'] = $row['@title'];
                          $output['msg'] = $row['@msg'];
                      }
                      echo json_encode($output);
                  }

              }
              if($this->input->post('bank', TRUE) == 'Bukopin')
              {
                  if($this->getTxtBkp($file) == 'failed')
                  {
                      $output['title'] = 'failed';
                      $output['msg'] = 'gagal upload file';
                      echo json_encode($output);
                  }
                  else
                  {
                      $data = $this->mutasi_model->autoCompareSP();
                      $output = array();
                      foreach($data as $row)
                      {
                          $output['title'] = $row['@title'];
                          $output['msg'] = $row['@msg'];
                      }
                      echo json_encode($output);
                  }
              }
          }
      }
  }

  public function file_selected_test()
  {
      $this->form_validation->set_message('file_selected_test', 'File belum diinput..');
      if (empty($_FILES['userfile']['name'])) {
          return false;
      } else {
          return true;
      }
  }

  public function getCsvMandiri($file)
  {
      $this->load->library('CSVReader');
      $keys = array();
      //$newArray = array();
      // Do it
      $data = $this->csvreader->csvToArray($file, ',');

      // Set number of elements (minus 1 because we shift off the first row)
      $count = count($data) - 1;

      // Use first row for names
      // Check and rename duplicate label
      $labels = array_shift($data);
      foreach ($labels as $k => $value) {
          if(in_array($value, $keys))
          {
              $keys[] = $value.'2';
          }
          else
          {
              $keys[] = $value;
          }

      }

      // Add Ids, just in case we want them later
      // $keys[] = 'id';
      // for ($i = 0; $i < $count; $i++) {
      //     $data[$i][] = $i;
      // }

      // // Bring it all together
      for ($j = 0; $j < $count; $j++) {
          $d = array_combine($keys, $data[$j]);
          $newArray[$j] = $d;
      }

      $dataArr =  $newArray;

      $insert = array();
      $i = 0;
      foreach ($dataArr as $key) {
          $insert[$i]['raw'] = json_encode($dataArr[$i]);
          $insert[$i]['nama_bank'] = $this->input->post('bank', TRUE);
          $insert[$i]['no_rekening'] = $key['Account No'];
          $insert[$i]['tgl_create'] = now();
          if($this->validateDate($key['Date'], "j/n/Y")) // format mandiri csv baru
          {
              $dateFormat = DateTime::createFromFormat("j/n/Y",$key['Date']);
              $insert[$i]['tgl_transfer'] = $dateFormat->format('Y-m-d');
          }
          else if($this->validateDate($key['Date'], 'd/m/y')) // format csv mandiri lama
          {
              $dateFormat = DateTime::createFromFormat("d/m/y",$key['Date']);
              $insert[$i]['tgl_transfer'] = $dateFormat->format('Y-m-d');
          }
          else
          {
              $output['title'] = 'failed';
              $output['msg'] = 'format tanggal tidak diketahui';
              echo json_encode($output);
          }

          $insert[$i]['waktu_transfer'] = 'NULL';
          $insert[$i]['keterangan'] = $key['Description'].' '.$key['Description2'].' '.$key['Reference No.'];
          if($key['Debit'] == 0)
          {
            $insert[$i]['nominal'] = str_replace(',','',$key['Credit']);
          }
          else if($key['Credit'] == 0)
          {
            $insert[$i]['nominal'] = str_replace(',','',$key['Debit']);
          }
          else
          {
            $insert[$i]['nominal'] = 0;
          }
          $insert[$i]['status_id'] = '1'; // default -> proses
          $insert[$i]['admin_id'] = $this->session->userdata('adminId');

          $i++;
      }

      $this->db->trans_start();
      foreach ($insert as $dataIns)
      {
          $this->mutasi_model->insertMutasi($dataIns);
      }
      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE)
      {
          $msg = 'failed';
          return $msg;
      }

  }

  public function getCsvBNI($file)
  {
    //$file = base_url('uploads/1518981066BRI_-_Copy.csv');
    $this->load->library('CSVReader');
    $keys = array();
    $newArray = array();
    // Do it
    $data = $this->csvreader->csvToArrayBNI($file, ',');

    // Set number of elements (minus 1 because we shift off the first row)
    $count = count($data) - 1;

    // Use first row for names
    // Check and rename duplicate label
    $labels = array_shift($data);
    foreach ($labels as $k => $value) {
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

    $dataArr =  $newArray;

    $insert = array();
    $i = 0;
    foreach ($dataArr as $key) {
        $insert[$i]['raw'] = json_encode($dataArr[$i]);
        $insert[$i]['nama_bank'] = $this->input->post('bank', TRUE);
        $insert[$i]['no_rekening'] = '-';
        $insert[$i]['tgl_create'] = now();
        $splitDate = explode(" ",$key['Post Date']);
        $date = $splitDate[0];
        $time = $splitDate[1];
        // if($this->validateDate($date, "j/n/Y")) // format mandiri csv baru
        // {
        //     $dateFormat = DateTime::createFromFormat("j/n/Y", $key['Date']);
        //     $insert[$i]['tgl_transfer'] = $dateFormat->format('Y-m-d');
        // }
        if($this->validateDate($date, 'd/m/y')) // format csv mandiri lama
        {
            $dateFormat = DateTime::createFromFormat("d/m/y",$date);
            $insert[$i]['tgl_transfer'] = $dateFormat->format('Y-m-d');
        }
        else
        {
            $output['title'] = 'failed';
            $output['msg'] = 'format tanggal tidak diketahui';
            echo json_encode($output);
        }
        $splitTime = explode(".", $time);
        $insert[$i]['waktu_transfer'] = $splitTime[0].':'.$splitTime[1].':'.$splitTime[2];
        $insert[$i]['keterangan'] = $key['Description'].' '.$key['Branch'].' '.$key['Journal No.'];
        if($key['Debit'] == 0)
        {
          $insert[$i]['nominal'] = str_replace(',','',$key['Credit']);
        }
        else if($key['Credit'] == 0)
        {
          $insert[$i]['nominal'] = str_replace(',','',$key['Debit']);
        }
        else
        {
          $insert[$i]['nominal'] = 0;
        }
        $insert[$i]['status_id'] = '1'; // default -> proses
        $insert[$i]['admin_id'] = $this->session->userdata('adminId');

        $i++;
    }

    $this->db->trans_start();
    foreach ($insert as $dataIns)
    {
        $this->mutasi_model->insertMutasi($dataIns);
    }
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE)
    {
        $msg = 'failed';
        return $msg;
    }
  }

  public function getCsvBRI($file)
  {
      $this->load->library('CSVReader');
      $keys = array();
      //$newArray = array();
      // Do it
      $data = $this->csvreader->csvToArrayBRI($file, ',');
      // hapus null value pada array
      $datas = array_filter(array_map('array_filter', $data));
      //return $datas = array_filter($data,'strlen');

      // Set number of elements (minus 1 because we shift off the first row)
      $count = count($datas) - 1;

      // Use first row for names
      // Check and rename duplicate label
      $labels = array_shift($datas);
      foreach ($labels as $k => $value) {
          if(in_array($value, $keys))
          {
              $keys[] = $value.'2';
          }
          else
          {
              $keys[] = $value;
          }
      }

      // // Bring it all together
      for ($j = 0; $j < $count; $j++) {
          $d = array_combine($keys, $datas[$j]);
          $newArray[$j] = $d;
      }

      $dataArr =  $newArray;
      $insert = array();
      $i = 0;
      foreach ($dataArr as $key) {
          $insert[$i]['raw'] = json_encode($dataArr[$i]);
          $insert[$i]['nama_bank'] = $this->input->post('bank', TRUE);
          $insert[$i]['no_rekening'] = '-';
          $insert[$i]['tgl_create'] = now();

          if($this->validateDate($key['textbox56'], 'd/m/y')) // format csv mandiri lama
          {
              $dateFormat = DateTime::createFromFormat("d/m/y",$key['textbox56']);
              $insert[$i]['tgl_transfer'] = $dateFormat->format('Y-m-d');
          }
          else
          {
              $output['title'] = 'failed';
              $output['msg'] = 'format tanggal tidak diketahui';
              echo json_encode($output);
          }

          $insert[$i]['waktu_transfer'] = $key['textbox59'];
          $insert[$i]['keterangan'] = $key['textbox18'].' '.$key['textbox14'];
          if($key['textbox72'] == 0)
          {
            $insert[$i]['nominal'] = str_replace(',','',$key['textbox104']);
          }
          else if($key['textbox104'] == 0)
          {
            $insert[$i]['nominal'] = str_replace(',','',$key['textbox72']);
          }
          else
          {
            $insert[$i]['nominal'] = 0;
          }
          $insert[$i]['status_id'] = '1'; // default -> proses
          $insert[$i]['admin_id'] = $this->session->userdata('adminId');

          $i++;
      }

      $this->db->trans_start();
      foreach ($insert as $dataIns)
      {
          $this->mutasi_model->insertMutasi($dataIns);
      }
      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE)
      {
          $msg = 'failed';
          return $msg;
      }

  }

  public function getTxtBkp($file)
  {

    $txt_file    = file_get_contents($file);
    $rows        = explode("\n", $txt_file);
    array_shift($rows);
    $dataArr = array();
    foreach($rows as $row => $data)
    {
        //get row data
        $row_data = array_map('trim', explode('	', $data, 7));
        if($row_data[0] == '') continue;
        if($rows == 1) continue;

         $dataArr[$row]['date']  = json_decode(str_replace('\\u0000', '', json_encode($row_data[0])));

         if ( ! isset($row_data[1])) {
            $row_data[1] = null;
            $dataArr[$row]['time'] = json_decode(str_replace('\\u0000', '', json_encode($row_data[1])));
         }
         else
         {
            $dataArr[$row]['time'] = json_decode(str_replace('\\u0000', '', json_encode($row_data[1])));
         }
         if ( ! isset($row_data[2])) {
            $row_data[2] = null;
            $dataArr[$row]['ref_num'] = json_decode(str_replace('\\u0000', '', json_encode($row_data[2])));
         }
         else
         {
            $dataArr[$row]['ref_num'] = json_decode(str_replace('\\u0000', '', json_encode($row_data[2])));
         }
         if ( ! isset($row_data[3])) {
            $row_data[3] = null;
            $dataArr[$row]['trx_des'] = json_decode(str_replace('\\u0000', '', json_encode($row_data[3])));
         }
         else
         {
            $dataArr[$row]['trx_des'] = json_decode(str_replace('\\u0000', '', json_encode($row_data[3])));
         }
         if ( ! isset($row_data[4])) {
            $row_data[4] = null;
            $dataArr[$row]['debit'] = json_decode(str_replace('\\u0000', '', json_encode($row_data[4])));
         }
         else
         {
            $dataArr[$row]['debit'] = json_decode(str_replace('\\u0000', '', json_encode($row_data[4])));
         }
         if ( ! isset($row_data[5])) {
            $row_data[5] = null;
            $dataArr[$row]['credit'] = json_decode(str_replace('\\u0000', '', json_encode($row_data[5])));
         }
         else
         {
            $dataArr[$row]['credit'] = json_decode(str_replace('\\u0000', '', json_encode($row_data[5])));
         }
         if ( ! isset($row_data[6])) {
            $row_data[6] = null;
            $dataArr[$row]['saldo'] = json_decode(str_replace('\\u0000', '', json_encode($row_data[6])));
         }
         else
         {
            $dataArr[$row]['saldo'] = json_decode(str_replace('\\u0000', '', json_encode($row_data[6])));
         }
    }

    // $dataArrs = array_filter(array_map('array_filter', $dataArr));
    $dataArrs = $dataArr;
    //return $info;
    $insert = array();
    $i = 0;
    foreach ($dataArrs as $key) {
        $insert[$i]['raw'] = json_encode($dataArrs[$i]);
        $insert[$i]['nama_bank'] = $this->input->post('bank', TRUE);
        $insert[$i]['no_rekening'] = '-';
        $insert[$i]['tgl_create'] = now();

        $splitDate = str_split($key['date'], 2);
        if(isset($splitDate[0])){ $year1 = $splitDate[0]; }
        if(isset($splitDate[1])){ $year2 = $splitDate[1]; }
        if(isset($splitDate[2])){ $month = $splitDate[2]; }
        if(isset($splitDate[3])){ $day = $splitDate[3]; }
        $insert[$i]['tgl_transfer'] = $year1.''.$year2.'-'.$month.'-'.$day;
        $splitTime = str_split($key['time'], 2);
        $insert[$i]['waktu_transfer'] = $key['time'][0].''.$key['time'][1].':'.$key['time'][2].''.$key['time'][3].':00';
        $insert[$i]['keterangan'] = $key['ref_num'].' '.$key['trx_des'];
        if($key['debit'] == '')
        {
          $insert[$i]['nominal'] = str_replace(',','',$key['credit']);
        }
        else if($key['credit'] == '')
        {
          $insert[$i]['nominal'] = str_replace(',','',$key['debit']);
        }
        else
        {
          $insert[$i]['nominal'] = 0;
        }
        $insert[$i]['status_id'] = '1'; // default -> proses
        $insert[$i]['admin_id'] = $this->session->userdata('adminId');

        $i++;
    }

    // return $insert;

    $this->db->trans_start();
    foreach ($insert as $dataIns)
    {
        $this->mutasi_model->insertMutasi($dataIns);
    }
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE)
    {
        $msg = 'failed';
        return $msg;
    }

  }

  function validateDate($date, $format)
  {
      $d = DateTime::createFromFormat($format, $date);
      return $d && $d->format($format) == $date;
  }

  // dengan kode unik auto generate
  public function autoCompare2()
  {
      $data = $this->mutasi_model->getTiket();
      foreach ($data as $key) {
        // cek jika nominal mutasi dgn nominal tiket sama
        if($this->mutasi_model->getMutasiByNominal($key['nominal'])->num_rows() == 1)
        {
          $tiket_id = $key['id'];
          $user_id = $key['user_id'];
          $mutasi_id = $this->mutasi_model->getMutasiByNominal($key['nominal'])->row('id');
          $nominal = $this->mutasi_model->getMutasiByNominal($key['nominal'])->row('nominal');
          $this->db->trans_start();
          //ubah status tiket
          $this->mutasi_model->updateStatusTiket($tiket_id);
          //ubah status mutasi
          $this->mutasi_model->updateStatusMutasi($mutasi_id);
          //update saldo
          if(!$this->saldo_model->updateSaldo($user_id,$nominal))
          {
            $this->db->trans_rollback();
            return false;
          }
          // ubah nominal deposit tiket
          if(!$this->mutasi_model->ubahNominalTiket($tiket_id,$nominal))
          {
            $this->db->trans_rollback();
            return false;
          }
          $this->db->trans_complete();
          if ($this->db->trans_status() === TRUE)
          {
              continue;
          }
        }
      }
  }

  // dengan kode unik dari id loket
  public function autoCompareOld()
  {
      // ambil data mutasi
      $data = $this->mutasi_model->getAllMutasi();
      //$count = $this->mutasi_model->countAllMutasi()+1;
      // ambil 4 digit terakhir dari nominal mutasi
      foreach ($data as $key) {

        $last4Digit = substr($key['nominal'], -4);
        if(substr($last4Digit, -4) == '0000')
        {
          continue;
        }
        else if(substr($last4Digit, -4,3) == '000')
        {
          $user_id = substr($last4Digit, -1);
        }
        else if(substr($last4Digit, -4,2) == '00')
        {
          $user_id = substr($last4Digit, -2);
        }
        else if(substr($last4Digit, -4,1) == '0')
        {
          $user_id = substr($last4Digit, -3);
        }
        else
        {
          $user_id = substr($last4Digit, -4);
        }

        //cari id sesuai 4 digit terakhir
        if($this->mutasi_model->isLoketExist($user_id))
        {
          $this->db->trans_start();
          // ubah status mutasi
          $this->mutasi_model->updateStatusMutasi($key['id']);
          // update saldo
          if(!$this->saldo_model->updateSaldo($user_id, $key['nominal']))
          {
            $this->db->trans_rollback();
            return false;
          }
          $this->db->trans_complete();
          if ($this->db->trans_status() === TRUE)
          {
              continue;
          }
        }
      }
  }


  public function tiketList()
  {
      $match = $this->input->get('term',TRUE);
      $data = $this->mutasi_model->getDataTiket($match);
      $output = array();
      foreach($data as $row)
      {
          $nominal =  number_format( $row['nominal'] , 0 ,'', '.');
          $output[] = $row['idT'].','.$row['username'].' '.$row['nama_bank'].' '.$nominal.' '.$row['tgl'];
      }
      echo json_encode($output);
  }

  public function grouplist()
  {
      $match = $this->input->get('term',TRUE);
      $data = $this->user_model->getGroupId($match);
      $output = array();
      foreach($data as $row)
      {
        if($row['username'] == $row['group_id'])
        {
          $output[] = $row['username'];
        }
      }
      echo json_encode($output);
  }

  public function rekonMutasi()
  {
      $username = $this->input->post('rekonMutasi',TRUE);
      $mutasi_id = $this->input->post('mutasi_id',TRUE);
      $data = $this->mutasi_model->rekonMutasiSP($username,$mutasi_id);
      $output = array();
      foreach($data as $row)
      {
          $output['title'] = $row['@title'];
          $output['msg'] = $row['@msg'];
      }
      echo json_encode($output);
  }

  public function rekonMutasiOld()
  {
      $username = $this->input->post('rekonMutasi',TRUE);
      $mutasi_id = $this->input->post('mutasi_id',TRUE);

      $user_id = $this->saldo_model->getUserIdByGroupId($username)->row('id');

      $this->db->trans_start();
      $nominal = $this->mutasi_model->getSaldoByMutasiID($mutasi_id)->row('nominal');
      // ganti status mutasi
      $this->mutasi_model->updateStatusMutasi($mutasi_id);
      // tambah saldo
      if(!$this->saldo_model->updateSaldo($user_id,$nominal))
      {
        $this->db->trans_rollback();
        $output['title'] = 'failed';
        $output['msg'] = 'gagal rekonsiliasi mutasi';
        echo json_encode($output);
      }
      $this->db->trans_complete();
      if ($this->db->trans_status() === FALSE)
      {
          $this->db->trans_rollback();
          $output['title'] = 'failed';
          $output['msg'] = 'gagal rekonsiliasi mutasi';
          echo json_encode($output);
      }
      if ($this->db->trans_status() === TRUE)
      {
          $output['title'] = 'success';
          $output['msg'] = 'berhasil rekonsiliasi mutasi';
          echo json_encode($output);
      }

  }

  public function rekonDeposit()
  {
      $mutasi_id = $this->input->post('mutasi_id',TRUE);
      $data = explode("," , $this->input->post('rekonMutasi',TRUE));
      $tiket_id = $data[0];

      $this->db->trans_start();
      $user_id = $this->mutasi_model->getUserIdByTiket($tiket_id)->row('user_id');
      $nominal = $this->mutasi_model->getSaldoByMutasiID($mutasi_id)->row('nominal');
      // ganti status mutasi
      $this->mutasi_model->updateStatusMutasi($mutasi_id);
      // ganti status tiket
      $this->mutasi_model->updateStatusTiket($tiket_id);
      // tambah saldo
      if(!$this->saldo_model->updateSaldo($user_id,$nominal))
      {
        $this->db->trans_rollback();
        $output['title'] = 'failed';
        $output['msg'] = 'gagal rekonsiliasi mutasi';
        echo json_encode($output);
      }
      // ubah nominal deposit tiket
      if(!$this->mutasi_model->ubahNominalTiket($tiket_id,$nominal))
      {
        $this->db->trans_rollback();
        $output['title'] = 'failed';
        $output['msg'] = 'gagal rekonsiliasi mutasi';
        echo json_encode($output);
      }

      // log aktivitas
      $this->db->trans_complete();
      if ($this->db->trans_status() === FALSE)
      {
          $this->db->trans_rollback();
          $output['title'] = 'failed';
          $output['msg'] = 'gagal rekonsiliasi mutasi';
          echo json_encode($output);
      }
      if ($this->db->trans_status() === TRUE)
      {
          $output['title'] = 'success';
          $output['msg'] = 'berhasil rekonsiliasi mutasi';
          echo json_encode($output);
      }
  }

}
