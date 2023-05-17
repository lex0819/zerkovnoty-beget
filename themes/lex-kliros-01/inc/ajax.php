<?php

add_action('wp_ajax_lex_kliros_file_download_summation', 'lex_kliros_file_download_summation');
add_action('wp_ajax_nopriv_lex_kliros_file_download_summation', 'lex_kliros_file_download_summation');

function lex_kliros_file_download_summation()
{
   if (!wp_verify_nonce($_POST['nonce'], 'lex_kliros_noty_ajax')) {
      wp_die('Error Nonce');
   }

   if (isset($_POST['postid'])) {
      $post_id = $_POST['postid'];
      $count = get_post_meta($post_id, 'lex_kliros_noty_count_download', true);
      if (empty($count)) {
         $count = 0;
      }
      $count++;
      update_post_meta($post_id, 'lex_kliros_noty_count_download', $count);
      wp_cache_flush();
      echo $post_id . ' downloaded ' . $count;
   }else{
      echo 'post is not found.';
   }

   wp_die();
}
