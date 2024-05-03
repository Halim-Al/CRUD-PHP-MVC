<?php 

namespace Halim\CrudMvc\App{
    function header(string $value){
        echo $value;
    }
}




 namespace Halim\CrudMvc\Controller{

 
 use PHPUnit\Framework\TestCase;
use Halim\CrudMvc\Controller\UserController;
use Halim\CrudMvc\Repository\UserRepository;
use Halim\CrudMvc\Model\UserRegisterRequest;
use Halim\CrudMvc\Service\UserService;
use Halim\CrudMvc\Config\Database;
use Halim\CrudMvc\Domain\User;
use Halim\CrudMvc\App\View;
    use Halim\CrudMvc\Domain\Session;
    use Halim\CrudMvc\Repository\SessionRepository;
    use Halim\CrudMvc\Service\SessionService;
    use PHPUnit\Framework\MockObject\MockObject;


 class UserControllerTest extends TestCase{

    
    private UserController $userController;
    private UserRepository $userRepository;

    private SessionRepository $sessionRepository;
    protected function setUp(): void
        {
            $this->userController = new UserController();

            $this->sessionRepository = new SessionRepository(Database::getConnection());
            $this->sessionRepository->deleteAll();

            $this->userRepository = new UserRepository(Database::getConnection());
            $this->userRepository->deleteAll();

            putenv("mode=test");
        }

        public function testRegister()
        {
            $this->userController->register();

            $this->expectOutputRegex("[Daftar]");
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Nama]");
            $this->expectOutputRegex("[Password]");
            
        }



        public function testPostRegisterValidationError()
        {
            $_POST['id'] = '';
            $_POST['name'] = 'Eko';
            $_POST['password'] = 'rahasia';

            $this->userController->postRegister();

            $this->expectOutputRegex("[Register]");
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Name]");
            $this->expectOutputRegex("[Password]");
            $this->expectOutputRegex("[Register new User]");
            $this->expectOutputRegex("[Id, Name, Password can not blank]");
        }

        public function testPostRegisterSuccess()
        {
            $_POST['id'] = 'lim';
            $_POST['name'] = 'lim';
            $_POST['password'] = 'rahasia';
                // Mulai output buffering
                //  ob_start();



            $this->userController->postRegister();

            $this->expectOutputRegex("/Location: \//");
            // Ambil output dan header yang disimpan dalam buffer
            //  $output = ob_get_clean();

    // Periksa apakah header redirect sesuai dengan yang diharapkan
            //  $this->assertStringContainsString('Location: /', $output);


         



        }

        public function testPostRegisterDuplicate()
        {
            $user = new User();
            $user->id = ";lim";
            $user->name = ";lim";
            $user->password = "rahasia";

            $this->userRepository->save($user);

            $_POST['id'] = ';lim';
            $_POST['name'] = ';lim';
            $_POST['password'] = 'rahasia';

            $this->userController->postRegister();

            $this->expectOutputRegex("[Register]");
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Name]");
            $this->expectOutputRegex("[Password]");
            $this->expectOutputRegex("[Register new User]");
            $this->expectOutputRegex("[User Id already exists]");
        }


        
        public function testLogin()
        {
            $this->userController->login();

            $this->expectOutputRegex("[Password:]");
            $this->expectOutputRegex("[Don't have an account? ]");
            $this->expectOutputRegex("[Sign Up]");
        }

        public function testLoginSuccess()
        {
            $user = new User();
            $user->id = "lim";
            $user->name = "lim";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $_POST['id'] = 'lim';
            $_POST['password'] = 'rahasia';

            $this->userController->postLogin();

            $this->expectOutputRegex("[Location: /]");
           
        }

        public function testLoginValidationError()
        {
            $_POST['id'] = '';
            $_POST['password'] = '';

            $this->userController->postLogin();

            $this->expectOutputRegex("[Login user]");
            $this->expectOutputRegex("[ID]");
            $this->expectOutputRegex("[Id, Password can not blank]");
          
        }

        public function testLoginUserNotFound()
        {
            $_POST['id'] = 'notfound';
            $_POST['password'] = 'notfound';

            $this->userController->postLogin();

            $this->expectOutputRegex("[Login user]");
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Password]");
            $this->expectOutputRegex("[Id or password is wrong]");
        }

        public function testLoginWrongPassword()
        {
            $user = new User();
            $user->id = "eko";
            $user->name = "Eko";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $_POST['id'] = 'eko';
            $_POST['password'] = 'salah';

            $this->userController->postLogin();

            $this->expectOutputRegex("[Login user]");
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Password]");
            
        }   

        public function testLogout()
        {
            $user = new User();
            $user->id = "lim";
            $user->name = "lim";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;
            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $this->userController->logout();

            $this->expectOutputRegex("[Location: /]");
           
        }


 }
 

        

}
?>