<style type="text/css">
#price_container {
	position:absolute;
	top:10px;
	right:10px;
	display:none;
}
#header_price {
	padding:10px;
}
#price_color_size_matrix_container {
	max-height:200px;
	overflow:auto;
}
.sep {
	border-width:0 0 2px 0;
}
#price_detail li {
	text-align:right;
}
</style>
<div class="ui-widget">
	<?php if($hide_matrix===false) : ?> 
	<div style="float:right; cursor:pointer; margin:2px 2px 0 0;" onclick="togglePrice()" >
		<span class="ui-state-default ui-corner-all" onmouseover="$(this).addClass('ui-state-hover')" onmouseout="$(this).removeClass('ui-state-hover')" style="position:relative; display:inline-block; padding:2px;">
			<span class="ui-icon ui-icon-triangle-2-n-s"></span>
		</span>
	</div>
	<?php endif; ?> 

	<div align="right">
		<?php if(empty($error_warning) && $total_price!==false) { ///could be zero ?>
			<div id="header_price" style="padding: 5px 30px 5px 5px;" class="ui-widget-header ui-corner-all">
				<span style="float:left; margin-right:30px;">
					<a style="cursor:pointer; display:inline-block; padding:5px;" class="ui-widget-content ui-corner-all ui-state-default" onmouseover="$(this).addClass('ui-state-hover')" onmouseout="$(this).removeClass('ui-state-hover')"  onclick="prompSave()" >
						<span style="float:left; margin-right: 0.3em;" class="ui-icon ui-icon-cart"></span>
						<span style="font-size:12px;"><?php echo $button_cart; ?></span>
					</a>
				</span>
				<span style="font-size:1.4em;line-height:25px;">
					<span><?php echo $text_total_price; ?></span>
					<span><?php echo $total_price; ?></span>
				</span>
			</div>
		<?php } ?>
		<?php if($error_warning) { ?>
			<div id="header_error" style="padding: 5px 30px 5px 5px;" class="ui-state-error ui-corner-all"  >
				<p align="left">
					<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
					<span style="text-align:left; max-width:400px; display:block;"><?php echo $error_warning; ?></span>
				</p>
			</div>
		<?php } ?>
	</div>
	<!--  collapsible  -->
	<div id="div_collapsible" class="ui-widget-content ui-corner-bl ui-corner-br" align="left" <?php if($hide_matrix===true || !$price_module_collapsed) : ?> style="padding:25px 10px 10px 10px; display:none" <?php else: ?> style="padding:25px 10px 10px 10px;" <?php endif; ?> >
		<form id="prices_form" method="post" action="index.php?route=studio/price"  >	
			<input type="hidden" value="<?php echo $price_id_composition; ?>" name="price_id_composition" id="price_id_composition" />
			<input type="hidden" value="<?php echo $price_id_product; ?>" name="price_id_product" id="price_id_product" />
			<input type="hidden" value="<?php echo $price_module_collapsed; ?>" name="price_module_collapsed" id="price_module_collapsed" />
			<div id="views_colors_container">
			<?php foreach($views_num_colors as $key=>$view) : ?>
				<input type="hidden" name="views_num_colors[<?php echo $key; ?>][num_colors]" value="<?php echo $view['num_colors']; ?>" />
				<input type="hidden" name="views_num_colors[<?php echo $key; ?>][name]" value="<?php echo $view['name']; ?>" />
				<input type="hidden" name="views_num_colors[<?php echo $key; ?>][need_white_base]" value="<?php echo $view['need_white_base']; ?>" />
			<?php endforeach; ?>
			</div>
			<div id="price_color_size_matrix_container">
				<table cellpadding="5" cellspacing="0" class="ui-widget-content ui-corner-all" style="margin:1px; ">
					<tr style="font-weight:bold">
						<td colspan="2"></td>
						<?php foreach($product_sizes_header as $size_header) : ?>
						<td align="center" valign="top"><?php echo $size_header['name']; ?>
							<?php if($size_header['upcharge']) : ?>
							<br /><span style="font-size:10px;"><?php echo $size_header['upcharge']; ?></span></td>
							<?php endif; ?>
						<?php endforeach; ?>
					</tr>
					<?php foreach($product_colors as $id_product_color) : ?>
					<tr>
						<td style="margin: 0px 5px 0px 5px; font-size:12px" align="left" valign="top" nowrap="nowrap"><?php echo $all_colors[$id_product_color]['name']; ?></td>
						<td width="60" height="20"  align="center" valign="top">
							<table width="100%" height="100%" onclick="studioChangeProductColor('<?php echo $id_product_color; ?>')" cellpadding="0" cellspacing="0" class="ui-widget-content">
								<tr style="cursor:pointer; ">
								<?php foreach($all_colors[$id_product_color]['hexa'] as $hexa) : ?>
									<td style="background-color:#<?php echo $hexa; ?>;">&nbsp;</td>
								<?php endforeach; ?>
								</tr>
							</table>
						</td>
						<?php foreach($product_sizes as $id_product_size) : ?>
						<td align="center" valign="top">
						<?php if($matrix_color_size_quantity[$id_product_color][$id_product_size]!==false) : ?>
							<input class="ui-widget-content ui-corner-all" size="4" type="text" title="<?php echo $all_sizes[$id_product_size]['initials'] ?>" data="quantity" name="quantity_s_c[<?php echo $id_product_color; ?>][<?php echo $id_product_size; ?>]" value="<?php echo $matrix_color_size_quantity[$id_product_color][$id_product_size]; ?>"  />
							<?php if(!empty($matrix_color_size_price[$id_product_color][$id_product_size])) : ?> 
							<div style="font-size:8px;" align="center"><?php echo $matrix_color_size_price[$id_product_color][$id_product_size]; ?></div>
							<?php endif; ?>
						<?php else : ?>
							<input class="ui-widget-content ui-corner-all ui-state-disabled" size="4" type="text" disabled="disabled" />
						<?php endif; ?>
						</td>
						<?php endforeach; ?>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<div align="right">
				<button style="margin-top:5px;" id="btn_recalculate_pricing" class="is_ml" ml_label="button_recalculate"><?php echo $button_recalculate; ?></button>
			</div>
		</form>
		
		<?php if(empty($error_warning)) : ?>
		<div id="price_detail"> 
			
			<!-- PRODUCT PRICE-->
			<div class="ui-widget-content sep"><?php echo $text_product_price; ?></div>
			<ul style="list-style:none">
				<li><span><?php echo $text_upcharge_larger_size; ?></span> <span><?php echo $product_upcharge_total; ?></span></li>
				<li class="ui-widget-header ui-corner-all "><span><?php echo $text_product_total; ?></span> <span><?php echo $product_total; ?></span></li>
			</ul>
			
			<!-- PRINTING PRICE-->
			<div class="ui-widget-content sep"><span><?php echo $text_printing_price; ?></span></div>
			<ul style="list-style:none">
				<li class="ui-widget-header ui-corner-all"><span><?php echo $text_printing_total; ?></span> <span><?php echo $printing_total; ?></span></li>
			</ul>
			
			<!-- PRODUCT PRICE + PRINTING PRICE = TOTAL PRICE-->
			<div class="ui-widget-content sep"><?php echo $text_total_price; ?></div>
			<ul style="list-style:none; padding:10px;">
				<li><span><?php echo $text_number_products; ?></span> <span><?php echo $amount_products; ?></span></li>
				<li><span><?php echo $text_price_per_product; ?></span> <span><?php echo $unit_price; ?></span></li>
				<li class="ui-state-highlight ui-widget-header ui-corner-all "><span><?php echo $text_total_price; ?></span> <span><?php echo $total_price; ?></span></li>
			</ul>
		</div>
		<?php endif; ?>
	</div>
</div>
<div id="promp_save" style="display:none;">
<?php echo $text_save; ?><br />
<div align="center" style="padding:10px; margin:10px;"><a onclick="$( '#promp_save' ).dialog('close'); saveDesign(true);" class="button"><?php echo $button_save; ?></a> &nbsp; &nbsp; <a onclick="$( '#promp_save' ).dialog('close'); addToCart();" class="button"><?php echo $button_no_save; ?></a></div>
</div>

<script type="text/javascript">
function showPricePopUP() {
	$( "#price_container" ).show();
}

function onProductChanged(id_product)
{
	showPricePopUP();
	
	$( "#price_id_product" ).val(id_product);
	
	$( "#prices_form" ).submit();
}
function updatePrice(arr)
{
	$("#views_colors_container").html("");
	
	$(arr).each(function(index) {
		$("#views_colors_container").append('<input type="hidden" name="views_num_colors['+index+'][num_colors]" value="'+this.num_colors+'" />');
		$("#views_colors_container").append('<input type="hidden" name="views_num_colors['+index+'][name]" value="'+this.name+'" />');
		$("#views_colors_container").append('<input type="hidden" name="views_num_colors['+index+'][need_white_base]" value="'+this.need_white_base+'" />');
	});
	
	$( "#prices_form" ).submit();
}
function prompSave() {
	//$( "#promp_save" ).dialog("open");
	saveDesign(true);
}
function addToCart()
{	
	success = function(data) {
		if(data.redirect) {
			location.href = data.redirect;
			return;
		}
		$("#popup_container").html(data.output);
		$( "#popup_dialog" ).dialog( "option", "position", 'center' );
	}
	loadPopUp('index.php?route=studio/price/update', $('#prices_form').serialize(), "POST",  success, "json");
}
function togglePrice()
{
	$('#div_collapsible').toggle(); 
	if( $('#div_collapsible').is(':visible') ) {
		$('#price_module_collapsed').val('1'); 
		$('#header_price').removeClass('ui-corner-all').addClass('ui-corner-tl').addClass('ui-corner-tl');
		$('#header_error').removeClass('ui-corner-all').addClass('ui-corner-tl').addClass('ui-corner-tl');
	} else {
		$('#price_module_collapsed').val('0'); 
		$('#header_price').removeClass('ui-corner-tl').removeClass('ui-corner-tl').addClass('ui-corner-all');
		$('#header_error').removeClass('ui-corner-tl').removeClass('ui-corner-tl').addClass('ui-corner-all');
	}
}
$(function() {
	
	$( "#btn_recalculate_pricing" ).button({icons: {primary: "ui-icon-refresh"}});
	$( ".button" ).button();
	
	$( "#prices_form" ).submit(function() {
		//event.preventDefault(); 
		$("#btn_recalculate_pricing").button( "option", "disabled", true );
		loadAjaxHtml('index.php?route=studio/price', "#price_container", $("#prices_form").serialize(), "POST");
		return false;
	});
	
	$(document).bind("onTemplateChange", function(event, id) {
		$( "#price_id_composition" ).val(id);
	});
	
	$( "#promp_save" ).dialog({
		autoOpen: false,
		height: "auto",
		width: "auto",
		minHeight: 50,
		minWidth: 200,
		modal: true
	});
	
});
</script> 
