<?php

namespace LaravelIssueTracker\Authorization\Acme\Services;


use LaravelIssueTracker\Authorization\Acme\Validators\PermissionValidator;
use LaravelIssueTracker\Authorization\Models\Permission;

class PermissionCreatorServices {

    /**
     * @var RoleValidator
     */
    protected $validator;

    /**
     * @var string
     */
    protected static $validationFailedMessage = 'Permission Validation Failed';

    /**
     * RoleCreatorService constructor.
     * @param PermissionValidator $validator
     */
    public function __construct(PermissionValidator $validator)
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
            return Permission::create($requestArray);
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
            return Permission::findOrFail($id)->update($requestArray);
        }

        throw new ValidationException(self::$validationFailedMessage, $this->validator->getErrors());
    }


    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        if( Permission::find($id)->exists() )
        {
            return Permission::destroy($id);
        }

        throw new ValidationException('Permission does not exists');
    }

}