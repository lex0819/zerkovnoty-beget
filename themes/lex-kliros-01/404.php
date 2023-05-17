<?php

get_header(); ?>
<section>
	<div class="wrap">
		<div class="main">
			<div class="content">
				<h2 class="title-h2">Ошибка 404 - ресурс не найден.</h2>
				<p class="p-404">Такой страницы нету. Увы ((</p>
				<p class="p-404"><a href="<?= get_home_url(); ?>">Перейти на Главную?</a></p>
			</div>
			<?php get_sidebar();
			get_footer();
