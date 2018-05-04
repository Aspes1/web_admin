<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['login']                         = 'Login';
$route['dashboard']                     = 'Dashboard';

$route['loket']                         = 'Loket/index';
$route['loket/create']                  = 'Loket/addLoketPage';
$route['loket/list']                    = 'Loket/listLoketPage';

$route['laporan']                       	= 'Laporan/index';
$route['laporan/transaksi']             	= 'Laporan/addTransaksiPage';
$route['laporan/transaksiHarian']         	= 'Laporan/laporanHarian';
$route['laporan/transaksiperiode']			= 'Laporan/addTransaksiPagePeriode';
$route['laporan/transaksiPerPeriode']   	= 'Laporan/laporanPeriode';
$route['laporan/transaksiharian_detail']	= 'Laporan/addTransaksiPageHarianDetail';
$route['laporan/transaksiHarianDetail']   	= 'Laporan/laporanHarianDetail';
$route['laporan/transaksigriyabayar']     	= 'Laporan/addTransaksiPageGriyaBayar';
$route['laporan/transaksipertanggal']  		= 'Laporan/transaksi_per_tanggal';
$route['laporan/transaksiGriyaBayarPerTgl']	= 'Laporan/transaksiGriyaBayarPerTgl';
$route['laporan/transaksiperuser']  		= 'Laporan/transaksi_per_user';
$route['laporan/transaksiGriyaBayarPerUser']= 'Laporan/transaksiGriyaBayarPerUser';
$route['laporan/importdata']  				= 'Laporan/import_data';
$route['laporan/upload_csv']  				= 'Laporan/UploadCsv';

$route['laporan/transaksibukopin']  		        = 'Laporan/TransaksiBukopin';
$route['laporan/transaksi_per_tanggal_bukopin']     = 'Laporan/TransaksiPerTglBukopin';
$route['laporan/transaksi_per_user_bukopin']        = 'Laporan/TransaksiPerUserBukopin';
$route['laporan/importfilebukopin']                 = 'Laporan/ImportFileBukopin';
$route['laporan/upload_file_bukopin']               = 'Laporan/UploadFileBukopin';
$route['laporan/load_trx_per_tgl_bukopin']          = 'Laporan/LoadTrxPertglBukopin';
$route['laporan/load_trx_per_user_bukopin']         = 'Laporan/LoadTrxPerUserBukopin';
$route['laporan/detail_trx_loket_bukopin']          = 'Laporan/DetailTrxLoketBukopin';

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

$route['master']                        = 'Master/index';
$route['master/produk']               	= 'Master/produkPage';
$route['master/tambah']               	= 'Master/AddProdukPage';
$route['master/create_produk']          = 'Master/CreateProduk';
$route['master/edit']          			= 'Master/EditPodukModal';
$route['master/update_produk']			= 'Master/UpdateProduk';
$route['master/delete']					= 'Master/DeleteProduk';
$route['master/block']					= 'Master/BlockProduk';
$route['master/aktifkan']				= 'Master/AktifProduk';
$route['master/tambah_produk_irs']      = 'Master/AddProdukIRS';

$route['master/jenis']               	= 'Master/jenisPage';
$route['master/tambah_jenis_produk']    = 'Master/AddJeniskPage';
$route['master/create_jenis_produk']    = 'Master/CreateJenisProduk';
$route['master/edit_jenis_produk']    	= 'Master/EditJenisPodukModal';
$route['master/update_jenis_produk']    = 'Master/UpdateJenisProduk';
$route['master/delete_jenis']    		= 'Master/DeleteJenis';

$route['master/vendor']               	= 'Master/vendorPage';
$route['master/tambah_vendor']          = 'Master/AddVendorPage';
$route['master/create_vendor']          = 'Master/CreateVendor';
$route['master/edit_vendor']          	= 'Master/EditVendorModal';
$route['master/update_vendor']         	= 'Master/UpdateVendor';
$route['master/delete_vendor']         	= 'Master/DeleteVendor';

$route['master/biaya']          		= 'Master/BiayaAdminPage';
$route['master/tambah_biaya']          	= 'Master/AddBiayaAdminPage';
$route['master/create_biaya_admin']     = 'Master/CreateBiayaAdmin';
$route['master/edit_biaya']     		= 'Master/EditBiayaAdminModal';
$route['master/update_biaya_admin']    	= 'Master/UpdateBiaya';
$route['master/delete_biaya_admin']    	= 'Master/DeleteBiaya';

$route['master/pengumuman']     		= 'Master/pengumumanPage';
$route['master/tambah_pengumuman']     	= 'Master/AddPengumumanPage';
$route['master/create_pengumuman']     	= 'Master/CreatePengumuman';
$route['master/edit_pengumuman']     	= 'Master/EditPengumumanModal';
$route['master/update_pengumuman']     	= 'Master/UpdatePengumuman';
$route['master/delete_pengumuman']     	= 'Master/DeletePengumuman';

$route['master/komisi']     	        = 'Master/KomisiPage';
$route['master/tambah_komisi']     	    = 'Master/addKomisiPage';
$route['master/create_komisi']     	    = 'Master/CreateKomisi';
$route['master/edit_komisi']     	    = 'Master/EditKomisiModal';

$route['master/daftar_harga']     	    = 'Master/DaftarHarga';
$route['master/tambah_daftar_harga']    = 'Master/TambahDaftarHarga';
$route['master/create_daftar_harga']    = 'Master/CreateDaftarHarga';
$route['master/edit_harga']             = 'Master/EditHarga';
$route['master/update_daftar_harga']    = 'Master/UpdateHarga';
$route['master/delete_harga']           = 'Master/DeleteHarga';
$route['master/block_harga']            = 'Master/BlockHarga';
$route['master/aktif_harga']            = 'Master/AktifHarga';

$route['komisi']                = 'Komisi/index';
$route['komisi/daftar_komisi']  = 'Komisi/DaftarKomisi';
$route['komisi/hitungkomisi']   = 'Komisi/getJsonLaporanKomisi';

$route['storageupload'] = 'Testuploadstorage/index';

$route['error_550'] = 'Error';


/** IRS Service Route */
$route['master/single/update/harga/irs'] = 'Master/SingleUpdateProductIRS';
$route['master/pilih/jenis/irs/(:any)'] = 'Master/getListIRSOperatorByCategory/$1';
$route['master/irs/update/harga/produk'] = 'Master/UpdateAllPriceProductIRS';
$route['data/produk/irs/by/operator'] = 'Master/getListProductByOperator';
$route['tambah/product/irs'] = 'Master/TambahDataProdukIRS';



$route['default_controller'] = $route['login'];
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
