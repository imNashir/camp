<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */

// default
$routes->get('/', 'Auth::index');

// auth
$routes->group('auth', static function ($routes) {
	$routes->post('login', 'Auth::login');
	$routes->get('logout', 'Auth::logout');
});

// dashboard`
$routes->group('dashboard', static function ($routes) {
	$routes->get('/', 'Dashboard::index');
});

//alat
$routes->group('alat', static function ($routes) {
	$routes->get('/', 'Alat::index');
	$routes->get('tambah', 'Alat::tambahAlat');
	$routes->post('simpan', 'Alat::simpanAlat');
	$routes->get('delete/(:num)', 'Alat::hapusAlat/$1');
	$routes->get('edit/(:num)', 'Alat::editAlat/$1');
	$routes->post('update/(:num)', 'Alat::updateAlat/$1');

	$routes->get('detail/(:num)', 'Alat::detailAlat/$1');
	$routes->get('rep-alat-habis', 'Alat::cetakAlatHabis');
	$routes->get('data-alat', 'Alat::dataAlat');
});

//kategori
$routes->group('kategori', static function ($routes) {
	$routes->get('/', 'Kategori::index');
	$routes->get('tambah', 'Kategori::tambahKategori');
	$routes->delete('(:num)', 'Kategori::hapusKategori/$1');
	$routes->post('simpan', 'Kategori::simpanKategori');
	$routes->get('edit/(:num)', 'Kategori::editKategori/$1');
	$routes->post('update/(:num)', 'Kategori::updateKategori/$1');
	$routes->get('data-kategori', 'Kategori::dataKategori');
});

//transaksi
$routes->group('transaksi', static function ($routes) {
	$routes->get('/', 'transaksiAlat::index');
	$routes->get('admin', 'transaksiAlat::indexs');
	$routes->get('tambah', 'transaksiAlat::tambahTransAlat');
	$routes->post('simpan', 'transaksiAlat::simpanTransAlat');
	$routes->get('delete/(:num)', 'transaksiAlat::hapusTransAlat/$1');
	$routes->get('rep-transaksi', 'transaksiAlat::repTrans');
	$routes->get('filtered-data', 'transaksiAlat::filter');
	$routes->get('adm', 'transaksiAlat::dataTransAlat_adm');
	$routes->get('plg', 'transaksiAlat::dataTransAlat_plg');
});
$routes->post('transaksi/update_status/(:num)', 'transaksiAlat::update_status/$1');
$routes->post('transaksi/update/(:num)', 'transaksiAlat::update/$1');


//pengembalian
$routes->group('pengembalian', static function ($routes) {
	$routes->get('/', 'pengembalianAlat::index');
	$routes->get('admin', 'pengembalianAlat::indexs');
	$routes->get('tambah', 'pengembalianAlat::tambahPengembAlat');
	$routes->post('simpan', 'pengembalianAlat::simpanPengembAlat');
	$routes->get('delete/(:num)', 'pengembalianAlat::hapusPengembAlat/$1');
	$routes->get('rep-pengembalian', 'pengembalianAlat::repPengemb');
	$routes->get('filtered-data', 'pengembalianAlat::filterData');
	$routes->get('adm', 'pengembalianAlat::dataPengembAlat_adm');
	$routes->get('plg', 'pengembalianAlat::dataPengembAlat_plg');
});

//user
$routes->group('user', static function ($routes) {
	$routes->get('/', 'User::index');
	$routes->get('tambah', 'User::tambahUser');
	$routes->post('simpan', 'User::simpanUser');
	$routes->get('edit/(:num)', 'User::editUser/$1');
	$routes->post('update/(:num)', 'User::updateUser/$1');
	$routes->delete('(:num)', 'User::hapusUser/$1');
	$routes->get('ubah-password', 'User::ubahPassword');
	$routes->post('ubah-password', 'User::updatePassword');
	$routes->get('data-user', 'User::dataUser');
});
