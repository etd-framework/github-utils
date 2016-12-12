<?php

// Composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Input
$input = new \Joomla\Input\Input($_GET);

// Params
$text     = $input->get("text", "", "string");
$bg       = $input->get("bg", "", "alnum");
$color    = $input->get("color", "", "alnum");
$subpixel = $input->get("subpixel", false, "bool");

if (empty($text) || empty($bg) || empty($color)) {
    die('invalid params');
}

// Label generator
$generator = new LabelGenerator();

$generator->setBg($bg)
          ->setColor($color)
          ->setSubpixel($subpixel)
          ->setText($text);

header('Content-Type: image/svg+xml');
echo $generator->getImage();