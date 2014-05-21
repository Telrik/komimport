<div class="subterms">
	<?
	$i = 0;
	while($i < count($childs)){
		$in_line = 0;
		// <div class="line">
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