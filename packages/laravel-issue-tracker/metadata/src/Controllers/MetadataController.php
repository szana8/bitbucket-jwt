<?php

namespace LaravelIssueTracker\Metadata\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use LaravelIssueTracker\Metadata\Models\Metadata;
use LaravelIssueTracker\Core\Controller\ApiController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaravelIssueTracker\Core\Acme\Validators\ValidationException;
use LaravelIssueTracker\Metadata\Acme\Services\MetadataCreatorService;
use LaravelIssueTracker\Metadata\Acme\Transformers\MetadataTransformer;

class MetadataController extends ApiController {

    /**
     * Property for metadata creator service.
     */
    protected $metadataCreator;

    /**
     * Property for the metadata transformer.
     */
    protected $metadataTransformer;

    /**
     * Reqrite the default limit
     */
    protected $limit = 8;

    /**
     * MetadataController constructor.
     *
     * @param $metadataTransformer
     * @param $metadataCreator
     */
    public function __construct(MetadataTransformer $metadataTransformer, MetadataCreatorService $metadataCreator)
    {
        $this->metadataCreator = $metadataCreator;
        $this->metadataTransformer = $metadataTransformer;
    }


    /**
     * Display the list of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $metadata = Metadata::searchInDefaultColumns(Request::get('search'))->orderBy('key', 'asc')->paginate($this->limit);

        return $this->responsWithPaginaton($metadata, [
            'data' => $this->metadataTransformer->transformCollection($metadata->all()),
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
            $this->metadataCreator->make(Input::all());

            return $this->respondCreated('Metadata created!');
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
    public function show($metadataID)
    {
        try
        {
            $metadata = Metadata::findOrFail($metadataID);

            return $this->respond(['data' => $this->metadataTransformer->transform($metadata)]);
        }
        catch ( ModelNotFoundException $e ) {
            return $this->respondNotFound(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $metadataID
     * @return Response
     */
    public function update($metadataID)
    {
        try {
            $this->metadataCreator->update(Input::all(), $metadataID);

            return $this->respondCreated('Metadata updated!');
        }
        catch(ValidationException $e) {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $metadataID
     * @return Response
     */
    public function destroy($metadataID)
    {
        try {
            $this->metadataCreator->destroy($metadataID);

            return $this->respondCreated('Metadata destroyed!');
        }
        catch(ValidationException $e) {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        }
    }
}