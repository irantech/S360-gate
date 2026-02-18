<?php
require('./BCGBarcode/BCGFont.php');
require('./BCGBarcode/BCGColor.php');
require('./BCGBarcode/BCGDrawing.php');
require('./BCGBarcode/BCGcode128.barcode.php');
$barcode=$_GET['barcode'];
$code = new BCGcode128();
$code->setScale(2);
$code->setThickness(30);
$color_black='#000';
$color_white='#FFF';
$color_black = new BCGColor(0, 0, 0);
$color_white = new BCGColor(255, 255, 255);
$code->setForegroundColor($color_black);
$code->setBackgroundColor($color_white);
$code->setFont('');
$code->setStart(NULL);
$code->setTilde(true);
$code->parse($barcode);
// Drawing Part
$drawing = new BCGDrawing('',$color_black);
$drawing->setBarcode($code);
$drawing->draw();

header('Content-Type: image/png');

$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
$font = new BCGFont('./class/font/Arial.ttf', 18);