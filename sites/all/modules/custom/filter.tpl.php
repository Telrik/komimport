<script type="text/javascript">
	var url_base = "<?=$base?>";
	var url_arr_query = <?=json_encode($arr_query)?>;
</script>
<div class="filter">
	<div class="left_f_col">
		<div class="hd">Подбор товарa по параметрам</div>
		<div class="in_col">
			<?
				$marks = $_GET['mark'];
				if($marks && !is_array($marks)){
					$marks = array($marks);
				}
				
				$rezet_style = 'style="display:none"';
				if(count($marks)){
					$rezet_style = '';
				}
			?>
			<div class="manufac">Производитель <a href="/<?=request_path()?>" <?=$rezet_style?> class='reset_filter'>Сбросить</a></div>
			
			<select multiple="multiple" id='brands_filter'>
				<?
				foreach($manufacturer as $term){
				$class = '';
				if(is_array($marks) && in_array($term->field_xid['und'][0]['value'], $marks)){
					$class='selected="selected"';
				}				
				?>
				<option <?=$class?> value='<?=$term->field_xid['und'][0]['value']?>'><?=$term->name?></option>
				<?}?>
			</select>
		</div>
	</div>
	<div class="right_f_col">
		<a href="/<?=request_path()?>" class='clear_filter'>Очистить фильтр</a>
		<div class="init_filter_frame"><a href="#" class='init_filter'><span>Подобрать</span></a></div>
	</div>
	<div class="cb"></div>
</div>