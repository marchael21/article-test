<?php

use App\User;
use App\Models\Booking;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

/**
 *  Custom Helpers
 */

if (! function_exists('assetUrl')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function assetUrl($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}

if (! function_exists('generateRandomValue')) {
    /**
     * Generate Random String
     *
     * @param  integer $num
     * @return string
     */
    function generateRandomValue($num) {
        switch($num) {
            case "1"  : $randValue = "a"; break;
            case "2"  : $randValue = "b"; break;
            case "3"  : $randValue = "c"; break;
            case "4"  : $randValue = "d"; break;
            case "5"  : $randValue = "e"; break;
            case "6"  : $randValue = "f"; break;
            case "7"  : $randValue = "g"; break;
            case "8"  : $randValue = "h"; break;
            case "9"  : $randValue = "i"; break;
            case "10" : $randValue = "j"; break;
            case "11" : $randValue = "k"; break;
            case "12" : $randValue = "l"; break;
            case "13" : $randValue = "m"; break;
            case "14" : $randValue = "n"; break;
            case "15" : $randValue = "o"; break;
            case "16" : $randValue = "p"; break;
            case "17" : $randValue = "q"; break;
            case "18" : $randValue = "r"; break;
            case "19" : $randValue = "s"; break;
            case "20" : $randValue = "t"; break;
            case "21" : $randValue = "u"; break;
            case "22" : $randValue = "v"; break;
            case "23" : $randValue = "w"; break;
            case "24" : $randValue = "x"; break;
            case "25" : $randValue = "y"; break;
            case "26" : $randValue = "z"; break;
            case "27" : $randValue = "0"; break;
            case "28" : $randValue = "1"; break;
            case "29" : $randValue = "2"; break;
            case "30" : $randValue = "3"; break;
            case "31" : $randValue = "4"; break;
            case "32" : $randValue = "5"; break;
            case "33" : $randValue = "6"; break;
            case "34" : $randValue = "7"; break;
            case "35" : $randValue = "8"; break;
            case "36" : $randValue = "9"; break;
        }
        return $randValue;
    }
}

if (! function_exists('generateRandomAlphanumeric')) {
    /**
     * Generate Random String
     *
     * @param  integer $num
     * @return string
     */
    function generateRandomAlphanumeric($length) {
        if ($length>0) {
            $randId="";
            for ($i=1; $i<=$length; $i++) {
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,36);
                $randId .= generateRandomValue($num);
            }
        }
        return $randId;
    }
}

if (! function_exists('generateRandomNumber')) {
    /**
     * Generate Random String
     *
     * @param  integer $length
     * @return string
     */
    function generateRandomNumber($length) {
        if ($length>0) {
            $randId="";
            for($i=1; $i<=$length; $i++) {
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(27,36);
                $randId .= generateRandomValue($num);
            }
        }
        return $randId;
    }
}

if (! function_exists('generateRandomLetter')) {
    /**
     * Generate Random String
     *
     * @param  integer $length
     * @return string
     */
    function generateRandomLetter($length) {
        if ($length>0) {
            $randId="";
            for($i=1; $i<=$length; $i++) {
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,26);
                $randId .= generateRandomValue($num);
            }
        }
        return $randId;
    }
}

if (! function_exists('generateBookingNumber')) {
    /**
     * Generate booking number
     *
     * @param 
     * @return string
     */
    function generateBookingNumber()
    {
        do {

            $count = Booking::count();

            $year = date('Y');
            $month = date('m');
            $day = date('d');

            $bookingNumber = $year . '-' . $month . '-' . str_pad($count + 1, 6, "0", STR_PAD_LEFT);

        } while ((Booking::where('booking_number','=',$bookingNumber)->first()) && strlen((string)$randomNumber) !== 16); // to check the transaction number already exist and have 16 digits

        return $bookingNumber;
    }
}


if (! function_exists('getDateRange')) {
    /**
     * Generate booking number
     *
     * @param 
     * @return string
     */
    function getDateRange($fromDate, $toDate)
    {
        $fromYear = date('Y', strtotime($fromDate));
        $fromMonth = date('m', strtotime($fromDate));
        $fromDay = date('d', strtotime($fromDate));

        $toYear = date('Y', strtotime($toDate));
        $toMonth = date('m', strtotime($toDate));
        $toDay = date('d', strtotime($toDate));

        if($toDate !== '' && $toDate !== '1970-01-01 00:00:00') {
            if($fromYear == $toYear) {
                if($fromMonth == $toMonth) {
                    if($fromDay == $toDay) {
                        $dateRange = date('F j, Y', strtotime($fromDate));
                    } else {
                       $dateRange = date('F', strtotime($fromDate)) . ' ' . date('j', strtotime($fromDate)) . '-' . date('j', strtotime($toDate)) . ' ' . $fromYear; 
                    }
                } else {
                    $dateRange = date('F j', strtotime($fromDate)) . ' - ' . date('F j', strtotime($toDate)) . ' ' . $fromYear;
                }
            } else {
                $dateRange = date('F j, Y', strtotime($fromDate)) . ' - ' . date('F j, Y', strtotime($toDate));
            } 
        } else {
            $dateRange = date('F j, Y', strtotime($fromDate));
        }

        return $dateRange;
    }
}

if (! function_exists('countBookings')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function countBookings()
    {
        $authId = Auth::id();

        if (Auth::user()->role_id === 3) {

            $all = Booking::where('employee_id', $authId)->count();
            $pending = Booking::where('status', 1)->where('employee_id', $authId)->count();
            $processed = Booking::where('status', 2)->where('employee_id', $authId)->count();
            $approved = Booking::where('status', 3)->where('employee_id', $authId)->count();
            $completed = Booking::where('status', 4)->where('employee_id', $authId)->count();
            $cancelled = Booking::where('status', 5)->where('employee_id', $authId)->count();

        } elseif (Auth::user()->role_id === 4) {

            $all = Booking::where('driver_id', $authId)->count();
            $pending = Booking::where('status', 1)->where('driver_id', $authId)->count();
            $processed = Booking::where('status', 2)->where('driver_id', $authId)->count();
            $approved = Booking::where('status', 3)->where('driver_id', $authId)->count();
            $completed = Booking::where('status', 4)->where('driver_id', $authId)->count();
            $cancelled = Booking::where('status', 5)->where('driver_id', $authId)->count();
            
        } else {

            $all = Booking::count();
            $pending = Booking::where('status', 1)->count();
            $processed = Booking::where('status', 2)->count();
            $approved = Booking::where('status', 3)->count();
            $completed = Booking::where('status', 4)->count();
            $cancelled = Booking::where('status', 5)->count();

        }

        $data = array(
            'all'           => $all,
            'pending'       => $pending,
            'processed'    => $processed,
            'approved'      => $approved,
            'completed'     => $completed,
            'cancelled'     => $cancelled,
        );

        return $data;
    }
}
