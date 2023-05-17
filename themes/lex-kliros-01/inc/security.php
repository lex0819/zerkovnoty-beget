<?php

define('DISALLOW_FILE_EDIT', true); //запрет редактора кода темы в админке

// Прячем ошибку при входе в админку, не показываем, что именно неверно ввели - логин или пароль
add_filter('login_errors', function () {
	return NULL;
});

// Прячем версию XHTML generator <meta name="generator" content="WordPress 5.3.2" />
add_filter('the_generator', function () {
	return NULL;
}, 10, 2);

// Прячем версию скриптов CSS и JS
add_filter('style_loader_src', 'script_loader_src_lex_kliros', 10, 2);
add_filter('script_loader_src', 'script_loader_src_lex_kliros', 10, 2);

function script_loader_src_lex_kliros($src)
{
	if (strpos($src, 'ver=' . get_bloginfo('version'))) {
		$src = remove_query_arg('ver', $src);
	}
	return $src;
}
