<li id="region_<?php echo $view_index; ?>_<?php echo $region_index; ?>">
<input type="hidden" style="width:50px;" name="views[<?php echo $view_index; ?>][regions][<?php echo $region_index; ?>][region_index]" value="<?php echo $region_index; ?>" />
<input type="hidden" style="width:50px;" name="views[<?php echo $view_index; ?>][regions][<?php echo $region_index; ?>][x]" value="<?php echo $x; ?>" />
<input type="hidden" style="width:50px;" name="views[<?php echo $view_index; ?>][regions][<?php echo $region_index; ?>][y]" value="<?php echo $y; ?>" />
<table cellpadding="3" cellspacing="0" border="0">
	<tr>
		<td nowrap="nowrap">
		<?php echo $entry_name; ?><input type="text" name="views[<?php echo $view_index; ?>][regions][<?php echo $region_index; ?>][name]" value="<?php echo $name; ?>" onchange="updateRegion(<?php echo $view_index; ?>,<?php echo $region_index; ?>)" />
		<span onclick="removeRegion(<?php echo $view_index; ?>, <?php echo $region_index; ?>)"><img src="view/image/delete.png" /><a style="vertical-align:top;"><?php echo $button_remove; ?></a></span>
		</td>
	</tr>
	<tr>
		<td nowrap="nowrap">
		<?php echo $entry_width; ?><input style="width:50px;" type="text" name="views[<?php echo $view_index; ?>][regions][<?php echo $region_index; ?>][width]" value="<?php echo $width; ?>" onchange="updateRegion(<?php echo $view_index; ?>,<?php echo $region_index; ?>)" />
		<?php echo $entry_height; ?><input style="width:50px;" type="text" name="views[<?php echo $view_index; ?>][regions][<?php echo $region_index; ?>][height]" value="<?php echo $height; ?>" onchange="updateRegion(<?php echo $view_index; ?>,<?php echo $region_index; ?>)" />
		</td>
	</tr>
	<tr>
		<td nowrap="nowrap">
			<?php echo $text_x; ?><span id="span_x_<?php echo $view_index; ?>_<?php echo $region_index; ?>"><?php echo $x; ?></span>
			<?php echo $text_y; ?><span id="span_y_<?php echo $view_index; ?>_<?php echo $region_index; ?>"><?php echo $y; ?></span>
		</td>
	</tr>
	<tr>
		<td nowrap="nowrap">
			<?php echo $text_default; ?><input type="radio" name="default_region" value="<?php echo $view_index; ?>_<?php echo $region_index; ?>" <?php if($default_region == $view_index.'_'.$region_index) { ?> checked="checked" <?php } ?> />
		</td>
	</tr>
</table>
<hr />
</li>
<script type="text/javascript">
$(document).ready(function() {
	if(swfobject.getObjectById("view_drawer_<?php echo $view_index; ?>")) {
		swfobject.getObjectById("view_drawer_<?php echo $view_index; ?>").addRegion(<?php echo $region_index; ?>,'<?php echo $name; ?>',<?php echo $width; ?>,<?php echo $height; ?>,<?php echo $x; ?>,<?php echo $y; ?>);
	} else {
		$(document).bind('creation_complete_<?php echo $view_index; ?>', function() {
			swfobject.getObjectById("view_drawer_<?php echo $view_index; ?>").addRegion(<?php echo $region_index; ?>,'<?php echo $name; ?>',<?php echo $width; ?>,<?php echo $height; ?>,<?php echo $x; ?>,<?php echo $y; ?>);
		});
	}
});
</script>