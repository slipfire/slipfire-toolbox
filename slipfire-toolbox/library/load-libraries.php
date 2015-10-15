<?php
/**
 * Mobile Detect
 */

if (!defined('ABSPATH'))
{
  exit;
}


if (!class_exists('Mobile_Detect'))
{
  require_once('Mobile-Detect/Mobile_Detect.php');

  $detect = new Mobile_Detect;
  $detect->setDetectionType('extended');
}