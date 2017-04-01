<?php

namespace LaravelIssueTracker\Authorization\Acme\Services;

use LaravelIssueTracker\Authorization\Acme\Validators\RoleValidator;
use LaravelIssueTracker\Authorization\Models\Role;

class RoleCreatorService {

    /**
     * @var RoleValidator
     */
    protected $validator;

    /**
     * @var string
     */
    protected static $validationFailedMessage = 'Role Validation Failed';

    /**
     * RoleCreatorService constructor.
     * @param RoleValidator $validator
     */
    public function __construct(RoleValidator $validator)
    {
        $this->validator = $validator;
    }


    /**
     * @param $requestArray
     * @return mixed
     */
    public function make($requestArray)
    {
        if( $this->validator->isValidForInsert($requestArray) )
        {
            return Role::create($requestArray);
        }

        throw new ValidationException(self::$validationFailedMessage, $this->validator->getErrors());
    }


    /**
     * @param $requestArray
     * @param $id
     * @return mixed
     */
    public function update($requestArray, $id)
    {
        if( $this->validator->isValidForUpdate($requestArray) )
        {
            return Role::findOrFail($id)->update($requestArray);
        }

        throw new ValidationException(self::$validationFailedMessage, $this->validator->getErrors());
    }


    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        if( Role::find($id)->exists() )
        {
            return Role::destroy($id);
        }

        throw new ValidationException('Role does not exists');
    }

}