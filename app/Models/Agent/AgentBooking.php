<?php

namespace App\Models\Agent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentBooking extends Model
{
    use HasFactory;
    
 protected $connection = 'mysql2';
}