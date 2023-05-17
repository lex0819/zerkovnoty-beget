<?php

//Хук save_post_(post_type) срабатывает при добавлении / обновлении поста
//надо добавить три мета поля для партитуры
add_action('save_post_lex_kliros_noty', function ($post_id) {

	//echo '<pre>'.print_r($_REQUEST['filepath'], 1).'</pre>';
	if (!isset($_REQUEST['filepath'])) {
		add_post_meta($post_id, 'filepath', 'Notes1/', true);
	} // true в конце обязательно чтобы при каждом update не добавлялись все новые и новые поля

});

//Хук wp_insert_post_data срабатывает после сохранения поста при редактировании
// Добавим автоматом всё из разных полей скопом в Отрывок
add_action('wp_insert_post_data', function ($data, $postarr) {
	if (!isset($_POST['post_type']) || $_POST['post_type'] != 'lex_kliros_noty') return $data; // убедимся что мы редактируем нужный тип поста
	if (get_current_screen()->id != 'lex_kliros_noty') return $data; // убедимся что мы на нужной странице админки
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $data; // пропустим если это автосохранение
	if (!current_user_can('edit_post', $postarr['ID'])) return $data; // убедимся что пользователь может редактировать запись
	// Все ОК! обрабатываем

	/*echo '<pre>$data: ';
	var_dump($data);
	echo '</pre>';
	echo '<pre>$postarr: ';
	var_dump($postarr);
	echo '</pre>';
	wp_die();*/

	$excerpt_arr = [];
	//$excerpt_arr += [...] будет одномерный массив элементов последовательно
	$excerpt_arr += ['post_title' => $postarr['post_title']];
	$excerpt_arr += ['content' => $postarr['content']];

	//композитор, распев, опус, тональность и рубрики
	$taxos = $postarr['tax_input'];
	/*echo '<pre>$taxos: ';
	var_dump($taxos);
	echo '</pre>';
	wp_die();*/
	foreach ($taxos as $tax_reg => $tax_array) {
		$full_term = '';
		foreach ($tax_array as $value) {
			if ($value > 0) {
				$term = get_term_parents_list($value, $tax_reg, ['format' => 'name', 'separator' => ' >> ', 'link' => false, 'inclusive' => true]);
				$term = rtrim($term, " >> ") . '  ';
				$full_term .= 	$term;
				//echo "in" . $value . " " . $tax_reg . " " . $full_term . "</br>";
			}
		}
		//echo "out" . $value . " " . $tax_reg . " " . $full_term . "</br>";
		$excerpt_arr += [$tax_reg => $full_term];
	}

	/*echo '<pre>$excerpt_arr: ';
	var_dump($excerpt_arr);
	echo '</pre>';
	wp_die();*/

	$excerpt = '';

	if ($excerpt_arr['post_title']) {
		$excerpt .= $excerpt_arr['post_title'];
	}
	if ($excerpt_arr['lex_kliros_onlyopus']) {
		$excerpt .= ' опус ' . $excerpt_arr['lex_kliros_onlyopus'];
	}
   if ($excerpt_arr['lex_kliros_number']) {
		$excerpt .= ' № ' . $excerpt_arr['lex_kliros_number'];
	}
	if ($excerpt_arr['lex_kliros_chant']) {
		$excerpt .= ' распев ' . $excerpt_arr['lex_kliros_chant'];
	}
	if ($excerpt_arr['lex_kliros_composer']) {
		$excerpt .= '  ' . $excerpt_arr['lex_kliros_composer'];
	}
	if ($excerpt_arr['content']) {
		$excerpt .= ' ' . $excerpt_arr['content'];
	}
	if ($excerpt_arr['lex_kliros_tonality']) {
		$excerpt .= '  ' . $excerpt_arr['lex_kliros_tonality'];
	}
	if ($excerpt_arr['lex_kliros_quality']) {
		$excerpt .= ' ' . $excerpt_arr['lex_kliros_quality'];
	}
	if ($excerpt_arr['lex_kliros_voices']) {
		$excerpt .= ' ' . $excerpt_arr['lex_kliros_voices'];
	}
	$excerpt .= "\n";
	if ($excerpt_arr['lex_kliros_liturgical']) {
		$excerpt .= ' ' . $excerpt_arr['lex_kliros_liturgical'] . ',';
	}
	if ($excerpt_arr['lex_kliros_minea']) {
		$excerpt .= ' ' . $excerpt_arr['lex_kliros_minea'] . ',';
	}
	if ($excerpt_arr['lex_kliros_triodion']) {
		$excerpt .= ' ' . $excerpt_arr['lex_kliros_triodion'] . ',';
	}
	if ($excerpt_arr['lex_kliros_miserere']) {
		$excerpt .= ' ' . $excerpt_arr['lex_kliros_miserere'] . ',';
	}

	$excerpt = rtrim($excerpt, ",");
	/*echo '<pre>$excerpt: ';
	var_dump($excerpt);
	echo '</pre>';
	wp_die();*/

	//заполняем Отрывок
	$data['post_excerpt'] = $excerpt;
	return $data;
}, 20, 2);

//фильтр - добавим выпадающий список в Админку
//Хук restrict_manage_posts изменяет админку
//Указываем все таксономии и в цикле формируем по ним выпадающие списки
//https://developer.wordpress.org/reference/hooks/restrict_manage_posts/  Contributed by Roy Tanck
add_action('restrict_manage_posts', function ($post_type) {
	if ('lex_kliros_noty' !== $post_type) {
		return;
	}
   $taxonomies_slugs = get_object_taxonomies( 'lex_kliros_noty' );
	/*$taxonomies_slugs = get_taxonomies(
		[//не работает на два post_type
			'object_type' => ['lex_kliros_noty'],
		],
		'names',
		'or',
	);*/
	//echo '<pre>'.print_r($taxonomies_slugs, 1).'</pre>';

	// loop through the taxonomy filters array
	foreach ($taxonomies_slugs as $slug) {
		$taxonomy = get_taxonomy($slug);
		$selected = '';
		// if the current page is already filtered, get the selected term slug
		$selected = isset($_REQUEST[$slug]) ? $_REQUEST[$slug] : '';
		// render a dropdown for this taxonomy's terms
		wp_dropdown_categories([
			'show_option_all' => $taxonomy->labels->all_items,
			'taxonomy' => $slug,
			'name' => $slug,
			'orderby' => 'name',
			'value_field' => 'slug',
			'selected' => $selected,
			'hierarchical' => true,
		]);
	}
}, 10, 1);
