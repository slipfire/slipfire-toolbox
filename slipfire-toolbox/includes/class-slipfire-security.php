<?php

if (!defined('ABSPATH'))
{
  exit;
}

$slipfire_security = new SlipFire_Security();

class SlipFire_Security
{
	/**
	 * Initialize the class
	 */
  public function __construct()
  {
  	add_action('slipfire_hourly_cron_job', array('slipfire_security', 'test_debug_log'));

		add_action('login_errors', array('slipfire_security', 'hide_wordpress_errors'));
	}

	/**
	 * If debug.log is publically accessible email me.
	 */
	public static function test_debug_log()
	{
		$file = 'debug.log';
		$response = wp_remote_get(content_url($file));
		$header = wp_remote_retrieve_response_code($response);

		if($header != '404')
		{
			$to = 'sbruner@slipfire.com';
			$subject = 'IMPORTANT: debug.log is Public';
			$message = 'File is public ' . content_url($file);
			mail($to, $subject, $message);
		}
	}

	public static function hide_wordpress_errors($error)
	{
  	return __('Login error');
	}

}
