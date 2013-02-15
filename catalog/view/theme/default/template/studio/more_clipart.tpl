<?php if ($cliparts) { ?>
	<?php foreach ($cliparts as $item) { ?>
		<?php if(isset($item['id_clipart'])) { ?>
		<li class="ui-widget-content ui-corner-all" title="<?php echo $item['name']; ?>" onclick="addClipart('<?php echo $item['id_clipart']; ?>');" >
			<table height="100%" width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td align="center" valign="middle" ><img src="<?php echo $item['thumb']; ?>" border="0"></td>
				</tr>
			</table>
		</li>
		<?php } ?>
		<?php if(isset($item['id_bitmap'])) { ?>
		<li class="ui-widget-content ui-corner-all" title="<?php echo $item['name']; ?>" onclick="addBitmap('<?php echo $item['id_bitmap']; ?>','<?php echo $item['source']; ?>', new Array(<?php echo $item['colors']; ?>));" >
			<table height="100%" width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td align="center" valign="middle" ><img src="<?php echo $item['thumb']; ?>" border="0"></td>
				</tr>
			</table>
		</li>
		<?php } ?>
	<?php } ?>
	<?php if($show_more) { ?>
	<div class="ui-widget-content ui-corner-all" style="clear:both; text-align:center;">
	    <div onclick="clipartLoadList(<?php echo ($clipart_page+1); ?>, $(this).parent())" style="cursor:pointer; padding:8px;">
		<span class="is_ml" ml_label="clipart_text_show_more"><?php echo $clipart_text_show_more; ?></span>
	    </div>
	</div>
	<?php } ?>
<?php } else { ?>
	<div class="is_ml" ml_label="clipart_text_empty"><?php echo $clipart_text_empty; ?></div>
<?php } ?>