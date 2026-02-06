<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 8/27/2019
 * Time: 5:20 PM
 */

class filterTicket
{


    public function __construct($ticket, $options)
    {

    }

    public function filterTicket($ticket, $options)
    {
        $isShow = true;
        foreach ($options as $key => $option) {
            $isShow=  $isShow && $this->$key($ticket, $option);
        }
        return $isShow;
    }

    public function interrupt($ticket, $option)
    {
        $countInterrupt = count($ticket['OutputRoutes']);

        switch ($countInterrupt) {
            case '1':
                $interruptShow = 'NoInterrupt';
                break;
            case '2':
                $interruptShow = 'OneInterrupt';
                break;
            case '3':
                $interruptShow = 'TwoInterrupt';
                break;
            default:
                $interruptShow = 'NoInterrupt';
                break;
        }

        $flag = true;

        foreach ($option as $keyOption => $item) {
           if($item=='allStop')
           {
               $flag = true ;
           }else{
               if (in_array($interruptShow, $option)) {
                   $flag = true;
               } else {
                   $flag = false;
               }
           }
        }


        if ($flag) {
            return true;
        }else{
            return false;
        }

    }


    public function flightType($ticket, $option)
    {

        $flag = true;

        $flightTypeShow = strtolower($ticket['FlightType']);

        foreach ($option as $keyOption => $flightType) {
            if($flightType=='allFlightType')
            {
                $flag = true ;
            }else{
                if (in_array($flightTypeShow, $option)) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }

        }


        if ($flag) {
            return true;
        }else{
            return false;
        }


    }


    public function seatClass($ticket, $option)
    {
        $seatClass = ($ticket['seatClass']=='B' || $ticket['seatClass']=='C') ? 'business':'economy';

        $flag = true;

        foreach ($option as $keyOption => $flightType) {
            if($flightType=='allSeatClass')
            {
                $flag = true ;
            }else {
                if (in_array($seatClass, $option)) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
        }


        if ($flag) {
            return true;
        }else{
            return false;
        }


    }


    public function airlinesCode($ticket, $option)
    {
        $flag = true;

        foreach ($option as $keyOption => $flightType) {
            if($flightType=='allAirline')
            {
                $flag = true ;
            }else {
                if (in_array($ticket['OutputRoutes'][0]['Airline']['Code'], $option)) {

                    $flag = true;
                } else {
                    $flag = false;
                }
            }
        }

        if ($flag) {
            return true;
        }else{
            return false;
        }


    }


    public function time($ticket, $option)
    {
        $timeShow = functions::format_hour($ticket['OutputRoutes'][0]['DepartureTime']);
        $time = '';
        if ($timeShow < 8) {
            $time =  'early';
        } elseif ($timeShow < 12) {
            $time =  'morning';
        } elseif ($timeShow < 18) {
            $time =  'afternoon';
        } elseif ($timeShow < 24) {
            $time =  'night';
        }
        $flag = true;

            if (in_array(trim($time), $option)) {
                 $flag = true;
            } else {
                 $flag = false;
            }

        if ($flag) {
            return true;
        }else{
            return false;
        }


    }

}