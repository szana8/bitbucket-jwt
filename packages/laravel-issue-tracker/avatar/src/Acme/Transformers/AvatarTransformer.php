<?php

namespace LaravelIssueTracker\Avatar\Acme\Transformers;

use LaravelIssueTracker\Core\Acme\Transformers\Transformer;

class AvatarTransformer extends Transformer {

    /**
     * @param $item
     * @return mixed
     */
    public function transform($item)
    {
        return $item;
    }

}