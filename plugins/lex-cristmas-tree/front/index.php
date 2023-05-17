<style>
   .banner-lex {
      display: block;
      position: absolute;
      <?php echo $css_pos[0]; ?>: 10px;
      <?php echo $css_pos[1]; ?>: 10px;
      width: <?php echo $width; ?>px;
   }

   @media screen and (max-width: 768px) {
      .banner-lex {
         width: <?php echo $width_mobile ?>px;
      }
   }

   .banner-lex img {
      width: 100%;
   }
</style>
<div class="banner-lex">
   <img src="<?php echo plugins_url() . '/lex-cristmas-tree/' . $path; ?>" alt="banner picture">
</div>