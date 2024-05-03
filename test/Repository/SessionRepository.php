<?php 
namespace Halim\CrudMvc\Repository;

use Halim\CrudMvc\Repository\SessionRepository;
use Halim\CrudMvc\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use Halim\CrudMvc\Config\Database;
use Halim\CrudMvc\Domain\Session;
use Halim\CrudMvc\Domain\User;
use Halim\CrudMvc\Repository\SessionService;

class SessionRepositoryTest extends TestCase
{   
    
    
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    protected function setUp():void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->id = "lim";
        $user->name = "lim";
        $user->password = "rahasia";
        $this->userRepository->save($user);
    }

    public function testSaveSuccess()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "lim";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);
        self::assertEquals($session->id, $result->id);
        self::assertEquals($session->userId, $result->userId);
    }

    public function testDeleteByIdSuccess()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "lim";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);
        self::assertEquals($session->id, $result->id);
        self::assertEquals($session->userId, $result->userId);

        $this->sessionRepository->deleteById($session->id);

        $result = $this->sessionRepository->findById($session->id);
        self::assertNull($result);
    }

    public function testFindByIdNotFound()
    {
        $result = $this->sessionRepository->findById('notfound');
        self::assertNull($result);
    }


}



?>