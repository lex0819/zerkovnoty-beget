<?php

get_header();

//echo '<pre>' . print_r($wp_query, 1) . '</pre>';

$rubrica = get_queried_object(); // Retrieve the currently-queried object.
//echo '<pre>'.print_r( $sub_rubrics, 1).'</pre>';
$sub_rubrics = get_categories([
   'taxonomy' => $rubrica->taxonomy,
   'parent' => $rubrica->term_id, //show only one child level of the rubric
   'hide_empty' => 1,
   'orderby' => 'description',
   'order' => 'ASC',
]);
//var_dump($rubrica->slug); //для Прокимнов и Ирмосов

$breadcrumbs = lex_kliros_breadcrumbs((int)$rubrica->term_id, $rubrica->taxonomy, ' / ');
?>
<section>
   <div class="wrap">
      <div class="main">
         <div class="content">
            <?php if ($sub_rubrics) : //Если есть дочернии категории 
            ?>
               <h2 class="title-h2">
                  <?= $breadcrumbs; ?>
               </h2>
               <p class="count-item">Найдено сборников: <span><?= $wp_query->found_posts; ?></span></p>
               <ol class="list-category">
                  <?php foreach ($sub_rubrics as $sub_rubric) : ?>
                     <li>
                        <a href="<?= get_term_link((int)$sub_rubric->term_id); ?>">
                           <?= $sub_rubric->name; ?>
                        </a>
                     </li>
                  <?php endforeach; ?>
               </ol>
               <?php else :
               //Пробуем найти записи в этой рубрике, если есть

               if (have_posts()) :

                  // echo $wp_query->found_posts . ' ';
                  // echo '<pre>$wp_query: ';
                  // var_dump($wp_query->query['paged']);
                  // echo '</pre>';
                  // echo '<pre>$wp_query->query_vars: ';
                  // var_dump($wp_query->query_vars);
                  // echo '</pre>';
                  /*echo '<pre>$wp_query: '; var_dump($wp_query);echo '</pre>';
						wp_die();*/

                  //по сколько песен выводим на одной странице
                  $per_page = (int)$wp_query->query_vars['posts_per_page'];
               ?>
                  <h2 class="title-h2"><?= $breadcrumbs; ?></h2>
                  <p class="count-item">Найдено сборников: <span><?= $wp_query->found_posts; ?></span></p>
                  <?php lex_kliros_posts_pagination($wp_query->max_num_pages); ?>
                  <ul class="list-item">
                     <?php while (have_posts()) : the_post();
                        //передача параметров в шаблон массивом $args[]
                        get_template_part('lex', 'list_collect', ['per_page' => $per_page]);
                     endwhile; ?>
                  </ul>
               <?php lex_kliros_posts_pagination($wp_query->max_num_pages);

               else : ?>
                  <h2 class="title-h2"><?= $breadcrumbs; ?></h2>
                  <p class="count-item">Рубрика в процессе заполнения</p>
            <?php endif;
            endif; ?>
         </div>
         <?php get_sidebar();
         get_footer();
