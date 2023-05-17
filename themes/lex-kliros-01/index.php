<?php

get_header(); ?>
<section>
	<div class="wrap">
		<div class="main">
			<div class="content">
				<?php if (have_posts()) : ?>
					<h2 class="title-h2">Партитуры на сайте:</h2>
					<ol class="list-item">
						<?php while (have_posts()) : the_post(); ?>
							<a href="<?php the_permalink() ?>" class="post-card-link">
								<?php the_post_thumbnail(); ?>
							</a>
							<a class="" href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
							<?php the_content(); ?>
						<?php endwhile; ?>
					</ol>
				<?php endif; ?>
			</div>
			<?php get_sidebar();
			lex_kliros_posts_pagination($wp_query->max_num_pages);
			get_footer();
