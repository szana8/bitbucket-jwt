<?php
namespace LaravelIssueTracker\ListOfValues\Controllers;

use Illuminate\Support\Facades\Input;
use LaravelIssueTracker\Core\Controller\ApiController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaravelIssueTracker\ListOfValues\Models\ListOfValues;
use LaravelIssueTracker\Core\Acme\Validators\ValidationException;
use LaravelIssueTracker\ListOfValues\Acme\Services\ListOfValuesService;
use LaravelIssueTracker\ListOfValues\Acme\Services\ListOfValuesLookupsService;
use LaravelIssueTracker\ListOfValues\Acme\Transformers\ListOfValuesTransformer;

/**
 * Class ListOfValuesController
 * @package LaravelIssueTracker\ListOfValues\Controllers
 */
class ListOfValuesController extends ApiController
{
    /**
     * @var ListOfValuesTransformer
     */
    protected $listOfValuesTransformer;
    /**
     * @var ListOfValuesService
     */
    protected $listOfValuesService;
    /**
     * @var ListOfValuesLookupsService
     */
    protected $listOfValuesLookupsService;


    /**
     * ListOfValuesController constructor.
     * @param ListOfValuesTransformer $listOfValuesTransformer
     * @param ListOfValuesService $listOfValuesService
     * @param ListOfValuesLookupsService $listOfValuesLookupsService
     */
    public function __construct(ListOfValuesTransformer $listOfValuesTransformer, ListOfValuesService $listOfValuesService, ListOfValuesLookupsService $listOfValuesLookupsService)
    {
        $this->listOfValuesService = $listOfValuesService;
        $this->listOfValuesTransformer = $listOfValuesTransformer;
        $this->listOfValuesLookupsService = $listOfValuesLookupsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $listOfValues = ListOfValues::with('lookups')->searchInDefaultColumns(\Request::get('search'))->paginate($this->limit);

        return $this->responsWithPaginaton($listOfValues, [
            'data' => $this->listOfValuesTransformer->transformCollection($listOfValues->all())
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try
        {
            $listOfValues = ListOfValues::with('lookups')->findOrFail($id);

            return $this->respond(['data' => $this->listOfValuesTransformer->transform($listOfValues)]);
        }
        catch( ModelNotFoundException $e)
        {
            return $this->respondNotFound('List Of Value does not exist');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store()
    {
        try
        {
            $this->listOfValuesService->make(Input::all());

            return $this->respondCreated('List Of Value created!');
        }
        catch ( ValidationException $e)
        {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Request $request
     * @param $id
     * @return mixed
     */
    public function update(\Request $request, $id)
    {
        try
        {
            // Store the original input of the request and then replace the input with your request instances input.
            $this->listOfValuesService->update(Input::all(), $id);

            return $this->respondCreated('List of Value updated!');
        }
        catch ( ValidationException $e )
        {
            return $this->respondUnprocessable(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        try
        {
            $this->listOfValuesService->destroy($id);

            return $this->respondCreated('List of Value destroyed!');
        }
        catch ( ValidationException $e )
        {
            return $this->respondUnprocessable($e->getMessage());
        }
    }

}