<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmailQueue
 *
 * @property int $id
 * @property string $email
 * @property string|null $subject
 * @property string|null $content
 * @property int $is_sent
 * @property int $type
 * @property string|null $email_bcc
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmailQueue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailQueue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailQueue query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailQueue whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailQueue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailQueue whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailQueue whereEmailBcc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailQueue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailQueue whereIsSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailQueue whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailQueue whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailQueue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EmailQueue extends Model
{
    use HasFactory;
    protected $fillable = [
      'email',
      'email_bcc',
      'subject',
      'content',
      'type',  // 1 => update_price, 2 => approve_submission
      'is_sent',
    ];
}
