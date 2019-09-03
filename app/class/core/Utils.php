<?php

class Utils {

    public static function allFull($arr) {
        foreach($arr as $field) {
            if (empty($field)) {
                return false;
            }
        }
        return true;
    }

    public static function allEmpty($arr) {
        foreach($arr as $field) {
            if (!empty($field)) {
                return false;
            }
        }
        return true;
    }

    public static function set(&$obj,$props) {
        if (isset($obj->$props)) return;
        $obj->$props="";
    }

    public static function baseUrl() {
        $docRoot = $_SERVER['DOCUMENT_ROOT'];
        $host = "http://".$_SERVER['HTTP_HOST']."/";
        $oooo =strpos($host,"demosviluppo");
        if (strpos($host,"demosviluppo")===true) {
            return $host.'meteomed/';
        }
        return $host;
    }

    // $data = array('key1' => 'value1', 'key2' => 'value2');
    public static function callPost($url, $data){
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { /* Handle error */ }

        return $result;
    }
}