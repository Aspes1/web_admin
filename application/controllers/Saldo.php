<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saldo extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('saldo_model');
    $this->load->helper('date_helper');
    $this->load->helper('global_helper');
    $this->load->library('datatables');
  }

  public function index()
  {
      $data['title']      = 'Menu Saldo';
      $data['submenu']    = 'saldo/menu_saldo';
      $data['contents']   = 'saldo/isi_saldo';
      $this->load->view('templates/app', $data);
  }

  public function isiSaldoPage()
  {
      $this->load->view('saldo/isi_saldo');
  }

  public function listSaldoPage()
  {
      $this->load->view('saldo/list_saldo');
  }

  public function listHistoryPage()
  {
      $this->load->view('saldo/list_history');
  }

  public function rekapHistoryPage()
  {
      $this->load->view('saldo/rekap_history');
  }

  public function getSaldoJson()
  {
      //data user by JSON object
      header('Content-Type: application/json');
      echo $this->saldo_model->getTabelSaldo();
  }

  public function infoExtra()
  {
      $group = $this->input->post('group', TRUE);
      //$group = 'hagaihagai';

      $data = $this->saldo_model->getExtraInfo($group);

      foreach($data as $row)
      {
        echo '<tr><td>'.$row['username'].'</td><td>'.$row['nama_user'].'</td></tr>';
      }

  }

  public function getHistoryJson()
  {
      //data user by JSON object
      header('Content-Type: application/json');
      echo $this->saldo_model->getHistoryDeposit();
  }

  public function getRekapJson()
  {
      // data rekap by JSON object
      header('Content-Type: application/json');
      $tgl = $this->input->post('tgl', TRUE);
      echo $this->saldo_model->getRekapDeposit($tgl);
  }

  public function setSaldoLoket()
  {
      $username = $this->input->post('user_saldo', TRUE);
      $nominal = $this->input->post('saldo', TRUE);
      $admin_id = $this->session->userdata('adminId');
      $data = $this->saldo_model->depositLangsung($username, $admin_id, $nominal);
      $output = array();
      foreach($data as $row)
      {
          if($row['@msg'] == 'success')
          {
            $output['msg'] = $row['@msg'];
            $output['no_kwitansi'] = $row['@no_kwitansi'];
            $output['username'] = $row['@username'];
            $output['nama_loket'] = $row['@nama_loket'];
            $output['nominal'] = $row['@nominal'];
            $output['terbilang'] = $row['@terbilang'];
            $output['tanggal'] = $row['@tanggal'];
          }
          if($row['@msg'] == 'failed')
          {
            $output['msg'] = $row['@msg'];
            $output['print'] = $row['@print'];
          }
      }
      echo json_encode($output);
  }

  public function setSaldoLoketOld()
  {

      $this->load->library('moneyFormat');
      $username = $this->input->post('user_saldo', TRUE);
      $nominal = $this->input->post('saldo', TRUE);

      //$username = 'juliojulio';
      //$nominal = '19000';

      $this->db->trans_start();
      if($this->saldo_model->getUserByUsername($username)->num_rows() == '')
      {
          $output['msg'] = 'failed';
          $output['print'] = 'Username tidak terdaftar';

          echo json_encode($output);
          exit();
      }
      $user_id = $this->saldo_model->getUserByUsername($username)->row()->id;
      $nama_loket = $this->saldo_model->getUserByUsername($username)->row()->nama_user;
      $this->saldo_model->updateSaldo($user_id, $nominal);

      // cek no kwintansi terakir
      if($this->saldo_model->getLastKwitansiNo() !== '')
      {
          $lastKwitansi = $this->saldo_model->getLastKwitansiNo(); // last full kwitansi number
          $datePart = substr($lastKwitansi,0,8); // get date part
          $idPart = substr($lastKwitansi, 8); // last id kwitansi number
          $nowIntDate = nowInt();
          // cek no kwitansi bulan ini
          if($datePart !== $nowIntDate) {
            $nextID = $nowIntDate.'00001';
          }
          else {
            $nextID = $nowIntDate.''.FormatNoTrans($idPart); // print 00002
          }
      }
      else
      {
          $nextID = $nowIntDate.'00001';
      }


      $print['no_kwitansi'] = $nextID;
      $print['username'] = $username;
      $print['nama_loket'] = $nama_loket;
      $print['nominal'] = $nominal;
      $print['terbilang'] = $this->moneyformat->terbilang($nominal).'Rupiah';
      $print['tanggal'] = nowDate();

      $print_out = json_encode($print);

      $insertData = array(
        'user_id' => $user_id,
        'no_kwitansi' => $nextID,
        'nominal' => $nominal,
        'print_out' => $print_out,
        'admin_id' => $this->session->userdata('adminId'),
        'tgl_create' => now()
      );

      // insert to deposit langsung
      $this->saldo_model->insertDepositLangsung($insertData);

      $this->db->trans_complete();
      if ($this->db->trans_status() === FALSE)
      {
          $output['msg'] = 'failed';
          $output['print'] = 'Gagal Tambah Saldo';

          echo json_encode($output);
      }
      else
      {
          $output['msg'] = 'success';
          $output['no_kwitansi'] = $nextID;
          $output['username'] = $username;
          $output['nama_loket'] = $nama_loket;
          $output['nominal'] = $nominal;
          $output['terbilang'] = $this->moneyformat->terbilang($nominal).'Rupiah';
          $output['tanggal'] = nowDate();

          echo json_encode($output);
      }

  }

  public function getDeposit()
  {
      $no_kwitansi = $this->input->post('no_kwitansi', TRUE);
      if($this->saldo_model->getDepositByNoKwitansi($no_kwitansi) !== '')
      {
          echo $this->saldo_model->getDepositByNoKwitansi($no_kwitansi);
      }
  }

  public function usernameList()
  {
      $match = $this->input->get('term',TRUE);
      $data = $this->saldo_model->getUsername($match);
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

  public function setPrinter()
  {
      $printer_name = $this->input->post('value', TRUE);
      $this->session->unset_userdata('printer');
      $this->session->set_userdata('printer', $printer_name);
  }

  // public function tesFormat()
  // {
  //     $lastKwitansi = $this->saldo_model->getLastKwitansiNo(); // last full kwitansi number
  //     $datePart = substr($lastKwitansi,0,8); // get date part
  //     echo $idPart = substr($lastKwitansi, 8); // last id kwitansi number
  //     echo "\t".FormatNoTrans($idPart);
  //     echo "\t".strlen($idPart);
  // }
  // public function pdf()
	// {
  // 		$this->load->library('pdfgenerator');
  //
  // 		$data['users']=array(
  // 			array('firstname'=>'Agung','lastname'=>'Setiawan','email'=>'ag@setiawan.com'),
  // 			array('firstname'=>'Hauril','lastname'=>'Maulida Nisfar','email'=>'hm@setiawan.com'),
  // 			array('firstname'=>'Akhtar','lastname'=>'Setiawan','email'=>'akh@setiawan.com'),
  // 			array('firstname'=>'Gitarja','lastname'=>'Setiawan','email'=>'git@setiawan.com')
  // 		);
  //
	//     $html = $this->load->view('table_report', $data, true);
  //
	//     $this->pdfgenerator->generate($html,'contoh');
	// }

}
