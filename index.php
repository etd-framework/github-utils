<?php

// Composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Input Filter
$filter = new \Joomla\Filter\InputFilter();

if (!isset($_GET["text"]) || !isset($_GET["bg"])) {
    die('invalid params');
}

// Params
$text     = $filter->clean($_GET["text"], "STRING");
$bg       = $filter->clean($_GET["bg"], "ALNUM");
$color    = $filter->clean($_GET["color"], "ALNUM");
$subpixel = $filter->clean($_GET["subpixel"], "BOOL");

if (empty($text) || empty($bg)) {
    die('invalid params');
}

// Label generator
$generator = new LabelGenerator();

$generator->setBg($bg)
          ->setColor($color)
          ->setSubpixel($subpixel)
          ->setText($text);

$image = $generator->getImage();

header('Content-Type: image/svg+xml');
echo $image;