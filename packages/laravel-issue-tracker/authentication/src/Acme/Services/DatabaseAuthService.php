<?php
namespace LaravelIssueTracker\Authentication\Acme\Services;

use App\User;
use Carbon\Carbon;
use LaravelIssueTracker\Core\Acme\Validators\ValidationException;
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
        if( $this->databaseAuthValidator->isValidForInsert($request->toArray()) )
        {
            $token = JWTAuth::attempt($request->only('email', 'password'), [
                'exp' => Carbon::now()->addWeek()->timestamp,
            ]);

            if (!$token) {
                throw new ValidationException('Check your credentials');
            }

            return [
                'data' => User::where('email', $request->email)->with('profiles')->first(),
                'meta' => [
                    'token' => $token
                ]
            ];
        }

        throw new ValidationException('User validation failed', $this->databaseAuthValidator->getErrors());
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserByToken($request)
    {
        return response()->json([
            'data' => User::where('email', $request->user()->email)->with('profiles')->first(),
        ]);
    }

}