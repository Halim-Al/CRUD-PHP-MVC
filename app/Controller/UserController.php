<?php 

namespace Halim\CrudMvc\Controller;

use Halim\CrudMvc\App\View;
use Halim\CrudMvc\Service\UserService;
use Halim\CrudMvc\Repository\UserRepository;
use Halim\CrudMvc\Config\Database;
use Halim\CrudMvc\Exception\ValidationException;
use Halim\CrudMvc\Model\UserLoginRequest;
use Halim\CrudMvc\Model\UserRegisterRequest;
use Halim\CrudMvc\Repository\SessionRepository;
use Halim\CrudMvc\Service\SessionService;

class UserController{

    private UserService $userService;
    private SessionService $sessionService;
    private $view;

   
    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }


    public function setView($view)
    {
        $this->view = $view;
    }

    public function register(){
        View::render('User/register',[
            'title' => 'REGISTER YOUR ACCOUNT'
        ]);
    }



    public function postRegister()
    {
        $request = new UserRegisterRequest();
        $request->id = $_POST['id'];
        $request->name = $_POST['name'];
        $request->password = $_POST['password'];

        try {
            
            $this->userService->register($request);
            View::redirect('/users/login');
        } catch (ValidationException $exception) {
            View::render('User/register', [
                'title' => 'REGISTER YOUR ACCOUNT',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function login()
    {
        View::render('User/login', [
            "title" => "SELAMAT DATANG",
                "content" => "DI TOKO MATAHARI"
        ]);
    }

    public function postLogin()
    {
        $request = new UserLoginRequest();
        $request->id = $_POST['id'];
        $request->password = $_POST['password'];

        try {
            $response = $this->userService->login($request);
            $this->sessionService->create($response->user->id);
            View::redirect('/');
        } catch (ValidationException $exception) {
            View::render('User/login', [
                "title" => "SELAMAT DATANG",
                "content" => "DI TOKO MATAHARI",
                'error' => $exception->getMessage()
            ]);
        }
    }


    public function logout()
    {
        $this->sessionService->destroy();
       
    }




}

?>