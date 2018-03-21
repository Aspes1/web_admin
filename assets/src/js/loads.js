'use strict'

var toLoadSecondPage = function(routes, idOrClassName, callFunc) {
    $.ajax({
       url: routes,
       success: function(result){
          $(idOrClassName).html(result);
          hideErrMsg();
          callFunc();
       }
    });
    console.log(routes);
}

// =========================== call maskMOney =========================== //
var maskMoney = function() {
    $('#saldo_saldo').maskMoney({thousands:'.', decimal:',', precision:0});
    $('#saldo').maskMoney({thousands:'.', decimal:',', precision:0});
}

maskMoney();
// =========================== //call maskMoney =========================== //


// =========================== open isi Saldo Page =========================== //
var showPrompt = function() {
  startConnection();
  $.confirm({
      title: 'Pengaturan Printer!',
      content: '' +
      '<div class="form-group">' +
      '<label>Silahkan pilih printer yang akan digunakan</label>' +
      '<select class="name form-control" name="list_printer" id="list_printer" required />' +
      '</div>',
      buttons: {
          formSubmit: {
              text: 'Submit',
              btnClass: 'btn-blue',
              action: function () {
                  var name = this.$content.find('.name').val();
                  if(!name){
                      qz.websocket.disconnect();
                      $.alert('Tidak Valid');
                      return false;
                  }
                  //$.alert('Your name is ' + name);
                  $.ajax({
                      type: "POST",
                      url: "saldo/setPrinter",
                      data: { value: name }
                   }).done(function( msg ) {
                      //$.alert('Sukses');
                      qz.websocket.disconnect();
                      location.reload();
                   });
              }
          },
          cancel: function () {
              qz.websocket.disconnect();
          },
      },
      onContentReady: function () {
          // bind to events
          var jc = this;
          this.$content.find('form').on('submit', function (e) {
              // if the user submits the form by pressing enter in the field.
              e.preventDefault();
              jc.$$formSubmit.trigger('click'); // reference the button and click it
          });
      }
  });
}

function startConnection(config) {
    if (!qz.websocket.isActive()) {

        qz.websocket.connect(config).then(function() {
          findPrinters();
        }).catch(handleConnectionError);
    } else {
        displayMessage('An active connection with QZ already exists.', 'alert-warning');
    }
}

function displayMessage(msg, css) {
    if (css == undefined) { css = 'alert-info'; }

    var timeout = setTimeout(function() { $('#' + timeout).alert('close'); }, 5000);

    var alert = $("<div/>").addClass('alert alert-dismissible fade in ' + css)
            .css('max-height', '20em').css('overflow', 'auto')
            .attr('id', timeout).attr('role', 'alert');
    alert.html("<button type='button' class='close' data-dismiss='alert'>&times;</button>" + msg);

    $("#qz-alert").append(alert);
}

function handleConnectionError(err) {

    if (err.target != undefined) {
        if (err.target.readyState >= 2) { //if CLOSING or CLOSED
            displayError("Connection to QZ Tray was closed");
        } else {
            displayError("A connection error occurred, check log for details");
            console.error(err);
        }
    } else {
        displayError(err);
    }
}

function findPrinters() {

    qz.printers.find().then(function(data) {
        var list = '';
        for(var i = 0; i < data.length; i++) {
            list += "<option>" + data[i] + "</option>";
        }
        $("#list_printer").append(list);
        // displayMessage("<strong>Available printers:</strong><br/>" + list);
    }).catch(displayError);
}

function displayError(err) {
    console.error(err);
    //displayMessage(err, 'alert-danger');
}

// handle isi saldo & isi dbs
var isGroupMaster = function(){
  var user_saldo = $('#user_saldo').val();
  var inUserSaldo = document.getElementById("user_saldo");
  getNamaLoket(user_saldo);
  if(user_saldo){
    $.ajax({
        type:'POST',
        url:base_url+'loket/is_group_master',
        data:'user='+user_saldo,
        success:function(html){
            if(html == 'suc'){
                inUserSaldo.classList.remove("is-invalid");
                inUserSaldo.classList.add("is-valid"); // username adalah group master
                $('#user_saldo_scs').show();
                $('#user_saldo_err').hide();
                document.getElementById("saldo_submit").disabled = false;
            }
            if(html == 'err'){
                inUserSaldo.classList.remove("is-valid");
                inUserSaldo.classList.add("is-invalid"); // username bukan group master
                $('#user_saldo_err').show();
                $('#user_saldo_scs').hide();
                document.getElementById("saldo_submit").disabled = true;
            }
        }
    });
  }
  else {
    inUserSaldo.classList.remove("is-invalid");
    inUserSaldo.classList.remove("is-valid");
    $('#user_saldo_scs').hide();
    $('#user_saldo_err').hide();
  }
}

var getNamaLoket = function (user) {
  if(user.length >= 8){
    $.ajax({
        type:'POST',
        url:base_url+'loket/get_loket_name',
        data:'user='+user,
        dataType:"json",
        success:function(html){
            $('#nama_saldo').val(html.nama);
        }
    });
  }
  else {
    $('#nama_saldo').val('');
  }
}

var reset = function() {
  document.getElementById("user_saldo").classList.remove("is-invalid");
  document.getElementById("user_saldo").classList.remove("is-valid");
  $('#user_saldo_scs').hide();
  $('#user_saldo_err').hide();
  $('#user_saldo').val('');
  $('#nama_saldo').val('');
  $('#saldo_saldo').val('');
  $('#bukti_saldo').val('');

  $('#nama_admin').val('');
  $('#user_admin').val('');
  $('#password_admin').val('');
  $('#jenis_admin').val('');
}

var resetSaldoForm = function (event){
    event.preventDefault();
    $.confirm({
      title: 'Confirm!',
      content: 'Reset Form ?',
      buttons: {
          confirm: function () {
            reset();
          },
          cancel: function () {
              $.alert('Reset dibatalkan');
          },
      }
  });
}

var isFormSaldoEmpty = function()
{
  var user = $('#user_saldo').val();
  var nama = $('#nama_saldo').val();
  var saldo = $('#saldo_saldo').val();
  var bukti = $('#bukti_saldo').val();
  if(user == "" || nama == "" || saldo == "" || bukti == ""){
    return false;
  }
  else {
    return true;
  }
}

var print = function(datas) {
  var printer = $('#printer_use').val();
  if(printer == '')
  {
    $.alert('Setting Printer terlebih dahulu');
    return;
  }
  var bilangan = datas.nominal;
  var	reverse = bilangan.toString().split('').reverse().join(''),
      ribuan 	= reverse.match(/\d{1,3}/g);
      ribuan	= ribuan.join('.').split('').reverse().join('');

  var config = qz.configs.create(printer);

  var data = [
     '\x1B' + '\x61' + '\x31', // center align
     '\x1B' + '\x45' + '\x0D', // bold on
     'BUKTI DEPOSIT PT. INTERPRIMA NUSANTARA MANDIRI\n',
     '\x1B' + '\x61' + '\x30', // left align
     'No Kwitansi        : '+datas.no_kwitansi+'\n',
     'Tanggal            : '+datas.tanggal+'\n',
     'User Id            : '+datas.username+'\n',
     'Nama Loket         : '+datas.nama_loket+'\n',
     'Jumlah Setoran     : Rp. '+ribuan+'\n',
     'Terbilang          : '+datas.terbilang+'\n',
     '\x1B' + '\x61' + '\x31', // center align
     ' Penyetor                                          Diterima\n',
     '\x0A', //line break
     '\x0A', //line break
     '\x1B' + '\x61' + '\x31', // center align
     '(_________________)                               (_________________)\n',
     '\x1B' + '\x45' + '\x0A', // bold off
     '\x0A', //line break
     '\x0A' //line break
  ];

  qz.print(config, data).catch(function(e) { console.error(e); });
}

var submitSaldoForm = function(event){
  event.preventDefault();
  var saldo = $("#saldo_saldo").val();
  var formData = new FormData($('#saldo_form')[0]);
  formData.delete('saldo_saldo');
  formData.append('saldo', saldo.split('.').join(""));

  $.confirm({
      title: 'Confirm!',
      content: 'Submit data... ??',
      buttons: {
          confirm: function () {
            qz.websocket.disconnect(); // close qz tray
            if(isFormSaldoEmpty()){
              $.ajax({
                  url:base_url+'saldo/setSaldoLoket',
                  method:'POST',
                  data:formData,
                  contentType:false,
                  processData:false,
                  dataType:"json",
                  success:function(datas){
                      if(datas.msg == 'failed') {
                        $.alert(datas.print);
                      }
                      if(datas.msg == 'success') {
                        qz.websocket.connect().then(function() {
                          print(datas);
                          reset();
                        });
                      }
                  }
              });
            }
            else {
              $.alert('salah satu form belum diisi');
            }
          },
          cancel: function () {

          },
      }
  });
}

$( function() {
  auto_complete_saldo();
});
var auto_complete_saldo = function() {
  $( function() {
      $( "#user_saldo" ).autocomplete({
        source: base_url+'saldo/usernameList',
        appendTo: "#auto_con_div"
      });

  });
}

var testPrint = function()
{
  qz.websocket.disconnect();
  $.confirm({
    title: 'Confirm!',
    content: 'Ingin Tes Printer',
    buttons: {
        confirm: function () {
          qz.websocket.connect().then(function() {
            var data = {
            	"nama_loket" : "Tes Printer",
            	"no_kwitansi" : "1945081700001",
            	"nominal" : "50000000",
            	"tanggal" : "17-08-1945 08:30",
            	"terbilang" : "Lima Puluh Juta Rupiah ",
            	"username" : "tesprinter"
            };
            print(data);
          });
        },
        cancel: function () {
            qz.websocket.disconnect();
        }
    }
});
}

// =========================== close isi Saldo Page =========================== //

// =========================== open tabel Rekap Page =========================== //



// =========================== close tabel Rekap Page =========================== //


// =========================== open create loket Page =========================== //
var resetLoketForm = function (event){
    event.preventDefault();
    $.confirm({
      title: 'Confirm!',
      content: 'Reset Form ?',
      buttons: {
          confirm: function () {
              document.getElementById("group").classList.remove("is-invalid");
              document.getElementById("group").classList.remove("is-valid");
              document.getElementById("username").classList.remove("is-invalid");
              document.getElementById("username").classList.remove("is-valid");
              $('#group_scs').hide();
              $('#group_err').hide();
              $('#user_scs').hide();
              $('#user_err').hide();
              $('#nama').val('');
              $('#username').val('');
              $('#password').val('');
              $('#kodepos').val('');
              $('#telp').val('');
              $('#alamat').val('');
              $('#email').val('');
              $('#prov').val('');
              $('#kab').val('');
              $('#saldo').val('');
              $('#group').val('');
          },
          cancel: function () {
              $.alert('Reset dibatalkan');
          },
      }
  });
}

var isFormLoketEmpty = function()
{
  var name = $('#nama').val();
  var username = $('#username').val();
  var password = $('#password').val();
  var kodepos = $('#kodepos').val();
  var telp = $('#telp').val();
  var alamat = $('#alamat').val();
  var email = $('#email').val();
  var prov = $('#prov').val();
  var kab = $('#kab').val();
  if(name == "" || username == "" || password == "" || kodepos == "" || telp == "" || alamat == "" || email == "" || prov == "" || kab == ""){
    return false;
  }
  else {
    return true;
  }
}

$(document).ready(function(){

    $(document).on('submit', '#loket_form', function(event){
        event.preventDefault();
        var name = $('#nama').val();
        var saldoIn = $('#saldo').val();
        var formData = new FormData(this);
        formData.delete('saldo');
        formData.append('saldo', saldoIn.split('.').join(""));

        $.confirm({
            title: 'Confirm!, Yakin membuat Loket?',
            content: 'Submit data... ??',
            buttons: {
                confirm: {
                    text: 'Confirm',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function(){
                        if(isFormLoketEmpty()){
                           $.ajax({
                               url:base_url+'loket/createLoket',
                               method:'POST',
                               data:formData,
                               contentType:false,
                               processData:false,
                               dataType:"json",
                               success:function(html){
                                 if (html.msg == 'success'){
                                   $.alert('Berhasil membuat Loket');
                                   resetFormLoketValue();
                                   hideErrMsg();
                                 }
                                 else if (html.msg == 'failed') {
                                   $.alert('Gagal membuat Loket');
                                 }
                                 else {
                                   $.alert(html.msg);

                                 }
                               }
                           });
                        }
                       else {
                           $.alert('ada form yang belum diisi');
                       }
                    }
                },
                cancel: function () {
                },
            }
        });

    });



    $('#kodepos').on('change',function(){
        var kodepos = $(this).val();
        if(kodepos){
            $.ajax({
                type:'POST',
                url:base_url+'loket/search',
                data:'kodepos='+kodepos,
                dataType:"json",
                success:function(html){
                    $('#kab').val(html.kabupaten);
                    $('#prov').val(html.provinsi);
                }
            });
        }
        else {
            $('#kab').val('');
            $('#prov').val('');
        }
    });

    $('#group').on('change',function(){
        var group = $(this).val();
        var inpGrp = document.getElementById("group");
        if(group){
            $.ajax({
                type:'POST',
                url:base_url+'loket/username_exists',
                data:'user='+group,
                success:function(html){
                    if(html === 'suc'){
                        inpGrp.classList.add("is-valid");
                        $('#group_err').hide();
                        $('#group_scs').show();
                    }
                    else {
                        inpGrp.classList.add("is-invalid");
                        $('#group_scs').hide();
                        $('#group_err').show();
                    }
                }
            });
        }
        else {
            $('#group_scs').hide();
            $('#group_err').hide();
        }
    });

    $('#username').on('change',function(){
        var username = $(this).val();
        var inUser = document.getElementById("username");
        if(username){
            $.ajax({
                type:'POST',
                url:base_url+'loket/username_exists',
                data:'user='+username,
                success:function(html){
                    if(html === 'suc'){
                        inUser.classList.remove("is-valid");
                        inUser.classList.add("is-invalid"); // username sudah terdaftar
                        $('#user_scs').hide();
                        $('#user_err').show();
                    }
                    else{
                        inUser.classList.remove("is-invalid");
                        inUser.classList.add("is-valid"); // username boleh digunakan
                        $('#user_err').hide();
                        $('#user_scs').show();
                    }
                }
            });
        }
        else {
            $('#user_scs').hide();
            $('#user_err').hide();
        }
    });


});

// =========================== close create loket Page =========================== //


// =========================== open create Admin Page ============================ //

var loadJenisAdmin = function()
{
  $.ajax({
      url:base_url+'admin/setJenisAdminOption',
      method:'GET',
      success:function(html){
        $("#jenis_admin").append(html);
      }
  });
}

// load function
$("#create_admin").ready(function()
{
  loadJenisAdmin();

  $('#user_admin').on('change',function(){
    var username = $(this).val();
    if(username.length >= 5)
    {
      $.ajax({
          type:'POST',
          url:base_url+'admin/useradmin_exists',
          data:'username='+username,
          success:function(html){
              if(html === 'suc'){
                  document.getElementById("user_admin").classList.remove("is-valid");
                  document.getElementById("user_admin").classList.add("is-invalid"); // username sudah terdaftar
                  $('#user_admin_scs').hide();
                  $('#user_admin_err').show();
              }
              else{
                  document.getElementById("user_admin").classList.remove("is-invalid");
                  document.getElementById("user_admin").classList.add("is-valid"); // username boleh digunakan
                  $('#user_admin_err').hide();
                  $('#user_admin_scs').show();
              }
          }
      });
    }
  });


});

var isFormAdminEmpty = function()
{
  var name = $('#nama_admin').val();
  var username = $('#user_admin').val();
  var password = $('#password_admin').val();
  var jenis = $('#jenis_admin').val();

  if(name == "" || username == "" || password == "" || jenis == ""){
    return false;
  }
  else {
    return true;
  }
}

var submitAdminForm = function(event){
  event.preventDefault();
  var formData = new FormData($('#admin_form')[0]);

  $.confirm({
      title: 'Confirm!',
      content: 'Submit data... ??',
      buttons: {
          confirm: function () {
            if(isFormAdminEmpty()){
              $.ajax({
                  url:base_url+'admin/setAdmin',
                  method:'POST',
                  data:formData,
                  contentType:false,
                  processData:false,
                  dataType:"json",
                  success:function(datas){
                      if(datas.msg == 'failed') {
                        $.alert('Gagal Mendaftar Admin');
                      }
                      if(datas.msg == 'success') {
                        $.alert('Sukses Mendaftar Admin');
                        resetAdminF();
                      }
                  }
              });
            }
            else {
              $.alert('salah satu form belum diisi');
            }
          },
          cancel: function () {

          },
      }
  });
}

var resetAdminF = function() {
  document.getElementById("user_admin").classList.remove("is-invalid");
  document.getElementById("user_admin").classList.remove("is-valid");
  $('#user_admin_scs').hide();
  $('#user_admin_err').hide();
  $('#nama_admin').val('');
  $('#user_admin').val('');
  $('#password_admin').val('');
  $('#jenis_admin').val('');
}

var resetAdminForm = function (event){
    event.preventDefault();
    $.confirm({
      title: 'Confirm!',
      content: 'Reset Form ?',
      buttons: {
          confirm: function () {
              resetAdminF();
          },
          cancel: function () {
              $.alert('Reset dibatalkan');
          },
      }
  });
}
// =========================== close create Admin Page =========================== //

// =========================== open add Produk Menu =========================== //
$("#add_produk").ready(function() {
  produkList();
  loadJenisProduk();
  loadVendor();
});

var loadJenisProduk = function()
{
  $.ajax({
      url:base_url+'master/setJenisProdukOption',
      method:'GET',
      success:function(html){
        $("#jenis_produk").append(html);
      }
  });
}

var loadVendor = function()
{
  $.ajax({
      url:base_url+'master/setVendorOption',
      method:'GET',
      success:function(html){
        $("#vendor").append(html);
      }
  });
}


// =========================== close add Produk Menu =========================== //

// =========================== open upload mutasi Menu =========================== //

$("#upload_mutasi_pg").ready(function() {
  $(document).on('submit', '#mutasi_form', function(event){
    event.preventDefault();
    var formData = new FormData(this);

    $.confirm({
        title: 'Confirm!, Upload File Mutasi',
        content: 'Submit data... ??',
        buttons: {
            confirm: {
                text: 'Confirm',
                btnClass: 'btn-blue',
                keys: ['enter', 'shift'],
                action: function(){
                    if(isFormMutasiEmpty()){
                      //$.alert('proses file');
                       $.ajax({
                           url:base_url+'mutasi/do_upload',
                           method:'POST',
                           data:formData,
                           contentType:false,
                           processData:false,
                           dataType:"json",
                           success:function(html){
                             if (html.title == 'success'){
                               $.alert(html.msg);
                               resetFormMutasiValue();
                             }
                             if (html.title == 'failed') {
                               $.alert(html.msg);
                             }
                           }
                       });
                    }
                   else {
                       $.alert('ada form yang belum diisi');
                   }
                }
            },
            cancel: function () {
            },
        }
    });

  });
});


var isFormMutasiEmpty = function()
{
  var userfile = $('#userfile').val();
  var bank = $('#bank').val();

  if(userfile == "" || bank == ""){
    return false;
  }
  else {
    return true;
  }
}

var isFormRekonEmpty = function()
{
  var mutasi_id = $('#mutasi_id').val();
  var tiketData = $('#rekonMutasi').val();

  if(mutasi_id == "" || tiketData == ""){
    return false;
  }
  else {
    return true;
  }
}

$( function() {
  auto_complete_tiket();
  $(document).on('submit', '#rekon_mutasi', function(event){
    event.preventDefault();
    var formData = new FormData(this);

    $.confirm({
        title: 'Confirm!, Rekon Deposit',
        content: 'Submit data... ??',
        buttons: {
            confirm: {
                text: 'Confirm',
                btnClass: 'btn-blue',
                keys: ['enter', 'shift'],
                action: function(){
                    if(isFormRekonEmpty()){
                      //$.alert('rekon mutasi');
                       $.ajax({
                           url:base_url+'mutasi/rekonMutasi',
                           method:'POST',
                           data:formData,
                           contentType:false,
                           processData:false,
                           dataType:"json",
                           success:function(html){
                             if (html.title == 'success'){
                               $.alert(html.msg);
                               $('#tabelMutasi').DataTable().ajax.reload();
                             }
                             if (html.title == 'failed') {
                               $.alert(html.msg);
                               $('#tabelMutasi').DataTable().ajax.reload();
                             }
                           }
                       });
                    }
                   else {
                       $.alert('ada form yang belum diisi');
                   }
                }
            },
            cancel: function () {
            },
        }
    });

  });
});
var auto_complete_tiket = function() {
  $( function() {
      $( "#rekonMutasi" ).autocomplete({
        source: base_url+'mutasi/grouplist',
        appendTo: "#auto_con_div"
      });
  });
}

// =========================== close upload mutasi Menu =========================== //

// =========================== open dbs Menu =========================== //

var submitDbsForm = function(event){
  event.preventDefault();
  var saldo = $("#saldo_saldo").val();
  var formData = new FormData($('#dbs_form')[0]);
  formData.delete('saldo_saldo');
  formData.append('saldo', saldo.split('.').join(""));

  $.confirm({
      title: 'Confirm!',
      content: 'Submit data... ??',
      buttons: {
          confirm: function () {
            if(isFormSaldoEmpty()){
              $.ajax({
                  url:base_url+'pinjaman/setDbs',
                  method:'POST',
                  data:formData,
                  contentType:false,
                  processData:false,
                  dataType:"json",
                  success:function(datas){
                      if(datas.msg == 'failed') {
                        $.alert(datas.print);
                      }
                      if(datas.msg == 'success') {
                        $.alert(datas.print);
                        reset();
                      }
                  }
              });
            }
            else {
              $.alert('salah satu form belum diisi');
            }
          },
          cancel: function () {

          },
      }
  });
}

// =========================== close dbs Menu =========================== //

// =========================== open pinjaman Menu =========================== //
var submitPinjamanForm = function(event){
  event.preventDefault();
  var saldo = $("#saldo_saldo").val();
  var formData = new FormData($('#pinjaman_form')[0]);
  formData.delete('saldo_saldo');
  formData.append('saldo', saldo.split('.').join(""));

  $.confirm({
      title: 'Confirm!',
      content: 'Submit data... ??',
      buttons: {
          confirm: function () {
            if(isFormSaldoEmpty()){
              $.ajax({
                  url:base_url+'pinjaman/setPinjaman',
                  method:'POST',
                  data:formData,
                  contentType:false,
                  processData:false,
                  dataType:"json",
                  success:function(datas){
                      if(datas.msg == 'failed') {
                        $.alert(datas.print);
                      }
                      if(datas.msg == 'success') {
                        $.alert(datas.print);
                        reset();
                      }
                  }
              });
            }
            else {
              $.alert('salah satu form belum diisi');
            }
          },
          cancel: function () {

          },
      }
  });
}
// =========================== close pinjaman Menu =========================== //
