<?php

namespace LaravelIssueTracker\Workflow\Acme\Services;

use LaravelIssueTracker\Core\Acme\Services\ApiService;

class WorkflowCreatorService extends ApiService {

    /**
     * ApiServiceInterface constructor.
     * @param ApiValidatorInterface $validator
     */
    public function __construct($validator)
    {

    }

    /**
     * Store a newly created resource in storage.
     * @param $requestArray
     * @return mixed
     */
    public function make($requestArray)
    {
        // TODO: Implement make() method.
    }

    /**
     * Update the specified resource in storage.
     * @param $requestArray
     * @param $id
     * @return mixed
     */
    public function update($requestArray, $id)
    {
        // TODO: Implement update() method.
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}