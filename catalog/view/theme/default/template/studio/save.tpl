<div style="padding:10px; text-align:left">
	<div id="div_save_design_form" style="display:none;">
		<span><?php echo $entry_design_name; ?></span>
		<input type="text" id="design_name" value="<?php echo $design_name; ?>" style="width:200px;">
		<div align="center" style="margin-top:10px">
			<input id="btn_save_design" type="button" value="<?php echo $text_save_design; ?>" >
		</div>
	</div>
	<div id="div_saving_design" style="display:none;">
		<div ><?php echo $text_saving_design; ?></div>
		<img src="<?php echo $loading_image; ?>" border="0" />
	</div>
	<div id="div_saving_successfully" style="display:none;">
		<div><?php echo $text_saved_successfully; ?></div>
	</div>
	<div id="div_saving_error" style="display:none;">
		<div><?php echo $text_saved_error; ?></div>
		<div id="save_error_info"></div>
	</div>
</div>
<script type="text/javascript" language="javascript">
$(function() {
	
	$( "#btn_save_design" ).button().click(function() {
		saveDesignButtonClick();
	});
	
	$(document).trigger('onLoginStateChange');
	<?php if($add_after_save) { ?>//remove saveDesignButtonClick() call if you want to be promped to name design
		saveDesignButtonClick();
	<?php } else { ?>
		$("#div_save_design_form").show();
	<?php } ?>
});
function saveDesignButtonClick() {
	$("#div_saving_design").show();
	$("#div_save_design_form").hide();
	studioSetCompositionName($("#design_name").val());
	studioSaveComposition();
}

function saveDesignCompletedSuccessfully(id_composition) {
	$("#div_saving_design").hide();
	$("#div_saving_successfully").show();
	
	$(document).trigger('onTemplateChange', [id_composition]);
	
	<?php if($add_after_save) { ?>
		addToCart();
	<?php } ?>
}
function saveDesignError(errorStr) {
	$("#div_saving_design").hide();
	$("#div_saving_error").show();
	$("#save_error_info").html("ERROR: "+errorStr);
	
}


</script>
