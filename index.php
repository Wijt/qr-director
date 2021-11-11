<?php 

require 'database.php';
include 'config.php';

if (!isset($_GET["qr"])) {
	header("Refresh:0; url=".$mainpage);
	exit();
}

$qr = htmlspecialchars(trim($_GET["qr"]));

$ip = $_SERVER['REMOTE_ADDR'];
$device = $_SERVER['HTTP_USER_AGENT'];

$db=new Database();
$location = $db->row("location", "qr", array("qr_id" => $qr));

$result = $db->query("INSERT INTO `log` (`ip`, `device`, `qr_id`) VALUES ('".$ip."','".$device."','".$qr."')");

$link = $location["location"];

if ($result) {
	header("Refresh:0; url=".$link);
	exit();
}

?>