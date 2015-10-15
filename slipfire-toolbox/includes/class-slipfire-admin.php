<?php

if (!defined('ABSPATH'))
{
  exit;
}

$slipfire_admin = new SlipFire_Admin();

class SlipFire_Admin
{
  public function __construct()
  {
		add_filter('admin_body_class', array('slipfire_theme', 'body_class'));
	}
}