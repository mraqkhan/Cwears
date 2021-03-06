<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
		<div class="pagination"><?php echo $pagination; ?></div>
		<div style="padding:10px 0px; "><?php echo $text_limit; ?><input type="text" name="limit" class="ui-widget-content" value="<?php echo $limit; ?>" /></div>
		<table class="list">
		  <thead>
			<tr>
			  <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
			  <td class="right"><?php if ($sort == 'id_design_color') { ?>
				<a href="<?php echo $sort_id_design_color; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_id_design_color; ?></a>
				<?php } else { ?>
				<a href="<?php echo $sort_id_design_color; ?>"><?php echo $column_id_design_color; ?></a>
				<?php } ?>
				</td>
			  <td width="80%" class="left"><?php if ($sort == 'name') { ?>
				<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
				<?php } else { ?>
				<a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
				<?php } ?>
			  </td>
			  <td class="right"><?php if ($sort == 'code') { ?>
				<a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_code; ?></a>
				<?php } else { ?>
				<a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?></a>
				<?php } ?></td>
			  <td class="right"><?php echo $column_hexa; ?></td>
			  <td class="left"><?php if ($sort == 'need_white_base') { ?>
				<a href="<?php echo $sort_need_white_base; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_need_white_base; ?></a>
				<?php } else { ?>
				<a href="<?php echo $sort_need_white_base; ?>"><?php echo $column_need_white_base; ?></a>
				<?php } ?></td>
			  <td class="left"><?php echo $column_status; ?></td>
			  <td class="right"><?php echo $column_action; ?></td>
			</tr>
		  </thead>
		  <tbody>
			<tr class="filter">
			  <td></td>
			  <td class="right"><input type="text" name="filter_id_design_color" class="ui-widget-content" value="<?php echo $filter_id_design_color; ?>" size="4" /></td>
			  <td></td>
			  <td><input type="text" name="filter_code" value="<?php echo $filter_code; ?>" class="ui-widget-content" size="6" /></td>
			  <td></td>
			  <td></td>
			  <td class="left"><select name="filter_status" class="ui-widget-content" onchange="filter();">
			  <?php foreach ($statuses as $status) { ?>
				  <?php if ($status['val'] === $filter_status) { ?>
				  <option value="<?php echo $status['val']; ?>" selected="selected"><?php echo $status['description']; ?></option>
				  <?php } else { ?>
				  <option value="<?php echo $status['val']; ?>"><?php echo $status['description']; ?></option>
				  <?php } ?>
			  <?php } ?>
			</select></td>
			  <td></td>
			</tr>
			<?php if ($colors) { ?>
				<?php foreach ($colors as $color) { ?>
				<tr>
				  <td style="text-align: center;">
				  <?php if (!$color['isdefault']) { ?>
					<?php if ($color['selected']) { ?>
					<input type="checkbox" name="selected[]" value="<?php echo $color['id_design_color']; ?>" checked="checked" />
					<?php } else { ?>
					<input type="checkbox" name="selected[]" value="<?php echo $color['id_design_color']; ?>" />
					<?php } ?>
				  <?php } ?>
				  </td>
				  <td class="right"><?php echo $color['id_design_color']; ?></td>
				  <td><?php if ($color['isdefault']) { ?><?php echo $text_default; ?> <?php } ?><?php echo $color['name']; ?></td>
				  <td><?php echo $color['code']; ?></td>
				  <td><span title="<?php echo $color['hexa']; ?>" class="ui-widget-content" style="display:block; width:20px; height:20px; background: #<?php echo $color['hexa']; ?>">&nbsp;</span></td>
				  <td class="left"><?php echo $color['need_white_base']; ?></td>
				  <td class="left"><?php echo $color['status']; ?></td>
				  <td class="right"><?php foreach ($color['action'] as $action) { ?>
				[ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
				<?php } ?></td>
				</tr>
				<?php } ?>
			<?php } else { ?>
			<tr>
			  <td align="center" colspan="8"><?php echo $text_no_results; ?></td>
			</tr>
			<?php } ?>
		  </tbody>
		</table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=design_color/design_color/_list&token=<?php echo $token; ?>';
	
	var filter_id_design_color = $('input[name=\'filter_id_design_color\']').attr('value');
	
	if (filter_id_design_color) {
		url += '&filter_id_design_color=' + encodeURIComponent(filter_id_design_color);
	}
	
	var filter_code = $('input[name=\'filter_code\']').val();
	
	if (filter_code != '') {
		url += '&filter_code=' + encodeURIComponent(filter_code);
	}
	
	var filter_status = $('select[name=\'filter_status\']').val();
	
	if (filter_status != '') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}
		
	var limit = $('input[name=\'limit\']').attr('value');
	
	if (limit) {
		url += '&limit=' + encodeURIComponent(limit);
	}
				
	location = url;
}
//--></script>  
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<?php echo $footer; ?>