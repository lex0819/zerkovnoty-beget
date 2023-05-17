<?php
/*
Plugin Name: Cristmas Tree Banner
Author: Lex Зайчик
Author URL: https://zerkovnoty.ru
Папка плагина lex-cristmas-tree
Description: Вешает в левом либо правом верхнем углу файл с картинкой. Сделайте сами файл GIF и положите его на хостинг в папку с плагином в подкаталог banners, - там должны лежить все файлы gif с баннерами.
*/

if (!defined('ABSPATH')) {
   die;
}

define('LEXBANNER_PATH', plugin_dir_path(__FILE__));

class LexBanner
{
   public function register()
   {
      add_action('admin_menu', [$this, 'add_plugin_page']); //добавим пункт меню в админку и страницу админки для настроек https://wp-kama.ru/function/add_menu_page
      add_action('wp_footer', [$this, 'banner_show']); //выводит баннер на сайте FRONT
      add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'cristmas_tree_link'], 99); //добавляет на странице плагинов ссылку на станицу данного плагина <a href="admin.php?page=lexbanner">Settings</a>
   }

   public function activation()
   {
      $banner_lex = $this->banner_list(); //self:: вместо $this потому что static функция
      update_option('banner_lex_path', $banner_lex[0]); //предустановленный файл баннера
      update_option('banner_lex_check', 'no'); //не выводить на сайт по дефолту
      update_option('banner_lex_width', 200); //ширина баннера 200px
      update_option('banner_lex_position', 'left_top'); //где выводить баннер, слева сверху по дефолту
      flush_rewrite_rules();
   }

   public static function deactivation()
   {
      delete_option('banner_lex_path');
      delete_option('banner_lex_check');
      delete_option('banner_lex_width');
      delete_option('banner_lex_position');
      flush_rewrite_rules();
   }

   //настройки храним в таблице options.php
   //читаем список файлов с картинками из папки banners в плагине
   private function banner_list()
   {
      $dir_banner = plugin_dir_path(__FILE__) . 'banners/';
      $list_banners = scandir($dir_banner);
      $banners_list = []; //массив с именами файлов-баннеров

      foreach ($list_banners as $key => $file_name) {
         if ($key > 1) {
            $path = 'banners/' . $file_name;
            $banners_list[] = $path;
         } else {
            continue;
         }
      }

      $banners_list = array_filter($banners_list, function ($item) {
         return $item !== 'banners/index.php';
      });
      return $banners_list;
   }

   public function cristmas_tree_link($links)
   {
      $link_banner = '<a href="admin.php?page=lexbanner">Settings</a>';
      array_push($links, $link_banner);

      return $links;
   }

   public function add_plugin_page()
   {
      add_theme_page(
         'Lex_Banner', //Тег <title> на странице, относящейся к пункту меню.
         'Banner-Cristmas', //Название пункта меню в сайдбаре админ-панели.
         'manage_options', //roles-and-capabilities
         'lexbanner', //menu_slug по которому можно обращаться к этому меню.
         [$this, 'callback_html_admin'], //callback print html to admin
         2, //menu position
      );
   }

   //АДМИНКА
   //Функция не только печатает страницу в админке, но и принимает с неё же запросы к серверу
   //$_POST уйдёт с этой формы и придёт на эту же страницу
   public function callback_html_admin()
   {
      if (!empty($_POST)) {
         update_option('banner_lex_path', $_POST['banner_lex_path']);
         update_option('banner_lex_width', $_POST['banner_lex_width']);


         if (isset($_POST['banner_lex_check']) && $_POST['banner_lex_check'] == 'yes') {
            update_option('banner_lex_check', $_POST['banner_lex_check']);
         } else {
            update_option('banner_lex_check', 'no');
         }

         if (isset($_POST['banner_lex_position']) && $_POST['banner_lex_position'] !== 'left_top') {
            update_option('banner_lex_position', $_POST['banner_lex_position']);
         } else {
            update_option('banner_lex_position', 'left_top');
         }
      }

      $path = get_option('banner_lex_path'); //path to file in plugin is banners/file_name
      $check = get_option('banner_lex_check'); // no / yes
      $width = get_option('banner_lex_width'); //size of picture
      $position = get_option('banner_lex_position'); // left_top / right_top

      $banner_lex = $this->banner_list();

      require_once LEXBANNER_PATH . '/admin/index.php';
   }

   //ФРОНТ на Сайте
   public function banner_show()
   {
      $path = get_option('banner_lex_path'); //path to file in plugin is banners/file_name
      $check = get_option('banner_lex_check'); // no / yes
      $width = get_option('banner_lex_width'); //size of picture
      $width_mobile = $width / 2; //size of picture on mobile
      $position = get_option('banner_lex_position'); // left_top / right_top
      $css_pos = explode('_', $position);

      if ($check == 'yes') {
         require_once LEXBANNER_PATH . '/front/index.php';
      } else {
         return;
      }
   }
}

if (class_exists('LexBanner')) {
   $lexbanner = new LexBanner();
   $lexbanner->register();
}

register_activation_hook(__FILE__, array($lexbanner, 'activation'));
register_deactivation_hook(__FILE__, array($lexbanner, 'deactivation'));
