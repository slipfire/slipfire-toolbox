<?php
/*
Plugin Name: SlipFire Toolbox
Plugin URI: http://slipfire.com
Description: SlipFire functions and CSS. Install in mu-plugins
Version: 4.9.5
Author: SlipFire
Author URI: http://slipfire.com/
Plugin Type: Piklist
License: GPLv2
*/


if (!defined('ABSPATH'))
{
  exit;
}

include_once('slipfire-toolbox/library/load-libraries.php');
include_once('slipfire-toolbox/includes/class-slipfire.php');
include_once('slipfire-toolbox/includes/class-slipfire-security.php');
include_once('slipfire-toolbox/includes/class-slipfire-theme.php');

if (is_admin())
{
  include_once('slipfire-toolbox/includes/class-slipfire-admin.php');
}

class SlipFire_Toolbox
{
  public static function base_dir_url()
	{
		return plugins_url('slipfire-toolbox/', __FILE__);
	}
}
