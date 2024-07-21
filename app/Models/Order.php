<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['payment_id' , 'order_id' ,'customerName' ,'customerPhone' ,'customerEmail' ,'amount' ,'discount' ,'gst' ,'total' ,'status' ,'status_id'];
}
