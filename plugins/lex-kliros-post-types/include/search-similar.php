<?php

require_once __DIR__ . '/func_lexkliros.php';

$list_ar = lex_search_excerpt();

// echo '<pre>';
// var_dump($list_ar);
// echo '</pre>';
// wp_die('debager');

$result_ar = lex_search_similar($list_ar);
// echo '<pre>';
// var_dump($result_ar);
// echo '</pre>';
// wp_die('debager');
?>
<h3 class="hed-h1"><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros">МЕНЮ</a></h3>
<h2>Список дублей - идентичных нот по разным рубрикам.</h2>
<?php if ($result_ar) :
   echo '<h3>Всего найдено ' . count($result_ar) . 'штук</h3>';
?>
   <ol>
      <?php foreach ($result_ar as $value) : $group = $value['group'] ?>
         <li class="list" data-group="<?= $group; ?>">
            <a href="<? the_permalink($value['id']); ?>"><i class="user-text"><?= $value['post_excerpt']; ?></i></a>
         </li>
      <?php endforeach; ?>
   </ol>
<?php else : ?>
   <p>Ничего не найдено</p>
<?php endif;
