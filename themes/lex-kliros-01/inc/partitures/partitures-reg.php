<?php

//Тип записи Ноты, это песнопения lex_kliros_noty
add_action('init', function () {
	//Таксономии к типу Партитуры / Ноты

	//Таксономия liturgical, это каждодневные обычные богослужения на Литургии
	register_taxonomy('lex_kliros_liturgical', ['lex_kliros_noty'], [
		'label' => 'Повседневное',
		'public' => true,
		'rewrite' => ['slug' => 'liturgical'],
		'hierarchical' => true,
		'has_archive' => true,
	]);

	//Таксономия minea, это праздничные службы - Рождество, Крещение, Иконы Божией Матери и т.д.
	register_taxonomy('lex_kliros_minea', ['lex_kliros_noty'], [
		'label' => 'МИНЕЯ',
		'public' => true,
		'rewrite' => ['slug' => 'minea'],
		'hierarchical' => true,
		'has_archive' => true,
	]);

	//Таксономия triodion, это  - Великий Пост, Страстная Седмица, Пасха
	register_taxonomy('lex_kliros_triodion', ['lex_kliros_noty'], [
		'label' => 'ТРИОДЬ',
		'public' => true,
		'rewrite' => ['slug' => 'triodion'],
		'hierarchical' => true,
		'has_archive' => true,
	]);

	//Таксономия miserere, это - Ектении, Прикимны, Гласы, Требы и т.д.
	register_taxonomy('lex_kliros_miserere', ['lex_kliros_noty'], [
		'label' => 'Остальное',
		'public' => true,
		'rewrite' => ['slug' => 'miserere'],
		'hierarchical' => true,
		'has_archive' => true,
	]);

	//Таксономия composer, это - композиторы
	register_taxonomy(
		'lex_kliros_composer', ['lex_kliros_noty','kliros_collections'], [
			'label' => 'Композиторы',
			'public' => true,
			'rewrite' => ['slug' => 'composer'],
			'show_ui' => true, //логика управления в админ панели
			'show_in_menu' => true, //показ в админки
			'hierarchical' => false,
			'has_archive' => true, //не надо показывать композиторов на Front
         'show_admin_column' => true,
         'show_in_quick_edit' => true,
		]
	);

	//Таксономия chant, это - Распевы
	register_taxonomy('lex_kliros_chant', ['lex_kliros_noty'], [
		'label' => 'Распевы',
		'public' => true,
		'show_ui' => true, //логика управления в админ панели
		'show_in_menu' => true, //показ в админки
		'rewrite' => ['slug' => 'chant'],
		'hierarchical' => false,
		'has_archive' => true,
      'show_admin_column' => true,
      'show_in_quick_edit' => true,
	]);

	//Таксономия tonality, это тональность, можно по русски и по итальянски, как теги
	register_taxonomy('lex_kliros_tonality', ['lex_kliros_noty'], [
		'label' => 'Тональность',
		'public' => true, //разрешает участие в поиске по URL на GET запросах
		'show_ui' => true, //логика управления в админ панели
		'show_in_menu' => true, //показ в админки
		'rewrite' => '',
		'hierarchical' => false,
		'has_archive' => true,
      'show_in_quick_edit' => true,
	]);

	//Таксономия opus, это номер сочинения у писучих композиторов
	/*register_taxonomy('lex_kliros_opus', ['lex_kliros_noty'], [
		'label' => 'Опус/Номер',
		'public' => true,
		'show_ui' => true, //логика управления в админ панели
		'show_in_menu' => true, //показ в админки
		'rewrite' => false,
		'hierarchical' => false,
		'has_archive' => false,
	]);*/

   //Таксономия number, это номер сочинения у писучих композиторов
	register_taxonomy('lex_kliros_number', ['lex_kliros_noty'], [
		'label' => 'НОМЕР',
		'public' => true,
		'show_ui' => true, //логика управления в админ панели
		'show_in_menu' => true, //показ в админки
		'rewrite' => false,
		'hierarchical' => false,
		'has_archive' => false,
	]);

   //Таксономия onlyopus, это номер сочинения у писучих композиторов
	register_taxonomy('lex_kliros_onlyopus', ['lex_kliros_noty'], [
		'label' => 'ОПУС',
		'public' => true,
		'show_ui' => true, //логика управления в админ панели
		'show_in_menu' => true, //показ в админки
		'rewrite' => false,
		'hierarchical' => false,
		'has_archive' => false,
	]);

	//Таксономия quality, это Смешанный хор или однородный
	register_taxonomy('lex_kliros_quality', ['lex_kliros_noty'], [
		'label' => 'Смешанный/однородный',
		'public' => true,
		'show_ui' => true, //логика управления в админ панели
		'show_in_menu' => true, //показ в админки
		'rewrite' => '',
		'hierarchical' => false,
		'has_archive' => true,
	]);

	//Таксономия voices, это Квартет, трио, дуэт или унисон 
	register_taxonomy('lex_kliros_voices', ['lex_kliros_noty'], [
		'label' => 'Квартет/трио',
		'public' => true,
		'show_ui' => true, //логика управления в админ панели
		'show_in_menu' => true, //показ в админки
		'rewrite' => '',
		'hierarchical' => false,
		'has_archive' => true,
	]);
   
	register_post_type('lex_kliros_noty', [
		'labels' => [
			'name' => 'Ноты',
			'singular_name' => 'Партитура',
			'add_new' => 'Добавить партитуру',
			'add_new_item' => 'Добавить новую партитуру',
			'edit_item' => 'Редактировать ноты',
			'new_item' => 'Новая партитура',
			'view_item' => 'Посмотреть партитуру',
			'search_items' => 'Найти ноты',
			'not_found' => 'Партитур не найдено',
			'not_found_in_trash' => 'В корзине нот не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Партитуры'
		],
		'public' => true,
		'query_var' => true, // добавить в поиск
		'menu_position' => 5,
		'menu_icon' => 'dashicons-format-audio',
		'supports' => ['title', 'editor', 'excerpt', 'custom-fields'],
		'rewrite' => ['slug' => 'choral'],
		'has_archive' => true, //вывод всех постов этого типа списком по url-у post-type
		'show_ui' => true, //логика управления в админ панели
		'show_in_menu' => true, //показ в админки
	]);

	//Мета поля или Произвольные поля к Нотам
	//неясно зачем их регистрировать, без этого тоже работает
	//Путь к PDF файлы с партитурой
	register_post_meta('lex_kliros_noty', 'filepath', [
		'type' => 'string',
		'description' => 'Путь к PDF файлы с партитурой',
		'single' => true,
		'sanitize_callback' => null,
		'auth_callback' => null,
		'show_in_rest' => true,
	]);

});
