<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\BaseModel
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model {
    //
    use SoftDeletes;
    protected $dates = ['created_at','updated_at', 'deleted_at'];
    protected $nullable = [];

    /**
     * Listen for save event
     */
    protected static function boot() {
        parent::boot();

        static::saving(function($model) {
            self::setNullables($model);
        });
    }

    /**
     * Set empty nullable fields to null
     * @param object $model
     */
    protected static function setNullables($model) {
        foreach($model->nullable as $field) {
            if(empty($model->{$field})) {
                $model->{$field} = null;
            }
        }
    }

    public function getTableColumns(): array {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
