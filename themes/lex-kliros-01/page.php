<?php

get_header(); ?>
<section>
	<div class="wrap">
		<div class="main">
			<div class="content">
			<?php if (have_posts()) : ?>
				
				<?php while (have_posts()) : the_post(); ?>
					<a href="<?php the_permalink() ?>" class="post-card-link">
						<?php the_post_thumbnail(); ?>
					</a>
					
					<h1 class="single"><?php the_title(); ?></h1>
					<?php the_content(); ?>
				<?php endwhile; ?>
				
			<?php endif; ?>
			</div>
			<?php get_sidebar();
			get_footer();