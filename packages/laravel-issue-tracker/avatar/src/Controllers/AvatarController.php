<?php

namespace LaravelIssueTracker\Avatar\Controllers;

use LaravelIssueTracker\Avatar\Models\Avatar;
use LaravelIssueTracker\Core\Acme\Validators\ValidationException;
use LaravelIssueTracker\Core\Controller\ApiController;
use LaravelIssueTracker\Avatar\Acme\Services\AvatarCreatorService;
use LaravelIssueTracker\Avatar\Acme\Transformers\AvatarTransformer;

class AvatarController extends ApiController {

    /**
     * @var AvatarTransformer
     */
    private $transformer;
    /**
     * @var AvatarCreatorService
     */
    private $creatorService;

    /**
     * ApiControllerInterface constructor.
     * @param AvatarTransformer $transformer
     * @param AvatarCreatorService $creatorService
     */
    public function __construct(AvatarTransformer $transformer, AvatarCreatorService $creatorService)
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
        $avatar = Avatar::paginate($this->limit);

        return $this->responsWithPaginaton($avatar, [
            'data' => $this->transformer->transformCollection($avatar->all())
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
            return $this->respondCreated('Avatar created!');
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
        $avatar = Avatar::find($id);

        if( ! $avatar )
        {
            return $this->respondNotFound('Avatar does not exist');
        }

        return $this->respond([
            'data' => $this->transformer->transform($avatar)
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
            return $this->respondCreated('Avatar updated!');
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
            //
            $this->creatorService->destroy($id);
            return $this->respondCreated('Avatar destroyed!');
        }
        catch(ValidationException $e) {
            return $this->respondUnprocessable($e->getMessage());
        }
    }
}