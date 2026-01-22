<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Client
 *
 * @property int                                                                 $id
 * @property string                                                              $prefix
 * @property string                                                              $name
 * @property string                                                              $phone
 * @property string                                                              $address
 * @property int                                                                 $city_id
 * @property string                                                              $postal_code
 * @property string|null                                                         $contact
 * @property \Illuminate\Support\Carbon|null                                     $created_at
 * @property \Illuminate\Support\Carbon|null                                     $updated_at
 * @property \Illuminate\Support\Carbon|null                                     $deleted_at
 * @property-read \App\Models\City|null                                          $city
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Query\Builder|Client onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Client withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Client withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Waybill[] $waybills
 * @property-read int|null                                                       $waybills_count
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePrefix($value)
 * @property int $user_id
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUserId($value)
 * @property string|null $extension
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereExtension($value)
 * @property string|null $note_permanent
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereNotePermanent($value)
 * @mixin \Eloquent
 */
class Client extends Model {

    protected $table      = 'clients';
    public    $timestamps = true;

    use SoftDeletes;

    protected $dates    = ['deleted_at'];
    protected $fillable = [
        'prefix',
        'name',
        'phone',
        'extension',
        'address',
        'city_id',
        'postal_code',
        'contact',
        'note_permanent',
        'city_name',
        'city_state'
    ];
    public    $rules    = [
        'prefix'             => 'nullable|max:6',
        'name'               => 'required|min:3|max:50',
        'phone'              => 'required|string|max:10',
        'extension'          => 'nullable|string|max:10',
        'address'            => 'required|max:70',
        'postal_code'        => 'required|max:7',
        'contact'            => 'nullable|max:70',
        'note_permanent'     => 'nullable|max:95',
        'city_name'         => 'nullable|max:95',
        'city_state'         => 'nullable|max:95'
    ];

    protected static function boot() {
        parent::boot();
        self::creating(function($model) {
            $model->user_id = \Auth::id();
            if(is_null($model->prefix)) {
                $parts         = str_split($model->name);
                $model->prefix = mb_strtoupper($parts[0] . $parts[1]);
            }
        });
    }

    public function city() {
        return $this->belongsTo('App\Models\City');
    }


    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function waybills() {
        return $this->hasMany('App\Models\Waybill', 'shipper_id');
    }

}
