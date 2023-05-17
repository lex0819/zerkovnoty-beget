<?php

//Функция принимает Типы кастом постов, чьи рубрики надо выводить в сайдбар
//По дефолту эти post_type-ы заполнены
function lex_grand_sidebar(array $custom_post_types = ['lex_kliros_noty', 'kliros_collections']): array
{
	//все иерархические таксономии для кастом типов
	$kliros_hierarhical_taxomonies = [];
	foreach ($custom_post_types as $custom_post_type) {
		$kliros_hierarhical_taxomonies += get_taxonomies(
			[
				'hierarchical' => true,
				'object_type' => [$custom_post_type],
			],
			'names',
			'and',
		);
	}
	/*echo '<pre>';
		var_dump($kliros_hierarhical_taxomonies);
		echo '</pre>';*/

	$list_sidebar_categories = []; //конечный список верхних рубрик для сайдбара

	foreach ($kliros_hierarhical_taxomonies as $tax) {

		$categories = get_terms([
			'taxonomy' => $tax,
			'parent' => 0, //верхняя рубрика
			'hide_empty' => false,
		]);

		foreach ($categories as $cat) {

			$list_sidebar_categories[] = [
				'id' => $cat->term_id,
				'name' => $cat->name,
				'order' => $cat->description,
			];
		}
	}
	/*echo '<pre>';
		var_dump($list_sidebar_categories);
		echo '</pre>';*/

	//Сортируем список по полю description, там в админке вписаны числа
	usort($list_sidebar_categories, function ($x, $y) {

		return (int)($x['order'] > $y['order']);
	});

	/*echo '<pre>';
		var_dump($list_sidebar_categories);
		echo '</pre>';*/

	return $list_sidebar_categories;
}
