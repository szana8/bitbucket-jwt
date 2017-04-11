<?php

namespace LaravelIssueTracker\Core\Acme\Services;

use LaravelIssueTracker\Core\Acme\Validators\ApiValidatorInterface;

interface ApiServiceInterface {

    /**
     * ApiServiceInterface constructor.
     * @param ApiValidatorInterface $validator
     */
    public function __construct(ApiValidatorInterface $validator);

    /**
     * @param $requestArray
     * @return mixed
     */
    public function make($requestArray);

    /**
     * @param $requestArray
     * @param $id
     * @return mixed
     */
    public function update($requestArray, $id);


    public function destroy($id);
}