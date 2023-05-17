<?php

//$id glogal wp
$title = get_the_title($id);
$quality = get_post_meta($id, 'quality', true);
$voices = get_post_meta($id, 'voices', true);
$zip = trim(get_post_meta($id, 'filepath', true));
$zip = str_replace('\\', '/', $zip);
$zip = ($zip) ? home_url('/') . 'Notes1/' . $zip : home_url('/') . 'Notes1/boris.pdf';
//echo $zip;
$composer = get_the_terms($id, 'lex_kliros_composer');
//echo '<pre>'.print_r($composer, 1).'</pre>';

//пришло из вызывающего скрипта - taxonomy-XXX.php
//echo '<pre>'.print_r($args, 1).'</pre>';
$per_page = (int)$args['per_page'];

//номер текущей страницы где стоим в пагинации 
if ((int)$wp_query->query_vars['paged'] === 0) {
	$page_number = 1;
} else {
	$page_number = (int)$wp_query->query_vars['paged'];
}
/*echo '<pre>';
	var_dump($wp_query->query['paged']);var_dump($page_number);
	var_dump($per_page);
	var_dump($wp_query->current_post);
	echo '</pre>';*/
//номер текущего поста на этой странице от НУЛЯ не сквозной поэтому плюс 1
$n_current = (int)$wp_query->current_post + 1;
$n_number = $n_current + (($page_number - 1) * $per_page);
//echo $n_number; // сквозная нумерация сборников
?>
<li>
	<?php if (!empty(get_the_content())) : ?>
		<a href="<?php the_permalink(); ?>">
			<span class="nota-title"><?= $n_number ?></span>
			<span class="nota-title"><?= $title . ' '; ?></span>
		</a>
	<?php else : ?>
		<div class="noblock">
			<span class="nota-title"><?= $n_number ?></span>
			<span class="nota-title"><?= $title . ' '; ?></span>
		</div>
	<?php endif; ?>
	<a href="<?= $zip ?>">Скачать ZIP</a>
</li>