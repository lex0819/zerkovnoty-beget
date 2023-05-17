<?php

get_header();

if (have_posts()) {
   the_post();
   $id = get_the_ID();
   $title = get_the_title($id);
   $composer = get_lex_kliros_term($id, 'lex_kliros_composer');
   $zip = get_lex_filepath($id);
   $terms = get_the_terms($id, 'collections_all');
   if ($terms) {
      $term = $terms[0];
   }

   //echo '<pre>'; var_dump($nota_term); echo '</pre>';
   //echo '<pre>'; var_dump($nota_term->term_id); echo '</pre>';
   //echo '<pre>'; var_dump($nota_term->taxonomy); echo '</pre>';

   $breadcrumbs = get_term_parents_list($term->term_id, $term->taxonomy, ['format' => 'name', 'separator' => ' / ', 'link' => true, 'inclusive' => true]);

   $str_len = iconv_strlen($breadcrumbs) - 2;
   $breadcrumbs = mb_strimwidth($breadcrumbs, 0, $str_len);
   //var_dump($breadcrumbs);

} else {
   wp_die('Не такой партитуры');
} ?>

<section>
   <div class="wrap">
      <div class="main">
         <div class="content-single">
            <h2 class="title-h2"><?= $breadcrumbs; ?></h2>
            <h1 class="single"><?= $title . ' ' . $composer . ' '; ?></h1>
            <button class="pdf-link" data-pdf="<?= $zip; ?>" data-postid="<?= $id; ?>">Скачать ZIP
            </button>
            <div class="compilation"><?= the_content(); ?></div>
         </div>
         <?php get_sidebar('single');
         get_footer();
