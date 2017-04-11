<?php

namespace LaravelIssueTracker\Core\Controller;

use LaravelIssueTracker\Core\Acme\Transformers\ApiTransformer;

interface ApiControllerInterface {

    /**
     * ApiControllerInterface constructor.
     * @param $apiTransformer
     * @param $apiCreatorService
     */
    public function __construct(ApiTransformer $apiTransformer, $apiCreatorService);

    /**
     * Display the list of the resource.
     * @return mixed
     */
    public function index();

    /**
     * Store a newly created resource in storage.
     * @return mixed
     */
    public function store();

    /**
     * Display the specified resource.
     * @param $id Resource id
     * @return mixed
     */
    public function show($id);

    /**
     * Update the specified resource in storage.
     * @param $id Resource id
     * @return mixed
     */
    public function update($id);

    /**
     * Remove the specified resource from storage.
     * @param $id Resource id
     * @return mixed
     */
    public function destroy($id);

}