<?php

class Dates {
    public static $mesi = array(1=>'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');
    public static $giorni = array('Domenica','Lunedì','Martedì','Mercoledì', 'Giovedì','Venerdì','Sabato');
    public static $giorniBrev = array('Dom','Lun','Mar','Mer', 'Gio','Ven','Sab');
    public static $giorniBrevToIt = array('sun'=>'dom','mon'=>'lun','tue'=>'mar','wed'=>'mer','thu'=>'gio','fri'=>'ven','sat'=>'sab');

    public static function nowDateExtend() {
        setlocale(LC_TIME,"it_IT");
        list($sett,$giorno,$mese,$anno) = explode('-',date('w-d-n-Y'));
        return self::$giorni[$sett].' '.$giorno.' '.self::$mesi[$mese].' '.$anno;
    }

    public static function nowDateExtendV2() {
        setlocale(LC_TIME,"it_IT");
        list($sett,$giorno,$mese,$anno) = explode('-',date('w-d-n-Y'));
        return $result = substr(self::$giorni[$sett], 0, 3).' '.$giorno.' '.self::$mesi[$mese].' '.$anno;
    }

    public static function nowDay() {
        return date('j/m/y');
    }

    public static function nowDayUTC($dayWithZero = true)
    {
        if ($dayWithZero) {
            return gmdate('d/m/y');
        } else{
            return gmdate('j/m/y');
        }
    }

    public static function futureDayUTC($daysToSum, $dayWithZero = true) {
        if ($dayWithZero) {
            return gmdate('d/m/y', strtotime("+".$daysToSum." days"));
        } else{
            return gmdate('j/m/y', strtotime("+".$daysToSum." days"));
        }
    }

    public static function nowTime() {
        return date('H:m');
    }


    public static function nowTimeUTC() {
        return gmdate('H:m');
    }

    public static function nowHoursUTC() {
        return gmdate('H');
    }

    public static function nowMinutesUTC() {
        return gmdate('i');
    }

    public static function format($fmt, $date) {
        return date($fmt, strtotime($date));
    }

    public static function nowTs() {
        $date = new DateTime();
        return $date->getTimestamp();
    }

    public static function dmY($date) {
        return explode('-',date('d-m-Y', strtotime($date)));
    }

    public static function dmYToDate($day,$month,$year) {
        return explode('-',date('d-m-Y', strtotime($year.'-'.str_pad($month,2,"0",STR_PAD_LEFT).'-'.str_pad($month,2,"0",STR_PAD_LEFT))));
    }

    public static function dmYToSimpleDate($day,$month,$year) {
        return date('Y-m-d', strtotime($year.'-'.str_pad($month,2,"0",STR_PAD_LEFT).'-'.str_pad($day,2,"0",STR_PAD_LEFT)));
    }

    public static function daysBtwDates($start,$end) {
        $date1=date_create($start);
        $date2=date_create($end);
        return date_diff($date1,$date2)->days;
    }

    public static function getMeseNome($mesenum) {
        return self::$mesi[$mesenum];
    }

    public static function getGiornoNomeBreve($weekdaynum) {
        return self::$giorniBrev[$weekdaynum];
    }

    public static function dayToIt($day) {
        $key = strtolower($day);
        if (array_key_exists($key,self::$giorniBrevToIt)) {
            return self::$giorniBrevToIt[$key];
        }
        return $day;
    }
}