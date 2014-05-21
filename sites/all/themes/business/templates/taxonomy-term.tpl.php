<?php

/**
 * @file
 * Default theme implementation to display a term.
 *
 * Available variables:
 * - $name: (deprecated) The unsanitized name of the term. Use $term_name
 *   instead.
 * - $content: An array of items for the content of the term (fields and
 *   description). Use render($content) to print them all, or print a subset
 *   such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $term_url: Direct URL of the current term.
 * - $term_name: Name of the current term.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - taxonomy-term: The current template type, i.e., "theming hook".
 *   - vocabulary-[vocabulary-name]: The vocabulary to which the term belongs to.
 *     For example, if the term is a "Tag" it would result in "vocabulary-tag".
 *
 * Other variables:
 * - $term: Full term object. Contains data that may not be safe.
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $page: Flag for the full page state.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the term. Increments each time it's output.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_taxonomy_term()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>
<div id="taxonomy-term-<?php print $term->tid; ?>" class="<?php print $classes; ?>">
  <?php if (!$page): ?>
    <h2><a href="<?php print $term_url; ?>"><?php print $term_name; ?></a></h2>
  <?php endif; ?>

  <div class="content">
	<?
	kpr($term);
	if($term->vid == 1){
		
		$childs = taxonomy_get_tree($vid, $term->tid, null, true);?>
		<div class="subterms">
			<?
			$i = 0;
			while($i < count($childs)){
				$in_line = 0;
				//<div class="line">
				?>
				
					<?while($i < count($childs) && $in_line < 4){
						$t = $childs[$i];?>
						<div class="item">
							<div class="img_frame">
								<?if($t->field_ext_image['und'][0]){?>
									<a href="/<?=drupal_get_path_alias('taxonomy/term/'.$t->tid)?>">
										<img src="<?=custom_get_file_url($t->field_ext_image['und'][0]['url'])?>" 
											alt="<?=custom_get_file_url($t->field_ext_image['und'][0]['title'])?>">
									</a>
								<?}?>
							</div>
							<a class='link_dop' href="/<?=drupal_get_path_alias('taxonomy/term/'.$t->tid)?>"><?=$t->name?></a>
						</div>
					<?++$i;++$in_line;}?>
				
			<?
				//</div>
			}?>
		</div>
	<?}?>
	<?if($term->vid == 1 || $term->vid == 3){?>
		<?
		
			$param = array();
			if($term->vid == 1){
				if($term->field_xid['und'][0]['value']){
					if($term->field_xid['und'][0]['value'] < 100000){
						$param['group'] = $term->field_xid['und'][0]['value'];
					}else{
						$param['type_e'] = $term->field_xid['und'][0]['value']-100000;
					}
				}
			}else if($term->vid == 3){
				if($term->field_xid['und'][0]['value']){
					$param['mark'] = $term->field_xid['und'][0]['value'];
				}
			}
			$rez = custom_get_reguest_GET_filter('getoffersequipment', $param);
			if($term->vid == 1 && $param['type_e']){
				$filter = custom_pagin_filter_GET();
				print $filter;
			}
			$pagin = custom_pagin_sort_GET($rez);
			$block = block_load('block', '8');
			$render_array = _block_get_renderable_array(_block_render_blocks(array($block)));
			$output = render($render_array);
			print $output;
			print($pagin);
			if(count($rez['CONTENT'])){
				?>
				<div class="pruduct_list">
					<?
					foreach($rez['CONTENT'] as $item){
						echo theme('custom_productinlist_template', $item);
					}
					?>
				</div>
				<?
			}
			print($pagin);
			print $output;
		
		if($term->description){
		?>
		<div class="term_deskription">
			<?=$term->description?>
		</div>
		<?}?>
	<?}else{?>
		<?php print render($content); ?>
	<?}?>
  </div>
</div>
