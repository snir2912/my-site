<?php
/**
 * Plugin Name:GutenTOC - Table of Content Gutenberg Block
 * Plugin URI: http://tauhidpro.com/gutentoc-advance-table-of-content
 * Author: Tauhidpro
 * Author URI: http://tauhidpro.com
 * Version: 2.0.9
 * License: GPL2+
 * Description: Easily create Table of Content in Gutenberg editor.
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt 
 * Text Domain: gutentoc
 *
 * @package Tauhidpro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
/** * Block Initializer. */
require_once plugin_dir_path( __FILE__ ) . 'dist/init.php';

add_action('wp_enqueue_scripts', 'stylemin_gutentoc',20, 1);
function stylemin_gutentoc() {
    if(is_singular()){
        //We only want the script if it's a singular page
        $id = get_the_ID();
        //if use [gutentoc/table-of-contents] bloks
        if(has_block('gutentoc/table-of-contents',$id)){
           wp_register_script( 'gutentocjs', plugin_dir_url( __FILE__ ) .'dist/toc.js',array('jquery'), '', true);
           wp_enqueue_script( 'gutentocjs' );
        }
     }
}

/**
 * Redirect to the GutenTOC Getting Started page on single plugin activation.
 */

register_activation_hook(__FILE__, function () {
   add_option('gutentoc_redirect', true);
});

add_action('admin_init', function () {
   if (get_option('gutentoc_redirect', false)) {
       delete_option('gutentoc_redirect');
       exit( wp_redirect("options-general.php?page=gutentoc") );
   }
});

// CSS and JS For Admin
  function gutentoc_admin_style() {
    wp_enqueue_style('gutentoc-admin-styles', plugin_dir_url( __FILE__ ) .'dist/gutentoc-wellcome.css');
    }
  add_action('admin_enqueue_scripts', 'gutentoc_admin_style');


  add_filter( 'plugin_action_links', 'gutentoc_add_action_links', 10, 5 );

 
/**
 * Add a link Pluginc activation area :gutentoc_add_action_links
 */
 
function gutentoc_add_action_links( $actions, $plugin_file ) {
 $action_links = array(
   'settigns' => array(
      'label' => __('Settings', 'my_domain'),
      'url'   => get_admin_url(null, 'options-general.php?page=gutentoc')
    ), 
   );
 
  return plugin_action_links_gutentoc( $actions, $plugin_file, $action_links, 'before');
}
 
/*** plugin_action_links*/
function  plugin_action_links_gutentoc ( $actions, $plugin_file,  $action_links = array(), $position = 'after' ) { 
  static $plugin;
  if( !isset($plugin) ) {
      $plugin = plugin_basename( __FILE__ );
  }
  if( $plugin == $plugin_file && !empty( $action_links ) ) {
     foreach( $action_links as $key => $value ) {
        $link = array( $key => '<a href="' . $value['url'] . '">' . $value['label'] . '</a>' );
         if( $position == 'after' ) {
            $actions = array_merge( $actions, $link );    
         } else {
            $actions = array_merge( $link, $actions );
         }
 
      }//foreach
 
  }// if
 
  return $actions;
  
 
}