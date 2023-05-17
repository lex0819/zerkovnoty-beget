<?php
function lex_kliros_meta_tags(): string
{
	$descript = '';

	if (is_front_page()) {
		$descript = get_bloginfo('description');
	} elseif (is_single()) {
		$descript = get_the_excerpt() . ' ' . get_bloginfo('name');
	} elseif (is_search()) {
		$descript = get_query_var('s') . ' ' . get_bloginfo('name') . ' Поиск по сайту';
	} elseif (is_post_type_archive('lex_kliros_noty')) {
		$descript = 'Все церковные песнопения на сайте ' . get_bloginfo('name');
	} elseif (is_post_type_archive('kliros_collections')) {
		$descript = 'Все нотные сборники на сайте ' . get_bloginfo('name');
	} elseif (is_tax()) {
		$rubrica = get_queried_object();
		$rubr_descr = lex_kliros_breadcrumbs((int)$rubrica->term_id, $rubrica->taxonomy, ' / ');
		$descript = strip_tags($rubr_descr) . ' ' . get_bloginfo('name');
	} else {
      $descript = get_bloginfo('description');
   }
	return esc_attr($descript); //двойные кавычки, 
}
