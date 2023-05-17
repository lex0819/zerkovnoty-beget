<?php

//var_dump($post->post_type);//тип записи
//var_dump($post->ID);//id поста
//var_dump(get_lex_filepath($post->ID));//путь к файлу для скачивания
$note_excerpt = get_the_excerpt();
$excerpt_arr = explode("\n", $note_excerpt);
//var_dump($excerpt_arr);


//пришло из вызывающего скрипта - search.php и т.д.
//echo '<pre>'.print_r($args, 1).'</pre>';
$per_page = (int)$args['per_page'];

//номер текущей страницы где стоим в пагинации 
if ((int)$wp_query->query_vars['paged'] === 0) {
	$page_number = 1;
} else {
	$page_number = (int)$wp_query->query_vars['paged'];
}
/*echo '<pre>';
	var_dump($wp_query->query['paged']);var_dump($page_number);
	var_dump($per_page);
	var_dump($wp_query->current_post);
	echo '</pre>';*/
//номер текущего поста на этой странице от НУЛЯ не сквозной поэтому плюс 1
$nota_current = (int)$wp_query->current_post + 1;
$nota_number = $nota_current + (($page_number - 1) * $per_page);
//echo $nota_number; // сквозная нумерация песен
?>
<li>
   <? if('lex_kliros_noty' == $post->post_type || get_the_content() != '' ) : ?>
      <a href="<?php the_permalink(); ?>">
         <span class="nota-title"><?= $nota_number ?></span>
         <span class="nota-composer"><?= $excerpt_arr[0]; ?></span>
         <? if(count($excerpt_arr)  > 1) : ?>
            <span class="nota-title"><?= $excerpt_arr[1]; ?></span>
         <? endif; ?>
      </a>
   <? //endif; ?>
   <? else :?>
   <? //if('kliros_collections' == $post->post_type) : ?>
      <span class="nota-title"><?= $nota_number ?></span>
      <span class="nota-composer"><?= $excerpt_arr[0]; ?></span>
      <a href="<?= get_lex_filepath($post->ID); ?>" download>Скачать ZIP</a>
   <? endif; ?>
</li>