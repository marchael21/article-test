<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
	/**
	 * Get the user's full name.
	 *
	 * @return string
	 */
	public function getScheduleAttribute()
	{

		$dateRange = getDateRAnge($this->departure_date, $this->return_date);

	    return "{$dateRange}";
	}

    /**
     * Get the current booking status
     */
    public function bookingStatus()
    {
        return $this->belongsTo('App\Models\BookingStatus', 'status');
    }

    /**
     * Get the current booking status
     */
    public function bookingCurrentHistory()
    {
        return $this->hasOne('App\Models\BookingHistory', 'booking_id')->orderBy('id', 'desc');
    }


    /**
     * Get the assigned driver
     */
    public function driver()
    {
        return $this->belongsTo('App\User', 'driver_id');
    }

    /**
     * Get the assigned driver
     */
    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle', 'vehicle_id');
    }


}
