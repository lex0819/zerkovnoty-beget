<?php

//$id global wp айдишник текущего поста
$nota_title = get_the_title($id) . ' ';
$nota_quality_choir = get_lex_kliros_term($id, 'lex_kliros_quality');
$nota_voices_choir = get_lex_kliros_term($id, 'lex_kliros_voices');
$nota_composer_choir = get_lex_kliros_term($id, 'lex_kliros_composer');
$nota_tonality_choir = get_lex_kliros_term($id, 'lex_kliros_tonality');
$nota_chant_choir = get_lex_kliros_term($id, 'lex_kliros_chant');
$nota_opus_choir = get_lex_kliros_term($id, 'lex_kliros_onlyopus');
$nota_number_choir = get_lex_kliros_term($id, 'lex_kliros_number');

//пришло из вызывающего скрипта - taxonomy.php
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
$nota_current = (int)$wp_query->current_post + 1;
$nota_number = $nota_current + (($page_number - 1) * $per_page);
//echo $nota_number; // сквозная нумерация песен
?>
<li>
	<a href="<?php the_permalink(); ?>">
		<span class="nota-title"><?= $nota_number ?></span>
		<span class="nota-title"><?= $nota_title;
         if ($nota_opus_choir) { echo "опус $nota_opus_choir";}
         if ($nota_number_choir) { echo "№ $nota_number_choir";}?></span>
		<span class="nota-composer"><?= $nota_composer_choir;
			if ($nota_chant_choir) {echo $nota_chant_choir . 'распев ';} ?></span>
		<?= $nota_tonality_choir;
		echo $nota_quality_choir;
		echo $nota_voices_choir; ?>
	</a>
</li>