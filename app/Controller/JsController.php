<?php
// File: JsController.php
namespace Halim\CrudMvc\Controller;

use Halim\CrudMvc\App\View;

// File: JsController.php

class JsController {
    public function index() {
        
        

        // Tentukan lokasi file JavaScript Anda
    $jsFilePath = View::jsviewer('script');

    // Periksa apakah file ada
    if (file_exists($jsFilePath)) {
        // Set header Content-Type untuk file JavaScript
        header('Content-Type: text/javascript');

        // Baca dan kirimkan file JavaScript
        readfile($jsFilePath);
    } else {
        // Jika file tidak ditemukan, kirimkan respons 404
        http_response_code(404);
        echo 'File not found';
    }
    }

    
}

