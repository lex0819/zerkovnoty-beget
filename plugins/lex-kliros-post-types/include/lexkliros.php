<?php
require_once('func_lexkliros.php');
$counters = lex_kliros_sum_downloads();
$sum = 0;
foreach ($counters as $item) {
   $sum += $item;
}
?>
<h1>Плагин проверки списков композиторов и т.д.</h1>
<p class="count_download noty">Сколько всего раз скачали <strong>ноты: <?php echo $counters['lex_kliros_noty']; ?></strong></p>

<p class="count_download collect">Сколько всего раз скачали <strong>сборники: <?php echo $counters['kliros_collections']; ?></strong></p>

<p class="count_download all">Общее число скачиваний: <strong><?php echo $sum; ?></strong></p>

<h2>Что хотите проверить?</h2>
<ul>
   <li>
      <h3><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros&c=composer">Список композиторов</a></h3>
   </li>
   <li>
      <h3><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros&c=chant">Список распевов</a></h3>
   </li>
   <li>
      <h3><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros&c=tonality">Список тональностей</a></h3>
   </li>
   <li>
      <h3><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros&c=null-tonality">Список партитур БЕЗ тональностей</a></h3>
   </li>
   <li>
      <h3><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros&c=null-compos_chant">Список партитур НЕТ ни композитора ни распева</a></h3>
   </li>
   <li>
      <h3><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros&c=null-rubric">Список партитур никуда НЕ добавленных, ни в Литургию, ни в ПАСХУ, ни в концерты и т.д.</a></h3>
   </li>
   <li>
      <h3><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros&c=bigfiles&size=2000">Список файлов партитур по убыванию мегабайт</a></h3>
   </li>
   <li>
      <h3><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros&c=add-excerpt">Список нот с пустым отрывком. Поле excerpt НЕ заполнено.</a></h3>
   </li>
   <li>
      <h3><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros&c=search-similar">Список дублей - идентичных нот по разным рубрикам.</a></h3>
   </li>
   <li>
      <h3><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros&c=update-all-excerpt">Автоматическое заполнение поля Отрывок у всех нот одним махом. Осторожно !!!</a></h3>
   </li>
   <li>
      <h3><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros&c=content-html-clear">Автоматическое заполнение поля Контент у всех нот одним махом. Осторожно !!!</a></h3>
   </li>
   <li>
      <h3><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros&c=download_counter">Автоматическая простановка НУЛЯ поля счетчика скачиваний у всех нот одним махом. Если поле счетчика не заполнено - туда запишется 0</a></h3>
   </li>

</ul>