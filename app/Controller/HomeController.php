<?php 

namespace Halim\CrudMvc\Controller;
use Halim\CrudMvc\App\View;
use Halim\CrudMvc\Config\Database;
use Halim\CrudMvc\Repository\SessionRepository;
use Halim\CrudMvc\Repository\UserRepository;
use Halim\CrudMvc\Service\SessionService;

class HomeController{

    private SessionService $sessionService;

    function __construct(){
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }
    public function index(){
        
        $user = $this->sessionService->current();
        if ($user == null) {
            $model = [
                "title" => "SELAMAT DATANG",
                "content" => "DI TOKO MATAHARI"
            ];
            View::render('User/login', $model);
        } else {
            View::render('Home/index', [
                
            ]);
        }
       
    }
}





?>