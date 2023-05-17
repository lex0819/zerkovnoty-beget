<h2><a href="<?php $_SERVER['PHP_SELF']; ?>?page=lexkliros">МЕНЮ</a></h2>

<?php
$terms = get_terms([
   'taxonomy' => 'lex_kliros_chant',
   'hide_empty' => false,
   'orderby' => 'name',
   'order' => 'ASC',
]);
//echo '<pre>'.print_r($terms, 1).'</pre>';

echo '<h3>Общее число распевов в базе: ' . count($terms) . '</h3>';
foreach ($terms as $terms) {
   echo '"' . $terms->name . '",<br>';
}
