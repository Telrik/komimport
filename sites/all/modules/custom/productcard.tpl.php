<?
kpr($good);
?>
<div class="item_top">
	<div class="item_photo_text">
		<div class="images">
			<div class="screen">
				<? $image = $good['OE_IMAGES']['IMAGES'][key($good['OE_IMAGES']['IMAGES'])];?>
				<img src="<?=custom_get_file_url($image['F_directory'], $image['F_file'])?>" alt="<?=$image['F_caption']?>">
				
			</div>
			<div class="trumbnails">
				<div class="trumb_frame">
					<?php foreach($good['OE_IMAGES']['IMAGES'] as $image){?>
						<a class="fancybox" rel="group" href="<?=custom_get_file_url($image['F_directory'], $image['F_file'])?>"><img src="<?=custom_get_file_url($image['F_directory'], $image['F_file'])?>" alt="<?=$image['F_caption']?>"></a>
					<?}?>
				</div>
				<div class="arr_left"></div>
				<div class="arr_right"></div>
			</div>
		</div>
		<div class="item_descr">
			<?if($good['OE_caption']){?>
			<div class="item_info"><?=$good['OE_caption']?></div>
			<?}?>
			<div class="item_props">
					<div class="line">
						<div class="name">Артикул:</div>
						<div class="value"><?=$good['OE_id']?></div>
					</div>
					<div class="line">
						<div class="name">Каталожный номер:</div>
						<div class="value"><?=$good['OE_model']?></div>
					</div>
					<div class="line">
						<div class="name">Производитель:</div>
						<div class="value"><?=$good['B_name']?></div>
					</div>
					<div class="line">
						<div class="name">Местонахождение:</div>
						<?
						$place = array();
						if($good['CITY_name']) $place[] = $good['CITY_name'];
						if($good['REGION_name'] && $good['REGION_id'] != 1) $place[] = $good['REGION_name'];
						if($good['CONT_name']) $place[] = $good['CONT_name'];
						
						?>
						<div class="value"><?=implode(', ', $place)?></div>
					</div>
					<div class="line">
						<div class="name">Год выпуска:</div>
						<div class="value"><?=$good['OE_release_date']?></div>
					</div>
					<a href="#tabs-1" class="all_char">Все характеристики</a>
			</div>
			<div class="item_user_models">
				<a href="#tabs-2" class="mods">Модели техники с этой запчастью</a>
				<div class="descr">укажите модели</div>
				<select name="" id="user_models" multiple="multiple">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</div>
		</div>
	</div>
	
	<div class="item_actions">
		<div class="top_act">
			<?if($good['PRICE']['RUR']){?>
				<div class="bay_tools">
					<div class="buy">
						
							<div class="prices">
								<!--<div class="old"><?=$good['PRICE']['RUR']?></div>-->
								<div class="new"><?=commerce_currency_format($good['PRICE']['RUR']*100, 'RUB');?></div>
							</div>
							
						
					</div>
					<div class="count">
						<label for="count">Кол-во</label>
						<div class="spin">
							<input type="text" id="count" value="1">
						</div>
					</div>
					<a href="#" data-id="<?=$good['OE_id']?>" class="buy_button"><span>Купить</span></a>
				</div>
			<?}?>
			<div class="info_tools">
				<?if($good['PRICE']['RUR']){?>
					<div class="nalicahe est">Есть в наличии</div>
				<?}else{?>
					<div class="nalicahe net"><a href='#' class='know_price'>Узнать цену</a></div>	
				<?}?>
				<div class="delevary_frame">
					<a href="#tabs-4" class="delevary">Доставка</a>
				</div>
				<? $rews = custom_rev_stat($good['OE_id']); ?>
				<div class="review">
					<?if($rews['count']){?>
						<a href="#tabs-3" class="rev_count">Отзывов <?=$rews['count']?></a>
						<div class="reit">
							<?for($i = 1; $i <= 5; ++$i){?>
								
								<span class="r<?=$i?> star <?=$i<=$rews['rate']?'act':'';?>"><?=$i?></span>
							<?}?>
						</div>
					<?}else{?>
						<a href="#tabs-3" class="rev_count">Отзывов нет</a>
					<?}?>
				</div>
			</div>
		</div>
		<div class="bot_act">
			<?php
			$block = block_load('block', '9');
			$render_array = _block_get_renderable_array(_block_render_blocks(array($block)));
			$output = render($render_array);
			print $output;
			?>
		</div>
	</div>
</div>
<div class="item_bot">
	<div id="tabs">
	  <ul>
		<li><a href="#tabs-1">Характеристики</a></li>
		<li><a href="#tabs-2">Модели техники</a></li>
		<li><a href="#tabs-3">Отзывы</a></li>
		<li><a href="#tabs-4">Доставка и оплата</a></li>
	  </ul>
	  <div id="tabs-1">
		<h2>Технические характеристики</h2>
		<table>
			<tr>
				<th>Наименование</th>
				<th>Значение</th>
			</tr>
			<?foreach($good['CHARACTER'] as $char){?>
			<tr>
				<td><?=$char['name']?></td>
				<td><?=$char['value']?></td>
			</tr>
			<?}?>
		</table>
		<a href="#" class="call_dock"><span>Заказать документацию</span></a>
	  </div>
	  <div id="tabs-2">
		модели техники
	  </div>
	  <div id="tabs-3">
		<h2>Отзывы</h2>
		<a href="#" class="write_review"><span>Написать отзыв</span></a>
		<div id="review_form">
			<?=custom_rev_node($good['OE_id']);?>
		</div>
		<?=views_embed_view('reviews', 'block_2', $good['OE_id']);?>
	  </div>
	  <div id="tabs-4">
		Доставка и оплата
	  </div>
	</div>
</div>
