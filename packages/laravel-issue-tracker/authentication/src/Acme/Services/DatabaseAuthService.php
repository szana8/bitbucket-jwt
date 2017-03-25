<?php
namespace LaravelIssueTracker\Authentication\Acme\Services;

use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use LaravelIssueTracker\Authentication\Acme\Repositories\UserRepository;
use LaravelIssueTracker\Authentication\Listeners\AuthenticateUserListener;
use LaravelIssueTracker\Authentication\Acme\Validators\DatabaseAuthValidator;
use LaravelIssueTracker\Authentication\Acme\Validators\AuthenticationValidator;

/**
 * Class DatabaseAuthService
 * @package LaravelIssueTracker\Authentication\Acme\Services
 */
class DatabaseAuthService
{
    /**
     * @var UserRepository
     */
    protected $user;
    /**
     * @var AuthenticationValidator
     */
    private $databaseAuthValidator;


    /**
     * DatabaseService constructor.
     * @param UserRepository $user
     * @param DatabaseAuthValidator $databaseAuthValidator
     * @internal param AuthenticationValidator $authenticationValidator
     */
    public function __construct(UserRepository $user, DatabaseAuthValidator $databaseAuthValidator)
    {
        $this->user = $user;
        $this->databaseAuthValidator = $databaseAuthValidator;
    }

    /**
     * @param $request
     * @param AuthenticateUserListener $listener
     * @return mixed
     */
    public function authenticate($request)
    {

        return JWTAuth::attempt($request->only('email', 'password'), [
            'exp' => Carbon::now()->addWeek()->timestamp,
        ]);

    }

}