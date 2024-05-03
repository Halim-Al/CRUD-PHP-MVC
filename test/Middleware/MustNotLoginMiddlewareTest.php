<?php 

namespace Halim\CrudMvc\Middleware {




use Halim\CrudMvc\Config\Database;
use Halim\CrudMvc\Domain\Session;
use Halim\CrudMvc\Domain\User;
use Halim\CrudMvc\Middleware\MustLoginMiddleware;
use Halim\CrudMvc\Middleware\MustNotLoginMiddleware;
use Halim\CrudMvc\Repository\SessionRepository;
use Halim\CrudMvc\Repository\UserRepository;
use Halim\CrudMvc\Service\SessionService;
use PHPUnit\Framework\TestCase;
 

class MustNotLoginMiddlewareTest extends TestCase
{

    private MustNotLoginMiddleware $middleware;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp():void
    {
        $this->middleware = new MustNotLoginMiddleware();
        putenv("mode=test");

        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testBeforeGuest()
    {
        $this->middleware->before();
        $this->expectOutputString("");
    }

    public function testBeforeLoginUser()
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

        $this->middleware->before();
        $this->expectOutputRegex("[Location: /]");

    }

}

}

?>