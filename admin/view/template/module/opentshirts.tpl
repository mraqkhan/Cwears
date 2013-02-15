<?php echo $header; ?>
<style>
#menu_ot > ul > li {
    float: left;
    list-style: none outside none;
    margin: 5px 10px;
}
#menu_ot {
    overflow: auto;
    margin: 10px;
}
</style>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="menu_ot">
        <ul class="left" style="display: none;">
          <li id="product"><a class="top"><?php echo $text_products; ?></a>
            <ul>
              <li><a href="<?php echo $product; ?>"><?php echo $text_product; ?></a></li>
              <li><a href="<?php echo $product_color; ?>"><?php echo $text_product_color; ?></a></li>
              <li><a href="<?php echo $product_size; ?>"><?php echo $text_product_size; ?></a></li>
              <?php /*<li><a href="<?php echo $product_category; ?>"><?php echo $text_category; ?></a></li>
              <li><a href="<?php echo $product_manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>*/ ?>
            </ul>
          </li>
          <li id="clipart"><a class="top"><?php echo $text_cliparts; ?></a>
            <ul>
              <li><a href="<?php echo $clipart; ?>"><?php echo $text_clipart; ?></a></li>
              <li><a href="<?php echo $clipart_category; ?>"><?php echo $text_category; ?></a></li>
            </ul>
          </li>
          <li id="bitmap"><a class="top"><?php echo $text_bitmaps; ?></a>
            <ul>
              <li><a href="<?php echo $bitmap; ?>"><?php echo $text_bitmap; ?></a></li>
              <li><a href="<?php echo $bitmap_category; ?>"><?php echo $text_category; ?></a></li>
            </ul>
          </li>
          <li id="font"><a class="top"><?php echo $text_fonts; ?></a>
            <ul>
              <li><a href="<?php echo $font; ?>"><?php echo $text_font; ?></a></li>
              <li><a href="<?php echo $font_category; ?>"><?php echo $text_category; ?></a></li>
            </ul>
          </li>
          <li id="composition"><a class="top"><?php echo $text_compositions; ?></a>
            <ul>
              <li><a href="<?php echo $composition; ?>"><?php echo $text_composition; ?></a></li>
              <li><a href="<?php echo $composition_category; ?>"><?php echo $text_category; ?></a></li>
            </ul>
          </li>
          <li id="printing"><a class="top"><?php echo $text_printing; ?></a>
            <ul>
              <li><a href="<?php echo $design_color; ?>"><?php echo $text_design_color; ?></a></li>
              <li><a href="<?php echo $printing_pricing; ?>"><?php echo $text_printing_pricing; ?></a></li>
            </ul>
          </li>
          <li id="installer"><a href="<?php echo $installer; ?>" class="top"><?php echo $text_installer; ?></a></li>
        </ul>
      </div>
      <div>
        <div id="tabs" class="htabs"><a href="#tab-data"><?php echo $tab_data; ?></a></div>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <input type="hidden" name="config_max_product_color_combination" value="5" />
          <div id="tab-data">
            <table class="form">
              <tr>
                <td><?php echo $entry_logo; ?></td>
                <td><div class="image"><img src="<?php echo $ot_logo; ?>" alt="" id="thumb-logo" />
                    <input type="hidden" name="ot_config_logo" value="<?php echo $ot_config_logo; ?>" id="logo" />
                    <br />
                    <a onclick="image_upload('logo', 'thumb-logo');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb-logo').attr('src', '<?php echo $no_image; ?>'); $('#logo').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
              </tr>
              <tr>
                <td><?php echo $entry_video_tutorial_link; ?></td>
                <td><textarea name="video_tutorial_embed" style="width:100%; height:100px"><?php echo $video_tutorial_embed; ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_home_button_link; ?></td>
                <td><input type="text" name="home_button_link" value="<?php echo $home_button_link; ?>" /></td>
              </tr>
              <tr>
                <td><?php echo $entry_printing_colors_limit; ?></td>
                <td><input type="text" name="printing_colors_limit" value="<?php echo $printing_colors_limit; ?>" /></td>
              </tr>
              <tr>
                <td><?php echo $entry_template; ?></td>
                <td><?php echo $config_template; ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_theme; ?></td>
                <td><select name="config_theme" onchange="$('#template').load('index.php?route=module/opentshirts/theme_thumb&token=<?php echo $token; ?>&template=' + encodeURIComponent('<?php echo $config_template; ?>') + '&theme=' + encodeURIComponent(this.value)); ">
                  <?php foreach ($themes as $theme) { ?>
                  <?php if ($theme == $config_theme) { ?>
                  <option value="<?php echo $theme; ?>" selected="selected"><?php echo $theme; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $theme; ?>"><?php echo $theme; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              </tr>
              <tr>
                <td></td>
                <td id="template"></td>
              </tr>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
    $(document).ready(function() {
      /*$('#menu_ot > ul').superfish({
        hoverClass   : 'sfHover',
        pathClass  : 'overideThisToUse',
        delay    : 0,
        animation  : {height: 'show'},
        speed    : 'normal',
        autoArrows   : false,
        dropShadows  : false, 
        disableHI  : false, 
        onInit     : function(){},
        onBeforeShow : function(){},
        onShow     : function(){},
        onHide     : function(){}
      });*/

      //$('#menu_ot a').attr('target','_new');
      
      $('#menu_ot > ul').css('display', 'block');
    });
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
//--></script> 
<script type="text/javascript"><!--
$('#template').load('index.php?route=module/opentshirts/theme_thumb&token=<?php echo $token; ?>&template=' + encodeURIComponent('<?php echo $config_template; ?>') + '&theme=' + encodeURIComponent($('select[name=\'config_theme\']').val()));
//--></script> 
<script type="text/javascript"><!--
function image_upload(field, thumb) {
  $('#dialog').remove();
  
  $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
  
  $('#dialog').dialog({
    title: '<?php echo $text_image_manager; ?>',
    close: function (event, ui) {
      if ($('#' + field).attr('value')) {
        $.ajax({
          url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
          dataType: 'text',
          success: function(data) {
            $('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
          }
        });
      }
    },  
    bgiframe: false,
    width: 800,
    height: 400,
    resizable: false,
    modal: false
  });
};
//--></script> 
<?php echo $footer; ?>