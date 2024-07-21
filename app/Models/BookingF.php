<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingF extends Model
{
    use HasFactory; 
    protected $connection = 'mysql2';
    protected $table  = "bookings";
    public $fillable=[
        'booking_from',
        'booking_id',
        'trip',
        'trip_type',
        'trip_stop',
        'gds_pnr',
        'airline_pnr',
        'email',
        'mobile',
        'itinerary',
        'baggage',
        'passenger',
        'fare',
        'status'
        ];
}
