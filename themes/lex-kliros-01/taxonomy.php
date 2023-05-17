<?php

get_header();

//echo '<pre>' . print_r($cat, 1) . '</pre>';//$cat не работает на custom taxonomy
//echo '<pre>' . print_r($posts, 1) . '</pre>';//$posts работает только на 1 страницу!!!
//echo '<pre>' . print_r($wp_query, 1) . '</pre>';//$wp_query работает целиком, но сразу грузит только первые неск постов на 1 страницу

$rubrica = get_queried_object(); // Retrieve the currently-queried object.
//echo '<pre>' . print_r($rubrica, 1) . '</pre>';

$sub_rubrics = get_terms([
   'taxonomy' => $rubrica->taxonomy,
   'parent' => $rubrica->term_id, //show only one child level of the rubric
   'hide_empty' => true,
   'orderby' => 'description',
   'order' => 'ASC',
]);
//echo '<pre>' . print_r($sub_rubrics, 1) . '</pre>';
//var_dump($rubrica->slug); //для Прокимнов и Ирмосов

$breadcrumbs = lex_kliros_breadcrumbs((int)$rubrica->term_id, $rubrica->taxonomy, ' / ');
?>
<section>
   <div class="wrap">
      <div class="main">
         <div class="content">
            <?php if ($sub_rubrics) : //Если есть дочернии категории то не смотрим посты, идем по рубрикам
            ?>
               <h2 class="title-h2">
                  <?= $breadcrumbs; ?>
               </h2>
               <p class="count-item">Найдено произведений: <span><?= $wp_query->found_posts; ?></span></p>
               <ol class="list-category">
                  <?php foreach ($sub_rubrics as $sub_rubric) : ?>
                     <li>
                        <a href="<?= get_term_link((int)$sub_rubric->term_id); ?>">
                           <?= $sub_rubric->name; ?>
                        </a>
                     </li>
                  <?php endforeach; ?>
               </ol>
               <?php else : //Ищем записи в этой рубрике
               if (have_posts()) :
                  /*echo '<pre>';
						var_dump($wp_query); //Главный запрос $wp_query по урлу global
						echo '</pre>';*/

                  //по сколько песен выводим на одной странице настройки админки
                  $per_page = (int)$wp_query->query_vars['posts_per_page'];
                  /*
							get_search_form();
						}*/
               ?>
                  <h2 class="title-h2"><?= $breadcrumbs; ?></h2>
                  <?php if ('prokimen' === $rubrica->slug || 'irmosy' === $rubrica->slug) : ?>
                     <p class="prim">Зри также Великий Пост и ПРАЗДНИКИ</p>
                  <?php endif; ?>
                  <p class="count-item">Найдено произведений: <span><?= $wp_query->found_posts; ?></span></p>
                  <?php lex_kliros_posts_pagination($wp_query->max_num_pages); ?>
                  <ul class="list-item">
                     <?php while (have_posts()) : the_post();
                        //echo $id;
                        //передача параметров в шаблон массивом $args[]
                        get_template_part('lex', 'list_choral', ['per_page' => $per_page]);
                     endwhile; ?>
                  </ul>
               <?php lex_kliros_posts_pagination($wp_query->max_num_pages);
               //wp_reset_postdata();
               else : ?>
                  <h2 class="title-h2"><?= $breadcrumbs; ?></h2>
                  <p class="count-item">Рубрика в процессе заполнения</p>
            <?php endif;
            endif; ?>
         </div>
         <?php get_sidebar();
         get_footer();
