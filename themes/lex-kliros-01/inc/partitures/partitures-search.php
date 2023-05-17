<?php

//HOOK template_include - какой шаблон, замена шаблона, обработка шаблона
//$_GET['s'] вызывает автоматом шаблон search.php
//Надо для результатов поиска выводить не стандартный search.php 
//для типа записи НОТЫ post_type = lex_kliros_noty а search-lex_kliros_noty.php
add_filter('template_include', function ($template) {
	if (isset($_GET['s']) && 'lex_kliros_noty' === get_query_var('post_type')) {
		return locate_template('search-lex_kliros_noty.php'); //redirect to search-lex_kliros_noty.php
	}
	return $template;
});

//Поиск в Названиях с Началом строки Исключаем Душе моя из середины и конца названий произведений
//Добавили новый параметр поиска 'start_str', он вместо 's'
//в него кладем название произведения и по точному совпадению с началом строки LIKE '$start_str%'
//чтобы не портить поиск s
add_filter('posts_where', function ($where, $query) {
	global $wpdb; //PDO in WordPress

	$start_str = $query->get('start_str');
	if ($start_str) {
		//$where .= " AND $wpdb->posts.post_title REGEXP '^$start_str'"; //only MySQL Oracle 8
		$where .= " AND $wpdb->posts.post_title LIKE '$start_str%'"; // all MySQL
	}
	return $where;
}, 10, 2);
