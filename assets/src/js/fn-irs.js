'use strict'
window.data_pulsa = {};

var this_chooser = {};

function setOptionalComboProduct(tools, data) 
{  
    tools.empty();
    $('<option>').val('-').text('-- DAFTAR NAMA PRODUK IRS --').appendTo(tools);
    $.each(data, function( i, v ) {
        $('<option>').val(v.kode_produk).text(v.nama_produk + ', ('+v.nominal+')').appendTo(tools);
    });
}

function setOptionalComboOperator(tools, data) 
{  
    tools.empty();
    $('<option>').val('-').text('-- PILIH OPERATOR --').appendTo(tools);
    $.each(data, function( i, v ) {
        $('<option>').val(v).text(i.toUpperCase()).appendTo(tools);
    });
}

function ConvertNumberToCurrency(currencies) {
    currencies = parseInt(currencies);

    var	number_string = currencies.toString(),
	    sisa 	= number_string.length % 3,
	    rupiah 	= number_string.substr(0, sisa),
	    ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

    if (ribuan) {
    	var separator = sisa ? '.' : '';
    	rupiah += separator + ribuan.join('.');
    }

    return rupiah;
}

function CalculatePlusInteger(numeric_1, numeric_2) {  
    return numeric_1 + numeric_2;
}

function AlertError(messages, title='')
{
    $.alert({
        title : (title == '') ? 'WARNING' : title ,
        content : messages,
        theme : 'modern',
        type : (title == '') ? 'orange' : 'red'
    });
}

function AlertSuccess(messages, title=''){
    $.alert({
        title : (title == '') ? 'SUCCESS' : title,
        content : messages,
        theme : 'modern',
        type : 'blue'
    });
}

$(function () {
    
    var pilihKategoriProduk = $('select[name=pilihKategoriProduk]'),
        pilihOperatorIRS    = $('select[name=pilihOperatorIRS]'), 
        pilihDaftarProdukIRS= $('select[name=pilihDaftarProdukIRS]');

    var txtNamaProdukIRS    = $('#txtNamaProdukIRS'),
        txtNamaLainProduk   = $('#txtNamaLainProduk'),
        txtKodeProdukIRS    = $('#txtKodeProdukIRS'),
        txtAliasKodeProduk  = $('#txtAliasKodeProduk');

    var txtNominalProduk    = $('#txtNominalProduk'),
        txtHargaProdukIRS   = $('#txtHargaProdukIRS'),
        txtSetMarkup        = $('#txtSetMarkup'),
        txtHargaJual        = $('#txtHargaJual');

    var tambahProdukIRS = $('#tambahProdukIRS'), resetProdukIRS  = $('#resetProdukIRS');
    var frmAddProduk = $('#frmAddProduk');

    /** Event Click Pilih Kategori Produk */
    pilihKategoriProduk.change(function (e) { 
        e.preventDefault();
        var jenis = $(this).val();
        var url = window.siteurl + 'master/pilih/jenis/irs/'+jenis;

        if(jenis != '-'){
            $.getJSON(url, function( data ) {
                if(data.status == true)
                {
                    this_chooser.jenis_produk = jenis;
                    pilihOperatorIRS.prop("disabled", false);
                    setOptionalComboOperator(pilihOperatorIRS, data.messages); 
                }
                else
                    AlertError(data.messages.toUpperCase(), 'ERROR IN SYSTEM IRS');
            });
        }
        else{
            AlertError('Silahkan Pilih Jenis Produk IRS');
        }
        
    });

    /** Event Click Pilih Operator IRS */
    pilihOperatorIRS.change(function (e) { 
        e.preventDefault();
        var operator_value = pilihOperatorIRS.val();
        var operator_id = operator_value.split(',');
        var url = window.siteurl + 'data/produk/irs/by/operator';

        var opt_selected = $('#pilihOperatorIRS option:selected').text(); 

        $.ajax({
            url: url,
            dataType: 'json',
            type: 'post',
            contentType: 'application/json',
            data: JSON.stringify( { "operator_id": operator_id } ),
            success: function( response ){
                console.log(response);
                if(response.status == true)
                {
                    window.data_pulsa = response.messages;
                    pilihDaftarProdukIRS.prop("disabled", false); 
                    setOptionalComboProduct(pilihDaftarProdukIRS, response.messages); 
                    this_chooser.nama_operator = opt_selected;
                }
                else{
                    pilihDaftarProdukIRS.prop("disabled", true); 
                    AlertError('Produk Pulsa Dari Operator '+ opt_selected + ' Tidak Tersedia', 'ALERT ERROR');
                }
            }
        });

    });

    /** Event Click Pilih Daftar Produk IRS */
    pilihDaftarProdukIRS.change(function (e) { 
        e.preventDefault();
        
        var pulsa = window.data_pulsa;
        var pilihan = pilihDaftarProdukIRS.val();
        
        $.each(pulsa, function (i, v) { 
            if(v.kode_produk == pilihan)
            {
                txtNamaProdukIRS.val(v.nama_produk);
                txtKodeProdukIRS.val(v.kode_produk);
                txtNominalProduk.val(ConvertNumberToCurrency(v.nominal * 1000));
                txtHargaProdukIRS.val(ConvertNumberToCurrency(v.harga_produk));

                this_chooser.nama_produk_irs = v.nama_produk;
                this_chooser.nama_terminal_irs = v.nama_terminal;
                this_chooser.kode_produk_irs = v.kode_produk;
                this_chooser.harga_produk = parseInt(v.harga_produk);
                this_chooser.nominal = parseInt(v.nominal);

                return false;
            }
        });

    });

    txtSetMarkup.keypress(function (e) { 
        if (e.which == 13) {
            var harga_jual = CalculatePlusInteger(parseInt($(this).val()), this_chooser.harga_produk);
            this_chooser.harga_markup = parseInt($(this).val());
            this_chooser.harga_jual = harga_jual;

            txtHargaJual.val(ConvertNumberToCurrency(harga_jual));
        }
    });

    tambahProdukIRS.click(function (e) { 
        e.preventDefault();
        var bools = true;

        this_chooser.nama_lain_produk = txtNamaLainProduk.val();
        this_chooser.nama_alias_kode = txtAliasKodeProduk.val();

        var url = window.siteurl + 'tambah/product/irs';
    
        if(txtNamaLainProduk.val() != '' && txtAliasKodeProduk.val() != ''){
            this_chooser.nama_lain_produk = txtNamaLainProduk.val();
            this_chooser.nama_alias_kode = txtAliasKodeProduk.val()

            var url = window.siteurl + 'tambah/product/irs';

            $.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                contentType: 'application/json',
                data: JSON.stringify( this_chooser ),
                success: function( response ){
                    if(response.status == true)
                        AlertSuccess(response.messages, 'INFORMASI SUKSES');
                    else
                        AlertError(response.messages, 'INSERT PRODUK IRS GAGAL');

                    frmAddProduk[0].reset();
                }
            });

        }
        else {
            AlertError(' "Nama Lain Dari Produk IRS" dan  "Nama Alias Dari Kode Produk IRS" Harus Diisi');
        }

    });

 });