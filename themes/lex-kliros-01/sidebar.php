<?php

$list_sidebar_categories = lex_grand_sidebar(['lex_kliros_noty', 'kliros_collections']);
?>

<aside class="sidebar">
	<?php if (isset($list_sidebar_categories)) : ?>
		<div class="side-item">
			<?php /*if( ! is_front_page() && ! is_search() ){
							get_search_form(); }*/ ?>
			<?php foreach ($list_sidebar_categories as $value) :
				if ($value['order'] < 50) : ?>
					<h3><a href="<?= get_term_link($value['id']); ?>"><?= $value['name']; ?></a></h3>
			<?php endif;
			endforeach; ?>
		</div>
		<div class="side-item">
			<?php foreach ($list_sidebar_categories as $value) :
				if ($value['order'] > 50) : ?>
					<h3><a href="<?= get_term_link($value['id']); ?>"><?= $value['name']; ?></a></h3>
			<?php endif;
			endforeach; ?>
		</div>
	<?php else : ?>
		<p>Не заполнены категории Богослужения</p>
	<?php endif; ?>
</aside>
</div>
</div>
</section>