<?php

class Translator {
    private $lang = array();
    private function findString($str,$lang) {
        if (array_key_exists($str, $this->lang[$lang])) {
            return $this->lang[$lang][$str];
        }
        return $str;
    }
    private function splitStrings($str) {
        return explode('=',trim($str));
    }
    public function __($str,$lang) {
        if (!array_key_exists($lang, $this->lang)) {
            if (file_exists($lang.'.txt')) {
                $strings = array_map(array($this,'splitStrings'),file($lang.'.txt'));
                foreach ($strings as $k => $v) {
                    $this->lang[$lang][$v[0]] = $v[1];
                }
                return $this->findString($str, $lang);
            }
            else {
                return $str;
            }
        }
        else {
            return $this->findString($str, $lang);
        }
    }
}

class English extends Translator {
    private $lang = 'en';
    private $package = 'index';
    public function __() {
        if (func_num_args() < 1) {
            return false;
        }
        $args = func_get_args();
        $str = array_shift($args);
        if (count($args)) {
            return vsprintf(parent::__($str, $this->lang . '_' . $this->package),$args);
        }
        else {
            return parent::__($str, $this->lang . '_' . $this->package);
        }
    }
}

class Italian extends Translator {
    public function __() {
        if (func_num_args() < 1) {
            return false;
        }
        $args = func_get_args();
        $str = array_shift($args);
        if (count($args)) {
            return vsprintf($str,$args);
        }
        else {
            return $str;
        }
    }
}