<?php
/*
Plugin Name:  BreadcrumbFy
Plugin URI:   http://becodify.com
Description:  The easiest way to generate your WordPress breadcrumbs
Version:      0.0.1
Author:       Bruno Lorente Cantarero
Author URI:   http://brunolorente.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  breadcrumbfy
Domain Path:  /languages
*/

//Do a PHP version check, require 5.3 or newer
if( version_compare(phpversion(), '5.6.30', '<') )
{
	//Only purpose of this function is to echo out the PHP version error
	function bcf_phpv()
	{
		printf('<div class="error"><p>' . __('Your PHP version is too old, please upgrade to a newer version. Your version is %1$s, Breadcrumbfy requires %2$s at least', 'breadcrumbfy') . '</p></div>', phpversion(), '5.6.30');
	}
	//If we are in the admin, let's print a warning then return
	if(is_admin())
	{
		add_action('admin_notices', 'bcf_phpv');
	}
	return;
}

//Register hook "bc_breadcrumbfy"
function get_breadcrumbfy() {
    do_action('get_breadcrumbfy');
}

// Generate BreadcrumbFy HTML code    
function generate_breadcrumbfy() {
  $delimiter = '> ';
  $currentBefore = '<span class="current breadcrumb_last">';
  $currentAfter = '</span>';
  
  if ( !is_home() && !is_front_page() || is_page() ) { ?>
    <div id="breadcrumbfy-wrap" class="container">
      <span class="breadcrumbs-part">
        <a name="Home" href="<?php bloginfo('url'); ?>"><i class="fa fa-home" aria-hidden="true" style="margin-right:5px;"></i>Inicio</a>
      </span>
    <?php
        echo $delimiter;
        global $post;

        if ( is_page() && !$post->post_parent ) {
            echo $currentBefore;
            the_title();
            echo $currentAfter; 

        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();

            while ( $parent_id ) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id  = $page->post_parent;
            }

            $breadcrumbs = array_reverse($breadcrumbs);

            foreach ( $breadcrumbs as $crumb ) {
                echo $crumb . ' ' . $delimiter . ' ';
                echo $currentBefore;
                the_title();
                echo $currentAfter;
            }
        } 
    ?>
    </div>
    <?php
  }
}
add_action( 'get_breadcrumbfy', 'generate_breadcrumbfy' );

// CB Function for styles
function bcf_breadstyles() {
    wp_enqueue_style('breadcrumbfy-styles', plugins_url("breadcrumbfy/").'css/breadcrumbfy.css');
}
add_action( 'get_header', 'bcf_breadstyles' );
