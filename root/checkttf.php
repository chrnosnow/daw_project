<?php // content="text/plain; charset=utf-8"
// Change this defines to where Your fonts are stored
// DEFINE("TTF_DIR", __DIR__ . "/module/dejavu-fonts-ttf-2.37/ttf/");
require_once __DIR__ . "/module/jpgraph-4.4.2/src/jpg-config.inc.php";

// Change this define to a font file that You know that You have
DEFINE("TTF_FONTFILE", "DejaVuSans-Bold.ttf");
// echo TTF_DIR . TTF_FONTFILE;
// Text to display
DEFINE("TTF_TEXT", "Hello World!");

$im = imagecreatetruecolor(400, 100);
$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$border_color = imagecolorallocate($im, 50, 50, 50);

imagefilledrectangle($im, 0, 0, 399, 99, $white);
imagerectangle($im, 0, 0, 399, 99, $border_color);
imagettftext($im, 30, 0, 90, 60, $black, TTF_DIR . TTF_FONTFILE, TTF_TEXT);

header("Content-type: image/png");
imagepng($im);
