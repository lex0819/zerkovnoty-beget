<?php

define('KLIROS_DIR_IMG', get_stylesheet_directory_uri() . '/build/img/');

// include_once(__DIR__ . '/inc/partitures/partitures-reg.php');
// include_once(__DIR__ . '/inc/partitures/partitures-admin.php');
// include_once(__DIR__ . '/inc/partitures/partitures-search.php');
// include_once(__DIR__ . '/inc/collections/collections-reg.php');
// include_once(__DIR__ . '/inc/collections/collections-admin.php');

include_once(__DIR__ . '/inc/pagination.php');
include_once(__DIR__ . '/inc/security.php');
include_once(__DIR__ . '/inc/sidebar-func.php');
include_once(__DIR__ . '/inc/breadcrumbs_func.php');
include_once(__DIR__ . '/inc/meta-tags.php');
include_once(__DIR__ . '/inc/ajax.php');
include_once(__DIR__ . '/inc/turn-off.php');

add_action('wp_enqueue_scripts', function () {
   //wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Forum&display=swap');
   //wp_enqueue_style('awesome-fonts', 'https://pro.fontawesome.com/releases/v5.10.0/css/all.css', array(), null);
   //wp_enqueue_style('autocomplete', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css');

   wp_enqueue_style('kliros-styles', get_stylesheet_directory_uri() . get_option('color_style_lex_path'));

   if (is_front_page()) {
      wp_enqueue_style('autocomplete-css', get_stylesheet_directory_uri() . '/vendor/jquery/jquery-ui.min.css');
      wp_enqueue_script('kliros-scripts-searh', get_stylesheet_directory_uri() . '/build/js/main.js', ['jquery', 'jquery-ui-autocomplete'], null, true);
   }

   if (is_single()) {
      wp_enqueue_script('kliros-scripts-single', get_stylesheet_directory_uri() . '/build/js/downloadCounter.js', ['jquery'], null, true);
   }

   //Передача параметров из PHP в JS для AJAX-а и т.д. 
   wp_localize_script(
      'kliros-scripts-single', //id скрипта для которого надо передать
      'lexKlirosAjax', // id массива куда придёт в HTML
      array( //сам массив
         'ajaxUrl' => admin_url('admin-ajax.php'),
         'nonce' => wp_create_nonce('lex_kliros_noty_ajax')
      )
   );
});

/* add_filter('style_loader_tag',  function( $html, $handle ){
   if ( 'awesome-fonts' === $handle ) {
      return str_replace( "media='all'", "media='all' integrity='sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p' crossorigin='anonymous'", $html );
  }
  return $html;
}, 10, 4); */

add_action('after_setup_theme', function () {
   add_theme_support('title-tag');
   add_theme_support('post-thumbnails');
   add_theme_support('custom-logo');

   register_nav_menu('header-menu', 'Меню в шапке сайта');
   register_nav_menu('footer-menu', 'Меню в подвале сайта');
});
