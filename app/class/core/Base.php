<?php require_once('Db.php') ?>
<?php require_once('DbInit.php') ?>
<?php require_once('Session.php')?>
<?php

class Base {
    protected $session = null;
    protected $list = null;
    protected $clName = null;

    function __construct($clName) {
        $this->session = new Session();
        $this->clName = $clName;
    }

    public function getList() {
        if (!isset($this->list)) {
            $db = Db::instance();
            $this->list = $db->read($this->clName)->fetch();
        }
        return $this->list;
    }

    public static function getJsonNazioni() {
        $db = Db::instance();
        $list = $db->raw("select n.id, n.code, n.nome, (select count(*) from regioni r2 where r2.country_code = r.country_code) child_num, count(*) porti_num, max(latitudine) maxy, min(latitudine) miny, max(longitudine) maxx, min(longitudine) minx,
            round((min(latitudine) + (max(latitudine)-min(latitudine))/2),6) center_x, round((min(longitudine) + (max(longitudine)-min(longitudine))/2),6) center_y
            from nazioni n inner join regioni r on n.code = r.country_code inner join porti p on p.regione_id = r.id
            group by n.id, n.code, n.nome, child_num order by n.nome")->all();
        return $list;
    }

    public static function getJsonAllRegioni() {
        $db = Db::instance();
        $list = $db->raw("select r.id, r.nome, n.id parent, count(*) porti_num,
            max(latitudine) maxy, min(latitudine) miny, max(longitudine) maxx,  min(longitudine) minx,
            round((min(latitudine) + (max(latitudine)-min(latitudine))/2),6) center_x,
            round((min(longitudine) + (max(longitudine)-min(longitudine))/2),6) center_y
            from regioni r inner join porti p on p.regione_id = r.id inner join nazioni n on n.code = r.country_code
            group by r.id, r.nome, n.id
            order by r.nome")->all();
        return $list;
    }

    public static function getJsonRegioni($nazione) {
        $db = Db::instance();
        $list = $db->raw(sprintf("select r.id, r.nome, n.id parent, count(*) porti_num,
            max(latitudine) maxy, min(latitudine) miny, max(longitudine) maxx,  min(longitudine) minx,
            round((min(latitudine) + (max(latitudine)-min(latitudine))/2),6) center_x,
            round((min(longitudine) + (max(longitudine)-min(longitudine))/2),6) center_y
            from regioni r inner join porti p on p.regione_id = r.id inner join nazioni n on n.code = r.country_code and n.id = %d
            group by r.id, r.nome, n.id
            order by r.nome",$nazione))->all();
        return $list;
    }
    
    public static function qto($data) {
        if (is_string($data)) {
            parse_str($data, $output);
            return (object) $output;
        }
        return $data;
    }
}