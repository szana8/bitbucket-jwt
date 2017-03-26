<?php
namespace LaravelIssueTracker\Authentication\Controllers;

use Illuminate\Http\Request;
use LaravelIssueTracker\Core\Acme\Validators\ValidationException;
use LaravelIssueTracker\Authentication\Acme\Services\DatabaseAuthService;
use LaravelIssueTracker\Authentication\Acme\Validators\DatabaseAuthValidator;
use LaravelIssueTracker\Authentication\Acme\Transformers\DatabaseAuthTransformer;
use LaravelIssueTracker\Authentication\Controllers\AbstractControllers\AuthenticationController;


/**
 * Class DatabaseAuthController
 * @package LaravelIssueTracker\Authentication\Controllers
 */
class DatabaseAuthController extends AuthenticationController
{
    /**
     * @var DatabaseAuthService
     */
    private $databaseAuthService;
    /**
     * @var DatabaseAuthTransformer
     */
    private $databaseAuthTransformer;

    /**
     * DatabaseAuthController constructor.
     * @param DatabaseAuthService $databaseAuthService
     * @param DatabaseAuthValidator $validator
     */
    public function __construct(DatabaseAuthService $databaseAuthService, DatabaseAuthTransformer $databaseAuthTransformer)
    {
        $this->databaseAuthService = $databaseAuthService;
        $this->databaseAuthTransformer = $databaseAuthTransformer;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login(Request $request)
    {
        try
        {
            return $this->databaseAuthService->authenticate($request);
        }
        catch(ValidationException $e) {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        }
    }

    /**
     * @param Request $request
     */
    public function getUserByToken(Request $request)
    {
        try
        {
            return $this->databaseAuthService->getUserByToken($request);
        }
        catch(Exception $e)
        {
            return $this->respondUnprocessable(['message' => $e->getMessage()]);
        }
    }

    public function logout()
    {
        $this->databaseAuthService->logout();

        return response(null, 200);
    }

}