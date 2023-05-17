<?php

require_once __DIR__ . '/func_lexkliros.php';

$all_pdf = lex_noty_no_excerpt();

//echo '<pre>'; var_dump($_POST['btn_add']); echo '</pre>';

if ((count($all_pdf) > 0) && isset($_POST['btn_add']) && ($_POST['btn_add'] == 'OK')) {
   //echo 'Заполняем'.'<br>';
   lex_noty_add_excerpt();
   $_POST['btn_add'] = '';
   $all_pdf = lex_noty_no_excerpt();
}
?>

<h3 class="hed-h1"><a href="<?php $_SERVER['PHP_SELF']; ?>?page=lexkliros">МЕНЮ</a></h3>
<h2>Список нот с пустым отрывком поле excerpt</h2>

<?php if (count($all_pdf) > 0) : ?>
   <h3 style="color: red">Всего найдено не заполненных нот <?php echo count($all_pdf); ?> штук</h3>
   <form name="form-kb" action="<?php echo $_SERVER['PHP_SELF'] . '?page=lexkliros&c=add-excerpt'; ?>" method="POST">
      <button name="btn_add" type="submit" value="OK" style="font-size: 20px; cursor: pointer;">Заполнить отрывки для этих партитур</button>
   </form>
<?php else : ?>
   <h3 style="color: green">Все ноты заполнены. Пока нечего заполнять.</h3>
<?php endif;
