<h2>Выбор и установка Новогодней Ёлочки</h2>
<form action="" method="post">
   <div style="padding: 1rem;">
      <label for="banner_lex">Выберите файл ёлочки</label>
      <select id="banner_lex_path" name="banner_lex_path" size=1>
         <?php
         foreach ($banner_lex as $value) : ?>
            <option value="<?= $value; ?>" <?php selected($value, $path, true); ?>><?= $value; ?></option>
         <?php endforeach; ?>
      </select>
   </div>
   <div style="padding: 1rem;">
      <label for="banner_lex_width">Ширина баннера на сайте</label>
      <input type="number" name="banner_lex_width" value="<?= $width; ?>">пикселей
   </div>
   <div style="padding: 1rem;">
      <p>Положение баннера на сайте</p>
      <label for="left_top">left_top</label>
      <input type="radio" id="left_top" name="banner_lex_position" value="left_top" <?php checked('left_top', $position, true); ?>>
      <label for="right_top">right_top</label>
      <input type="radio" id="right_top" name="banner_lex_position" value="right_top" <?php checked('right_top', $position, true); ?>>
   </div>
   <div style="padding: 1rem;">
      <label for="banner_lex_check"> Активировать баннер</label>
      <input type="checkbox" name="banner_lex_check" value="yes" <?php checked('yes', $check, true); ?>>
   </div>
   <button type="submit">Save changes</button>
   <div style=" padding: 1rem;">
      <img class="banner-img" src="<?= plugin_dir_url(__DIR__) . $path; ?>" alt="banner picture">
   </div>
</form>
<script>
   let themePath = '<?= plugin_dir_url(__DIR__); ?>';
   const bannerCurrent = document.querySelector("select[name=banner_lex_path]");
   let bannerImg = document.querySelector('.banner-img');

   bannerCurrent.addEventListener('change', function() {
      let newPath = bannerCurrent.value;
      bannerImg.src = themePath + newPath;
   });
</script>