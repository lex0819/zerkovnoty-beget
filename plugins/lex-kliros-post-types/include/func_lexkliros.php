<?php

/*Функции достают из базы массив ID постов
получается двумерный массив
но кроме ID ничего лишнего*/

/*Функция достает из базы все произведения*/
function lex_noty_all()
{
   global $wpdb;
   $table_name = $wpdb->prefix . 'posts';
   $q =
      "SELECT `id` 
      FROM $table_name 
      WHERE `post_type` = 'lex_kliros_noty'";

   return $wpdb->get_results($q, ARRAY_A);
}

/*Функция достает из базы все произведения у которых заполнена Тональность*/
function lex_noty_tonality()
{
   global $wpdb;
   $table_relation = $wpdb->prefix . 'term_relationships';
   $table_taxonomy = $wpdb->prefix . 'term_taxonomy';
   $q =
      "SELECT DISTINCT `object_id` 
      FROM $table_relation 
      WHERE `term_taxonomy_id` IN 
         (SELECT `term_taxonomy_id` 
         FROM $table_taxonomy 
         WHERE `taxonomy`='lex_kliros_tonality')";

   return $wpdb->get_results($q, ARRAY_A);
}

/*Функция достает из базы все произведения у которых заполнен либо композитор либо распев*/
function lex_noty_composer_chant()
{
   global $wpdb;
   $table_relation = $wpdb->prefix . 'term_relationships';
   $table_taxonomy = $wpdb->prefix . 'term_taxonomy';
   $q =
      "SELECT DISTINCT `object_id` 
      FROM $table_relation 
      WHERE `term_taxonomy_id` IN 
         (SELECT `term_taxonomy_id` 
         FROM $table_taxonomy 
         WHERE `taxonomy`='lex_kliros_composer'
         OR `taxonomy`='lex_kliros_chant')";

   return $wpdb->get_results($q, ARRAY_A);
}

/*Функция достает из базы все произведения в рубриках, прикрепленные куда-то, в Пост, Литургию и т.д.*/
function lex_noty_is_rubric()
{
   global $wpdb;
   $table_relation = $wpdb->prefix . 'term_relationships';
   $table_taxonomy = $wpdb->prefix . 'term_taxonomy';
   $q =
      "SELECT DISTINCT `object_id` 
      FROM $table_relation 
      WHERE `term_taxonomy_id` IN 
         (SELECT `term_taxonomy_id` 
         FROM $table_taxonomy 
         WHERE `taxonomy` IN 
            ('lex_kliros_liturgical', 'lex_kliros_triodion', 'lex_kliros_minea', 'lex_kliros_miserere')) ";

   return $wpdb->get_results($q, ARRAY_A);
}

/*Функция производит вычитание Множества заполненных произведений из множества ВСЕХ произведений
Таким образом при вычитании множеств остается только множество произведений, которые БЕСХОЗНЫЕ*/
function lex_null_rubrics($rubrics)
{
   $res_noty_all = lex_noty_all();
   if (isset($rubrics)) {
      //echo '<pre>'.print_r($_GET).'</pre>';
      switch ($rubrics) {
         case 'null-tonality':
            $res_noty_rubrics = lex_noty_tonality();
            break;
         case 'null-compos_chant':
            $res_noty_rubrics = lex_noty_composer_chant();
            break;
         case 'null-rubric':
            $res_noty_rubrics = lex_noty_is_rubric();
            break;
         default:
            $res_noty_rubrics = lex_noty_is_rubric();
            break;
      }
   } else {
      return false;
      die('Не заданы рубрики либо тональности');
   }
   //echo '<pre>'.print_r($res_noty_all, 1).'</pre>';
   //echo '<pre>'.print_r($res_noty_rubrics, 1).'</pre>';

   $noty_all = array(); // массив ID всех нот
   $noty_rubrics = array(); // массив ID нот НЕ бесхозных

   $noty_does_not_have_owner = array(); // массив ID нот Бесхозных

   foreach ($res_noty_all as $value) {
      $noty_all[] = $value['id'];
   }
   //echo '<pre>'.print_r($noty_all, 1).'</pre>';

   foreach ($res_noty_rubrics as $value) {
      $noty_rubrics[] = $value['object_id'];
   }
   //echo '<pre>'.print_r($noty_rubrics, 1).'</pre>';

   /*array_diff() разность массивов
	MySQL не хочет этого делать
	приходится напрягать PHP*/
   $noty_does_not_have_owner = array_diff($noty_all, $noty_rubrics);
   //echo '<pre>'.print_r($noty_does_not_have_owner, 1).'</pre>';

   if (empty($noty_does_not_have_owner)) {
      return false;
   } else {
      return $noty_does_not_have_owner;
   }
}

function big_file_size()
{
   $all_noty = lex_noty_all();
   //echo '<pre>'.print_r($all_noty, 1).'</pre>';

   foreach ($all_noty as $key => $value) {
      $all_noty[$key]['path'] = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] . '/Notes1/' . get_post_meta($value['id'], 'filepath', true));
      $all_noty[$key]['size'] = (file_exists($all_noty[$key]['path'])) ? filesize($all_noty[$key]['path']) : 0;
      //var_dump($all_noty[$key]['path']);
      //$all_noty[$key]['size'] = filesize( $all_noty[$key]['path'] );
   }
   //echo $_SERVER['DOCUMENT_ROOT'];
   //echo '<pre>'.print_r($all_noty, 1).'</pre>';

   $size  = array_column($all_noty, 'size');
   array_multisort($size, SORT_DESC, $all_noty);
   return $all_noty;
   //echo '<pre>'.print_r($all_noty, 1).'</pre>';
}

/*Функция достает из базы все произведения c пустым excerpt*/
function lex_noty_no_excerpt()
{
   global $wpdb;
   $table_name = $wpdb->prefix . 'posts';
   $q =
      "SELECT `id` 
      FROM $table_name 
      WHERE `post_type` = 'lex_kliros_noty' 
      AND `post_excerpt` = ''";

   return $wpdb->get_results($q, ARRAY_A);
}

/*Функция заполняет в базе все произведения c пустым excerpt*/
function lex_noty_add_excerpt()
{
   global $wpdb;
   $table_name = $wpdb->prefix . 'posts';

   $noty_no_excerpt = lex_noty_no_excerpt();
   // echo '<pre>';
   // var_dump($noty_no_excerpt);
   // echo '</pre>';
   // wp_die();

   foreach ($noty_no_excerpt as $value) {
      $nota_title = get_the_title($value['id']);
      $nota_quality_choir = get_post_meta($value['id'], 'quality', true);
      $nota_voices_choir = get_post_meta($value['id'], 'voices', true);
      $nota_composer = get_the_terms($value['id'], 'lex_kliros_composer');
      //echo '<pre>'.print_r($nota_composer, 1).'</pre>';
      $nota_tonality = get_the_terms($value['id'], 'lex_kliros_tonality');
      //echo '<pre>'.print_r($nota_composer, 1).'</pre>';
      $nota_chant = get_the_terms($value['id'], 'lex_kliros_chant');
      //echo '<pre>'.print_r($nota_composer, 1).'</pre>';
      $nota_opus = get_the_terms($value['id'], 'lex_kliros_opus');
      //echo '<pre>'.print_r($nota_composer, 1).'</pre>';

      $add_post_excerpt = $nota_title . ' ';
      if (is_array($nota_opus)) {
         $add_post_excerpt .= $nota_opus[0]->name . ' ';
      };
      if (is_array($nota_composer)) {
         $add_post_excerpt .= $nota_composer[0]->name . ' ';
      };
      if (is_array($nota_chant)) {
         $add_post_excerpt .= $nota_chant[0]->name . ' распев ';
      };
      if (is_array($nota_tonality)) {
         $add_post_excerpt .= $nota_tonality[0]->name . ' ';
      };
      if ($nota_quality_choir) {
         $add_post_excerpt .= $nota_quality_choir . ' ';
      };
      if ($nota_voices_choir) {
         if ('квартет' == $nota_voices_choir) {
            $add_post_excerpt .= $nota_voices_choir . ' и более';
         } else {
            $add_post_excerpt .= $nota_voices_choir;
         }
      };
      echo var_dump($add_post_excerpt) . '<br>';
      //echo var_dump($table_name).'<br>';
      $data_update = array('post_excerpt' => $add_post_excerpt,);
      $where_update = array('id' => $value['id'],);
      //echo var_dump($data_update).'<br>';
      //echo var_dump($where_update).'<br>';
      //wp_die('Первый элемент массива $noty_no_excerpt');
      $wpdb->update($table_name, $data_update, $where_update);
   }
}

/*функция берет файл txt со списком и возвращает массив произведений*/
/*function lex_parser_txt($file_name)
{
   $file_name = site_url('/') . 'Notes1/' . $file_name;
   if (is_readable($file_name)) {
      $string_message = file_get_contents($file_name);

      if ($string_message) {
         $string_message = explode("\n*\n", $string_message);
         array_shift($string_message);
         return $string_message;
      } else {
         return false;
      }
   } else return false;
}*/

//Функция поиска двух и более записей одного и того же произведения
function lex_search_excerpt()
{
   global $wpdb;
   $table_name = $wpdb->prefix . 'posts';

   $q =
      "SELECT `id`, `post_excerpt` 
      FROM $table_name 
      WHERE `post_type` = 'lex_kliros_noty' 
      AND `post_excerpt` <> '' 
      ORDER BY `post_excerpt` ASC";

   return $wpdb->get_results($q, ARRAY_A);
}

function lex_search_similar($list_ar)
{
   $result_ar = [];
   $count = count($list_ar) - 1;
   $group = 1;

   for ($i = 0; $i < $count;) {

      $excerpt = $list_ar[$i]['post_excerpt'];

      if ($excerpt === $list_ar[$i + 1]['post_excerpt']) {
         $j = 1;
         while ($excerpt === $list_ar[$i + $j]['post_excerpt']) {
            if ($j === 1) {
               $result_ar[] = [
                  'group' => $group,
                  'id' => $list_ar[$i]['id'],
                  'post_excerpt' => $list_ar[$i]['post_excerpt']
               ];
            }
            $result_ar[] = [
               'group' => $group,
               'id' => $list_ar[$i + $j]['id'],
               'post_excerpt' => $list_ar[$i + $j]['post_excerpt']
            ];
            $j++;
         }
         $i = $i + $j;
         $group++;
      } else {
         $i++;
      }
   }

   return $result_ar;
}

//Функция запускает SELECT в базе на все партитуры и сборники без поля счётчика скачиваний. Счётчика не было вообще.
function lex_kliros_search_empty_counter_download()
{
   global $wpdb;
   $table_name = $wpdb->prefix . 'postmeta';

   $query =
      "SELECT `post_id` 
      FROM $table_name 
      WHERE `meta_key` = 'filepath' 
      AND `meta_value` != 'Notes1/' 
      AND `meta_value` IS NOT NULL
      AND `post_id` NOT IN
         (SELECT `post_id`
         FROM $table_name
         WHERE `meta_key` = 'lex_kliros_noty_count_download')";

   return $wpdb->get_results($query, ARRAY_A);
}

//Функция INSERT заполняет счетчик скачивания НУЛЁМ, если его не было вообще
function lex_kliros_insert_counter_download()
{
   global $wpdb;
   $table_name = $wpdb->prefix . 'postmeta';

   $not_counter_download_all = lex_kliros_search_empty_counter_download();
   // echo '<pre>';
   // var_dump($not_counter_download_all);
   // echo '</pre>';
   // wp_die();

   foreach ($not_counter_download_all as $value) {
      $data_update = array(
         'post_id' => $value['post_id'],
         'meta_key' => 'lex_kliros_noty_count_download',
         'meta_value' => 0,
      );

      $wpdb->insert($table_name, $data_update);
   }
}

//Функция запускает SELECT на суммирование скачиваний по сборникам и по нотам
function lex_kliros_sum_downloads()
{
   global $wpdb;
   $table_post = $wpdb->prefix . 'posts';
   $table_meta = $wpdb->prefix . 'postmeta';

   $query = "SELECT `post_type`, SUM(`meta_value`) AS sum_value 
   FROM $table_post , $table_meta
   WHERE `post_id`=`ID`
   AND `meta_key`='lex_kliros_noty_count_download'
   GROUP BY `post_type`";

   $outputs = $wpdb->get_results($query, ARRAY_A);
   $results = [];

   foreach ($outputs as $record) {
      $results[$record['post_type']] =  $record['sum_value'];
   }

   return $results;
}
