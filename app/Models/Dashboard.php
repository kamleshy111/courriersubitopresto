<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    protected $table      = 'dashboard';
    // public    $timestamps = true;

    // use SoftDeletes;

    // protected $dates    = ['deleted_at'];
    protected $fillable = [
        'id',
        'note',
        'cheque_note',
        'active_cheque',
        'active_absent'
    ];
    public    $rules    = [
        // 'id'             => 'required|max:1000',
        'note'               => 'nullable|min:1|max:1000',
        'cheque_note'        => 'nullable|string|max:500',
        'active_cheque'      => 'boolean',
        'active_absent'      => 'boolean'
    ];

}
