<?php

namespace LaravelIssueTracker\InventoryOrganization\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use LaravelIssueTracker\Core\Acme\Validators\ValidationException;
use LaravelIssueTracker\Core\Controller\ApiController;
use LaravelIssueTracker\InventoryOrganization\Acme\Services\InventoryOrganizationCreatorService;
use LaravelIssueTracker\InventoryOrganization\Acme\Transformers\InventoryOrganizationTransformer;
use LaravelIssueTracker\InventoryOrganization\Models\InventoryOrganization;

class InventoryOrganizationController extends ApiController
{

    /**
     * @var InventoryOrganizationTransformer
     */
    private $transformer;
    /**
     * @var InventoryOrganizationCreatorService
     */
    private $creatorService;


    /**
     * InventoryOrganizationController constructor.
     * @param InventoryOrganizationTransformer $transformer
     * @param InventoryOrganizationCreatorService $creatorService
     */
    public function __construct(InventoryOrganizationTransformer $transformer, InventoryOrganizationCreatorService $creatorService)
    {
        $this->transformer = $transformer;
        $this->creatorService = $creatorService;
    }

    /**
     * Display the list of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $inventoryOrganization = InventoryOrganization::searchInDefaultColumns(Request::get('search'))->paginate($this->limit);

        return $this->responsWithPaginaton($inventoryOrganization, [
            'data' => $this->transformer->transformCollection($inventoryOrganization->all()),
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
            $this->creatorService->make(Input::all());

            return $this->respondCreated('Inventory Organization created!');
        }
        catch (ValidationException $e) {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors(), 'status_code' => 500]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $metadataID
     * @return Response
     */
    public function show($id)
    {
        try
        {
            $inventoryOrganization = InventoryOrganization::findOrFail($id);

            return $this->respond(['data' => $this->transformer->transform($inventoryOrganization)]);
        }
        catch ( ModelNotFoundException $e ) {
            return $this->respondNotFound(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        try {
            $this->creatorService->update(Input::all(), $id);

            return $this->respondCreated('Inventory Organiztaion updated!');
        }
        catch(ValidationException $e) {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $this->creatorService->destroy($id);

            return $this->respondCreated('Inventory Organization destroyed!');
        }
        catch(ValidationException $e) {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        }
    }

}