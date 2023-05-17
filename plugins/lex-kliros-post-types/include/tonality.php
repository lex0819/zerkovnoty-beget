<h3><a href="<?php $_SERVER['PHP_SELF']; ?>?page=lexkliros">МЕНЮ</a></h3>

<?php
$terms = get_terms([
   'taxonomy' => 'lex_kliros_tonality',
   'hide_empty' => false,
   'orderby' => 'name',
   'order' => 'ASC',
]);
//echo '<pre>'.print_r($terms, 1).'</pre>';
foreach ($terms as $terms) {
   echo '"' . $terms->name . '",<br>';
}
