<?php

require_once('func_lexkliros.php');
$res = lex_null_rubrics($_GET['c']);
//echo '<pre>'.print_r($res, 1).'</pre>';

?>

<h3 class="hed-h1"><a href="<?php $_SERVER['PHP_SELF']; ?>?page=lexkliros">МЕНЮ</a></h3>
<h2>Список произведений и без композитора и без распева</h2>
<?php if ($res) : ?>
   <ol>
      <?php foreach ($res as $value) : ?>
         <li><a href="<?= get_permalink($value); ?>"><strong><?php echo esc_html(get_the_title($value)); ?></strong><i class="user-text"><?php echo ' ';
                                                                                                                                          echo get_post_meta($value, 'filepath', true); ?></i></a></li>
      <?php endforeach; ?>
   </ol>
<?php else : ?>
   <p>Ничего не найдено</p>
<?php endif; ?>