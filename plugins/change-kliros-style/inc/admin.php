<style>
   .color-show-kliros-style {
      margin: 10px;
      width: 200px;
      height: 100px;
      background-color: <?php echo $color_name; ?>;
   }
</style>
<h2>Выбор файла CSS для цветовой схемы оформления</h2>
<h3><a href="https://www.w3schools.com/colors/colors_monochromatic.asp" target="_blank">Monochromatic Color Schemes w3schools</a></h3>
<form action="" method="post">
   <div style="padding: 1rem;">
      <h3>Выберите цветовую схему</h3>
      <select name="color_style_lex" size=1>
         <?php
         foreach ($color_style_lex as $value) :
            $selected = ($value['color_style_lex_color'] == $color_name) ? 'selected' : '';
         ?>
            <option value="<?php echo $value['color_style_lex_color']; ?>" <?php echo $selected; ?>>
               <?php echo $value['color_style_lex_color']; ?>
            </option>
         <?php endforeach; ?>
      </select>
   </div>
   <div style="padding: 1rem;">
      <label for="color_style_lex_path">Путь к файлу style_***.css на сервере</label>
      <input type="text" name="color_style_lex_path" value="<?php echo $path; ?>" required="required" class="regular-text">
   </div>
   <div style="padding: 1rem;">
      <label for="color_style_lex_color">Название цветовой схемы</label>
      <input type="text" name="color_style_lex_color" value="<?php echo $color_name; ?>" required="required" class="regular-text">
   </div>
   <div class="color-show-kliros-style"></div>
   <button type="submit">Save changes</button>
</form>
<script>
   const ColorStyleLex = [
      <?php
      foreach ($color_style_lex as $value) {
         echo '{ name: "' . $value['color_style_lex_color'] . '", path: "' . $value['color_style_lex_path'] . '" },';
      }
      ?>
   ];
   const StyleCurrent = document.querySelector("select[name=color_style_lex]");
   let StyleName = document.querySelector('input[name=color_style_lex_color]');
   let StylePath = document.querySelector('input[name=color_style_lex_path]');
   let colorShow = document.querySelector('.color-show-kliros-style');

   StyleCurrent.addEventListener('change', function() {
      // console.log(StyleCurrent.value);

      let CurrentCouple = ColorStyleLex.filter((item) => {
         return item.name == StyleCurrent.value;
      });
      // console.log(CurrentCouple);

      StyleName.value = CurrentCouple[0].name;
      StylePath.value = CurrentCouple[0].path;
      colorShow.style.backgroundColor = CurrentCouple[0].name;
   });
</script>