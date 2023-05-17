<?php
/*
* Plugin Name: Change Kliros Style
* Author: Lex Зайчик
* Author URL: https://zerkovnoty.ru
* Description: Меняет файл style.css на другой. Только для темы Kliros. Плагин поставляется с подкаталогом css/ в котором лежат файлы style_***.css, в т.ч и стандартный файл темы Kliros. Файлы сделаны специально под код темы Kliros.
* https://codex.wordpress.org/Написание_плагина
* https://codex.wordpress.org/Плагины:_создание_таблиц_БД
* https://codex.wordpress.org/Создание_страниц_настройки
* https://codex.wordpress.org/Plugin_API/Action_Reference хуки русский
*/

/*
* В функции add_menu_page() в параметр $capability надо ставить не числа 8, 10 и т.д. как раньше права доступа юзеров, а писать права на редактирование 'manage_options' или 'edit_pages'
* https://developer.wordpress.org/reference/functions/add_menu_page/
*/

//global variable $color_style_lex это неудобно, а не global не работает
//поэтому вместо переменной положим массив настроек в функцию
//настройки храним в таблице options.php
function color_style_lex()
{
   //читаем папку плагина/css/ c разноцветными css стилями
   $dir_css = plugin_dir_path(__FILE__) . 'css/';
   $list_styles = scandir($dir_css);

   $styles_arr = [
      [
         'color_style_lex_path' => 'css/style.css',
         'color_style_lex_color' => 'BlueViolet',
      ]
   ];

   $pattern = ['/style_/', '/.css/'];

   foreach ($list_styles as $key => $file_name) {
      if ($key > 2) {
         $path = 'css/' . $file_name;
         $name = preg_replace($pattern, '', $file_name);
         $styles_arr[] = [
            'color_style_lex_path' => $path,
            'color_style_lex_color' => $name,
         ];
      } else {
         continue;
      }
   }

   return $styles_arr;
}

register_activation_hook(__FILE__, function () {
   $color_style_lex = color_style_lex();
   foreach ($color_style_lex[0] as $set => $value) {
      update_option($set, $value);
   }
});

register_deactivation_hook(__FILE__, function () {
   delete_option('color_style_lex_path');
   delete_option('color_style_lex_color');
});

//добавим пункт меню в админку и страницу админки для настроек
//https://wp-kama.ru/function/add_menu_page
add_action('admin_menu', function () {
   add_theme_page(
      'Change_Kliros_Style', //Тег <title> на странице, относящейся к пункту меню.
      'Change Style Kliros', //Название пункта меню в сайдбаре админ-панели.
      'manage_options', //roles-and-capabilities
      'kliros-style', //menu_slug по которому можно обращаться к этому меню.
      'lexcocolor_callback_html', //callback print html to admin
      1, //menu position
   );
});

//Функция не только печатает страницу в админке, но и принимает с неё же запросы к серверу
//$_POST уйдёт с этой формы и придёт на эту же страницу
function lexcocolor_callback_html()
{
   if (!empty($_POST)) {
      update_option('color_style_lex_path', $_POST['color_style_lex_path']);
      update_option('color_style_lex_color', $_POST['color_style_lex_color']);
   }

   $path = get_option('color_style_lex_path');
   $color_name = get_option('color_style_lex_color');
   $color_style_lex = color_style_lex();

   require_once 'inc/admin.php';
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'lex_page_style_link', 99); //добавляет на странице плагинов ссылку на станицу данного плагина <a href="themes.php?page=kliros-style">Settings</a>

function lex_page_style_link($links)
{
   $link_banner = '<a href="themes.php?page=kliros-style">Settings</a>';
   array_push($links, $link_banner);

   return $links;
}

//ФРОНТ на Сайте, хуки wp_enqueue_scripts и wp_head, он сам стартанет
//удаляем из темы стандартный файл стилей и регистрируем стиль из плагина
add_action('wp_enqueue_scripts', 'lex_style_front_scripts', 9999);

function lex_style_front_scripts()
{
   wp_dequeue_style('kliros-styles');
   wp_deregister_style('kliros-styles');

   wp_enqueue_style('kliros-styles-plugin', plugins_url(get_option('color_style_lex_path'), __FILE__));
}
