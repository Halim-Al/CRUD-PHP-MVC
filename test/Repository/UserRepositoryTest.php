<?php 

namespace Halim\CrudMvc\Repository;

use PHPUnit\Framework\TestCase;
use Halim\CrudMvc\Config\Database;

use Halim\CrudMvc\Domain\User;


class UserRepositoryTest extends TestCase{
    private UserRepository $userRepository;

    public function setUp() :void{
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }
    public function testSaveSuccess()
    {
        $user = new User();
        $user->id = "eko";
        $user->name = "Eko";
        $user->password = "rahasia";

        $this->userRepository->save($user);

        $result = $this->userRepository->findById($user->id);

        self::assertEquals($user->id, $result->id);
        self::assertEquals($user->name, $result->name);
        self::assertEquals($user->password, $result->password);
    }

}


?>