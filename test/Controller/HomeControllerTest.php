<?php

namespace Halim\CrudMvc\Controller;

use Halim\CrudMvc\Config\Database;
// use Halim\CrudMvc\Controller\HomeController;
use Halim\CrudMvc\Domain\Session;
use Halim\CrudMvc\Domain\User;
use Halim\CrudMvc\Repository\SessionRepository;
use Halim\CrudMvc\Repository\UserRepository;
use Halim\CrudMvc\Service\SessionService;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    private HomeController $homeController;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp():void
    {
        $this->homeController = new HomeController();
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testGuest()
    {
        $this->homeController->index();

        $this->expectOutputRegex("[DI TOKO MATAHARI]");
    }

    public function testUserLogin()
    {
        $user = new User();
        $user->id = "lim";
        $user->name = "lim";
        $user->password = "rahasia";
        $this->userRepository->save($user);

        $session = new Session();
        $session->id = uniqid();
        $session->userId = $user->id;
        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $this->homeController->index();

        $this->expectOutputRegex("[Toko Matahari]");
    }

    // public function testSomethingThatProducesWarning()
    // {
    //    // Mulai output buffering
    //    ob_start();

    //    // Kode yang mungkin menghasilkan pesan peringatan
    //    trigger_error('Ini adalah pesan peringatan', E_USER_WARNING);

    //    // Tangkap hasil output buffering
    //    $output = ob_get_clean();

    //    // Periksa apakah pesan peringatan ada dalam output
    //    $this->assertStringContainsString('Ini adalah pesan peringatan', $output);
    // }

}



?>