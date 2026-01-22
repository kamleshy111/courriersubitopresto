<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dispatch
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Dispatch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dispatch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dispatch query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dispatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dispatch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dispatch whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dispatch whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dispatch extends Model
{
    use HasFactory;
    protected $fillable = [
      'name'
    ];
}
