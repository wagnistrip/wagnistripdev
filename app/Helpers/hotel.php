<?php
if (!function_exists('roomTypeCode')) {
    function roomTypeCode($data)
    {
        $firstLater = substr($data, 0, 1);
        $secondLater = substr($data, 1, 1);
        $thrdLater = substr($data, 2, 1);
        //    dd([$firstLater,$secondLater,$thrdLater]);
        switch ($firstLater) {
            case 'A':
                $roomType = 'Superior Room With Bath/Shower';
                break;

            case 'B':
                $roomType = 'Moderate Room With Bath/Shower';
                break;

            case 'C':
                $roomType = 'Standard Room With Bath/Shower';
                break;

            case 'D':
                $roomType = 'Minimum Room With Bath/Shower';
                break;

            case 'E':
                $roomType = 'Superior Room With Shower';
                break;

            case 'F':
                $roomType = 'Moderate Room With Shower';
                break;

            case 'G':
                $roomType = 'Standard Room With Shower';
                break;

            case 'H':
                $roomType = 'Minimum Room With Shower';
                break;

            case 'I':
                $roomType = 'Moderate Room';
                break;

            case 'J':
                $roomType = 'Standard Room';
                break;

            case 'K':
                $roomType = 'Minimum Room';
                break;

            case 'N':
                $roomType = 'Non-Smoking Room';
                break;

            case 'p':
                $roomType = 'Executive Floor Room';
                break;

            case 'S':
                $roomType = 'Moderate Suites Room';
                break;

            case 'T':
                $roomType = 'Standard Suites Room';
                break;

            case 'U':
                $roomType = 'Minimum Suites Room';
                break;

            case '*':
                $roomType = '';
                break;
    
            default:
                $roomType = '';
                break;
        }

        switch ($thrdLater) {
            case 'D':
                $bedType = 'Double Size Bed';
                break;

            case 'K':
                $bedType = 'King Size Bed';
                break;

            case 'P':
                $bedType = 'Pullout Size Bed';
                break;

            case 'Q':
                $bedType = 'Queen Size Bed';
                break;

            case 'S':
                $bedType = 'Single Bed';
                break;

            case 'T':
                $bedType = 'Twin Bed';
                break;

            case 'W':
                $bedType = 'Weter Bed';
                break;

            case '*':
                $bedType = '';
                break;

            default:
                $bedType = '';
                break;
        }

        return $roomType . ' ' . $bedType;
    }
}
