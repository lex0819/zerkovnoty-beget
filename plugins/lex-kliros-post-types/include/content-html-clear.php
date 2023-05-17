<?php

require_once('func_lexkliros.php');
global $wpdb;
$table_name = $wpdb->prefix . 'posts';
$noty_posts = lex_noty_all();
/*echo '<pre>'; var_dump($noty_posts); echo '</pre>'; wp_die();*/


foreach ($noty_posts as $nota) {

   $nota_post = get_post($nota['id']); // по одной штуке

   $clear_content = strip_tags($nota_post->post_content);
   $clear_content = str_replace("\n", ' ', $clear_content);

   $data_update = ['post_content' => $clear_content];
   $where_update = ['id' => $nota['id']];
   $wpdb->update($table_name, $data_update, $where_update);
} ?>

<h3 class="hed-h1"><a href="<?php $_SERVER['PHP_SELF']; ?>?page=lexkliros">МЕНЮ</a></h3>
<h2>Контент заменен во всех произведениях </h2>