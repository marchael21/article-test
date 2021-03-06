<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * Get the vehicle stats
     */
    public function vehicleStatistic()
    {
        return $this->hasOne('App\Models\vehicleStatistic', 'vehicle_id');
    }
}
