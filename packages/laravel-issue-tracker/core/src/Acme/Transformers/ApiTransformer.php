<?php
/**
 * Created by PhpStorm.
 * User: HUSzanaI
 * Date: 2017. 04. 11.
 * Time: 11:27
 */

namespace LaravelIssueTracker\Core\Acme\Transformers;


interface ApiTransformer {

    /**
     * Transform the object to the appropriate array.
     * @param $object
     * @return mixed
     */
    public function transform($object);

}