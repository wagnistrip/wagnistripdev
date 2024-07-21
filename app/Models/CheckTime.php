<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckTime extends Model
{
    use HasFactory;
    //to check if the current time lies b/w 9 AM  to 6:30 in pm
    public static function checktimeandpricing($amt){
        $now = date('H:i:s' , strtotime("+330 minutes"));
        $bool1 = strtotime($now) > strtotime('09:00:00');
        $bool2 = strtotime($now) < strtotime('19:29:00');
        $bool1 = true;
        $bool2 = true;
        if($bool1 && $bool2){
            return 1;
        }
        else{
            return $amt;
        }
    }
}
