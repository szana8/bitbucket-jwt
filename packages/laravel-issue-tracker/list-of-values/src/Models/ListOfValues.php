<?php
namespace LaravelIssueTracker\ListOfValues\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelIssueTracker\ListOfValues\Events\ListOfValueWasCreated;
use LaravelIssueTracker\ListOfValues\Events\ListOfValueWasDestroyed;
use LaravelIssueTracker\ListOfValues\Events\ListOfValueWasUpdated;

/**
 * Class ListOfValues
 * @package LaravelIssueTracker\ListOfValues\Models
 */
class ListOfValues extends Model
{
    /**
     * These fields are mandatory.
     * @var array
     */
    protected $fillable = [
        'name',
        'datatype',
        'table_name',
        'column',
        'condition',
    ];

    /**
     * We don't want to save the lookups object to this table.
     * @var array
     */
    protected $guarded = [
        'lookups',
    ];

    /**
     * Eloquent model fired events.
     * @var array
     */
    protected $events = [
        'created' => ListOfValueWasCreated::class,
        'updated' => ListOfValueWasUpdated::class,
        'deleted' => ListOfValueWasDestroyed::class
    ];

    /**
     * Join the lookup values eloquent model to this.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lookups()
    {
        return $this->hasMany('\LaravelIssueTracker\ListOfValues\Models\ListOfValuesLookups');
    }

    /**
     * @param $query
     * @param string $search
     * @return mixed
     */
    public function scopeSearchInDefaultColumns($query, $search = null)
    {
        if ( ! $search )
            return $query;

        return $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('table', 'like', '%' . $search . '%')
                      ->orWhere('column', 'like', '%' . $search . '%')
                      ->orWhere('datatype', 'like', '%' . $search . '%');
    }

}