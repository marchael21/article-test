<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleStatistic extends Model
{
    /**
     * Get the vehicle info
     */
    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle');
    }

    /**
     * Get the user who last updated the vehicle
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }

}
