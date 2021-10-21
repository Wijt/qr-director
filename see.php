<?php
namespace chillerlan\QRCodeExamples;

use chillerlan\QRCode\{QRCode, QROptions};

require_once 'vendor/autoload.php';

$qr = htmlspecialchars(trim($_GET["qr"]));

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


