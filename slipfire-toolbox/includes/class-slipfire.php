<?php

if (!defined('ABSPATH'))
{
  exit;
}

$slipfire = new SlipFire();

class SlipFire
{
  public function __construct()
  {
    add_action('init', array('slipfire', 'create_cron_schedules'));
  }


  /**
   * Output as preformatted text
   */
  public static function pre($output, $hide = false)
  {
    if ($output === '-')
    {
      $output = '--------------------------------------------------';
    }
    
    echo "<pre " . ($hide ? 'style="display: none !important;"' : null) . ">\r\n";
  
    print_r($output);
  
    echo "</pre>\r\n";

    $output = ob_get_contents();
 
    if (!empty($output))
    {
      @ob_flush();
      @flush();
    }
  }


  /**
   * performance
   * Removes what php limits are possible to remove to allow a process to run as long as needed.
   */
  public static function performance()
  {
    if (!ini_get('safe_mode'))
    { 
      ini_set('max_execution_time', -1);
      ini_set('memory_limit', -1);
    }
  }


  /**
   * Is Mobile
   * 
   * Checks if current browser is a phone or tablet
   *
   * Uses Mobile_Detect
   */
  public static function is_mobile()
  {
    global $detect;

    if(($detect->isMobile() == true))
    {
      return true;
    }
  }

  /**
   * Is Phone
   *
   * Checks if current browser is a phone
   *
   * Uses Mobile_Detect
   */
  public static function is_phone()
  {
    global $detect;

    if(($detect->isMobile() == true) && ($detect->isTablet() == false))
    {
      return true;
    }

    return false;
  }

  /**
   * Is Tablet
   *
   * Checks if current browser is a tablet
   *
   * Uses Mobile_Detect
   */
  public static function is_tablet()
  {
    global $detect;

    if($detect->isTablet() == true)
    {
      return true;
    }

    return false;
  }

  /**
   * Returns page slug.
   */
  public static function get_the_slug($id = null)
  {
    global $wp_query;

    if(!empty($wp_query->queried_object->slug))
    {
      $slug = $wp_query->queried_object->slug;
    }
    elseif(!empty($wp_query->query_vars['name']))
    {
      $slug = $wp_query->query_vars['name'];
    }
    elseif(!empty($wp_query->queried_object->rewrite['slug']))
    {
      $slug = $wp_query->queried_object->rewrite['slug'];
    }
    else
    {
      return;
    }

    return $slug;
  }

  /**
   * Echos page slug
   */
  public static function the_slug($id = null)
  {
    echo slipfire::get_the_slug($id);
  }

  /**
   * Get the current, full URL.
   *
   * @return string
   */
  public static function get_current_url()
  {
    return ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  }

  /**
   * Enable Maintenance Mode
   */
  public static function enable_maintenance_mode()
  {
    update_option('sfire_maintenance_mode', true);
  }

  /**
   * Check Maintenance Mode
   */
  public static function is_maintenance_mode()
  {
    $mode = get_option('sfire_maintenance_mode');

    if($mode)
    {
      return true;
    }

    return false;
  }

  /**
   * Disable Maintenance Mode
   */
  public static function disable_maintenance_mode()
  {
    update_option('sfire_maintenance_mode', false); ?>

    <div class="updated">
      <p>
        <?php _e('Maintenance Mode Disabled'); ?>
      </p>
    </div>

     <?php 
  }


  /**
   * Returns a list of taxonomies
   *
   * param $remove: taxonomies to remove from list
   */
  public static function get_taxonomies($remove = false, $args)
  {
    $taxonomies = get_taxonomies($args);

    if($remove)
    {
      foreach ($remove as $taxonomy)
      {
        unset($taxonomies[$taxonomy]);
      }
    }

    return $taxonomies;
  }


  /**
   * Returns a list of Post Types
   *
   * param $remove: taxonomies to remove from list
   */
  public static function get_post_types($remove = false, $args = array('public' => true, '_builtin' => false))
  {
    $post_types = get_post_types(
        $args
        , 'names'
        , 'and'
      );

    if($remove)
    {
      foreach ($remove as $post_type)
      {
        unset($post_types[$post_type]);
      }
    }

    return $post_types;
  }

  /**
   * Setup cron schedule
   * 
   * To use: add_action('slipfire_hourly_cron_job', 'function_to_run_hourly')
   */
  public static function create_cron_schedules()
  {
    // Setup hourly cron job
    if(!wp_next_scheduled('slipfire_hourly_cron_job'))
    {
      wp_schedule_event (time(), 'hourly', 'slipfire_hourly_cron_job');
    }
  }



}

