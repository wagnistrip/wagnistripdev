<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currencycode extends Model
{
    use HasFactory;
    protected $table = 'currency';
    protected $primaryKey = 'id';
}
