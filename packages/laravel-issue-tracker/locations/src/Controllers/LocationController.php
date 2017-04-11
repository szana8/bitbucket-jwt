<?php

namespace LaravelIssueTracker\Locations\Controllers;

use Illuminate\Support\Facades\Request;
use LaravelIssueTracker\Core\Controller\ApiController;
use LaravelIssueTracker\Locations\Acme\Services\LocationCreatorService;
use LaravelIssueTracker\Locations\Acme\Transformers\LocationTransformer;
use LaravelIssueTracker\Locations\Models\Location;

class LocationController extends ApiController {

    /**
     * @var LocationTransformer
     */
    private $locationTransformer;

    /**
     * @var LocationCreatorService
     */
    private $locationCreatorService;

    /**
     * ApiControllerInterface constructor.
     * @param LocationTransformer $locationTransformer
     * @param LocationCreatorService $locationCreatorService
     */
    public function __construct(LocationTransformer $locationTransformer, LocationCreatorService $locationCreatorService)
    {
        $this->locationTransformer = $locationTransformer;
        $this->locationCreatorService = $locationCreatorService;
    }

    /**
     * Display the list of the resource.
     * @return mixed
     */
    public function index()
    {
        $location = Location::searchInDefaultColumns(Request::get('search'))->paginate($this->limit);

        return $this->responsWithPaginaton($location, [
            'data' => $this->locationTransformer->transformCollection($location->all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @return mixed
     */
    public function store()
    {
        // TODO: Implement store() method.
    }

    /**
     * Display the specified resource.
     * @param $id Resource id
     * @return mixed
     */
    public function show($id)
    {
        // TODO: Implement show() method.
    }

    /**
     * Update the specified resource in storage.
     * @param $id Resource id
     * @return mixed
     */
    public function update($id)
    {
        // TODO: Implement update() method.
    }

    /**
     * Remove the specified resource from storage.
     * @param $id Resource id
     * @return mixed
     */
    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}