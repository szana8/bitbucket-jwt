<?php
namespace LaravelIssueTracker\ListOfValues\Acme\Transformers;

use LaravelIssueTracker\Core\Acme\Transformers\Transformer;

/**
 * Class ListOfValuesTransformer
 * @package LaravelIssueTracker\ListOfValues\Acme\Transformers
 */
class ListOfValuesTransformer extends Transformer
{

    /**
     * Transform the given array to the proper style.
     *
     * @param $listOfValues
     * @return mixed
     */
    public function transform($listOfValues)
    {
        return [
            'id' => $listOfValues['id'],
            'name' => $listOfValues['name'],
            'datatype' => $listOfValues['datatype'],
            'datatypeName' => $listOfValues['datatype'] == 1 ? 'From Table' : 'From List',
            'table_name' => $listOfValues['table_name'],
            'column' => $listOfValues['column'],
            'condition' => $listOfValues['condition'],
            'lookups' => $listOfValues['lookups']
        ];
    }

}