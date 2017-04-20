<?php

namespace LaravelIssueTracker\Workflow\Controllers;

use LaravelIssueTracker\Core\Controller\ApiController;
use LaravelIssueTracker\Workflow\Acme\Services\WorkflowCreatorService;
use LaravelIssueTracker\Workflow\Acme\Transformers\WorkflowTransformer;


class WorkflowController extends ApiController {

    /**
     * @var WorkflowTransformer
     */
    private $transformer;
    /**
     * @var WorkflowCreatorService
     */
    private $creatorService;

    /**
     * ApiControllerInterface constructor.
     * @param WorkflowTransformer $transformer
     * @param WorkflowCreatorService $creatorService
     */
    public function __construct(WorkflowTransformer $transformer, WorkflowCreatorService $creatorService)
    {
        $this->transformer = $transformer;
        $this->creatorService = $creatorService;
    }

    /**
     * Display the list of the resource.
     * @return mixed
     */
    public function index()
    {
        // TODO: Implement index() method.
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