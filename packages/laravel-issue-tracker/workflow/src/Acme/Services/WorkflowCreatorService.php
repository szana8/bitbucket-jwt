<?php

namespace LaravelIssueTracker\Workflow\Acme\Services;

use LaravelIssueTracker\Core\Acme\Services\ApiService;
use LaravelIssueTracker\Core\Acme\Validators\ValidationException;
use LaravelIssueTracker\Workflow\Acme\Validators\WorkflowValidator;
use LaravelIssueTracker\Workflow\Models\Workflow;

class WorkflowCreatorService extends ApiService {

    /**
     * @var WorkflowValidator
     */
    private $validator;

    /**
     * ApiServiceInterface constructor.
     * @param WorkflowValidator $validator
     */
    public function __construct(WorkflowValidator $validator)
    {

        $this->validator = $validator;
    }

    /**
     * Store a newly created resource in storage.
     * @param $requestArray
     * @return mixed
     * @throws ValidationException
     */
    public function make($requestArray)
    {
        if( $this->validator->isValidForInsert($requestArray) )
        {
            return Workflow::create($requestArray);
        }

        throw new ValidationException('Workflow validation failed', $this->validator->getErrors());
    }

    /**
     * Update the specified resource in storage.
     * @param $requestArray
     * @param $id
     * @return mixed
     * @throws ValidationException
     */
    public function update($requestArray, $id)
    {
        if( $this->validator->isValidForUpdate($requestArray) )
        {
            return Workflow::findOrFail($id)->update($requestArray);
        }

        throw new ValidationException('Workflow validation failed', $this->validator->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return mixed
     * @throws ValidationException
     */
    public function destroy($id)
    {
        if( Workflow::find($id)->exists() )
        {
            return Workflow::destroy($id);
        }

        throw new ValidationException('Workflow does not exists', '');
    }
}