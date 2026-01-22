<?php

namespace App\Models;

use App\Models\BaseModel;
use Storage;

/**
 * App\Models\File
 *
 * @property integer $id
 * @property integer $morph_id
 * @property string $morph_type
 * @property string $path
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string|null $name
 * @property-read mixed $background
 * @property-read mixed $icon
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $morph
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereMorphId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereMorphType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|File withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|File withoutTrashed()
 * @mixin \Eloquent
 */
class File extends BaseModel {
    /**
     * @var array
     */
    protected $fillable = ['morph_id', 'morph_type', 'name', 'path', 'created_at', 'updated_at', 'deleted_at'];

    public function morph() {
        return $this->morphTo();
    }

    //Helper save file
    public static function saveFile($model, $path, $content, $name = null) {
        Storage::put($path, $content);

        $file = new File();
        $file->name = $name;
        $file->path = $path;
        return $model->{'files'}()->save($file);
    }
}
