<?php echo $header; ?>
<style type="text/css">
body {
	height:100%; 
	overflow:hidden;
}
#welcome {
	display:none
}
</style>
<script type="text/javascript"> 
	function log(){
		if (typeof(console) != 'undefined' && typeof(console.log) == 'function'){            
			Array.prototype.unshift.call(arguments, '[Opentshirts]');
			console.log( Array.prototype.join.call(arguments, ' '));
		}
	} 
	
	(function($){
		 $.fn.extend({
			  center: function () {
					return this.each(function() {
							var top = ($(window).height() - $(this).outerHeight()) / 2;
							var left = ($(window).width() - $(this).outerWidth()) / 2;
							$(this).css({position:'absolute', margin:0, top: (top > 0 ? top : 0)+'px', left: (left > 0 ? left : 0)+'px'});
					});
			}
		 });
	})(jQuery);


	function getMovie() {
		return swfobject.getObjectById("studio");
	}
	
	function handleWheel(event) {	
		var o = {
			x: event.screenX, 
			y: event.screenY,
			delta: event.detail,
			ctrlKey: event.ctrlKey, 
			altKey: event.altKey,
			shiftKey: event.shiftKey
		}
		getMovie().handleWheel(o);
	}
	function updateMovieSize()
	{
		$('#studio').width($(window).width());
		$('#studio').height($(window).height()-$("#header").outerHeight(true));
	}
	///callback from swf
	function onApplicationReady()
	{					
		//translate($("#current_lang").val());
		
		if(!(document.attachEvent)) {
			window.addEventListener("DOMMouseScroll", handleWheel, false);
		}
		
		//$('#switcher').themeswitcher();
		//$( "#switcher" ).draggable();
		//$("#switcher").fadeIn(500);
		//$("#header").fadeIn(500, updateMovieSize);
		$("#header").show();
		updateMovieSize();
		
		<?php if($video_tutorial_embed) { ?>
		$( "#popup_video" ).dialog("open");
		<?php } ?>
		$(document).trigger('onApplicationReady');
		
	}
	
	///callback from swf
	function onCreationComplete()
	{	
		$(document).trigger('onCreationComplete');
	}
	
	function alertError(errorStr) {
		alert(errorStr);	
	}
	
	function loadPopUp(url, data, method, success, dataType)
	{
		$("#popup_container").html('<img src="<?php echo $loading_image; ?>" />');
		$( "#popup_dialog" ).dialog("open");
		centerPopUp();
		
		if(data===undefined) {
			data = null;
		}
		
		if(method===undefined) {
			method = "GET";
		}

		if(success===undefined) {
			success = function(response){
				$("#popup_container").html(response);
				$( "#popup_dialog" ).dialog( "option", "position", 'center' );
			}
		}
		
		var settings = {
			type: method,
			url: url,
			data: data,
			success: success
		}
		
		if(dataType!=undefined) {
			settings.dataType = dataType;
		}
		
		
		$.ajax(settings);	
	
	}
	function centerPopUp()
	{
		$( "#popup_dialog" ).dialog( "option", "position", 'center' );	
	}
	
	function closePopUp()
	{
		$( "#popup_dialog" ).dialog("close");
	}

	function saveDesign(addToCart) {
		var idc = ($( "#global_id_composition" ).val()!="")?'&id_composition=' + $( "#global_id_composition" ).val():'';
		var add = (addToCart != null)?'&add=1':'';
		loadPopUp('index.php?route=studio/save' + idc + add);
	}
	
	function swfObjectCreated(e) 
	{
		/*Properties of this event object are:
			* success, Boolean to indicate whether the creation of a Flash plugin-in <object> DOM was successful or not
			* id, String indicating the ID used in swfobject.registerObject
			* ref, HTML object element reference (returns undefined when success=false) 
		*/
		if(e.success)
		{
			$(window).bind('beforeunload', function(){
				return "Do you really want to leave now?";
			});
			
			$("#header").hide();
			
			$(window).resize(function() {
				updateMovieSize();
			});
			
			$(document).trigger('swfObjectCreated',e);
			
		}
		
	}

	
	function studioLoadComposition(id)
	{
		getMovie().loadComposition(id);
	}
	function studioImportComposition(id)
	{
		getMovie().importComposition(id);
	}
	function studioAddClipart(id)
	{
		getMovie().addClipart(id);
	}
	function studioAddBitmap(id, source, used_colors, hidden_colors)
	{
		if (arguments.length == 4) {
			getMovie().addBitmap(id, source, used_colors, hidden_colors);
		} else if (arguments.length == 3)  {
			getMovie().addBitmap(id, source, used_colors, new Array());
		} else if (arguments.length == 2)  {
			getMovie().addBitmap(id, source, new Array(), new Array());
		}
	}
	function studioSetProduct(id)
	{
		getMovie().setProduct({id_product:id});
	}
	function studioChangeProductColor(id)
	{
		getMovie().changeProductColor(id);
	}
	function studioLoadTemplate(id)
	{
		getMovie().loadComposition(id);
	}
	function studioSaveComposition(id)
	{
		getMovie().saveComposition();
	}
	function studioSetCompositionName(name)
	{
		getMovie().setCompositionName(name);
	}
	function studioAddText()
	{
		getMovie().addText();
	}
	function studioAddTemplate(id)
	{
		getMovie().addTemplate(id);
	}
	function studioExportImage()
	{
		getMovie().exportImage();
	}
	function studioZoomIn()
	{
		getMovie().zoomIn();
	}
	function studioZoomOut()
	{
		getMovie().zoomOut();
	}
	function studioZoomArea()
	{
		getMovie().zoomArea();
	}	
	
	//callback from studio
	function onLoadObjectStart() {
		log("start");
		$('#preloader').show();
		$('#preloader-text').center();
	}
	
	function onLoadObjectProgress(p) {
		log("progress" + p);
		$('#preloader-text').text('<?php echo $text_loading; ?>' + p + '%');
		$('#preloader-text').center();
	}
	
	function onLoadObjectComplete() {
		log("complete");
		$('#preloader').hide();
	}
	
	function onLoadObjectError(msg) {
		log(msg);
		$('#preloader').hide();
	}
	
	
	$(document).bind("onTemplateChange", function(event, id) {
		$( "#global_id_composition" ).val(id);
	});
	
	<?php
	if($idc) {
	?>
		$(document).bind("onApplicationReady", function(event) {
			studioLoadComposition('<?php echo $idc; ?>');
			$(document).trigger('onTemplateChange', ['<?php echo $idc; ?>']);
		});
	<?php
	}
	?>	
	<?php
	if($import_idc) {
	?>
		$(document).bind("onApplicationReady", function(event) {
			studioImportComposition('<?php echo $import_idc; ?>');
		});
	<?php
	}
	?>	
	<?php
	if($default_product) {
	?>
		$(document).bind("onApplicationReady", function(event) {
			studioSetProduct('<?php echo $default_product; ?>');
		});
		
	<?php
	}
	?>	
	
	$(function() {
		// For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection. 
		var swfVersionStr = "10.0.0";
		// To use express install, set to playerProductInstall.swf, otherwise the empty string. 
		var xiSwfUrlStr = "catalog/view/javascript/swfobject/playerProductInstall.swf";
		var flashvars = {};
		var params = {};
		params.quality = "high";
		params.allowscriptaccess = "sameDomain";
		params.allowfullscreen = "true";
		params.wmode = "transparent";
		var attributes = {};
		attributes.id = "studio";
		attributes.name = "studio";
		swfobject.embedSWF(
				"<?php echo $studio_swf; ?>", "flashContent", 
				"100%", "100%", 
				swfVersionStr, xiSwfUrlStr, 
				flashvars, params, attributes, swfObjectCreated);
		
	
		$( "#popup_dialog" ).dialog({
			autoOpen: false,
			height: "auto",
			width: "auto",
			minHeight: 50,
			minWidth: 200,
			modal: true,
			close: function(event, ui) {
				$("#popup_container").html("");
			}
	
		});
		
									
	});
</script>

<!-- 
SWFObject's dynamic embed method replaces this alternative HTML content with Flash content when enough 
JavaScript and Flash plug-in support is available. The div is initially hidden so that it doesn't show
when JavaScript is disabled.
-->
<div id="flashContent">
	<p>To view this page ensure that Adobe Flash Player version 10.0.0 or greater is installed. </p>
	<script type="text/javascript"> 
		var pageHost = ((document.location.protocol == "https:") ? "https://" : "http://"); 
		document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='" 
						+ pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" ); 
	</script> 
</div>
<img src="<?php echo $loading_image; ?>" style="display:none;" />
<div id="popup_dialog" style="display:none;">
	<div id="popup_container"></div>
</div>
<div id="preloader" style="display:none; ">
	<div class="ui-widget-overlay" style="z-index: 1001;"><span id="preloader-text" style="font-size:20px"></span></div>
</div>
<?php if($video_tutorial_embed) { ?>
	<div id="popup_video" style="display:none;">
		<?php echo html_entity_decode($video_tutorial_embed); ?>
	</div>
	<div id="popup_video_link" class="ui-widget-content ui-corner-all" style="position:absolute; z-index:1000; bottom:10px; left:10px; display:none; padding:5px;">
		<a onclick="$( '#popup_video' ).dialog('open');" style="cursor:pointer">Design Studio Tutorial</a>
	</div>
	<script type="text/javascript">
		$(function() {
			$( "#popup_video" ).dialog({
				autoOpen: false,
				height: "auto",
				width: "auto",
				modal: true,
				close: function(event, ui) {
					$("#popup_video_link").show();
				},
				open: function(event, ui) {
					$("#popup_video_link").hide();
				}
		
			});
		});
	</script>
<?php } ?>
<input type="hidden" id="global_id_composition" />
<?php echo $zoom; ?>
<?php echo $toolbar; ?>
<?php echo $list_clipart; ?>
<?php echo $list_product; ?>
<?php echo $list_template; ?>
<?php echo $account_bar; ?>
<div id="price_container"><?php echo $price; ?></div>
<?php echo $footer; ?>
