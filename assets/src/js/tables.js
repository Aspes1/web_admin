'use strict'
var format = function (d) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" class="table-striped" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Nama Loket:</td>'+
            '<td>'+d.nama+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>No Telp:</td>'+
            '<td>'+d.no_telp+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Alamat:</td>'+
            '<td>'+d.alamat+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Kabupaten:</td>'+
            '<td>'+d.kab+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Provinsi:</td>'+
            '<td>'+d.prov+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>IP Adrress:</td>'+
            '<td>'+d.ip_address+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Mac Adress:</td>'+
            '<td>'+d.mac_address+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Tanggal Daftar:</td>'+
            '<td>'+d.tgl_create+'</td>'+
        '</tr>'+
    '</table>';
}

var formatExtraSaldo = function (d) {

    var text = '<table cellpadding="5" class="table-bordered" cellspacing="0" border="0" style="padding-left:50px;margin-left:10%;">';
    text += '<thead><tr><th width="200">Username</th><th width="200">Nama Loket</th></tr></thead>';
    text += d;
    text += '</table>';
    return text;
}

var formatgriya = function (d) {
    // `d` is the original data object for the row
    return '<div>'+d.tablenya+'</div>';
}

var inputMutasi = function (id) {
    var text = '<form method="post" id="rekon_mutasi" enctype="multipart/form-data" class="form-horizontal">';
    text += '<div class="row"><div class="col-md-8">';
    text += '<input type="hidden" id="mutasi_id" name="mutasi_id" value="'+id+'">';
    text += '<input type="text" class="form-control" id="rekonMutasi" name="rekonMutasi" placeholder="Masukkan username loket">';
    text += '</div>';
    text += '<div class="col-md-2">';
    text += '<button type="submit" id="rekon_submit" class="btn btn-xs btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>';
    text += '</div></div>';
    text += '<div id="auto_con_div" onclick=""></div>';
    text += '</form>';
    return text;
}

var loketTable = function () {
  maskMoney();
  $(document).ready(function(){
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };

      var table = $("#tabelLoket").DataTable({
          "dom": 'Zlfrtip',
          initComplete: function() {
              var api = this.api();
              $('#tabelLoket_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
                "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
              sProcessing: "loading..."
          },
              processing: true,
              serverSide: true,
              ajax: {"url": base_url+"loket/getUserJson", "type": "POST"},
                columns: [
                      {
                        "data": "icon",
                        "className":"details-control"
                      },
                      {"data": "nama_user"},
                      {"data": "username"},
                      {"data": "group_id"},
                      {"data": "level"},
                      {"data": "no_telp"},
                      // {"data": "jumlah_saldo", render: $.fn.dataTable.render.number(',', '.', '')},
                      {"data": "nama_status"},
                      {"data": "view"}
                ],
                order: [[1, 'asc']],
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    $('td:eq(0)', row).html();
                }

      });

        $('#tabelLoket tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var tdi = tr.find("i.fa");
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
                tdi.first().removeClass('fa-minus-square');
                tdi.first().addClass('fa-plus-square');
            }
            else {
                var username = row.data().username;
                if(username){
                    $.ajax({
                        type:'POST',
                        url:base_url+'loket/infoExtra',
                        data:'username='+username,
                        dataType:'json',
                        success:function(res){
                          row.child(format(res)).show();
                          //console.log(res.nama);
                          tr.addClass('shown');
                          tdi.first().removeClass('fa-plus-square');
                          tdi.first().addClass('fa-minus-square');
                        }
                    });
                }
            }
        });

        // end setup datatables

        // reset mac
        $('#tabelLoket').on('click','.resetMac',function(){
            var username=$(this).data('username');
            $.confirm({
                title: 'Confirm!, Reset Mac Address',
                content: username,
                buttons: {
                    confirm: {
                        text: 'Confirm',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function(){
                            if(username){
                              $.ajax({
                                  type:'POST',
                                  url:base_url+'loket/reset_mac',
                                  data:'username='+username,
                                  success:function(res){
                                    $.alert('Mac Adrress <b>'+username+'</b> telah dikosongkan');
                                    $('#tabelLoket').DataTable().ajax.reload();
                                  }
                              });
                            }
                        }
                    },
                    cancel: function () {
                    },
                }
            });
        });


        // block loket
        $('#tabelLoket').on('click','.block',function(){
          var username=$(this).data('username');
          $.confirm({
              title: 'Confirm!, Block Loket',
              content: username,
              buttons: {
                  confirm: {
                      text: 'Confirm',
                      btnClass: 'btn-blue',
                      keys: ['enter', 'shift'],
                      action: function(){
                          if(username){
                            $.ajax({
                                type:'POST',
                                url:base_url+'loket/block',
                                data:'username='+username,
                                success:function(res){
                                  $.alert('Akun <b>'+username+'</b> telah diblock');
                                  $('#tabelLoket').DataTable().ajax.reload();
                                }
                            });
                          }
                      }
                  },
                  cancel: function () {
                  },
              }
          });
        });


        // unblock Loket
        $('#tabelLoket').on('click','.unblock',function(){
          var username=$(this).data('username');
          $.confirm({
              title: 'Confirm!, Aktifkan Loket',
              content: username,
              buttons: {
                  confirm: {
                      text: 'Confirm',
                      btnClass: 'btn-blue',
                      keys: ['enter', 'shift'],
                      action: function(){
                          if(username){
                            $.ajax({
                                type:'POST',
                                url:base_url+'loket/unblock',
                                data:'username='+username,
                                success:function(res){
                                  $.alert('Akun <b>'+username+'</b> telah diaktifkan');
                                  $('#tabelLoket').DataTable().ajax.reload();
                                }
                            });
                          }
                      }
                  },
                  cancel: function () {
                  },
              }
          });
        });


        // reset password
        $('#tabelLoket').on('click','.resetPass',function(){
          var username=$(this).data('username');
          $.confirm({
              title: 'Confirm!, Reset Password',
              content: username,
              buttons: {
                  confirm: {
                      text: 'Confirm',
                      btnClass: 'btn-blue',
                      keys: ['enter', 'shift'],
                      action: function(){
                          if(username){
                            $.ajax({
                                type:'POST',
                                url:base_url+'loket/reset_pass',
                                data:'username='+username,
                                success:function(res){
                                  $.alert('Password <b>'+username+'</b> telah direset menjadi 123456');
                                  $('#tabelLoket').DataTable().ajax.reload();
                                }
                            });
                          }
                      }
                  },
                  cancel: function () {
                  },
              }
          });
        });

    });
}

var loketSaldo = function () {
  maskMoney(); // load maskMoney Format
  $(document).ready(function(){
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };

      var table = $("#tabelSaldo").DataTable({
          "dom": 'Zlfrtip',
          initComplete: function() {
              var api = this.api();
              $('#tabelSaldo_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
                "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
              sProcessing: "loading..."
          },
              processing: true,
              serverSide: true,
              ajax: {"url": base_url+"saldo/getSaldoJson", "type": "POST"},
                columns: [
                      {
                        "data": "icon",
                        "className":"details-control"
                      },
                      {"data": "group_id"},
                      {"data": "nama_user"},
                      {"data": "tgl"},
                      {"data": "jumlah_saldo", render: $.fn.dataTable.render.number(',', '.', '')}
                ],
                order: [[1, 'asc']],
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    $('td:eq(0)', row).html();
                }

      });

      $('#tabelSaldo tbody').on('click', 'td.details-control', function () {
          var tr = $(this).closest('tr');
          var tdi = tr.find("i.fa");
          var row = table.row(tr);

          if (row.child.isShown()) {
              // This row is already open - close it
              row.child.hide();
              tr.removeClass('shown');
              tdi.first().removeClass('fa-minus-square');
              tdi.first().addClass('fa-plus-square');
          }
          else {
              var group = row.data().group_id;
              if(group){
                  $.ajax({
                      type:'POST',
                      url:base_url+'saldo/infoExtra',
                      data:'group='+group,
                      //dataType:'json',
                      success:function(res){
                        //console.log(res);
                        row.child(formatExtraSaldo(res)).show();
                        tr.addClass('shown');
                        tdi.first().removeClass('fa-plus-square');
                        tdi.first().addClass('fa-minus-square');
                      }
                  });
              }
          }
      });
    });
}

var historyDeposit = function() {
  $(document).ready(function(){
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };

      var table = $("#tabelHistoryDeposit").DataTable({
          "dom": 'Zlfrtip',
          initComplete: function() {
              var api = this.api();
              $('#tabelHistoryDeposit_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
                "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
              sProcessing: "loading..."
          },
              processing: true,
              serverSide: true,
              ajax: {"url": base_url+"saldo/getHistoryJson", "type": "POST"},
                columns: [
                      {"data": "no_kwitansi"},
                      {"data": "nama_user"},
                      {"data": "username"},
                      {"data": "nominal", render: $.fn.dataTable.render.number(',', '.', '')},
                      {"data": "tgl"},
                      {"data": "view"},
                ],
                order: [[4, 'desc']],
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    $('td:eq(0)', row).html();
                }

      });

      $('#tabelHistoryDeposit').on('click','.print',function(){
        var id = $(this).data('id');
        var no_kwitansi = $(this).data('no_kwitansi');
        $.confirm({
            title: 'Print Ulang',
            content: 'No Kwitansi : '+no_kwitansi,
            buttons: {
                confirm: function () {
                  qz.websocket.disconnect();
                  if(no_kwitansi){
                    $.ajax({
                        url:base_url+'saldo/getDeposit',
                        method:'POST',
                        data:'no_kwitansi='+no_kwitansi,
                        dataType:"json",
                        success:function(datas){
                          if(datas !== '')
                          {
                            qz.websocket.connect().then(function() {
                              print(datas);
                            });
                          }
                        }
                    });
                  }
                },
                cancel: function () {
                },
            }
        });
      });
    });
}

// table admin
var adminTable = function () {
  maskMoney(); // load maskMoney Format
  $(document).ready(function(){
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };

      var table = $("#tabelAdmin").DataTable({
          "dom": 'Zlfrtip',
          initComplete: function() {
              var api = this.api();
              $('#tabelAdmin_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
                "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
              sProcessing: "loading..."
          },
              processing: true,
              serverSide: true,
              ajax: {"url": base_url+"admin/getAdminJson", "type": "POST"},
                columns: [
                      {"data": "username"},
                      {"data": "nama_admin"},
                      {"data": "nama_jenis"},
                      {"data": "mac_address"},
                      {"data": "nama_status"},
                      {"data": "view"},
                ],
                order: [[0, 'asc']],
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    $('td:eq(0)', row).html();
                }

      });

      // reset mac
      $('#tabelAdmin').on('click','.resetAdminMac',function(){
          var username=$(this).data('username');
          $.confirm({
              title: 'Confirm!, Reset Mac Address',
              content: username,
              buttons: {
                  confirm: {
                      text: 'Confirm',
                      btnClass: 'btn-blue',
                      keys: ['enter', 'shift'],
                      action: function(){
                          if(username){
                            $.ajax({
                                type:'POST',
                                url:base_url+'admin/reset_mac',
                                data:'username='+username,
                                success:function(res){
                                  $.alert('Mac Adrress <b>'+username+'</b> telah direset');
                                  $('#tabelAdmin').DataTable().ajax.reload();
                                }
                            });
                          }
                      }
                  },
                  cancel: function () {
                  },
              }
          });
      });


      // block loket
      $('#tabelAdmin').on('click','.blockAdmin',function(){
        var username=$(this).data('username');
        $.confirm({
            title: 'Confirm!, Block Admin',
            content: username,
            buttons: {
                confirm: {
                    text: 'Confirm',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function(){
                        if(username){
                          $.ajax({
                              type:'POST',
                              url:base_url+'admin/block',
                              data:'username='+username,
                              success:function(res){
                                $.alert('Akun <b>'+username+'</b> telah diblock');
                                $('#tabelAdmin').DataTable().ajax.reload();
                              }
                          });
                        }
                    }
                },
                cancel: function () {
                },
            }
        });
      });


      // unblock Loket
      $('#tabelAdmin').on('click','.unblockAdmin',function(){
        var username=$(this).data('username');
        $.confirm({
            title: 'Confirm!, Aktifkan Loket',
            content: username,
            buttons: {
                confirm: {
                    text: 'Confirm',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function(){
                        if(username){
                          $.ajax({
                              type:'POST',
                              url:base_url+'admin/unblock',
                              data:'username='+username,
                              success:function(res){
                                $.alert('Akun <b>'+username+'</b> telah diaktifkan');
                                $('#tabelAdmin').DataTable().ajax.reload();
                              }
                          });
                        }
                    }
                },
                cancel: function () {
                },
            }
        });
      });


      // reset password
      $('#tabelAdmin').on('click','.resetAdminPass',function(){
        var username=$(this).data('username');
        $.confirm({
            title: 'Confirm!, Reset Password',
            content: username,
            buttons: {
                confirm: {
                    text: 'Confirm',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function(){
                        if(username){
                          $.ajax({
                              type:'POST',
                              url:base_url+'admin/reset_pass',
                              data:'username='+username,
                              success:function(res){
                                $.alert('Password <b>'+username+'</b> telah direset menjadi 12345');
                                $('#tabelAdmin').DataTable().ajax.reload();
                              }
                          });
                        }
                    }
                },
                cancel: function () {
                },
            }
        });
      });

    });
}

var showRekap = function() {

  var tgl = $('#rekapDate').val();
  $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
  {
      return {
          "iStart": oSettings._iDisplayStart,
          "iEnd": oSettings.fnDisplayEnd(),
          "iLength": oSettings._iDisplayLength,
          "iTotal": oSettings.fnRecordsTotal(),
          "iFilteredTotal": oSettings.fnRecordsDisplay(),
          "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
          "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
      };
  };

  var table = $("#tabelRekapHistory").DataTable({
      "dom": 'Zlfrtip',
      initComplete: function() {
          var api = this.api();
          $('#tabelRekapHistory_filter input')
              .off('.DT')
              .on('input.DT', function() {
                  api.search(this.value).draw();
          });
      },
          oLanguage: {
            "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
          sProcessing: "loading..."
      },
          processing: true,
          serverSide: true,
          "searching": false,
          "lengthChange": false,
          "bInfo" : false,
          paging: false,
          destroy: true,
          ajax: {"url": base_url+"saldo/getRekapJson", "type": "POST", "data": { "tgl": tgl }},

            columns: [
                  {"data": "view"},
                  {"data": "total"},
                  {"data": "jumlah", render: $.fn.dataTable.render.number(',', '.', '')}
            ],
            order: [[1, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                $('td:eq(0)', row).html();
            }

  });
}

var produkList = function() {

  $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
  {
      return {
          "iStart": oSettings._iDisplayStart,
          "iEnd": oSettings.fnDisplayEnd(),
          "iLength": oSettings._iDisplayLength,
          "iTotal": oSettings.fnRecordsTotal(),
          "iFilteredTotal": oSettings.fnRecordsDisplay(),
          "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
          "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
      };
  };

  var table = $("#tabelProduk").DataTable({
      "dom": 'Zlfrtip',
      initComplete: function() {
          var api = this.api();
          $('#tabelProduk_filter input')
              .off('.DT')
              .on('input.DT', function() {
                  api.search(this.value).draw();
          });
      },
          oLanguage: {
            "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
          sProcessing: "loading..."
      },
          processing: true,
          serverSide: true,
          destroy: true,
          ajax: {"url": base_url+"master/getProdukJson", "type": "POST"},

            columns: [
                  {"data": "nama_lengkap"},
                  {"data": "nama_singkat"},
                  {"data": "jenis"},
                  {"data": "vendor"},
                  {"data": "status"}
            ],
            //order: [[1, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                $('td:eq(0)', row).html();
            }

  });
}

var mutasiList = function() {

  $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
  {
      return {
          "iStart": oSettings._iDisplayStart,
          "iEnd": oSettings.fnDisplayEnd(),
          "iLength": oSettings._iDisplayLength,
          "iTotal": oSettings.fnRecordsTotal(),
          "iFilteredTotal": oSettings.fnRecordsDisplay(),
          "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
          "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
      };
  };

  var table = $("#tabelMutasi").DataTable({
      "dom": 'Zlfrtip',
      initComplete: function() {
          var api = this.api();
          $('#tabelMutasi_filter input')
              .off('.DT')
              .on('input.DT', function() {
                  api.search(this.value).draw();
          });
      },
          oLanguage: {
            "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
          sProcessing: "loading..."
      },
          processing: true,
          serverSide: true,
          destroy: true,
          ajax: {"url": base_url+"mutasi/getMutasiJson", "type": "POST"},
            columns: [
                  {
                    "data": "icon",
                    "className":"details-control"
                  },
                  {"data": "nama_bank"},
                  {"data": "nominal", render: $.fn.dataTable.render.number(',', '.', '')},
                  {"data": "keterangan"},
                  {"data": "tgl_transfer"}
            ],
            order: [[1, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                $('td:eq(0)', row).html();
            }

  });

  $('#tabelMutasi tbody').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var tdi = tr.find("i.fa");
      var row = table.row(tr);

      if (row.child.isShown()) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
          tdi.first().removeClass('fa-minus-square');
          tdi.first().addClass('fa-plus-square');
      }
      else {
          var id = row.data().id;
          if(id){
            row.child(inputMutasi(id)).show();
            tr.addClass('shown');
            tdi.first().removeClass('fa-plus-square');
            tdi.first().addClass('fa-minus-square');
            auto_complete_tiket();
          }
      }
  });
}

var listDbs = function() {
  $(document).ready(function(){
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };

      var table = $("#tabelListDbs").DataTable({
          "dom": 'Zlfrtip',
          initComplete: function() {
              var api = this.api();
              $('#tabelListDbs_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
                "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
              sProcessing: "loading..."
          },
              processing: true,
              serverSide: true,
              ajax: {"url": base_url+"pinjaman/getDbsJson", "type": "POST"},
                columns: [
                      {"data": "group_id"},
                      {"data": "no_telp"},
                      {"data": "nominal", render: $.fn.dataTable.render.number(',', '.', '')},
                      {"data": "tgl"}
                ],
                order: [[3, 'asc']],
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    $('td:eq(0)', row).html();
                }

      });

      // $('#tabelListDbs').on('click','.dbs_ubah',function(){
      //   var id = $(this).data('id');
      //   var group_id = $(this).data('group_id');
      //   $.confirm({
      //       title: 'Bayar',
      //       content: 'Grup Loket : '+group_id,
      //       buttons: {
      //           confirm: function () {
      //             if(id){
      //               $.ajax({
      //                   url:base_url+'pinjaman/setLunas',
      //                   method:'POST',
      //                   data:'id='+id,
      //                   dataType:"json",
      //                   success:function(datas){
      //                     if(datas.msg == 'success') {
      //                       $.alert(datas.print);
      //                       $('#tabelListDbs').DataTable().ajax.reload();
      //                     }
      //                     else {
      //                       $.alert(datas.print);
      //                       $('#tabelListDbs').DataTable().ajax.reload();
      //                     }
      //                   }
      //               });
      //             }
      //           },
      //           cancel: function () {
      //           },
      //       }
      //   });
      // });
    });
}

var listPinjaman = function() {
  $(document).ready(function(){
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };

      var table = $("#tabelListPinjaman").DataTable({
          "dom": 'Zlfrtip',
          initComplete: function() {
              var api = this.api();
              $('#tabelListPinjaman_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
                "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
              sProcessing: "loading..."
          },
              processing: true,
              serverSide: true,
              ajax: {"url": base_url+"pinjaman/getPinjamanJson", "type": "POST"},
                columns: [
                      {"data": "group_id"},
                      {"data": "no_telp"},
                      {"data": "nominal", render: $.fn.dataTable.render.number(',', '.', '')},
                      {"data": "tgl"}
                ],
                order: [[3, 'asc']],
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    $('td:eq(0)', row).html();
                }

      });
    });
}

var JenisProdukList = function(){
  $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
  {
      return {
          "iStart": oSettings._iDisplayStart,
          "iEnd": oSettings.fnDisplayEnd(),
          "iLength": oSettings._iDisplayLength,
          "iTotal": oSettings.fnRecordsTotal(),
          "iFilteredTotal": oSettings.fnRecordsDisplay(),
          "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
          "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
      };
  };

  var table = $("#tabelJenis").DataTable({
      "dom": 'Zlfrtip',
      initComplete: function() {
          var api = this.api();
          $('#tabelJenis_filter input')
              .off('.DT')
              .on('input.DT', function() {
                  api.search(this.value).draw();
          });
      },
          oLanguage: {
            "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
          sProcessing: "loading..."
      },
          processing: true,
          serverSide: true,
          destroy: true,
          ajax: {"url": base_url+"master/getJenisProdukJson", "type": "POST"},

            columns: [
                  // {
                  //     "data": null,
                  //     render: function (data, type, row, meta) {
                  //         return meta.row + meta.settings._iDisplayStart + 1;
                  //     }
                  // },
                  {"data": "nama_jenis"},
                  // {
                  //   data: null,
                  //   className: "center",
                  //   defaultContent: '<a href="javascript:void(0);"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a> | <a href="javascript:void(0);"><i class="fa fa-trash" aria-hidden="true" title="Hapus"></i></a>'
                  // }

            ],
            // order: [[1, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                $('td:eq(0)', row).html();
            }

  });  
}

var VendorList = function(){
  $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
  {
      return {
          "iStart": oSettings._iDisplayStart,
          "iEnd": oSettings.fnDisplayEnd(),
          "iLength": oSettings._iDisplayLength,
          "iTotal": oSettings.fnRecordsTotal(),
          "iFilteredTotal": oSettings.fnRecordsDisplay(),
          "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
          "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
      };
  };

  var table = $("#tabelVendor").DataTable({
      "dom": 'Zlfrtip',
      initComplete: function() {
          var api = this.api();
          $('#tabelVendor_filter input')
              .off('.DT')
              .on('input.DT', function() {
                  api.search(this.value).draw();
          });
      },
          oLanguage: {
            "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
          sProcessing: "loading..."
      },
          processing: true,
          serverSide: true,
          destroy: true,
          ajax: {"url": base_url+"master/getVendorJson", "type": "POST"},

            columns: [
                  // {
                  //     "data": null,
                  //     render: function (data, type, row, meta) {
                  //         return meta.row + meta.settings._iDisplayStart + 1;
                  //     }
                  // },
                  {"data": "nama_vendor"},
                  {"data": "kode_vendor"},

            ],
            // order: [[1, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                $('td:eq(0)', row).html();
            }

  });  
}


var BiayaAdminList = function(){
  $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
  {
      return {
          "iStart": oSettings._iDisplayStart,
          "iEnd": oSettings.fnDisplayEnd(),
          "iLength": oSettings._iDisplayLength,
          "iTotal": oSettings.fnRecordsTotal(),
          "iFilteredTotal": oSettings.fnRecordsDisplay(),
          "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
          "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
      };
  };

  var table = $("#tabelBiayaAdmin").DataTable({
      "dom": 'Zlfrtip',
      initComplete: function() {
          var api = this.api();
          $('#tabelBiayaAdmin_filter input')
              .off('.DT')
              .on('input.DT', function() {
                  api.search(this.value).draw();
          });
      },
          oLanguage: {
            "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
          sProcessing: "loading..."
      },
          processing: true,
          serverSide: true,
          destroy: true,
          ajax: {"url": base_url+"master/getBiayaAdminJson", "type": "POST"},

            columns: [
                  // {
                  //     "data": null,
                  //     render: function (data, type, row, meta) {
                  //         return meta.row + meta.settings._iDisplayStart + 1;
                  //     }
                  // },
                  {"data": "kode_produk"},
                  {"data": "nominal_admin_bank", render: $.fn.dataTable.render.number(',', '.', '')},
                  {
                    "data": "tgl_create"
                  }

            ],
            // order: [[1, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                $('td:eq(0)', row).html();
            }

  });  
}

var PengumumanList = function(){
  $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
  {
      return {
          "iStart": oSettings._iDisplayStart,
          "iEnd": oSettings.fnDisplayEnd(),
          "iLength": oSettings._iDisplayLength,
          "iTotal": oSettings.fnRecordsTotal(),
          "iFilteredTotal": oSettings.fnRecordsDisplay(),
          "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
          "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
      };
  };

  var table = $("#tabelPengumuman").DataTable({
      "dom": 'Zlfrtip',
      initComplete: function() {
          var api = this.api();
          $('#tabelPengumuman_filter input')
              .off('.DT')
              .on('input.DT', function() {
                  api.search(this.value).draw();
          });
      },
          oLanguage: {
            "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
          sProcessing: "loading..."
      },
          processing: true,
          serverSide: true,
          destroy: true,
          ajax: {"url": base_url+"master/getPengumumanJson", "type": "POST"},

            columns: [
                  // {
                  //     "data": null,
                  //     render: function (data, type, row, meta) {
                  //         return meta.row + meta.settings._iDisplayStart + 1;
                  //     }
                  // },
                  {"data": "judul"},
                  {"data": "isi"},
                  {"data": "tgl_update"},

            ],
            // order: [[1, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                $('td:eq(0)', row).html();
            }

  });  
}

var laporanHarian=function(){
    if ($.fn.DataTable.isDataTable('#tabelTransaksiHarian')) {
        $('#tabelTransaksiHarian').DataTable().destroy();
    }

    $(document).ready(function(){
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };

      var dari  = $("input[name=fromT]").val();
      var sampai= $("input[name=toT]").val();

      console.log(dari);

      var table = $("#tabelTransaksiHarian").DataTable({
          "dom": 'Zlfrtip',
          initComplete: function() {
              var api = this.api();
              $('#tabelTransaksiHarian_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },

          oLanguage: {
            "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
            sProcessing: "loading..."
          },          

              bInfo: false,
              bPaginate: false,
              processing: true,
              serverSide: true,
              ajax: {
                  "url": base_url+"laporan/transaksiHarian",
                  "type": "POST",
                  "data": { dari: dari, sampai: sampai },      
                  },         
                columns: [
                      {
                          "data": "username",
                          defaultContent: '-'
                      },
                      {
                        "data": "PDAM",
                        defaultContent: '-',
                        className: "sum"
                      },
                      {
                        "data": "TotalTagihan_PDAM",
                        render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ),
                        defaultContent: '-',
                        className: "sum"
                      },
                      {
                          "data": "PLN",
                          defaultContent: '-',
                          className: "sum"
                      },
                      {
                          "data": "TotalTagihan_PLN",
                          render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ),
                          defaultContent: '-',
                          className: "sum"
                      }
                ],
                "footerCallback": function(row, data, start, end, display) {
                    console.log('in footerCallback');
                    // var api = this.api(),;

                    var api = this.api(),
                    intVal = function (i) {
                      return typeof i === 'string' ?
                        i.replace(/[. Rp]|(\.\d{2})/g, "") * 1 :
                        typeof i === 'number' ?
                          i : 0;
                    };


                  api.columns('.sum', { page: 'current' }).every(function () {
                    var sum = api
                        .cells( null, this.index(), { page: 'current'} )
                        .render('display')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                          }, 0);
                    console.log(this.index() +' '+ sum); //alert(sum);
                    var numFormat = $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ).display;

                    if(this.index()==2||this.index()==4){
                        $(this.footer()).html(numFormat(sum));
                    }else{
                        $(this.footer()).html(sum);
                    }
                });

                }
                // rowCallback: function(row, data, iDisplayIndex) {
                //     var info = this.fnPagingInfo();
                //     var page = info.iPage;
                //     var length = info.iLength;
                //     $('td:eq(0)', row).html();
                // }

      });      

    });

}

var laporanPeriode=function(){
    if ($.fn.DataTable.isDataTable('#tabelTransaksiPeriode')) {
        $('#tabelTransaksiPeriode').DataTable().destroy();
    }

    $(document).ready(function(){
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };
      var dari  = $("input[name=fromT]").val();
      var sampai= $("input[name=toT]").val();

      console.log(dari);

      var tablePeriode = $("#tabelTransaksiPeriode").DataTable({
          "dom": 'Zlfrtip',
          initComplete: function() {
              var api = this.api();
              $('#tabelTransaksiPeriode_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
                  "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
                  sProcessing: "loading..."
              },
              bInfo: false,
              bPaginate: false,
              processing: true,
              serverSide: true,
              ajax: {
                  "url": base_url+"laporan/transaksiPerPeriode",
                  "type": "POST",
                  "data": { dari: dari, sampai: sampai },
                },
                columns: [
                      {
                          "data": "tgl_transaksi",
                          defaultContent: '-',
                      },
                      {
                        "data": "PDAM",
                        defaultContent: '-',
                        className: "sum"
                    },
                    {
                        "data": "TotalTagihan_PDAM",
                        defaultContent: '-',
                        className: "sum",
                        render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ),
                    },
                      {
                          "data": "PLN",
                          defaultContent: '-',
                          className: "sum"
                      },
                      {
                          "data": "TotalTagihan_PLN",
                          render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ),
                          defaultContent: '-',
                          className: "sum"
                      }

                ],
                "footerCallback": function(row, data, start, end, display) {
                    console.log('in footerCallback');
                    // var api = this.api(),;

                    var api = this.api(),
                    intVal = function (i) {
                      return typeof i === 'string' ?
                        i.replace(/[. Rp]|(\.\d{2})/g, "") * 1 :
                        typeof i === 'number' ?
                          i : 0;
                    };


                  api.columns('.sum', { page: 'current' }).every(function () {
                    var sum = api
                        .cells( null, this.index(), { page: 'current'} )
                        .render('display')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                          }, 0);
                    console.log(this.index() +' '+ sum); //alert(sum);
                    var numFormat = $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ).display;

                    if(this.index()==2||this.index()==4){
                        $(this.footer()).html(numFormat(sum));
                    }else{
                        $(this.footer()).html(sum);
                    }
                });

                }
                // rowCallback: function(row, data, iDisplayIndex) {
                //     var info = this.fnPagingInfo();
                //     var page = info.iPage;
                //     var length = info.iLength;
                //     $('td:eq(0)', row).html();
                // }

      });

    });
}

var laporanHarianDetail=function(){
    if ($.fn.DataTable.isDataTable('#tabelTransaksiHarianDetail')) {
        $('#tabelTransaksiHarianDetail').DataTable().destroy();
    }

    $(document).ready(function(){
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };

      var dari  = $("input[name=inptDari]").val();
      var sampai= $("input[name=inptSampai]").val();

      console.log(dari);

      var table = $("#tabelTransaksiHarianDetail").DataTable({
          "dom": 'Zlfrtip',
          initComplete: function() {
              var api = this.api();
              $('#tabelTransaksiHarianDetail_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
                  "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
                  sProcessing: "loading..."
              },
              bInfo: true,
              bPaginate: true,
              processing: true,
              serverSide: true,
              ajax: {
                  "url": base_url+"laporan/transaksiHarianDetail",
                  "type": "POST",
                  "data": { dari: dari, sampai: sampai },               
                },
                columns: [
                      {"data": "id_pelanggan"},
                      {"data": "nama_pelanggan"},
                      {"data": "tgl_transaksi"},
                      {"data": "lembar"},
                      {
                          "data": "jumlah_tagihan",
                          render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' )
                      },
                      {
                          "data": "biaya_admin",
                          render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' )
                      },
                      {
                          "data":"total_tagihan",
                           render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' )
                      },
                      {"data":"nama_lengkap"}
                ],
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    $('td:eq(0)', row).html();
                }

      });
    });
}

var laporaGriyaPerTgl=function(){
    if ($.fn.DataTable.isDataTable('#tabelTransaksiGriyaPerTgl')) {
        $('#tabelTransaksiGriyaPerTgl').DataTable().destroy();
    }

    $(document).ready(function(){
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };
      var dari  = $("input[name=fromT]").val();
      var sampai= $("input[name=inptSampai]").val();

      console.log(dari);

      var tablePerTgl = $("#tabelTransaksiGriyaPerTgl").DataTable({
          "dom": 'Zlfrtip',
          initComplete: function() {
              var api = this.api();
              $('#tabelTransaksiGriyaPerTgl_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
                  "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
                  sProcessing: "loading..."
              },
              bInfo: false,
              bPaginate: true,
              processing: true,
              serverSide: true,
              ajax: {
                  "url": base_url+"laporan/transaksiGriyaBayarPerTgl",
                  "type": "POST",
                  "data": { dari: dari, sampai: sampai },
                },
                columns: [
                      {
                          "data": "tanggal",
                          defaultContent: '-',
                          // render: function(d){
                          //   return moment(d).format("DD/MMM/YYYY");
                          // },
                      },
                      {
                        "data": "PDAM",
                        defaultContent: '-',
                        className: "sum"
                    },
                    {
                        "data": "TotalTagihan_PDAM",
                        defaultContent: '-',
                        className: "sum",
                        render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ),
                    },
                      {
                          "data": "PLN",
                          defaultContent: '-',
                          className: "sum"
                      },
                      {
                          "data": "TotalTagihan_PLN",
                          render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ),
                          defaultContent: '-',
                          className: "sum"
                      }

                ],
                "footerCallback": function(row, data, start, end, display) {
                    console.log('in footerCallback');
                    // var api = this.api(),;

                    var api = this.api(),
                    intVal = function (i) {
                      return typeof i === 'string' ?
                        i.replace(/[. Rp]|(\.\d{2})/g, "") * 1 :
                        typeof i === 'number' ?
                          i : 0;
                    };


                  api.columns('.sum', { page: 'current' }).every(function () {
                    var sum = api
                        .cells( null, this.index(), { page: 'current'} )
                        .render('display')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                          }, 0);
                    console.log(this.index() +' '+ sum); //alert(sum);
                    var numFormat = $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ).display;

                    if(this.index()==2||this.index()==4){
                        $(this.footer()).html(numFormat(sum));
                    }else{
                        $(this.footer()).html(sum);
                    }
                });

                }
                // rowCallback: function(row, data, iDisplayIndex) {
                //     var info = this.fnPagingInfo();
                //     var page = info.iPage;
                //     var length = info.iLength;
                //     $('td:eq(0)', row).html();
                // }

      });

    });
}

var laporaGriyaPerUser=function(){
    if ($.fn.DataTable.isDataTable('#tabelTransaksiGriyaBayarPerUser')) {
        $('#tabelTransaksiGriyaBayarPerUser').DataTable().destroy();
    }

    $(document).ready(function(){
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };

      var dari  = $("input[name=fromT]").val();
      var sampai= $("input[name=inptSampai]").val();

      var table = $("#tabelTransaksiGriyaBayarPerUser").DataTable({
          "dom": 'Zlfrtip',
          initComplete: function() {
              var api = this.api();
              $('#tabelTransaksiGriyaBayarPerUser_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
                  "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json",
                  sProcessing: "loading..."
              },
              bInfo: false,
              bPaginate: true,
              processing: true,
              serverSide: true,
              ajax: {
                  "url": base_url+"laporan/transaksiGriyaBayarPerUser",
                  "type": "POST",
                  "data": { dari: dari, sampai: sampai },
                },
                columns: [
                      {
                          data: "nama",
                          // orderable: false,
                          orderClasses: false,
                          defaultContent: '-',
                          render: function ( data, type, row, meta ) {
                                  return '<a href="javascript:void(0);" data-nama="'+ data +'" title="Detail"><i class="fa fa-caret-right" aria-hidden="true"></i></a>';
                          },
                          className: "details-control"
                      },
                      {
                          data: "nama",
                          defaultContent: '-',
                          // className: "details-control"
                      },
                      {
                        data: "PDAM",
                        defaultContent: '-',
                        className: "sum"
                      },
                      {
                        "data": "TotalTagihan_PDAM",
                        render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ),
                        defaultContent: '-',
                        className: "sum"
                      },
                      {
                          "data": "PLN",
                          defaultContent: '-',
                          className: "sum"
                      },
                      {
                          "data": "TotalTagihan_PLN",
                          render: $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ),
                          defaultContent: '-',
                          className: "sum"
                      }
                ],
                "footerCallback": function(row, data, start, end, display) {
                    console.log('in footerCallback');
                    // var api = this.api(),;

                    var api = this.api(),
                    intVal = function (i) {
                      return typeof i === 'string' ?
                        i.replace(/[. Rp]|(\.\d{2})/g, "") * 1 :
                        typeof i === 'number' ?
                          i : 0;
                    };


                  api.columns('.sum', { page: 'current' }).every(function () {
                    var sum = api
                        .cells( null, this.index(), { page: 'current'} )
                        .render('display')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                          }, 0);
                    console.log(this.index() +' '+ sum); //alert(sum);
                    var numFormat = $.fn.dataTable.render.number( '.', ',', 0,'Rp ' ).display;

                    if(this.index()==3||this.index()==5){
                        $(this.footer()).html(numFormat(sum));
                    }else{
                        $(this.footer()).html(sum);
                    }
                });

                }
                // rowCallback: function(row, data, iDisplayIndex) {
                //     var info = this.fnPagingInfo();
                //     var page = info.iPage;
                //     var length = info.iLength;
                //     $('td:eq(0)', row).html();
                // }

      });

    });

    $('#tabelTransaksiGriyaBayarPerUser tbody').on('click', 'td.details-control', function () {
        var table = $('#tabelTransaksiGriyaBayarPerUser').DataTable();
        var tr = $(this).closest('tr');
        var tdi = tr.find("i.fa");
        var row = table.row(tr);
        // var nama = row.data().nama;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
            tdi.first().removeClass('fa-caret-down');
            tdi.first().addClass('fa-caret-right');
        }
        else {
            var nama = row.data().nama;
            if(nama){
                $.ajax({
                    type:'POST',
                    url:base_url+'laporan/infoExtra',
                    data:'nama='+nama,
                    dataType:'json',
                    success:function(res){
                      row.child(formatgriya(res)).show();
                      //console.log(res.nama);
                      tr.addClass('shown');
                      tdi.first().removeClass('fa-caret-right');
                      tdi.first().addClass('fa-caret-down');
                    }
                });
            }
        }
        console.log(nama);
        // console.log(nama);
    });

}