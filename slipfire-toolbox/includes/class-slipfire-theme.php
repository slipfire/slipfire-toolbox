<?php

if (!defined('ABSPATH'))
{
  exit;
}

$slipfire_theme = new SlipFire_Theme();

class SlipFire_Theme
{
  public function __construct()
  {
    add_action('wp_headers', array('slipfire_theme', 'send_headers'));
    add_action('get_header', array('slipfire_theme', 'get_header'));
    add_action('wp_enqueue_scripts', array('slipfire_theme', 'scripts_styles_early'), 0);
    add_action('wp_enqueue_scripts', array('slipfire_theme', 'scripts_styles_last'), 99999);

    add_action('wp_head', array('slipfire_theme', 'browse_happy'), 99999);
    add_filter('body_class', array('slipfire_theme', 'body_class'));
  }

  /**
   * Update Headers for better security
   */
  public static function send_headers()
  {
    send_nosniff_header();

    $headers['X-Frame-Options'] = 'SAMEORIGIN'; // http://engineeredweb.com/blog/2013/secure-site-clickjacking-x-frame-options/
    $headers['X-XSS-Protection'] = '1; mode=block';  // https://kb.sucuri.net/warnings/hardening/headers-x-xss-protection
    
    return $headers;
  }

  public static function get_header()
  {
    self::check_maintenance_mode();
  }

  /**
   * Enqueue Style and Scripts before themes and plugins
   */
  public static function scripts_styles_early()
  {
    wp_register_style('normalize', slipfire_toolbox::base_dir_url() . 'parts/css/normalize.min.css');
    wp_enqueue_style('normalize');
  }

  /**
   * Enqueue Style and Scripts after themes and plugins
   */
  public static function scripts_styles_last()
  {
    wp_register_style('slipfire-toolbox', slipfire_toolbox::base_dir_url() . 'parts/css/slipfire-toolbox.min.css');
    wp_enqueue_style('slipfire-toolbox');
  }

  public static function browse_happy()
  {
    ?>

    <!--[if lt IE 8]>
      <style>
        #slipfire-browsehappy {
          text-align: center;
          margin: 10px !important;
          padding: 10px !important;
          font-family: serif;
          font-weight: bold;
        }
      </style>

      <p id="slipfire-browsehappy">You are using an outdated web browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> </p>
    <![endif]-->
    <?php
  }

  /**
   * Enhanced body classes
   *
   * Mostly inspired from Theme Hybrid 
   * https://github.com/justintadlock/hybrid-core
   */
  public static function body_class($classes)
  {
    global $post, $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

    // Yes, this is WordPress
    $classes[] = 'wordpress';

    // Text direction.
    $classes[] = is_rtl() ? 'rtl' : 'ltr';

    // Parent or child theme
    $classes[] = is_child_theme() ? 'child-theme' : 'parent-theme';

    // Multisite and the site name and  ID.
    if (is_multisite())
    {
      $classes[] = 'multisite';
      $classes[] = 'site-' . get_current_blog_id();
      
      $sitename = str_replace(' ', '-' , strtolower(get_bloginfo('name')));
      $classes[] = 'site-' . $sitename;
    }

    // User logged in or out
    $classes[] = is_user_logged_in() ? 'logged-in' : 'logged-out';

    // Admin bar
    if (is_admin_bar_showing())
    {
      $classes[] = 'admin-bar';
    }

    // Use the '.custom-background' class to integrate with the WP background feature.
    if (get_background_image() || get_background_color())
    {
      $classes[] = 'custom-background';
    }

    // Add the '.custom-header' class if the user is using a custom header.
    if (get_header_image() || (display_header_text() && get_header_textcolor()))
    {
      $classes[] = 'custom-header';
    }

    // Add the '.display-header-text' class if the user chose to display it.
    if (display_header_text())
    {
      $classes[] = 'display-header-text';
    }

    // Singular
    if (is_singular())
    {
      /* Get the queried post object. */
      $post = get_queried_object();

      /* Checks for custom template. */
      $template = str_replace(array("{$post->post_type}-template-", "{$post->post_type}-"), '', basename( get_post_meta( get_queried_object_id(), "_wp_{$post->post_type}_template", true ), '.php' ));
      if (!empty( $template))
      {
        $classes[] = "{$post->post_type}-template-{$template}";
      }

      // Post format
      if (current_theme_supports( 'post-formats') && post_type_supports($post->post_type, 'post-formats'))
      {
        $post_format = get_post_format(get_queried_object_id());
        $classes[] = (empty( $post_format) || is_wp_error($post_format)) ? "{$post->post_type}-format-standard" : "{$post->post_type}-format-{$post_format}";
      }

      // Attachment mime types.
      if (is_attachment())
      {
        foreach (explode( '/', get_post_mime_type()) as $type)
        {
          $classes[] = "attachment-{$type}";
        }
      }
    }

    // Page title
    if(is_page())
    {
      $title = $post->post_name;
      $classes[] = 'page_title_' . $title;
    }

    // Parent page title
    if (is_page() && $post->post_parent)
    {
      $post_parent = get_post($post->post_parent);
      $title = $post_parent->post_name;
      $classes[] = 'parent_' . $title;
    }

    // Page template
    if(is_page_template())
    {
      $path = pathinfo(get_page_template());
      $file = $path['filename'] . '.' . $path['extension'];
      $file= str_replace('.php', '', $file);

      $classes[] = 'template_' . $file;
    }

    // Post Type
    if(is_singular())
    {
      $classes[] = 'post_type_' . get_post_type();
    }

    // Paged views
    if (is_paged())
    {
      $classes[] = 'paged';
      $classes[] = 'paged-' . intval(get_query_var('paged'));
    }
    // Singular post paged views using <!-- nextpage -->
    elseif (is_singular() && 1 < get_query_var('page'))
    {
      $classes[] = 'paged';
      $classes[] = 'paged-' . intval(get_query_var('page'));
    }

    //'user-level' if logged in
    if (is_user_logged_in())
    {
      global $current_user;

      get_currentuserinfo();
      $userid = $current_user->ID;
      $user_info = get_userdata($userid);
      $user_level = $user_info->user_level;

      $classes[] = "user-level-" . $user_level;
    }

    if(slipfire::is_mobile())
    {
      $classes[] = 'mobile';
    }

    if(slipfire::is_phone())
    {
      $classes[] = 'phone';
    }

    if(slipfire::is_tablet())
    {
      $classes[] = 'tablet';
    }

    // Browsers
    if ($is_lynx)
    {
      $classes[] = 'lynx';
    }
    elseif ($is_gecko)
    {
      $classes[] = 'gecko';
    }
    elseif ($is_opera)
    {
      $classes[] = 'opera';
    }
    elseif ($is_NS4)
    {
      $classes[] = 'ns4';
    }
    elseif ($is_safari)
    {
      $classes[] = 'safari';
    }
    elseif ($is_chrome)
    {
      $classes[] = 'chrome';
    }
    elseif ($is_IE)
    {
      $classes[] = 'ie';
      if (preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
      {
        $classes[] = 'ie-' . $browser_version[1];
      }
    }
    else
    {
      $classes[] = 'browser-unknown';
    }

    if ($is_iphone)
    {
      $classes[] = 'iphone';
    }

    return $classes; 
  }

  /**
   * Check if site was placed in maintenance mode
   */
  public static function check_maintenance_mode()
  {    
    $maintenance_mode = get_option('sfire_maintenance_mode');
    $maintenance_mode_network = get_site_option('sfire_maintenance_mode');

    if($maintenance_mode == false && $maintenance_mode_network == false)
    {
      return;
    }
    else
    {
      $sitename = get_bloginfo('name');
      wp_die($sitename . ' is currently unavailable.');
    }
  }

}