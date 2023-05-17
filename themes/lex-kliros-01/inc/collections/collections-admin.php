<?php

//Хук save_post_(post_type) срабатывает при добавлении / обновлении поста
//надо добавить три мета поля для партитуры
add_action('save_post_kliros_collections', function ($post_id) {

	//echo '<pre>'.print_r($_REQUEST['filepath'], 1).'</pre>';
	if (!isset($_REQUEST['filepath'])) {
		add_post_meta($post_id, 'filepath', 'Notes1/', true);
	} // true в конце обязательно чтобы при каждом update не добавлялись все новые и новые поля

});

//Хук wp_insert_post_data срабатывает после сохранения поста при редактировании
// Добавим автоматом всё из разных полей скопом в Отрывок
add_action('wp_insert_post_data', function ($data, $postarr) {
	if (!isset($_POST['post_type']) || $_POST['post_type'] != 'kliros_collections') return $data; // убедимся что мы редактируем нужный тип поста
	if (get_current_screen()->id != 'kliros_collections') return $data; // убедимся что мы на нужной странице админки
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $data; // пропустим если это автосохранение
	if (!current_user_can('edit_post', $postarr['ID'])) return $data; // убедимся что пользователь может редактировать запись
	// Все ОК! обрабатываем

	/*var_dump($data);
		echo '<hr>';
		var_dump($postarr);
		echo '<hr>';
		echo $postarr['post_title'];
		echo '<hr>';
		var_dump($postarr['tax_input']);
		echo '<hr>';
		var_dump($postarr['meta']);
		echo '<hr>';
		wp_die();*/
	$excerpt = $postarr['post_title'] ."\n" . 'Сборники';

	//композитор, распев, опус и рубрика
	$taxos = $postarr['tax_input'];
	foreach ($taxos as $key => $tax) {
      if($key !== 'lex_kliros_composer'){
         foreach ($tax as $value) {
            if ($value !== 0) {
               $term = get_term($value);
               $excerpt .= ' >> ' . $term->name;
            }
         }
      }
		
	}

	$excerpt .= '.';

	//заполняем Отрывок
	$data['post_excerpt'] = $excerpt;
	return $data;
}, 20, 2);

//фильтр - добавим выпадающий список в Админку
//Хук restrict_manage_posts изменяет админку
//Указываем все таксономии и в цикле формируем по ним выпадающие списки
//https://developer.wordpress.org/reference/hooks/restrict_manage_posts/  Contributed by Roy Tanck
add_action('restrict_manage_posts', function ($post_type) {
	if ('kliros_collections' !== $post_type) {
		return;
	}
	$taxonomies_slugs = get_object_taxonomies( 'kliros_collections' );
   /*$taxonomies_slugs = get_taxonomies(
		[//не работает на два и более post_type
			'object_type' => ['kliros_collections'],
		],
		'names',
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