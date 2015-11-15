<?php

if (!defined('ABSPATH'))
{
  exit;
}

/**
 * Mobile Detect
 */
if (!class_exists('Mobile_Detect'))
{
  require_once('Mobile-Detect/Mobile_Detect.php');

  $detect = new Mobile_Detect;
  $detect->setDetectionType('extended');
}