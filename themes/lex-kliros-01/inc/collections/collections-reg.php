<?php

//Тип записи Сборники, это сборники в зипах kliros_collection
add_action('init', function () {

	//Таксономии к типу Сборники

	//Таксономия collections, это каждодневные обычные богослужения на Литургии
	register_taxonomy('collections_all', ['kliros_collections'], [
		'label' => 'Сборники',
		'public' => true,
		'rewrite' => ['slug' => 'collections'],
		'hierarchical' => true,
      'show_admin_column' => true,
	]);
   
	register_post_type('kliros_collections', [
		'labels' => [
			'name' => 'Сборники',
			'singular_name' => 'Сборник',
			'add_new' => 'Добавить сборник',
			'add_new_item' => 'Добавить новый сборник',
			'edit_item' => 'Редактировать сборник',
			'new_item' => 'Новый сборник',
			'view_item' => 'Посмотреть сборник',
			'search_items' => 'Найти сборник',
			'not_found' => 'Сборников не найдено',
			'not_found_in_trash' => 'В корзине сборников не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Сборники'
		],
		'public' => true,
		'query_var' => true, // добавить в поиск
		'menu_position' => 5,
		'menu_icon' => 'dashicons-book-alt',
		'supports' => ['title', 'editor', 'excerpt', 'custom-fields', 'thumbnail'],
		'rewrite' => ['slug' => 'collection'],
		'has_archive' => true, //вывод всех постов этого типа списком по url-у post-type
		'show_ui' => true, //логика управления в админ панели
		'show_in_menu' => true, //показ в админки
	]);

	//Мета поля или Произвольные поля к Нотам
	//неясно зачем их регистрировать, без этого тоже работает
	//Путь к ZIP файлу со сборником
	register_post_meta('kliros_collections', 'filepath', [
		'type' => 'string',
		'description' => 'Путь к ZIP файлу сборника',
		'single' => true,
		'sanitize_callback' => null,
		'auth_callback' => null,
		'show_in_rest' => true,
      'show_admin_column' => true
	]);

});
