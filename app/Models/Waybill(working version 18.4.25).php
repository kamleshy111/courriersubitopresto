<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Waybill
 *
 * @property int                             $id
 * @property int                             $soft_id
 * @property int                             $shipper_id
 * @property int                             $recipient_id
 * @property string                          $who_pay
 * @property string                          $status
 * @property string|null                     $description
 * @property string|null                     $details
 * @property string|null                     $cost_1
 * @property string|null                     $cost_2
 * @property string|null                     $hazardous_materials_1
 * @property string|null                     $hazardous_materials_2
 * @property string|null                     $weight_1
 * @property string|null                     $weight_2
 * @property string|null                     $cubing_1
 * @property string|null                     $cubing_2
 * @property string|null                     $waiting_time_1
 * @property string|null                     $waiting_time_2
 * @property int|null                        $round_trip_1
 * @property string|null                     $round_trip_2
 * @property string|null                     $truck_1
 * @property string|null                     $truck_2
 * @property string|null                     $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Client|null    $recipent
 * @property-read \App\Models\Client|null    $shipper
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill newQuery()
 * @method static \Illuminate\Database\Query\Builder|Waybill onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill query()
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereCost1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereCost2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereCubing1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereCubing2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereHazardousMaterials1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereHazardousMaterials2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereRecipientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereRoundTrip1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereRoundTrip2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereShipperId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereSoftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereTruck1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereTruck2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereWaitingTime1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereWaitingTime2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereWeight1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereWeight2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereWhoPay($value)
 * @method static \Illuminate\Database\Query\Builder|Waybill withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Waybill withoutTrashed()
 * @property string                          $date
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereDate($value)
 * @property-read \App\Models\Client $recipient
 * @property int $user_id
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereUserId($value)
 * @property string|null $shipper_contact
 * @property string|null $recipient_contact
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereRecipientContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereShipperContact($value)
 * @property int|null $status_id
 * @property int|null $dispatch_id
 * @property int|null $driver_id
 * @property string|null $note_permanent
 * @property int|null $delivery_status
 * @property int|null $type 0 => waybill, 1 => submissions
 * @property int|null $submission_status Null => nothing,0 => rejected, 1 => approved
 * @property string|null $price
 * @property-read \App\Models\Status|null $statusModel
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereDeliveryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereDispatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereNotePermanent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereSubmissionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Waybill whereType($value)
 * @mixin \Eloquent
 */
class Waybill extends BaseModel {
    public $timestamps = true;

    use SoftDeletes;

    public $rules = [
        '*.date'                  => 'required|date',
        '*.description'           => 'required|max:255',
        '*.who_pay'               => 'required|in:shipper,recipient,other',
        '*.status'                => 'required|in:night,code_red,very_urgent,urgent,same_day,tomorrow,tomorrow_48h',
        '*.shipper_id'            => 'required_without_all:*.shipper.name,*.shipper.phone,*.shipper.address,*.shipper.city_name,*.shipper.postal_code|nullable|exists:clients,id',
        '*.recipient_id'          => 'required_without_all:*.recipient.name,*.recipient.phone,*.recipient.address,*.recipient.city_name,*.recipient.postal_code|nullable|exists:clients,id',
        '*.shipper.name'          => 'required_without:*.shipper_id|max:50',
        '*.shipper.phone'         => 'required_without:*.shipper_id|max:10',
        '*.shipper.address'       => 'required_without:*.shipper_id|max:70',
        '*.shipper.city_name'       => 'required_without:*.shipper_id|max:30',
        '*.shipper.postal_code'   => 'required_without:*.shipper_id|max:7',
        '*.shipper.contact'       => 'required_without:*.shipper_id|max:70',
        '*.recipient.name'        => 'required_without:*.recipient_id|max:50',
        '*.recipient.phone'       => 'required_without:*.recipient_id|max:10',
        '*.recipient.address'     => 'required_without:*.recipient_id|max:70',
        '*.recipient.city_name'     => 'required_without:*.recipient_id',
        '*.recipient.postal_code' => 'required_without:*.recipient_id|max:7',
        '*.recipient.contact'     => 'required_without:*.recipient_id|max:70',
        '*.note_permanent'         => 'nullable|max:95'
    ];

    public $rules_update = [
        'date'                  => 'required|date',
        'description'           => 'required|max:255',
        'who_pay'               => 'required|in:shipper,recipient,other',
        'status'                => 'required|in:night,code_red,very_urgent,urgent,same_day,tomorrow,tomorrow_48h',
        'shipper_id'            => 'required_without_all:shipper.name,shipper.phone,shipper.address,shipper.city_name,shipper.postal_code|nullable|exists:clients,id',
        'recipient_id'          => 'required_without_all:recipient.name,recipient.phone,recipient.address,recipient.city_name,recipient.postal_code|nullable|exists:clients,id',
        'shipper.name'          => 'required_without:shipper_id|max:50',
        'shipper.phone'         => 'required_without:shipper_id|max:10',
        'shipper.address'       => 'required_without:shipper_id|max:70',
        'shipper.city_name'       => 'required_without:shipper_id',
        'shipper.postal_code'   => 'required_without:shipper_id|max:7',
        'shipper.contact'       => 'required_without:shipper_id|max:70',
        'recipient.name'        => 'required_without:recipient_id|max:50',
        'recipient.phone'       => 'required_without:recipient_id|max:10',
        'recipient.address'     => 'required_without:recipient_id|max:70',
        'recipient.city_name'     => 'required_without:recipient_id',
        'recipient.postal_code' => 'required_without:recipient_id|max:7',
        'recipient.contact'     => 'required_without:recipient_id|max:70',
        '*.note_permanent'      => 'nullable|max:95',
        '*.price'               => 'nullable|numeric'
    ];

    protected $fillable = [
        'user_id',
        'soft_id',
        'shipper_id',
        'shipper_contact',
        'recipient_id',
        'recipient_contact',
        'date',
        'who_pay',
        'status',
        'description',
        'details',
        'cost_1',
        'cost_2',
        'hazardous_materials_1',
        'hazardous_materials_2',
        'weight_1',
        'weight_2',
        'cubing_1',
        'cubing_2',
        'waiting_time_1',
        'waiting_time_2',
        'round_trip_1',
        'round_trip_2',
        'truck_1',
        'truck_2',
        'total',
        'status_id',
        'dispatch_id',
        'driver_id',
        'note_permanent',
        'delivery_status',
        'type',
        'submission_status',
        'price',
    ];

    protected $dates = ['date'];
    protected static function boot() {
        parent::boot();
        self::creating(function($model) {
            $model->user_id =\Auth::id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shipper()
    {
        return $this->belongsTo(Client::class, 'shipper_id')->withTrashed();
    }

    public function recipient()
    {
        return $this->belongsTo(Client::class, 'recipient_id')->withTrashed();
    }

    public function statusModel()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    
    public function driver()
{
    return $this->belongsTo(User::class, 'driver_id', 'id');
}
}
