<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomizationRequest extends Model
{
    protected $fillable = [
        'house_plan_id',
        'name',
        'email',
        'phone',
        'message',
        'status',
    ];

    public function housePlan()
    {
        return $this->belongsTo(HousePlan::class);
    }
}
