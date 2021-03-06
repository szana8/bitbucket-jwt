<?php

namespace LaravelIssueTracker\Authorization\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use LaravelIssueTracker\Authorization\Acme\Services\PermissionCreatorServices;
use LaravelIssueTracker\Authorization\Acme\Transformers\PermissionTransformer;
use LaravelIssueTracker\Authorization\Models\Permission;
use LaravelIssueTracker\Core\Acme\Validators\ValidationException;
use LaravelIssueTracker\Core\Controller\ApiController;

class PermissionController extends ApiController {

    /**
     * @var PermissionTransformer
     */
    private $permissionTransformer;
    /**
     * @var PermissionCreatorServices
     */
    private $permissionCreatorServices;

    /**
     * @var int
     */
    protected $limit = 8;

    /**
     * AuthorizationController constructor.
     * @param PermissionTransformer $permissionTransformer
     * @param PermissionCreatorServices $permissionCreatorServices
     */
    public function __construct(PermissionTransformer $permissionTransformer, PermissionCreatorServices $permissionCreatorServices)
    {
        $this->permissionTransformer = $permissionTransformer;
        $this->permissionCreatorServices = $permissionCreatorServices;
    }

    /**
     * Display the list of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $permission = Permission::searchInDefaultColumns(Request::get('search'))->paginate($this->limit);

        return $this->responsWithPaginaton($permission, [
            'data' => $this->permissionTransformer->transformCollection($permission->all()),
        ]);
    }

    function autoload($pin_ClassName)
    {
        $loc_Directory = explode("\\", $pin_ClassName);
        $loc_Location = '';

        for($loc_Cycle=0;$loc_Cycle<=count($loc_Directory)-2;$loc_Cycle++) {
            $loc_Location .= '/' . $loc_Directory[$loc_Cycle];
        }

        if($loc_Directory[0] == 'modules')
            $loc_Location .= '/library/'. end($loc_Directory);
        elseif($loc_Directory[0] == 'WebServices')
            $loc_Location .= '/' . end($loc_Directory) . '/' .  end($loc_Directory);
        else
            $loc_Location .= '/'. end($loc_Directory);

        $loc_File = BASEPATH . $loc_Location . '.php';

        if(strlen($loc_File) <= 260) {
            if(is_file($loc_File))
                require_once $loc_File;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        try {
            $this->permissionCreatorServices->make(Input::all());

            return $this->respondCreated('Permission created!');
        }
        catch (ValidationException $e) {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors(), 'status_code' => 500]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $permissionId
     * @return Response
     */
    public function show($permissionId)
    {
        try
        {
            $permission = Permission::findOrFail($permissionId);

            return $this->respond(['data' => $this->permissionTransformer->transform($permission)]);
        }
        catch ( ModelNotFoundException $e ) {
            return $this->respondNotFound(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $permissionId
     * @return Response
     */
    public function update($permissionId)
    {
        try {
            $this->permissionCreatorServices->update(Input::all(), $permissionId);

            return $this->respondCreated('Permission updated!');
        }
        catch(ValidationException $e) {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $permissionId
     * @return Response
     */
    public function destroy($permissionId)
    {
        try {
            $this->permissionCreatorServices->destroy($permissionId);

            return $this->respondCreated('Permission destroyed!');
        }
        catch(ValidationException $e) {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        }
    }

}