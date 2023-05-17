<?php
/*
* Plugin Name: Custom Post Types for Kliros Partitures
* Author: Lex Зайчик
* Author URL: https://zerkovnoty.ru
* Папка плагина: lex-kliros-post-types 
* Description: Custom Post Types for Kliros Partitures
*/

if (!defined('ABSPATH')) {
   die;
}

define('KLIROS_PATH', plugin_dir_path(__FILE__));

if (!class_exists('zerkovNotyCpt')) {
   require  KLIROS_PATH . 'inc/cpt.php';
}
class ZerkovNoty
{
   public function register()
   {
      add_action('admin_menu', [$this, 'add_plugin_page']); //добавим пункт меню в админку и страницу админки для настроек https://wp-kama.ru/function/add_menu_page
      add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'page_link'], 99); //добавляет на странице плагинов ссылку на станицу данного плагина <a href="tools.php?page=lexkliros">Settings</a>
      add_action('admin_enqueue_scripts', [$this, 'reg_styles_scripts']);
   }
   public function add_plugin_page()
   {
      add_management_page(
         'Lex_Kliros', //Тег <title> на странице, относящейся к пункту меню.
         'Lex Kliros', //Название пункта меню в сайдбаре админ-панели.
         'manage_options', //roles-and-capabilities
         'lexkliros', //menu_slug по которому можно обращаться к этому меню.
         [$this, 'lexkliros_callback_html'], //callback print html to admin
         1, //menu position
      );
   }

   public function lexkliros_callback_html()
   {
      if (isset($_GET['c'])) {
         //echo '<pre>'.print_r($_GET).'</pre>';
         switch ($_GET['c']) {
            case 'composer':
               $action = 'composer';
               break;
            case 'chant':
               $action = 'chant';
               break;
            case 'tonality':
               $action = 'tonality';
               break;
            case 'null-tonality':
               $action = 'null-tonality';
               break;
            case 'null-compos_chant':
               $action = 'null-compos_chant';
               break;
            case 'null-rubric':
               $action = 'null-rubric';
               break;
            case 'bigfiles':
               $action = 'bigfiles';
               break;
            case 'add-excerpt':
               $action = 'add-excerpt';
               break;
            case 'search-similar':
               $action = 'search-similar';
               break;
            case 'update-all-excerpt':
               $action = 'update-all-excerpt';
               break;
            case 'content-html-clear':
               $action = 'content-html-clear';
               break;
            case 'download_counter':
               $action = 'download_counter';
               break;
            default:
               $action = 'lexkliros';
               break;
         }
      } else {
         $action = 'lexkliros';
      }
      //echo $action;
      require_once("include/$action.php");
   }

   public function reg_styles_scripts()
   {
      wp_enqueue_style('lexkliros_style', plugins_url('assests/css/admin/style.css', __FILE__));
      wp_enqueue_script('lexkliros_script', plugins_url('assests/js/admin/script.js', __FILE__), 'jQuery');
   }

   public function page_link($links)
   {
      $link_banner = '<a href="tools.php?page=lexkliros">Settings</a>';
      array_push($links, $link_banner);

      return $links;
   }

   static function activation()
   {
      flush_rewrite_rules();
   }

   static function deactivation()
   {
      flush_rewrite_rules();
   }
}

if (class_exists('ZerkovNoty')) {
   $noty = new ZerkovNoty();
   $noty->register();
}

register_activation_hook(__FILE__, array($noty, 'activation'));
register_deactivation_hook(__FILE__, array($noty, 'deactivation'));
