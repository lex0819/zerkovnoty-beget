<?php

function lex_kliros_posts_pagination(int $total_pages): bool
{
	echo get_the_posts_pagination([
		'total' => $total_pages, //$lex_query->max_num_pages, //само не работает только в поиске но ставим везде
		'end_size' => 2,
		'mid_size' => 3,
		'prev_next' => True,
		'prev_text' => '<<',
		'next_text' => '>>',
		'type' => 'plain',
		'add_args' => False,
		'add_fragment' => '',
		'before_page_number' => '',
		'after_page_number' => '',
		'screen_reader_text' => ' ',
		'aria_label' => '', // aria-label="" для nav элемента. С WP 5.3
		'class' => 'pagination',  // class="" для nav элемента. С WP 5.5
	]);
	return true;
}


/*//Пример с буферизацией, свой фильтр
//Своя Функция вывода пагинации страниц с фильтрами названий и т.д. на экран
//Для создания своего фильтра кастомного пагинации
function posts_pagination_output_func()
{

	ob_start(); // Буферизация
	the_posts_pagination(); //стандартная пагинация WP
	$pagination_output = ob_get_clean();
	echo apply_filters('posts-pagination-output', $pagination_output);
};

//Фильтр для классов пагинации от функции the_posts_pagination()
add_filter('posts-pagination-output', function ($pagination_output) {
	
	// в буфере весь код html от функции the_posts_pagination()
	//оставляем только цифры страниц и Вперед Назад
	$pagination_output = str_replace('<h2 class="screen-reader-text">Навигация по записям</h2>', '', $pagination_output);
	$pagination_output = preg_replace("/Далее/", '>>', $pagination_output);
	$pagination_output = preg_replace("/Назад/", '<<', $pagination_output);

	return $pagination_output;
});*/