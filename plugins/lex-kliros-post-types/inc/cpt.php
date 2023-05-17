<?php

if (!defined('zerkovNotyCpt')) {
   class zerkovNotyCpt
   {
      public function register()
      {
         add_action('init', [$this, 'custom_post_types']);
         add_action('add_meta_boxes', [$this, 'add_metabox_lex_kliros']);
         add_action('save_post', [$this, 'save_metabox'], 10, 3);
         add_action('wp_insert_post_data', [$this, 'insert_excerpt'], 20, 2);
         add_action('restrict_manage_posts', [$this, 'dropdown_categories_kliros'], 10, 1);
         add_filter('template_include', [$this, 'template_include_kliros']);
         add_filter('posts_where', [$this, 'posts_where_kliros'], 10, 2);
         add_filter('manage_lex_kliros_noty_posts_columns', [$this, 'new_columns_kliros']);
         add_filter('manage_kliros_collections_posts_columns', [$this, 'new_columns_kliros']);
         add_action('manage_posts_custom_column', [$this, 'show_columns_content'], 10, 2);
         add_filter('manage_edit-lex_kliros_noty_sortable_columns', [$this, 'sort_post_kliros']);
         add_filter('manage_edit-kliros_collections_sortable_columns', [$this, 'sort_post_kliros']);
         add_action('pre_get_posts', [$this, 'orderby_kliros_items']);
      }

      public function orderby_kliros_items($query)
      {
         // так как сортировка будет осуществляться только в админке
         if (!is_admin()) {
            return;
         }

         // получаем значение параметра сортировки
         $orderby = $query->get('orderby');

         if ('Count_Down' == $orderby) { // 'Count_Down' - параметр в GET-запросе
            $query->set('meta_key', 'lex_kliros_noty_count_download'); // 'lex_kliros_noty_count_download' - название произвольного поля
            $query->set('orderby', 'meta_value_num'); // если сортировка не по числовому значению, а по алфавиту, замените на 'meta_value'
         }
      }

      public function sort_post_kliros($columns)
      {
         $columns['counter_downloads'] = 'Count_Down';
         return $columns;
      }

      public function new_columns_kliros($columns)
      {
         // this will add the column to the end of the array
         $columns['counter_downloads'] = 'Count_Down';
         //add more columns as needed

         // as with all filters, we need to return the passed content/variable
         return $columns;
      }

      public function show_columns_content($column_id, $post_id)
      {
         //run a switch statement for all of the custom columns created
         switch ($column_id) {
            case 'counter_downloads':
               echo ($value = get_post_meta($post_id, 'lex_kliros_noty_count_download', true)) ? $value : 0;
               break;

               //add more items here as needed, just make sure to use the column_id in the filter for each new item.

         }
      }

      public function posts_where_kliros($where, $query)
      {
         global $wpdb; //PDO in WordPress

         $start_str = $query->get('start_str');
         if ($start_str) {
            //$where .= " AND $wpdb->posts.post_title REGEXP '^$start_str'"; //only MySQL Oracle 8
            $where .= " AND $wpdb->posts.post_title LIKE '$start_str%'"; // all MySQL
         }
         return $where;
      }

      public function template_include_kliros($template)
      {
         if (isset($_GET['s']) && 'lex_kliros_noty' === get_query_var('post_type')) {
            return locate_template('search-lex_kliros_noty.php'); //redirect to search-lex_kliros_noty.php
         }
         return $template;
      }

      public function dropdown_categories_kliros($post_type)
      {
         if ('kliros_collections' !== $post_type && 'lex_kliros_noty' !== $post_type) {
            return;
         }
         $taxonomies_slugs = get_object_taxonomies($post_type);

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
      }

      public function insert_excerpt($data, $postarr)
      {
         // echo '<pre>';
         // var_dump($data);
         // echo '<pre>';
         // echo '<pre>';
         // var_dump($postarr);
         // echo '<pre>';
         // wp_die('$data and $postarr insert_excerpt');

         if ($postarr['post_type'] != 'lex_kliros_noty' && $postarr['post_type'] != 'kliros_collections') {
            return $data;
         }  // убедимся что мы редактируем нужный тип поста
         if (get_current_screen()->id != 'lex_kliros_noty' && get_current_screen()->id != 'kliros_collections') {
            return $data;
         }  // убедимся что мы на нужной странице админки
         if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $data;
         } // пропустим если это автосохранение
         if (!current_user_can('edit_post', $postarr['ID'])) {
            return $data;
         } // убедимся что пользователь может редактировать запись
         // Все ОК! обрабатываем
         // echo $postarr['post_type'];
         // wp_die();

         $excerpt_arr = [];
         //$excerpt_arr += [...] будет одномерный массив элементов последовательно
         $excerpt_arr += ['post_title' => $postarr['post_title']];
         $excerpt_arr += ['content' => $postarr['content']];

         //композитор, распев, опус, тональность и рубрики
         $taxos = $postarr['tax_input'];

         foreach ($taxos as $tax_reg => $tax_array) {
            $full_term = '';
            foreach ($tax_array as $value) {
               if ($value > 0) {
                  $term = get_term_parents_list($value, $tax_reg, ['format' => 'name', 'separator' => ' >> ', 'link' => false, 'inclusive' => true]);
                  $term = rtrim($term, " >> ") . '  ';
                  $full_term .=    $term;
               }
            }
            $excerpt_arr += [$tax_reg => $full_term];
         }

         $excerpt = '';

         if ($postarr['post_type'] == 'lex_kliros_noty') {

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
         }

         if ($data['post_type'] == 'kliros_collections') {
            $excerpt = $postarr['post_title'] . "\n" . 'Сборники';

            //композитор, распев, опус и рубрика
            $taxos = $postarr['tax_input'];
            foreach ($taxos as $key => $tax) {
               //не надо выкидывать композитора из Отрывка
               // if ($key !== 'lex_kliros_composer') {
               //    foreach ($tax as $value) {
               //       if ($value !== 0) {
               //          $term = get_term($value);
               //          $excerpt .= ' >> ' . $term->name;
               //       }
               //    }
               // }
               foreach ($tax as $value) {
                  if ($value !== 0) {
                     $term = get_term($value);
                     $excerpt .= ' >> ' . $term->name;
                  }
               }
            }

            $excerpt .= '.';
         }

         // echo '<pre>';
         // var_dump($excerpt);
         // echo '</pre>';
         // wp_die();

         //заполняем Отрывок
         $data['post_excerpt'] = $excerpt;
         return $data;
      }

      private function save_meta_field($post_id, $field_name)
      {
         if (is_null($_POST[$field_name])) {
            delete_post_meta($post_id, $field_name);
         } else {
            update_post_meta($post_id, $field_name, sanitize_text_field($_POST[$field_name]));
         }
      }

      private function security_check($post_id, $post, $nonce_fild, $nonce_action, $post_type)
      {
         //nonce is contained in $_POST['fild_name']
         if (!isset($_POST[$nonce_fild]) || !wp_verify_nonce($_POST[$nonce_fild], $nonce_action)) {
            return $post_id;
         }
         //autosave
         if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
         }
         //post_type
         if ($post->post_type != $post_type) {
            return $post_id;
         }
         //user's capability for this post_type
         $current_post_type = get_post_type_object($post->post_type);
         if (!current_user_can($current_post_type->cap->edit_post, $post_id)) {
            return $post_id;
         }
      }

      public function save_metabox($post_id, $post, $update)
      {
         if (!$update) {
            return $post_id;
         }

         switch ($post->post_type) {
            case 'kliros_collections':
               $this->security_check($post_id, $post, '_lex_kliros_collect_field', 'lex_kliros_collect_action_security', $post->post_type);

               $this->save_meta_field($post_id, 'filepath');
               $this->save_meta_field($post_id, 'lex_kliros_noty_count_download');

               return $post_id;
               break;

            case 'lex_kliros_noty':
               $this->security_check($post_id, $post, '_lex_kliros_noty_field', 'lex_kliros_noty_action_security', $post->post_type);

               $this->save_meta_field($post_id, 'filepath');
               $this->save_meta_field($post_id, 'lex_kliros_noty_count_download');

               return $post_id;
               break;
         }
      }

      public function add_metabox_lex_kliros()
      {
         add_meta_box(
            'lex_kliros_noty_settings', //slug or ID
            "Information about the Partitura", //label in admin
            [$this, 'metabox_lex_kliros_noty_html'], //callback html in admin
            'lex_kliros_noty',
            'normal',
            'high',
         );
         add_meta_box(
            'lex_kliros_collect_settings', //slug or ID
            "Information about the Books", //label in admin
            [$this, 'metabox_lex_kliros_collect_html'], //callback html in admin
            'kliros_collections',
            'normal',
            'high',
         );
      }

      public function metabox_lex_kliros_collect_html($post)
      {
         $filepath = get_post_meta($post->ID, 'filepath', true);
         $count_download = get_post_meta($post->ID, 'lex_kliros_noty_count_download', true);
         if (empty($count_download)) {
            $count_download = 0;
            update_post_meta($post->ID, 'lex_kliros_noty_count_download', $count_download);
         }

         wp_nonce_field('lex_kliros_collect_action_security', '_lex_kliros_collect_field'); //nonce security 1=action 2=nonce

         echo '
            <p>
               <label for="filepath">Path to PDF Book</label>
               <input type="text" id="filepath" name="filepath" style="width: 80%;" value="' . esc_html($filepath) . '">
            </p>
            <p>
               <label for="lex_kliros_noty_count_download">how many times the file was downloaded</label>
               <input type="number" id="lex_kliros_noty_count_download" name="lex_kliros_noty_count_download" value="' . esc_html($count_download) . '">
            </p>
         ';
      }

      public function metabox_lex_kliros_noty_html($post)
      {
         $filepath = get_post_meta($post->ID, 'filepath', true);
         $count_download = get_post_meta($post->ID, 'lex_kliros_noty_count_download', true);
         if (empty($count_download)) {
            $count_download = 0;
            update_post_meta($post->ID, 'lex_kliros_noty_count_download', $count_download);
         }

         wp_nonce_field('lex_kliros_noty_action_security', '_lex_kliros_noty_field'); //nonce security 1=action 2=nonce

         echo '
            <p>
               <label for="filepath">Path to file</label>
               <input type="text" id="filepath" name="filepath" style="width: 80%;" value="' . esc_html($filepath) . '">
            </p>
            <p>
               <label for="lex_kliros_noty_count_download">how many times the file was downloaded</label>
               <input type="number" id="lex_kliros_noty_count_download" name="lex_kliros_noty_count_download" value="' . esc_html($count_download) . '">
            </p>
         ';
      }

      public function custom_post_types()
      {
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
            'lex_kliros_composer',
            ['lex_kliros_noty', 'kliros_collections'],
            [
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
            'supports' => ['title', 'editor', 'excerpt'],
            'rewrite' => ['slug' => 'choral'],
            'has_archive' => true, //вывод всех постов этого типа списком по url-у post-type
            'show_ui' => true, //логика управления в админ панели
            'show_in_menu' => true, //показ в админки
         ]);

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
            'supports' => ['title', 'editor', 'excerpt', 'thumbnail'],
            'rewrite' => ['slug' => 'collection'],
            'has_archive' => true, //вывод всех постов этого типа списком по url-у post-type
            'show_ui' => true, //логика управления в админ панели
            'show_in_menu' => true, //показ в админки
         ]);
      }
   }
}

if (class_exists('zerkovNotyCpt')) {
   $zerkovnotycpt = new zerkovNotyCpt();
   $zerkovnotycpt->register();
}
