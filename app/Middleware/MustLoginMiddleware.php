<?php
namespace Halim\CrudMvc\Middleware;


use Halim\CrudMvc\App\View;
use Halim\CrudMvc\Config\Database;
use Halim\CrudMvc\Middleware\Middleware;
use Halim\CrudMvc\Repository\SessionRepository;
use Halim\CrudMvc\Repository\UserRepository;
use Halim\CrudMvc\Service\SessionService;

class MustLoginMiddleware implements Middleware{

    private SessionService $sessionService;
    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    function before(): void
    {
        $user = $this->sessionService->current();
        if ($user == null) {
            View::redirect('/users/login');
        }
    }
}

?>