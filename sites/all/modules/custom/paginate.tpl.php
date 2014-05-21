
<div class="paginate">
	<div class="sort_by">
		Сортировать по <a href="<?=$sort['price']['desc']['link']?>"><?=$sort['price']['desc']['name']?></a> | <a href="<?=$sort['price']['ask']['link']?>"><?=$sort['price']['ask']['name']?></a> цены
	</div>
	<div class="per_page">
		Показывать по <select name="" id="" class='dynamic_select'><?
			foreach($per_page as $pp){
				?><option <?if($pp['link']){?> value="<?=$pp['link']?>"
					<?}else{?>
						selected='selected'
					<?}?>><?=$pp['name']?></option><?
			}
		?></select> товаров
	</div>
	<div class="paginate_nums">
		<?foreach($pages as $p){
			if($p['link']){?>
				<a href="<?=$p['link']?>" class='<?=$p['class']?>'><?=$p['name']?></a>
			<?}else{?>
				<span><?=$p['name']?></span>
			<?}?>
		<?}?>
	</div>
</div>