<?php

namespace LaravelIssueTracker\Authorization\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use LaravelIssueTracker\Authorization\Models\Role;
use LaravelIssueTracker\Core\Controller\ApiController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaravelIssueTracker\Core\Acme\Validators\ValidationException;
use LaravelIssueTracker\Authorization\Acme\Services\RoleCreatorService;
use LaravelIssueTracker\Authorization\Acme\Transformers\RoleTransformer;

class RoleController extends ApiController {

    /**
     * @var RoleTransformer
     */
    private $roleTransformer;
    /**
     * @var RoleCreatorService
     */
    private $roleCreatorService;

    /**
     * AuthorizationController constructor.
     * @param RoleTransformer $roleTransformer
     * @param RoleCreatorService $roleCreatorService
     */
    public function __construct(RoleTransformer $roleTransformer, RoleCreatorService $roleCreatorService)
    {
        $this->roleTransformer = $roleTransformer;
        $this->roleCreatorService = $roleCreatorService;
    }


    /**
     * Display the list of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $role = Role::searchInDefaultColumns(Request::get('search'))->orderBy('key', 'asc')->paginate($this->limit);

        return $this->responsWithPaginaton($role, [
            'data' => $this->roleTransformer->transformCollection($role->all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        try {
            $this->roleCreatorService->make(Input::all());

            return $this->respondCreated('Role created!');
        }
        catch (ValidationException $e) {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors(), 'status_code' => 500]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $roleId
     * @return Response
     */
    public function show($roleId)
    {
        try
        {
            $role = Role::findOrFail($roleId);

            return $this->respond(['data' => $this->roleTransformer->transform($role)]);
        }
        catch ( ModelNotFoundException $e ) {
            return $this->respondNotFound(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $roleId
     * @return Response
     */
    public function update($roleId)
    {
        try {
            $this->roleCreatorService->update(Input::all(), $roleId);

            return $this->respondCreated('Role updated!');
        }
        catch(ValidationException $e) {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $roleId
     * @return Response
     */
    public function destroy($roleId)
    {
        try {
            $this->roleCreatorService->destroy($roleId);

            return $this->respondCreated('Role destroyed!');
        }
        catch(ValidationException $e) {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        }
    }

}