<?php

namespace LaravelIssueTracker\Workflow\Controllers;

use LaravelIssueTracker\Core\Controller\ApiController;
use LaravelIssueTracker\Workflow\Acme\Services\WorkflowCreatorService;
use LaravelIssueTracker\Workflow\Acme\Transformers\WorkflowTransformer;
use LaravelIssueTracker\Workflow\Models\Workflow;


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
        $workflow = Workflow::all()->paginate($this->limit);

        return $this->responsWithPaginaton($workflow, [
            'data' => $this->transformer->transformCollection($workflow->all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @return mixed
     */
    public function store()
    {
        try {
            //
            $this->creatorService->make(Input::all());
            return $this->respondCreated('Workflow created!');
        }
        catch (ValidationException $e) {
            return $this->respondUnprocessable($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * @param $id Resource id
     * @return mixed
     */
    public function show($id)
    {
        $workflow = Workflow::find($id);

        if( ! $workflow )
        {
            return $this->respondNotFound('Workflow does not exist');
        }

        return $this->respond([
            'data' => $this->transformer->transform($workflow)
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param $id Resource id
     * @return mixed
     */
    public function update($id)
    {
        try {
            //
            $this->creatorService->update(Input::all(), $id);
            return $this->respondCreated('Workflow updated!');
        }
        catch(ValidationException $e) {
            return $this->respondUnprocessable($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param $id Resource id
     * @return mixed
     */
    public function destroy($id)
    {
        try {
            $this->creatorService->destroy($id);
            return $this->respondCreated('Workflow destroyed!');
        }
        catch(ValidationException $e) {
            return $this->respondUnprocessable($e->getMessage());
        }
    }
}