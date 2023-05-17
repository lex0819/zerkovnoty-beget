<?php
require_once('func_lexkliros.php');

$not_counter_download_all = lex_kliros_search_empty_counter_download();
lex_kliros_insert_counter_download();
?>
<h3 class="hed-h1"><a href="<?php $_SERVER['PHP_SELF']; ?>?page=lexkliros">МЕНЮ</a></h3>
<h2>Все пустые счетчики нот и сборников созданы и сброшены на НОЛЬ!</h2>
<p>Обработано <?= count($not_counter_download_all); ?> строк</p>