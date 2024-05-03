<?php 

require __DIR__ ."/../vendor/autoload.php";

use Halim\CrudMvc\App\Router;
use Halim\CrudMvc\Controller\HomeController;
 use Halim\CrudMvc\Controller\UserController;
 use Halim\CrudMvc\Controller\JsController;
 use Halim\CrudMvc\Config\Database;
use Halim\CrudMvc\Controller\BarangController;
use Halim\CrudMvc\Controller\PelangganController;
use Halim\CrudMvc\Middleware\MustLoginMiddleware;
use Halim\CrudMvc\Middleware\MustNotLoginMiddleware;

Database::getConnection('prod');

// HOME Controller
Router::add('GET', '/', HomeController::class, 'index', []);

// UserController
Router::add('GET', '/users/register', UserController::class, 'register', [MustNotLoginMiddleware::class]);
Router::add('POST', '/users/register', UserController::class, 'postregister', [MustNotLoginMiddleware::class]);
Router::add('POST', '/users/login', UserController::class, 'postlogin', []);
Router::add('GET', '/users/login', UserController::class, 'login', [MustNotLoginMiddleware::class]);
Router::add('GET', '/users/logout', UserController::class, 'logout', [MustLoginMiddleware::class]);

// Router::add('GET', '/users/home', UserController::class, 'postlogin', []);

// BarangController
// method for pagination
Router::add('POST', '/navlink/barang', BarangController::class, 'postbarang', [MustLoginMiddleware::class]);
// $method = isset($_GET['page']) ? 'showPage' : 'index';
Router::add('GET', '/navlink/barang', BarangController::class, 'index', [MustLoginMiddleware::class]);
Router::add('GET', '/edit', BarangController::class, 'editview', [MustLoginMiddleware::class]);
// Router::add('GET', '/navlink/barang?query', BarangController::class, 'index', [MustLoginMiddleware::class]);
Router::add('DELETE', '/delete', BarangController::class, 'deletebarang', [MustLoginMiddleware::class]);
Router::add('POST', '/update', BarangController::class, 'postupdate', [MustLoginMiddleware::class]);
// Router::add('GET', '/js/script.js', JsController::class, 'index', [MustLoginMiddleware::class]);


// Pelanggan Router
Router::add('GET', '/navlink/pelanggan', PelangganController::class, 'index', [MustLoginMiddleware::class]);
Router::add('POST', '/navlink/pelanggan', PelangganController::class, 'postpelanggan', [MustLoginMiddleware::class]);
Router::add('DELETE', '/deletepelanggan', PelangganController::class, 'deletePelanggan', [MustLoginMiddleware::class]);
Router::add('GET', '/editpelanggan', PelangganController::class, 'editview', [MustLoginMiddleware::class]);
Router::add('POST', '/updatepelanggan', PelangganController::class, 'postupdate', [MustLoginMiddleware::class]);









Router::run();

?>