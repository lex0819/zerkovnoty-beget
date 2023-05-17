<!Doctype html>
<html <?php language_attributes(); ?>>

<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-52MG3RR');</script>
<!-- End Google Tag Manager -->
   <meta charset="<?php bloginfo('charset'); ?>">
   <meta name="description" content="<?= lex_kliros_meta_tags(); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <?php wp_head(); ?>
</head>

<body class="lex-body">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-52MG3RR"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
   <header id="masthead" class="site-header">
      <div class="page-header">
         <div class="wrap">
            <div class="header-logo">
               <a href="<?php echo home_url('/'); ?>">
                  <picture>
                     <source type="image/webp" srcset="<?= KLIROS_DIR_IMG . 'vnushi1094.webp' ?>">
                     <img src="<?= KLIROS_DIR_IMG . 'vnushi1094.png' ?>" alt="Logo" width="875" height="235">
                  </picture>
                  <h1><?php bloginfo('name'); ?></h1>
               </a>
            </div>
         </div>
      </div>
   </header>
   <?php
   $count_query = new WP_Query(array(
      'post_type' => array('lex_kliros_noty', 'kliros_collections')
   ));
   // echo '<pre>';
   // var_dump($count_query->found_posts);
   // echo '</pre>';
   ?>
   <nav class="nav-menu">
      <div class="wrap">
         <div class="nav-menu__flex">
            <?php wp_nav_menu([
               'theme_location' => 'header-menu',
               'menu_id' => 'Header Menu',
               'container' => false,
               'container_class' => '',
               'menu_class' => '',
               'echo' => true,
               'fallback_cb' => 'wp_page_menu',
               'items_wrap' => '<ul class="%2$s">%3$s</ul>',
               'depth' => 0,
            ]); ?>
            <div class="nav-menu__counter">на сайте: <?php echo $count_query->found_posts ?></div>
         </div>
      </div>
   </nav>