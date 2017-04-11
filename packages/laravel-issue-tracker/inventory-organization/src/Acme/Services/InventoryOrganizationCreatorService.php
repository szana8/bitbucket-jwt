<?php

namespace LaravelIssueTracker\InventoryOrganization\Acme\Services;

use LaravelIssueTracker\InventoryOrganization\Acme\Validators\InventoryOrganizationValidator;
use LaravelIssueTracker\InventoryOrganization\Models\InventoryOrganization;

class InventoryOrganizationCreatorService
{

    /**
     * @var InventoryOrganizationValidator
     */
    private $validator;

    /**
     * @var string
     */
    protected static $validationFailedMessage = 'Inventory Organization Validation Failed';

    /**
     * InventoryOrganizationCreatorService constructor.
     * @param InventoryOrganizationValidator $validator
     */
    public function __construct(InventoryOrganizationValidator $validator)
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
            return InventoryOrganization::create($requestArray);
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
            return InventoryOrganization::findOrFail($id)->update($requestArray);
        }

        throw new ValidationException(self::$validationFailedMessage, $this->validator->getErrors());
    }

    /**
     * @param $id
     * @return int
     */
    public function destroy($id)
    {
        if( InventoryOrganization::find($id)->exists() )
        {
            return InventoryOrganization::destroy($id);
        }

        throw new ValidationException('Inventory Organization does not exists');
    }

}