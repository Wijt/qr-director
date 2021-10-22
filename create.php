<?php
namespace chillerlan\QRCodeExamples;

use chillerlan\QRCode\{QRCode, QROptions};
use Database;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'vendor/autoload.php';
include "config.php";
$pass = htmlspecialchars(trim($_GET["pass"]));
if($pass != $urlPass) exit("Wrong password!");

include 'database.php';
$db = new Database();

$qr = htmlspecialchars(trim($_GET["qr"]));
$idTaken = $db->row("qr_id", "qr", array("qr_id" => $qr)); 
$location = htmlspecialchars(trim($_GET["location"]));

if ($idTaken) {
    $result = $db->query("update qr set location='".$location."' where qr_id='".$qr."'");
}else{
	$result = $db->query("INSERT INTO `qr` (`qr_id`, `location`) VALUES ('".$qr."','".$location."')");
}

$data = "https://qr.kovan.tech?qr=".$qr;

$options = new QROptions([
	'version'      => 4,
	'outputType'   => QRCode::OUTPUT_MARKUP_SVG,
	'imageBase64'  => false,
	'eccLevel'     => QRCode::ECC_Q,
	'svgViewBoxSize' => 100,
	'addQuietzone' => true,
	'svgOpacity'   => 1.0
]);

$qrcode = (new QRCode($options))->render($data);

header('Content-type: image/svg+xml');

echo $qrcode;


?>