<?php
add_action('wp_enqueue_scripts', function () {
   //Отключение лишних стилей и скриптов
   wp_dequeue_style('wp-block-library');
   wp_dequeue_style('wp-embed');
   wp_deregister_script('wp-embed');
});
//Отключение лишних defolt скриптов и стилей WP 
add_action('wp_loaded', function () {
   remove_action('wp_head', 'feed_links_extra', 3); // убирает ссылки на rss категорий
   remove_action('wp_head', 'feed_links', 2); // минус ссылки на основной rss и комментарии
   remove_action('wp_head', 'rsd_link');  // сервис Really Simple Discovery
   remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer
   remove_action('wp_head', 'wp_generator');  // скрыть версию wordpress
   remove_action('wp_head', 'wp_resource_hints', 2); // <link rel="dns-prefetch" href="//s.w.org">
   remove_action('wp_head', 'start_post_rel_link', 10, 0);
   remove_action('wp_head', 'index_rel_link');
   remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
   remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
   remove_action('wp_head', 'rest_output_link_wp_head');
   remove_action('wp_head', 'wp_oembed_add_discovery_links');
   remove_action('template_redirect', 'rest_output_link_header', 11, 0);
   remove_action('wp_head', 'print_emoji_detection_script', 7);
   remove_action('wp_print_styles', 'print_emoji_styles');
});
