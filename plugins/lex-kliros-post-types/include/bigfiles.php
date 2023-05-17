<?php

require_once __DIR__ . '/func_lexkliros.php';

$all_pdf = big_file_size();
//echo '<pre>'.print_r($all_pdf, 1).'</pre>';
//var_dump($_GET);
$min_size_kb = $_GET['size'] ?? 0;

if (isset($_POST['filesize'])) {
   $min_size_kb = $_POST['filesize'];
}

$min_size_break = (int)$min_size_kb * 1024;
// var_dump($min_size_break);

$big_pdf = array();
foreach ($all_pdf as $value) {
   if ($value['size'] <= $min_size_break) {
      break;
   }
   $big_pdf[] = array(
      get_permalink($value['id']),
      esc_html(get_the_title($value['id'])),
      get_post_meta($value['id'], 'filepath', true),
      strval(intdiv($value['size'], 1000)),
   );
}
//echo '<pre>'.print_r( $big_pdf, 1).'</pre>';

?>

<h3 class="hed-h1"><a href="<?= $_SERVER['PHP_SELF']; ?>?page=lexkliros">МЕНЮ</a></h3>
<h2>Список файлов PDF по убываню мегабайтов</h2>

<form name="form-kb" action="<?= $_SERVER['PHP_SELF'] . '?page=lexkliros&c=bigfiles'; ?>" method="POST">
   <label for="filesize">Показать файлы больше этого размера Килобайты</label>
   <input class="input-send" type="text" id="filesize" name="filesize" value="<?= $min_size_kb ?>">
   <button name="btn_size" type="submit">OK</button>
</form>

<?php if ($big_pdf) :
   echo '<h3>Всего найдено ' . count($big_pdf) . 'штук</h3>';
?>
   <ol>
      <?php foreach ($big_pdf as $value) : ?>
         <li class="list">
            <a href="<?= $value[0]; ?>"><strong><?= $value[1]; ?></strong><i class="user-text"><?= ' ' . $value[2]; ?></i></a><?= ' ' . $value[3] . ' Kb'; ?>
         </li>
      <?php endforeach; ?>
   </ol>
<?php else : ?>
   <p>Ничего не найдено</p>
<?php endif;
