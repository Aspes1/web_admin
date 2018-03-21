<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['login']                         = 'Login';
$route['dashboard']                     = 'Dashboard';

$route['loket']                         = 'Loket/index';
$route['loket/create']                  = 'Loket/addLoketPage';
$route['loket/list']                    = 'Loket/listLoketPage';

$route['laporan']                       = 'Laporan/index';
$route['laporan/transaksi']             = 'Laporan/addTransaksiPage';
$route['laporan/history']               = 'Laporan/addHistoryPage';

$route['saldo']                         = 'Saldo/index';
$route['saldo/saldo_isi']               = 'Saldo/isiSaldoPage';
$route['saldo/saldo_list']              = 'Saldo/listSaldoPage';
$route['saldo/saldo_history']           = 'Saldo/listHistoryPage';
$route['saldo/rekap_history']           = 'Saldo/rekapHistoryPage';

$route['admin']                         = 'Admin/index';
$route['admin/admin_create']            = 'Admin/createAdminPage';
$route['admin/admin_list']              = 'Admin/listAdminPage';

$route['mutasi']                        = 'Mutasi/index';
$route['mutasi/upload']                 = 'Mutasi/uploadPage';
$route['mutasi/list']                   = 'Mutasi/listPage';

$route['pinjaman']                      = 'Pinjaman/index';
$route['pinjaman/isi']                  = 'Pinjaman/isiDbsPage';
$route['pinjaman/list']                 = 'Pinjaman/listDbsPage';
$route['pinjaman/isi_p']                = 'Pinjaman/isiPinjamanPage';
$route['pinjaman/list_p']               = 'Pinjaman/listPinjamanPage';

$route['error_550']                     = 'Error';

$route['default_controller'] = $route['login'];
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
