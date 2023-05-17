<div class="search-title">
	<h2>Поиск партитур на сайте</h2>
	<p class="check-field">Заполните хотя бы одно поле! - Название, композитор либо распев.</p>
</div>
<form class="big-search-form" id="big-search-form" role="search" method="get" action="<?= home_url(); ?>">
	<label class="search-row" for="s">
		<span>Название</span>
		<input class="lex-search-form" type="text" name="s" id="s" value="">
	</label>
	<label class="search-row" for="composer">
		<span>Композитор</span>
		<input id="composer" type="text" class="lex-search-form" placeholder="Чесноков" value="" pattern="^[А-Яа-яёь -.]{4,33}">
      <input id="lex_kliros_composer" type="hidden" name="lex_kliros_composer">
	</label>
	<label class="search-row" for="chant">
		<span>Распев</span>
		<input id="chant" type="text" class="lex-search-form" placeholder="Киевский" value="" pattern="^[А-Яа-яёь -.№1-8]{4,50}">
      <input type="hidden" name="lex_kliros_chant" id="lex_kliros_chant">
	</label>
	<label class="search-row" for="lex_kliros_tonality">
		<span>Тональность</span>
		<?php wp_dropdown_categories([
			'show_option_all'    => '',
			'show_option_none'   => ' ',
			'option_none_value'  => 0,
			'orderby'            => 'name',
			'order'              => 'ASC',
			'show_last_update'   => 1,
			'show_count'         => 0,
			'hide_empty'         => 1,
			'child_of'           => 0,
			'exclude'            => '',
			'echo'               => 1,
			'selected'           => 'ми бемоль минор',
			'hierarchical'       => 0,
			'name'               => 'lex_kliros_tonality',
			'id'                 => 'lex_kliros_tonality',
			'class'              => 'lex-search-form',
			'depth'              => 0,
			'tab_index'          => 0,
			'taxonomy'           => 'lex_kliros_tonality',
			'hide_if_empty'      => false,
			'value_field'        => 'slug', // значение value option
			'required'           => false,
		]); ?>
	</label>
	<label class="search-row" for="lex_kliros_onlyopus">
		<span>Опус</span>
		<input class="lex-search-form" type="text" name="lex_kliros_onlyopus" id="lex_kliros_onlyopus" placeholder="40" value="" pattern="\w{1,4}">
   </label>
   <label class="search-row" for="lex_kliros_number">   
      <span>Номер</span>
		<input class="lex-search-form" type="text" name="lex_kliros_number" id="lex_kliros_number" placeholder="8" value="" pattern="[0-9]{1,3}">
   </label>
	<div class="search-row">
		<span>Состав хора</span>
      <div>
         <?php wp_dropdown_categories([
            'show_option_all'    => '',
            'show_option_none'   => ' ',
            'option_none_value'  => 0,
            'orderby'            => 'name',
            'order'              => 'ASC',
            'show_last_update'   => 1,
            'show_count'         => 0,
            'hide_empty'         => 1,
            'child_of'           => 0,
            'exclude'            => '',
            'echo'               => 1,
            'selected'           => 'Смешанный Хор',
            'hierarchical'       => 0,
            'name'               => 'lex_kliros_quality',
            'id'                 => 'lex_kliros_quality',
            'class'              => 'lex-search-form',
            'depth'              => 0,
            'tab_index'          => 0,
            'taxonomy'           => 'lex_kliros_quality',
            'hide_if_empty'      => false,
            'value_field'        => 'slug', // значение value option
            'required'           => false,
         ]); ?>
         <?php wp_dropdown_categories([
            'show_option_all'    => '',
            'show_option_none'   => ' ',
            'option_none_value'  => 0,
            'orderby'            => 'name',
            'order'              => 'ASC',
            'show_last_update'   => 1,
            'show_count'         => 0,
            'hide_empty'         => 1,
            'child_of'           => 0,
            'exclude'            => '',
            'echo'               => 1,
            'selected'           => 'квартет',
            'hierarchical'       => 0,
            'name'               => 'lex_kliros_voices',
            'id'                 => 'lex_kliros_voices',
            'class'              => 'lex-search-form',
            'depth'              => 0,
            'tab_index'          => 0,
            'taxonomy'           => 'lex_kliros_voices',
            'hide_if_empty'      => false,
            'value_field'        => 'slug', // значение value option
            'required'           => false,
         ]); ?>
      </div>
	</div>
	<div class="button-search">
		<button id="btn-search" class="btn-search" type="submit" title="Заполните хотя бы одно поле">Найти</button>
	</div>
</form>
<script>
   const litsOfComposer = [
      <?php
         $terms = get_terms( [
            'taxonomy' => 'lex_kliros_composer',
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC',
         ] );
         foreach ($terms as $terms) {
            echo '{ label: "'.$terms->name.'", value: "'.$terms->slug.'" },';
         }
      ?>
   ];

   //[ { label: "Choice1", value: "value1" }, ... ]

   const litsOfChant = [
      <?php
         $terms = get_terms( [
            'taxonomy' => 'lex_kliros_chant',
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC',
         ] );
         foreach ($terms as $terms) {
            echo '{ label: "'.$terms->name.'", value: "'.$terms->slug.'" },';
         }
      ?>
   ];
</script>