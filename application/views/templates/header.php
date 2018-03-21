<?php $role = $this->session->userdata('adminRole'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
  <meta name="author" content="Łukasz Holeczek">
  <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,AngularJS,Angular,Angular2,Angular 2,Angular4,Angular 4,jQuery,CSS,HTML,RWD,Dashboard,React,React.js,Vue,Vue.js">
  <link rel="shortcut icon" href="<?php echo base_url('assets/src/img/icon.png') ?>">

  <title><?php echo $title ?></title>

  <!-- Icons -->
  <link href="<?php echo base_url('assets/dist/vendors/css/font-awesome.min.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/dist/vendors/css/simple-line-icons.min.css') ?>" rel="stylesheet">

  <!-- Main styles for this application -->
  <link href="<?php echo base_url('assets/src/css/style.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/src/css/custom_css.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/src/css/datatables.min.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/src/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/src/css/jquery-confirm.min.css') ?>" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <!-- Styles required by this views -->

</head>

<body class="app header-fixed aside-menu-fixed aside-menu-hidden">
  <header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="<?php echo base_url('dashboard');?>"></a>
    <!-- <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
      <span class="navbar-toggler-icon"></span>
    </button> -->

    <ul class="nav navbar-nav d-md-down-none">
      <li class="nav-item px-3">
        <a class="nav-link" href="javascript:coomingSoon()">Laporan</a>
      </li>
      <li class="nav-item px-3">
        <a class="nav-link" href="<?php echo base_url('loket');?>">Loket</a>
      </li>
      <li class="nav-item px-3">
        <a class="nav-link" href="<?php echo base_url('mutasi');?>">Mutasi</a>
      </li>
      <li class="nav-item px-3">
        <a class="nav-link" href="<?php echo base_url('saldo');?>">Saldo</a>
      </li>
      <li class="nav-item px-3">
        <a class="nav-link" href="<?php echo base_url('pinjaman');?>">Pinjaman</a>
      </li>
      <li class="nav-item px-3">
        <a class="nav-link" href="<?php echo base_url('admin');?>">Admin Users</a>
      </li>
      <li class="nav-item px-3">
        <a class="nav-link" href="javascript:coomingSoon()">Master INM</a>
      </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item px-3">
          <a class="nav-link" href="<?php echo base_url('logout');?>">Logout</a>
        </li>
    </ul>

    <button class="navbar-toggler aside-menu-toggler" type="button">
      <span class="navbar-toggler-icon"></span>
    </button>

  </header>

  <div class="app-body">

      <!-- Main content -->
      <main class="main">
        <div class="container-fluid">
