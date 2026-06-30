<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing page (guest) / Dashboard (logged-in)
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::dashboard');

// Auth
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::registerProcess');
$routes->get('/logout', 'AuthController::logout');

// Generate Soal (wizard)
$routes->get('/generate-soal', 'GenerateSoal::index');
$routes->post('/generate-soal/process', 'GenerateSoal::process');

// Bank Soal
$routes->get('/bank-soal', 'BankSoal::index');
$routes->post('/bank-soal/simpan', 'BankSoal::simpan');
$routes->get('/bank-soal/detail/(:num)', 'BankSoal::detail/$1');
$routes->post('/bank-soal/hapus/(:num)', 'BankSoal::hapus/$1');

// Admin — hanya untuk role admin
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('users', 'AdminController::users');
    $routes->post('users/hapus/(:num)', 'AdminController::hapusUser/$1');
    $routes->get('bank-soal', 'AdminController::bankSoal');
    $routes->get('bank-soal/detail/(:num)', 'AdminController::bankSoalDetail/$1');
    $routes->post('bank-soal/hapus/(:num)', 'AdminController::hapusSoal/$1');
});

// Pengaturan - sub pages
$routes->get('/pengaturan', 'Pengaturan::index');
$routes->get('/pengaturan/profil', 'Pengaturan::profil');
$routes->post('/pengaturan/profil', 'Pengaturan::profilUpdate');
$routes->get('/pengaturan/sandi', 'Pengaturan::sandi');
$routes->post('/pengaturan/sandi', 'Pengaturan::sandiUpdate');
