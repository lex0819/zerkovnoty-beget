<?php

get_header();

if (have_posts()) {
   the_post();
   $nota_id = get_the_ID();
   $nota_title = get_the_title($nota_id);
   $nota_link = get_lex_filepath($nota_id);
   $nota_quality_choir = get_lex_kliros_term($id, 'lex_kliros_quality');
   $nota_voices_choir = get_lex_kliros_term($id, 'lex_kliros_voices');
   $nota_composer = get_lex_kliros_term($nota_id, 'lex_kliros_composer');
   //echo '<pre>'.print_r($nota_composer, 1).'</pre>';
   $nota_tonality = get_lex_kliros_term($nota_id, 'lex_kliros_tonality');
   $nota_chant = get_lex_kliros_term($nota_id, 'lex_kliros_chant');
   $nota_opus = get_lex_kliros_term($id, 'lex_kliros_onlyopus');
   $nota_number = get_lex_kliros_term($id, 'lex_kliros_number');

   $nota_term = []; //рубрики для партитуры, одна или несколько
   $nota_terms = get_the_terms($nota_id, 'lex_kliros_liturgical');
   if ($nota_terms) {
      $nota_term[] = $nota_terms[0];
   }
   $nota_terms = get_the_terms($nota_id, 'lex_kliros_triodion');
   if ($nota_terms) {
      $nota_term[] = $nota_terms[0];
   }
   $nota_terms = get_the_terms($nota_id, 'lex_kliros_minea');
   if ($nota_terms) {
      $nota_term[] = $nota_terms[0];
   }
   $nota_terms = get_the_terms($nota_id, 'lex_kliros_miserere');
   if ($nota_terms) {
      $nota_term[] = $nota_terms[0];
   }
   /*echo '<pre>';
	var_dump($nota_term);
	echo '</pre>';
	wp_die();*/

   $breadcrumbs = [];
   foreach ($nota_term as $key => $obj_rubric) {
      $breadcrumbs[$key] = lex_kliros_breadcrumbs((int)$obj_rubric->term_id, $obj_rubric->taxonomy, ' / ');
   }
} else {
   wp_die('Не такой партитуры');
}
//var_dump($breadcrumbs); 
?>

<section>
   <div class="wrap">
      <div class="main">
         <div class="content-single">
            <? foreach ($breadcrumbs as $rubric) :
               //var_dump($one_rubric); 
            ?>
               <h2 class="title-h2"><?= $rubric; ?></h2>
            <? endforeach; ?>
            <h1 class="single"><?= $nota_title;
                                 if ($nota_opus) {
                                    echo "  опус $nota_opus";
                                 }
                                 if ($nota_number) {
                                    echo " № $nota_number ";
                                 } ?>
               <strong class="composer-h2"><?= $nota_composer;
                                             if ($nota_chant) {
                                                echo $nota_chant . ' распев ';
                                             }; ?></strong>
               <span class="tonality-h2"><?= $nota_tonality . ', ';
                                          echo $nota_quality_choir;
                                          echo $nota_voices_choir; ?></span>
            </h1>
            <button class="pdf-link" data-pdf="<?= $nota_link; ?>" data-postid="<?= $nota_id; ?>">pdf file
            </button>
            <embed class="score-show" src="<?= $nota_link; ?>" type="application/pdf"></embed>
         </div>
         <?php get_sidebar('single');
         get_footer();
         //<embed src="path#toolbar=0&navpanes=0&scrollbar=0" disable and hide PDF Menu Header in embed frame
