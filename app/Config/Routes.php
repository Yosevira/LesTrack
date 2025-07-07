<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::login');              // Halaman awal langsung ke login
$routes->get('login', 'Auth::login');          // Route GET untuk /login
$routes->get('register', 'Auth::register');    // Halaman register
$routes->post('auth/login', 'Auth::doLogin');  // Proses login
$routes->post('auth/register', 'Auth::doRegister'); // Proses register
$routes->get('logout', 'Auth::logout');        // Logout


$routes->get('/ortu/dashboard', 'Ortu::dashboard');
$routes->get('/guru/dashboard', 'Guru::dashboard');

//halaman jadwal
$routes->get('ortu/jadwal', 'Ortu::jadwal'); 
$routes->post('ortu/jadwal/add', 'Ortu::tambahJadwal');
$routes->post('ortu/jadwal/add', 'Ortu::tambahJadwal');
$routes->get('ortu/jadwal/edit/(:any)', 'Ortu::editJadwalHari/$1'); // 'Senin', 'Selasa', dst
$routes->post('ortu/jadwal/update', 'Ortu::updateJadwal');
$routes->get('ortu/jadwal/delete/(:num)', 'Ortu::hapusMapel/$1');

//halaman tugas
$routes->get('ortu/tugas', 'Ortu::tugas');
$routes->post('ortu/tugas/add', 'Ortu::tambahTugas');
$routes->get('ortu/tugas/delete/(:num)', 'Ortu::hapusTugas/$1');
$routes->get('ortu/tugas/edit/(:num)', 'Ortu::editTugas/$1');
$routes->post('ortu/tugas/update/(:num)', 'Ortu::updateTugas/$1');
$routes->get('/ortu/tugas/detail/(:num)', 'Ortu::detailTugas/$1');

$routes->get('ortu/profil', 'Ortu::profil');
$routes->get('ortu/profil/edit', 'Ortu::editProfil'); // Menampilkan form edit profil
$routes->post('ortu/profil/update', 'Ortu::updateProfil');

//guru
$routes->get('/guru/siswa/(:num)', 'Guru::detailSiswa/$1');
$routes->get('/guru/tugas/(:num)', 'Guru::tugas/$1'); // lihat tugas siswa
$routes->post('/guru/tugas/update', 'Guru::updateTugas'); // update status + bukti
$routes->get('/guru/siswa/(:num)', 'Guru::detailSiswa/$1');  // untuk jadwal
$routes->get('/guru/tugas/(:num)', 'Guru::tugas/$1');        // untuk tugas
$routes->get('guru/tugas', 'Guru::tugas');

$routes->get('/guru/absensi', 'Guru::absensi');
$routes->post('/guru/absensi/simpan', 'Guru::simpanAbsensi');
$routes->get('guru/absensi', 'Guru::absensi');
$routes->get('guru/absensi/(:num)/(:num)', 'Guru::absensi/$1/$2');
$routes->post('guru/simpanAbsensiPopup', 'Guru::simpanAbsensiPopup');

//password hash
$routes->get('/hash', 'Hash::index');
$routes->post('/hash/generate', 'Hash::generate');
$routes->get('buatpassword', 'Auth::buatPassword');