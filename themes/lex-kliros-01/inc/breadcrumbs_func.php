<?php

//Вывод красивых хлебных крошек в рубриках, удаляет слеш на конце
function lex_kliros_breadcrumbs(int $term_id, string $taxonomy, string $separator): string
{
	$breadcrumbs = get_term_parents_list(
		$term_id,
		$taxonomy,
		[
			'format' => 'name',
			'separator' => $separator,
			'link' => true,
			'inclusive' => true
		]
	);

	$breadcrumbs = rtrim($breadcrumbs, $separator); //удаляет слеш на конце
	//var_dump($breadcrumbs);

	return $breadcrumbs;
}
//получение только первого термина таксономии для Нот
//один композитор, один распев, одна тональность и т.д
function get_lex_kliros_term(int $id, string $taxonomy_reg): string
{
	$nota_param = get_the_terms($id, $taxonomy_reg);
	/*var_dump($nota_param);
	wp_die('get_lex_kliros_term');*/
	if ($nota_param) {
		$nota = $nota_param[0]->name . ' ';
	} else {
		$nota = '';
	}
	return $nota;
}

//получение ссылки на файл для скачивания нот и сборников
function get_lex_filepath( int $id): string {
   $filepath = trim(get_post_meta($id, 'filepath', true));
	$filepath = str_replace('\\', '/', $filepath);
	
   $filepath = ($filepath) ? home_url() . '\/Notes1/' . $filepath : home_url() . '\/Notes1/boris.pdf';
	
   return $filepath;
}