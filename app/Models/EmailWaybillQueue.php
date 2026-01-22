<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmailWaybillQueue
 *
 * @property int $id
 * @property string|null $email_to
 * @property string|null $email_bcc
 * @property string|null $subject
 * @property string|null $content
 * @property string|null $user_name
 * @property int $pdf_type 1=>single, 2=>multiple
 * @property string $pdf_ids
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $attach_data_extension
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue whereAttachDataExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue whereEmailBcc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue whereEmailTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue wherePdfIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue wherePdfType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailWaybillQueue whereUserName($value)
 * @mixin \Eloquent
 */
class EmailWaybillQueue extends Model
{
    use HasFactory;
    protected $fillable = [
      'email_to',
      'email_bcc',
      'subject',
      'content',
      'user_name',
      'pdf_type', // 1=>single, 2=>multiple
      'pdf_ids',
      'attach_data_extension',
    ];
}
