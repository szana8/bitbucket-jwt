<?php

namespace LaravelIssueTracker\Avatar\Acme\Services;

use LaravelIssueTracker\Avatar\Models\Avatar;
use LaravelIssueTracker\Core\Acme\Services\ApiService;
use LaravelIssueTracker\Avatar\Acme\Validators\AvatarValidator;
use LaravelIssueTracker\Core\Acme\Validators\ValidationException;

class AvatarCreatorService extends ApiService {

    /**
     * @var AvatarValidator
     */
    private $validator;

    /**
     * ApiServiceInterface constructor.
     * @param  $validator
     */
    public function __construct(AvatarValidator $validator)
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
            return Avatar::create($requestArray);
        }

        throw new ValidationException('Avatar validation failed', $this->validator->getErrors());
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
            return Avatar::findOrFail($id)->update($requestArray);
        }

        throw new ValidationException('Avatar validation failed', $this->validator->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return mixed
     * @throws ValidationException
     */
    public function destroy($id)
    {
        if( Avatar::find($id)->exists() )
        {
            return Avatar::destroy($id);
        }

        throw new ValidationException('Avatar does not exists', '');
    }
}