'use strict'
var _route_loket       = 'loket';
var _route_laporan     = 'laporan';
var _route_saldo       = 'saldo';
var _route_admin       = 'admin';
var _route_master      = 'master';
var _route_mutasi      = 'mutasi';
var _route_pinjaman    = 'pinjaman';

var _cover_transaksi   = '#isi';

function getPageLoket(str){
  var routes = _route_loket + '/' + str;
  toLoadSecondPage(routes, _cover_transaksi, loketTable);
}

function getPageLaporan(str){
  var routes = _route_laporan + '/' + str;
  toLoadSecondPage(routes, _cover_transaksi, flatpickrActivation);
}

function getPageSaldo(str){
  var routes = _route_saldo + '/' + str;
  toLoadSecondPage(routes, _cover_transaksi, saldo_table);
}

function getPageAdmin(str){
  var routes = _route_admin + '/' + str;
  toLoadSecondPage(routes, _cover_transaksi, admin_page);
}

function getPageMaster(str){
  var routes = _route_master + '/' + str;
  toLoadSecondPage(routes, _cover_transaksi, master_page);
}

function getPageMutasi(str){
  var routes = _route_mutasi + '/' + str;
  toLoadSecondPage(routes, _cover_transaksi, mutasi_page);
}

function getPagePinjaman(str){
  var routes = _route_pinjaman + '/' + str;
  toLoadSecondPage(routes, _cover_transaksi, pinjaman_page);
}

var pinjaman_page = function()
{
  console.log('pinjaman_page_load');
  auto_complete_saldo();
  listDbs();
  maskMoney();
  listPinjaman();
}

var mutasi_page = function()
{
  console.log('mutasi_page_load');
  mutasiList();
  auto_complete_tiket();
}

var master_page = function()
{
  console.log('master_page');
  produkList();
}

var saldo_table = function()
{
  loketSaldo();
  historyDeposit();
  //rekapDeposit();
  auto_complete_saldo();
  flatpickrActivation();
}

var admin_page = function()
{
  loadJenisAdmin();
  adminTable();
}

var ignore = function ()
{
  console.log('Page Changing');
}

var flatpickrActivation = function()
{
  $('.fromT').flatpickr();
  $('.toT').flatpickr();
  $('.tgl_isi').flatpickr();
  $('.rekapDate').flatpickr();
}

var hideErrMsg = function()
{
    $('#alert_err').hide();
    $('#alert_scs').hide()
    $('#prov_err').hide();
    $('#kab_err').hide();
    $('#kodepos_err').hide();
    $('#saldo_err').hide();
    $('#group_err').hide();
    $('#group_scs').hide();
    $('#telp_err').hide();
    $('#pass_err').hide();
    $('#user_err').hide();
    $('#email_err').hide();
    $('#user_scs').hide();
    $('#nama_err').hide();
    $('#bukti_err').hide();
    $('#user_saldo_err').hide();
    $('#user_saldo_scs').hide();
    $('#user_admin_err').hide();
    $('#user_admin_scs').hide();
}

var resetFormLoketValue = function()
{
    $('#prov').val('');
    $('#kab').val('');
    $('#kodepos').val('');
    $('#saldo').val('');
    $('#group').val('');
    $('#telp').val('');
    $('#password').val('');
    $('#username').val('');
    $('#nama').val('');
    $('#alamat').val('');
    $('#email').val('');
}

var resetFormMutasiValue = function()
{
    $('#userfile').val('');
    $('#bank').val('');
}

var coomingSoon = function()
{
  $.alert('Coming Soon');
}

hideErrMsg();
//loadJenisAdmin();
flatpickrActivation();

// Active/Inactive menu
var ulContainer = document.getElementById("ulCon");

var aHref = ulContainer.getElementsByClassName("nav-link");

for (var i = 0; i < aHref.length; i++) {
  aHref[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}

// var colModelData = function() {
//   $.ajax({
//      url: 'laporan/setColumn',
//      method:'GET',
//      success: function(data){
//         alert(data);
//      }
//   });
// }
