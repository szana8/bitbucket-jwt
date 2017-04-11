<?php

namespace LaravelIssueTracker\Locations\Acme\Services;

use LaravelIssueTracker\Locations\Acme\Validators\LocationValidator;
use LaravelIssueTracker\Locations\Models\Location;

class LocationCreatorService {

    /**
     * @var LocationValidator
     */
    private $locationValidator;

    /**
     * LocationCreatorService constructor.
     * @param LocationValidator $locationValidator
     */
    public function __construct(LocationValidator $locationValidator)
    {
        $this->locationValidator = $locationValidator;
    }

    /**
     * @param $requestArray
     * @return mixed
     */
    public function make($requestArray)
    {
        if( $this->validator->isValidForInsert($requestArray) )
        {
            return Location::create($requestArray);
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
            return Location::findOrFail($id)->update($requestArray);
        }

        throw new ValidationException(self::$validationFailedMessage, $this->validator->getErrors());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        if( Location::find($id)->exists() )
        {
            return Location::destroy($id);
        }

        throw new ValidationException('Location not exists');
    }
}