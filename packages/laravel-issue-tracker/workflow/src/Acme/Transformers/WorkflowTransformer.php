<?php

namespace LaravelIssueTracker\Workflow\Acme\Transformers;

use LaravelIssueTracker\Core\Acme\Transformers\Transformer;

class WorkflowTransformer extends Transformer {


    /**
     * Abstract function for the transformation, need to be implement in the child class.
     * @param $item
     * @return mixed
     */
    public function transform($item)
    {
        return $item;
    }
}