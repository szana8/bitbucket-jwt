<?php

namespace LaravelIssueTracker\Authorization\Acme\Transformers;

use LaravelIssueTracker\Core\Acme\Transformers\Transformer;

class RoleTransformer extends Transformer {

    /**
     * Abstract function for the transformation, need to be implement in the child class.
     *
     * @param $item
     * @return mixed
     */
    public function transform($item)
    {
        // TODO: Implement transform() method.
        return $item;
    }
}