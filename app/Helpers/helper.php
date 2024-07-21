<?php

if (!function_exists('data_print')) {
    function data_print($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}

if (!function_exists('getTotalTaxes')) {
    function getTotalTaxes($adt, $chd, $inf, $otherMonetaryAdt, $otherMonetaryChd, $otherMonetaryInf, $monetaryAdt, $monetaryChd, $monetaryInf)
    {
        $total = array_sum([$adt * $otherMonetaryAdt, $chd * $otherMonetaryChd, $inf * $otherMonetaryInf]) - array_sum([$adt * $monetaryAdt, $chd * $monetaryChd, $inf * $monetaryInf]);
        return $total;
    }
}

if (!function_exists('getTotalTaxesWithGal')) {
    function getTotalTaxesWithGal($adt, $chd, $inf, $otherMonetaryAdt, $otherMonetaryChd, $otherMonetaryInf, $monetaryAdt, $monetaryChd, $monetaryInf, $galtaxesFare)
    {
        $total = array_sum([array_sum([$adt * $otherMonetaryAdt, $chd * $otherMonetaryChd, $inf * $otherMonetaryInf]) - array_sum([$adt * $monetaryAdt, $chd * $monetaryChd, $inf * $monetaryInf]), $galtaxesFare]);
        return $total;
    }
}

if (!function_exists('getTotalAmount')) {
    function getTotalAmount($adt, $chd, $inf, $otherMonetaryAdt, $otherMonetaryChd, $otherMonetaryInf)
    {
        $total = array_sum([$adt * $otherMonetaryAdt, $chd * $otherMonetaryChd, $inf * $otherMonetaryInf]);
        return $total;
    }
}

if (!function_exists('getTotalAmountWithGal')) {
    function getTotalAmountWithGal($adt, $chd, $inf, $otherMonetaryAdt, $otherMonetaryChd, $otherMonetaryInf, $galtotalfare)
    {
        $total = array_sum([$adt * $otherMonetaryAdt, $chd * $otherMonetaryChd, $inf * $otherMonetaryInf, $galtotalfare]);
        return $total;
    }
}

if (!function_exists('getTime_fn')) {
    function getTime_fn($data)
    {
        if (strlen($data) == 3) {
            $data = "0" . $data;
            $data = date('H:i', strtotime($data));
        } elseif (strlen($data) == 2) {
            $data = "00" . $data;
            $data = date('H:i', strtotime($data));
        } else {
            $data = date('H:i', strtotime($data));
        }

        return $data;
    }
}

if (!function_exists('getDate_fn')) {
    function getDate_fn($data)
    {
        if (strlen($data) == 6) {
            $date = \DateTime::createFromFormat("dmy", $data);
            $data = $date->format('D, d M Y');
        } else {
            $date = \DateTime::createFromFormat("dmY", $data);
            $data = $date->format('D, d M Y');
        }
        return $data;
    }
}
if (!function_exists('NOgetDate_fn')) {
    function NOgetDate_fn($data)
    {
        if (strlen($data) == 6) {
            $date = \DateTime::createFromFormat("dmy", $data);
            $data = $date->format('D,%20d%20M%20Y');
        } else {
            $date = \DateTime::createFromFormat("dmY", $data);
            $data = $date->format('D,%20d%20M%20Y');
        }
        return $data;
    }
}

if (!function_exists('getDateFormat')) {
    function getDateFormat($date)
    {
        $resDate = \DateTime::createFromFormat('Y-m-d\TH:i:s', $date);
        $resDate = $resDate->format('D, d M Y');
        return $resDate;

    }
}

if (!function_exists('getTimeFormat')) {
    function getTimeFormat($date)
    {
        $resDate = \DateTime::createFromFormat('Y-m-d\TH:i:s', $date);
        $resDate = $resDate->format('H:i');
        return $resDate;
    }
}

// "2021-12-25T13:20:00"  

if (!function_exists('getTimeFormat_db')) {
    function getTimeFormat_db($date)
    {
        $resDate = \DateTime::createFromFormat('Y-m-d\TH:i:s.vP', $date);
        $resDate = $resDate->format('H:i');
        return $resDate;
    }
}

if (!function_exists('NOgetDateFormat_db')) {
    function NOgetDateFormat_db($date)
    {
        $resDate = \DateTime::createFromFormat('Y-m-d\TH:i:s.vP', $date);
        // "2021-12-20T13:40:00.000+05:30"
        $resDate = $resDate->format('D,%20d%20M%20Y');
        return $resDate;

    }
}
if (!function_exists('getDateFormat_db')) {
    function getDateFormat_db($date)
    {
        $resDate = \DateTime::createFromFormat('Y-m-d\TH:i:s.vP', $date);
        // "2021-12-20T13:40:00.000+05:30"
        $resDate = $resDate->format('D, d M Y');
        return $resDate;

    }
}

if (!function_exists('getTimeDff_fn')) {
    function getTimeDff_fn($segmentInformationArr, $segmentInformationDep)
    {

        $ddate = $segmentInformationArr->flightDetails->flightDate->arrivalDate;
        $dtime = $segmentInformationArr->flightDetails->flightDate->arrivalTime;
        $adate = $segmentInformationDep->flightDetails->flightDate->departureDate;
        $atime = $segmentInformationDep->flightDetails->flightDate->departureTime;

        if (strlen($dtime) == 3) {
            $dtime = "0" . $dtime;
            $dtime = date('H:i', strtotime($dtime));
        } elseif (strlen($dtime) == 2) {
            $dtime = "00" . $dtime;
            $dtime = date('H:i', strtotime($dtime));
        } else {
            $dtime = date('H:i', strtotime($dtime));
        }

        if (strlen($atime) == 3) {
            $atime = "0" . $atime;
            $atime = date('H:i', strtotime($atime));
        } elseif (strlen($atime) == 2) {
            $atime = "00" . $atime;
            $atime = date('H:i', strtotime($atime));
        } else {
            $atime = date('H:i', strtotime($atime));
        }

        $date1 = \DateTime::createFromFormat('dmy H:i', $ddate . " " . $dtime);
        $date2 = \DateTime::createFromFormat('dmy H:i', $adate . " " . $atime);

        $interval = $date1->diff($date2);

        if ($interval->d > 0) {
            $data = $interval->d . 'd ' . $interval->format("%h") . 'h :' . $interval->format("%i") . 'm';
        } else {
            $data = $interval->format("%h") . 'h :' . $interval->format("%i") . 'm';
        }
        return $data . ' Layover in ' . $segmentInformationArr->flightDetails->offpointDetails->trueLocationId;
    }

    if (!function_exists('getTimeDff_formated')) {
        function getTimeDff_formated($ArrDate, $DepDate)
        {

            // dd([$ArrDate, $DepDate]);
            $date1 = \DateTime::createFromFormat('Y-m-d\TH:i:s', $ArrDate);
            $date2 = \DateTime::createFromFormat('Y-m-d\TH:i:s', $DepDate);

            $interval = $date1->diff($date2);

            if ($interval->d > 0) {
                $data = $interval->d . 'd ' . $interval->format("%h") . 'h :' . $interval->format("%i") . 'm';
            } else {
                $data = $interval->format("%h") . 'h :' . $interval->format("%i") . 'm';
            }
            return $data . ' Layover in ';
        }
    }

    if (!function_exists('consoleLog')) {
        function consoleLog($message)
        {
            $data = '<script type="text/javascript">' . 'console.log(' . $message . ')</script>';
            return $data;
        }
    }

}
