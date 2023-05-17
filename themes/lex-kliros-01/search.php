<?php

get_header();
?>
<section>
	<div class="wrap">
		<div class="main">
			<div class="content">

				<?php if (have_posts()) :
					/*echo '<pre>';
					var_dump($wp_query); //Главный запрос $wp_query по урлу global
					echo '</pre>';*/

					//по сколько песен выводим на одной странице настройки админки
					$per_page = (int)$wp_query->query_vars['posts_per_page'];
				?>
					<p class="count-item">Найдено всего: <span><?= $wp_query->found_posts; ?></span></p>
					<?php lex_kliros_posts_pagination($wp_query->max_num_pages); ?>
					<ul class="list-item">
						<?php while (have_posts()) : the_post();
							//echo $id;
							//передача параметров в шаблон массивом $args[]
							get_template_part('lex', 'list_excerpt', ['per_page' => $per_page]);
						endwhile; ?>
					</ul>
				<?php lex_kliros_posts_pagination($wp_query->max_num_pages);
				else : ?>
					<p class="count-item">По вашему запросу Ничего не найдено</p>
				<?php endif; ?>
			</div>
			<?php get_sidebar();
			get_footer();
