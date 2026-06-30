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

// Pengaturan - sub pages
$routes->get('/pengaturan', 'Pengaturan::index');
$routes->get('/pengaturan/profil', 'Pengaturan::profil');
$routes->post('/pengaturan/profil', 'Pengaturan::profilUpdate');
$routes->get('/pengaturan/sandi', 'Pengaturan::sandi');
$routes->post('/pengaturan/sandi', 'Pengaturan::sandiUpdate');
$routes->get('/pengaturan/preferensi', 'Pengaturan::preferensi');
$routes->post('/pengaturan/preferensi', 'Pengaturan::preferensiUpdate');
$routes->get('/pengaturan/tampilan', 'Pengaturan::tampilan');
$routes->get('/pengaturan/api-key', 'Pengaturan::apiKey');
$routes->post('/pengaturan/api-key/store', 'Pengaturan::apiKeyStore');
$routes->get('/pengaturan/api-key/edit/(:num)', 'Pengaturan::apiKeyEdit/$1');
$routes->post('/pengaturan/api-key/update/(:num)', 'Pengaturan::apiKeyUpdate/$1');
$routes->post('/pengaturan/api-key/delete/(:num)', 'Pengaturan::apiKeyDelete/$1');
