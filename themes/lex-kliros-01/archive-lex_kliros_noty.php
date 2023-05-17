<?php

get_header();
/*echo '<pre>';
var_dump($_GET);
echo '</pre>';
echo '<pre>';
var_dump($wp_query);
echo '</pre>';*/
?>
<section>
	<div class="wrap">
		<div class="main">
			<div class="content">
				<?php if (have_posts()) : ?>
					<h2 class="title-h2">Партитуры на сайте:</h2>
					<p class="count-item">Найдено произведений: <span><?php echo $wp_query->found_posts; ?></span></p>
					<?php lex_kliros_posts_pagination($wp_query->max_num_pages); ?>
					<ol class="list-item">
						<?php while (have_posts()) : the_post();
							get_template_part('lex', 'list_choral');
						endwhile; ?>
					</ol>
				<?php else : ?>
					<p class="count-item">По вашему запросу <strong><b><?= get_search_query(); ?></b></strong> ничего не найдено</p>
				<?php endif; ?>
			</div>
			<?php get_sidebar();
			lex_kliros_posts_pagination($wp_query->max_num_pages);
			get_footer();
