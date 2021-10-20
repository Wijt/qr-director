<?php 

require 'database.php';
include "config.php";

if (!isset($_GET["qr"])) {
	header("Refresh:0; url=".$mainpage);
	exit();
}

$qr = htmlspecialchars(trim($_GET["qr"]));

$ip = $_SERVER['REMOTE_ADDR'];
$date = getDatetimeNow();

$db=new Database();
$location = $db->row("location","qr", array("qr_id"=>$qr));

$logged = $db->query("select ip from log where ip='".$ip."' and qr_id='".$qr."'");

if ($logged) {
	$result = $db->query("update log set entry_count=entry_count+1 where ip='".$ip."'");
}else{
	$result = $db->query("INSERT INTO `log` (`ip`, `device`, `date`, `qr_id`, `entry_count`) VALUES ('".$ip."','".$device."','".$date."','".$qr."','1')");
}

$link = $location["location"];

if ($result) {
	header("Refresh:0; url=$link");
	exit();
}

function getDatetimeNow() {
    $tz_object = new DateTimeZone('Europe/Istanbul');

    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d\ h:i:s');
}

?>