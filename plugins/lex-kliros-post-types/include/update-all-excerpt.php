<?php

require_once('func_lexcontrol.php');
global $wpdb;
$table_name = $wpdb->prefix . 'posts';
$noty_posts = lex_noty_all();
/*echo '<pre>'; var_dump($noty_posts); echo '</pre>'; wp_die();*/


foreach ($noty_posts as $nota) {

	$nota_post = get_post($nota['id']); // по одной штуке

	$excerpt_arr = ['post_title' => $nota_post->post_title];
	$excerpt_arr += ['content' => strip_tags($nota_post->post_content)];

	//Все таксономии для поста 
	$nota_taxos = get_object_taxonomies($nota_post);
	/*echo '<pre>'; var_dump($taxos); echo '</pre>';*/

	//Все рубрики и теги для поста по всем таксономиям в виде объектов
	$nota_terms = wp_get_object_terms($nota['id'], $nota_taxos);
	/*echo '<pre>' . $nota['id'] . ' ';
	var_dump($nota_terms);
	echo '</pre>';
	wp_die();*/

	foreach ($nota_terms as $term) {
		if ($term->parent > 0) {
			$rubric = get_term_parents_list($term->term_id, $term->taxonomy, ['format' => 'name', 'separator' => ' >> ', 'link' => false, 'inclusive' => true]);
			$rubric = rtrim($rubric, " >> ");
			$excerpt_arr += [$term->taxonomy => $rubric];
		} else {
			$excerpt_arr += [$term->taxonomy => $term->name];
		}
	}

	/*echo '<pre>'; var_dump($excerpt_arr); echo '</pre>';*/

	$excerpt = '';

	if (isset($excerpt_arr['post_title'])) {
		$excerpt .= $excerpt_arr['post_title'];
	}
	if (isset($excerpt_arr['lex_kliros_opus'])) {
		$excerpt .= ' номер ' . $excerpt_arr['lex_kliros_opus'];
	}
	if (isset($excerpt_arr['lex_kliros_chant'])) {
		$excerpt .= ' распев ' . $excerpt_arr['lex_kliros_chant'];
	}
	if (isset($excerpt_arr['lex_kliros_composer'])) {
		$excerpt .= '  ' . $excerpt_arr['lex_kliros_composer'];
	}
	if (isset($excerpt_arr['content'])) {
		$excerpt .= ' ' . $excerpt_arr['content'];
	}
	if (isset($excerpt_arr['lex_kliros_tonality'])) {
		$excerpt .= '  ' . $excerpt_arr['lex_kliros_tonality'];
	}
	if (isset($excerpt_arr['lex_kliros_quality'])) {
		$excerpt .= ' ' . $excerpt_arr['lex_kliros_quality'];
	}
	if (isset($excerpt_arr['lex_kliros_voices'])) {
		$excerpt .= ' ' . $excerpt_arr['lex_kliros_voices'];
	}
	$excerpt .= "\n";
	if (isset($excerpt_arr['lex_kliros_liturgical'])) {
		$excerpt .= '  ' . $excerpt_arr['lex_kliros_liturgical'] . ',';
	}
	if (isset($excerpt_arr['lex_kliros_minea'])) {
		$excerpt .= '  ' . $excerpt_arr['lex_kliros_minea'] . ',';
	}
	if (isset($excerpt_arr['lex_kliros_triodion'])) {
		$excerpt .= '  ' . $excerpt_arr['lex_kliros_triodion'] . ',';
	}
	if (isset($excerpt_arr['lex_kliros_miserere'])) {
		$excerpt .= '  ' . $excerpt_arr['lex_kliros_miserere'] . ',';
	}

	$excerpt = rtrim($excerpt, ",");

	$data_update = ['post_excerpt' => $excerpt, 'post_content' => $excerpt_arr['content']];
	$where_update = ['id' => $nota['id']];
	$wpdb->update($table_name, $data_update, $where_update);
} ?>

<h3 class="hed-h1"><a href="<?php $_SERVER['PHP_SELF']; ?>?page=lexcontrol">МЕНЮ</a></h3>
<h2>Отрывок заменен во всех произведениях </h2>