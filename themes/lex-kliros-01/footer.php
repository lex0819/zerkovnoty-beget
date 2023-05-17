<nav class="nav-menu">
   <div class="wrap">
      <?php wp_nav_menu([
         'theme_location' => 'footer-menu',
         'menu_id'        => 'Footer Menu',
         'container'       => false,
         'container_class' => '',
         'menu_class'      => '',
         'echo'            => true,
         'fallback_cb'     => 'wp_page_menu',
         'items_wrap'      => '<ul class="main-navigation">%3$s</ul>',
         'depth'           => 0,
      ]); ?>
   </div>
</nav>
<footer id="colophon" class="page-footer">
   <div class="wrap">
      <div class="footer-flex">
         <p class="footer-copiright">Сайт <strong><? bloginfo('name'); ?></strong></p>
         <p class="footer-copiright">Помощь сайту, нормер карты Сбер <strong>4274320073536339</strong></p>
      </div>
   </div>
</footer>
<?php wp_footer(); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/analyticstracking.php'); //google
?>
<!-- BEGIN Yandex.Metrika counter -->
<script type="text/javascript">
   (function(m, e, t, r, i, k, a) {
      m[i] = m[i] || function() {
         (m[i].a = m[i].a || []).push(arguments)
      };
      m[i].l = 1 * new Date();
      k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
   })
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(62018935, "init", {
      clickmap: true,
      trackLinks: true,
      accurateTrackBounce: true,
      webvisor: true
   });
</script>
<noscript>
   <div><img src="https://mc.yandex.ru/watch/62018935" style="position:absolute; left:-9999px;" alt="" /></div>
</noscript>
<!-- END /Yandex.Metrika counter -->
</body>

</html>