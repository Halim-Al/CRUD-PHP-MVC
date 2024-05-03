<?php
namespace Halim\CrudMvc\Service;

require_once __DIR__ . '/../Helper/helper.php';

use Halim\CrudMvc\Config\Database;
use Halim\CrudMvc\Domain\Session;
use Halim\CrudMvc\Domain\User;
use Halim\CrudMvc\Repository\UserRepository;
use Halim\CrudMvc\Service\SessionService;
use Halim\CrudMvc\Repository\SessionRepository;
use PHPUnit\Framework\TestCase;



class SessionServiceTest extends TestCase
{
    private SessionService $sessionService;
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    protected function setUp():void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository, $this->userRepository);

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->id = "lim";
        $user->name = "lim";
        $user->password = "rahasia";
        $this->userRepository->save($user);
    }

    public function testCreate()
    {
        $session = $this->sessionService->create("lim");

        $this->expectOutputRegex("[LIM-AL: $session->id]");

        $result = $this->sessionRepository->findById($session->id);

        self::assertEquals("lim", $result->userId);
    }

    public function testDestroy()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "lim";

        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $this->sessionService->destroy();

        $this->expectOutputRegex("[LIM-AL: ]");

        $result = $this->sessionRepository->findById($session->id);
        self::assertNull($result);
    }

    public function testCurrent()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "lim";

        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $user = $this->sessionService->current();

        self::assertEquals($session->userId, $user->id);
    }
}


?>