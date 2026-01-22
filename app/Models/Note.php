<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Note
 *
 * @property int $id
 * @property string|null $news
 * @property string|null $useful_links_1
 * @property string|null $useful_links_2
 * @property string|null $quick_links_1
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note query()
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereNews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereQuickLinks1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUsefulLinks1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUsefulLinks2($value)
 * @mixin \Eloquent
 */
class Note extends Model
{
    use HasFactory;
    protected $fillable = [
      'news',
      'useful_links_1',
      'useful_links_2',
      'quick_links_1',
    ];
}
