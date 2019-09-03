<?php $cl = htmlentities($_POST['cl']);
$mt = htmlentities($_POST['mt']);
$vl = isset($_POST['vl'])? $_POST['vl'] : "";
include("database.php");
require_once('class/'.$cl.'.php');

if(!is_array($vl)) {
    parse_str($vl, $args);
    $args = array('data' => json_encode($args));
}else{
    $args = $vl;
}

$ins = new $cl();
$res = call_user_func_array(array($ins, $mt), $args);

?>
<?php if ($res) echo json_encode($res); ?>