<?
	$image = array();
	if(count($OE_IMAGES['IMAGES'])){
		$image = $OE_IMAGES['IMAGES'][key($OE_IMAGES['IMAGES'])];
	}else if(count($M_IMAGES['IMAGES'])){
		$image = $M_IMAGES['IMAGES'][key($M_IMAGES['IMAGES'])];
	}else{
		//$image = $variables;
	}
?>
<div class="product_frame">
	<div class="image_frame">
		<?if($image['F_directory']){?>
			<img src="<?=custom_get_file_url($image['F_directory'], $image['F_file'], 'prew_avg')?>" alt="<?=$image['F_name']?>">
		<?}?>
	</div>
	<a href="/product/<?=$OE_id?>" class="link"><?=$TE_name?> <?=$B_name?> <?=$M_name?></a>
	<div class="discript">
		<div class="line">
			<span class="name"><?=t('Cat name')?></span>: <span class="val"><?=$OE_id?></span>
		</div>
		<div class="line">
			<span class="name"><?=t('Mark name')?></span>: <span class="val"><?=$M_name?></span>
		</div>
		<div class="line">
			<span class="name"><?=t('Brand name')?></span>: <span class="val"><?=$B_name?></span>
		</div>
	</div>
	<div class="price">
		<?=commerce_currency_format($PRICE['RUR']*100, 'RUB');?>
	</div>
	<a href="#" data-id="<?=$OE_id?>" class="add_to_cat"><span><?=t('Add to cart')?></span></a>
</div>

