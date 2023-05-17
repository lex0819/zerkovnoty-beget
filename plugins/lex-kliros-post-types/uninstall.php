<?php
$posts = get_posts(
   array(
      'post_type' => ['lex_kliros_noty', 'kliros_collections'],
      'numberposts' => -1,
   )
);

foreach ($posts as $post) {
   wp_delete_post($post->ID, true);
}
