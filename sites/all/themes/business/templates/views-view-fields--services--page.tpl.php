<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
 foreach ($fields as $id => $field){
	$arr[] = $id;
 }
 //kpr($arr);
 
 $arr = array('field_image', 'field_action_button');
 //$arr_left = array('field_autor', 'created');
?>
<div class="r_frame">
	<div class="image_f">
		<?php $field = $fields['field_image']; ?>
		<?php print $field->content; ?>
	</div>
	<div class="el_fields">
		<?php foreach ($fields as $id => $field): ?>
			<? if(!in_array($id, $arr)){?>
				<?php if (!empty($field->separator)): ?>
					<?php print $field->separator; ?>
				<?php endif; ?>

				<?php print $field->wrapper_prefix; ?>
				<?php print $field->label_html; ?>
				<?php print $field->content; ?>
				<?if($id == 'body'){?>
					<a href="<?=drupal_get_path_alias('node/'.$row->nid);?>" class="more">Подробнее>></a>
				<?}?>
				<?php print $field->wrapper_suffix; ?>
			<?}?>
		<?php endforeach; ?>
		
	</div>
	<div class="action_ser">
		
		<a href="#" class="<?=$row->field_field_action_button[0]['raw']['value']?>_serv"><span><?=$row->field_field_action_button[0]['rendered']['#markup']?></span></a>
	</div>
</div>