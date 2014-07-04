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
      <h1><img src="admin/view/image/download.png" alt="" /> <?php echo $heading_title_csv_import; ?></h1>
      <h1 class="wait" style="margin-left:1850px; display:none;" ">Please Wait, this may take awhile..... &nbsp;<img src="view/image/loading.gif" alt="" width="20" height="20"/></h1>
      <div class="buttons">        
          <a onclick="start_import(); $('#form').submit();" class="button" title="start the CSV import"><?php echo $button_import; ?></a>
          <a onclick="$('#form').attr('action', '<?php echo $edit; ?>'); $('#form').submit();" class="button" title="edit the selected product"><?php echo $button_edit_list; ?></a>
          <a onclick="$('#form').attr('action', '<?php echo $delete; ?>'); $('#form').submit();" class="button" title="delete the selected product"><?php echo $button_delete; ?></a>
          <a onclick="$('#form').attr('action', '<?php echo $clear; ?>'); $('#form').submit();" class="button" title="clear the CSV table, does not delete anything"><?php echo $button_clear; ?></a>
          <a href="<?php echo $cancel; ?>" class="button" title="return to admin home"><?php echo $button_cancel; ?></a>
      </div>
    </div><!-- .heading -->

    <div class="content">

    <form action="<?php echo $import; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><?php echo $text_choose_file; ?></td>
          <td><input name="csv" type="file" /><?php if($loading) { echo $loading; } ?></td>
        </tr>

      </table>
    <table class="list" cellpadding="2">
      <thead>
          <tr>
               <td width="1" class="center">
                 <input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" />
              </td>
              <td class="left" width="18%"><?php echo $text_title; ?></td>
              <td class="left" width="18%"><?php echo $text_description; ?></td>
              <td class="center width100"><?php echo $text_quantity; ?></td>
              <td class="center width100"><?php echo $text_price; ?></td>
              <td class="center width100"><?php echo $text_length; ?></td>
              <td class="center width100"><?php echo $text_width; ?></td>
              <td class="center width100"><?php echo $text_height; ?></td>
              <td class="center width100"><?php echo $text_category; ?></td>
              <td class="center width100"><?php echo $text_manufacturer; ?></td>
              <td class="center width100"><?php echo $text_weight; ?></td>
              <td class="center width200"><?php echo $text_shipping_dom; ?></td>
              <td class="center width200"><?php echo $text_shipping_intl; ?></td>
              <td class="center width100"><?php echo $text_model; ?></td>
              <td class="center width100"><?php echo $text_image; ?></td>
              <td class="center width400"><?php echo $text_gallery_image; ?></td>
          </tr>
      </thead>
      <tbody>
    <?php if($csv_view) { ?>
      <?php foreach($csv_view as $product) { ?>
          <tr>
            <td width="1" class="center">
              <?php if ($product['selected']) { ?>
                <input type="checkbox" name="selected[]" id="<?php echo $product['product_id']; ?>_select" value="<?php echo $product['product_id']; ?>" checked="checked">
              <?php } else { ?>
                <input type="checkbox" name="selected[]" id="<?php echo $product['product_id']; ?>_select" value="<?php echo $product['product_id']; ?>">
              <?php } ?>
            </td>
            <!-- product name -->
            <td width="18%">
            <input type="text" class="editable left" name="<?php echo $product['product_id']; ?>_name" value="<?php echo $product['product_name']; ?>"  size="85" onclick="check(<?php echo $product['product_id']; ?>)" readonly>
            </td>
            <!-- product description -->
            <td width="18%">
            <textarea style="margin:5px;" class="editable left" name="<?php echo $product['product_id']; ?>_description" id="<?php echo $product['product_id']; ?>_description" onclick="editText(<?php echo $product['product_id']; ?>);check(<?php echo $product['product_id']; ?>)" onDblClick="remove(<?php echo $product['product_id']; ?>)" cols="85" rows="2">
            <?php  echo $product['description']; ?>
            </textarea>
            <!-- quantity -->
            <td>
            <input type="text" class="editable center width50" name="<?php echo $product['product_id']; ?>_quantity" value="<?php echo $product['quantity']; ?>" onclick="check(<?php echo $product['product_id']; ?>)">
            </td>
            <!-- price -->
            <td>
            <input type="text" class="editable center width75" name="<?php echo $product['product_id']; ?>_price" value="<?php echo number_format($product['price'],2); ?>" onclick="check(<?php echo $product['product_id']; ?>)">
            </td>
            <!-- lenght -->
            <td>
            <input type="text" class="editable center width75" name="<?php echo $product['product_id']; ?>_length" value="<?php echo number_format($product['length'],3); ?>" onclick="check(<?php echo $product['product_id']; ?>)">
            </td>
            <!-- width -->
            <td>
            <input type="text" class="editable center width75" name="<?php echo $product['product_id']; ?>_width" value="<?php echo number_format($product['width'],3); ?>" onclick="check(<?php echo $product['product_id']; ?>)">
            </td>
            <!-- height -->
            <td>
            <input type="text" class="editable center width75" name="<?php echo $product['product_id']; ?>_height" value="<?php echo number_format($product['height'],3); ?>" onclick="check(<?php echo $product['product_id']; ?>)">
            </td>
            <!-- category -->
            <td>
            <select class="width150" name="<?php echo $product['product_id']; ?>_category" onchange="check(<?php echo $product['product_id']; ?>)">
            <option value=""><?php echo $entry_select; ?></option>
            <?php foreach($product['categories'] as $category) { ?>
            <?php if (!empty($product['category_name']) && ($product['category_id'] == $category['category_id']))  { ?>
            <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['category_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
            <?php } ?>
            <?php } ?>
            </select>
            </td>
            <!-- manufacturer -->
            <td>
            <select class="width150" name="<?php echo $product['product_id']; ?>_manufacturer" onchange="check(<?php echo $product['product_id']; ?>)">
            <option value=""><?php echo $entry_select; ?></option>
            <?php foreach($manufacturers as $manufacturer) { ?>
            <?php if(!empty($product['manufacturer_name']) && ($product['manufacturer_id'] == $manufacturer['manufacturer_id'])) { ?>
            <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
            <?php } ?>
            <?php } ?>
            </select>
            </td>
            <!-- weight -->
            <td>
            <input type="text" class="editable center width75" name="<?php echo $product['product_id']; ?>_weight" value="<?php echo number_format($product['weight'],3); ?>" onclick="check(<?php echo $product['product_id']; ?>)">
            </td>
            <!-- shipping domestic -->
            <td class="editable">
            <select class="width200" name="<?php echo $product['product_id']; ?>_shipping_dom" onchange="check(<?php echo $product['product_id']; ?>)">
            <option value=""><?php echo $entry_select; ?></option>
            <?php foreach($domestic_shipping as $shipping) { ?>
            <?php if (!empty($product['shipping_methods'][0]) && ($product['shipping_methods'][0]['shipping_id'] == $shipping['shipping_id'])) { ?>
            <option value="<?php echo $shipping['shipping_id']; ?>" selected="selected"><?php echo $shipping['shipping_name']; ?></option>
            <?php } else if(empty($product['shipping_methods'][0])) { ?>
            <option value="7" selected="selected">Parcel Select</option>
            <?php } else { ?>
            <option value="<?php echo $shipping['shipping_id']; ?>"><?php echo $shipping['shipping_name']; ?></option>
            <?php } ?>
            <?php } ?>
            </select>
            </td>
            <!-- shipping international -->
            <td>
            <select class="width200" name="<?php echo $product['product_id']; ?>_shipping_intl" onchange="check(<?php echo $product['product_id']; ?>)">
            <option value=""><?php echo $entry_select; ?></option>
            <?php foreach($international_shipping as $shipping) { ?>
            <?php if (!empty($product['shipping_methods'][1]) && ($product['shipping_methods'][1]['shipping_id'] == $shipping['shipping_id'])) { ?>
            <option value="<?php echo $shipping['shipping_id']; ?>" selected="selected"><?php echo $shipping['shipping_name']; ?></option>
            <?php } else if(empty($product['shipping_methods'][1])) { ?>
            <option value="10" selected="selected">Priority International</option>
            <?php } else { ?>
            <option value="<?php echo $shipping['shipping_id']; ?>"><?php echo $shipping['shipping_name']; ?></option>
            <?php } ?>
            <?php } ?>
            </select>
            </td>
            <!-- model -->
            <td>
            <input type="text" class="editable center width100" name="<?php echo $product['product_id']; ?>_model" value="<?php echo $product['model']; ?>" onclick="check(<?php echo $product['product_id']; ?>)" />
            </td>
            <!-- featured image -->
            <td>
            <input type="text" class="editable center width200" name="<?php echo $product['product_id']; ?>_featured_image" value="<?php echo $product['featured_image']; ?>" onclick="check(<?php echo $product['product_id']; ?>)" />
            </td>
            <!-- gallery images -->
            <td class="center width400">
            <?php if($product['gallery_images']) { ?>
            <?php foreach($product['gallery_images'] as $key => $image) { ?>
            <input type="text" class="editable center width200" name="<?php echo $product['product_id']; ?>_gallery_image_<?php echo $key; ?>" value="<?php echo $image; ?>" onclick="check(<?php echo $product['product_id']; ?>)" />
            <?php } ?>
            <?php } else { ?>
            <input type="text" class="editable center width200" name="<?php echo $product['product_id']; ?>_gallery_image_<?php echo $key; ?>" value="" onclick="check(<?php echo $product['product_id']; ?>)" />
            <?php } ?>
            </td>
          </tr>

      <?php } ?>
    <?php } ?>
    </tbody>
    </table>
    </form>
    <div class="pagination"><?php echo $pagination; ?></div>
    </div><!-- .content -->

  </div><!-- .box -->
</div><!-- #content -->

</div><!-- #container -->

<script src="view/javascript/ckeditor/ckeditor.js" type="text/javascript"></script>

<script type="text/javascript"><!--
$(document).ready(function() {

  // Confirm delete
  $('#form').submit(function(){
        if ($(this).attr('action').indexOf('delete',1) != -1) {
            if (!confirm('<?php echo $text_confirm; ?>')) {
                return false;
            }
        }
    });

  // Confirm edit
  /*
  $('#form').submit(function(){
        if ($(this).attr('action').indexOf('edit',1) != -1) {
            if (!confirm('<?php echo $text_confirm_edit; ?>')) {
                return false;
            }
        }
    });
  */

  $('.editable').focus(function() {
    $(this).addClass("focusField");
      if (this.value == this.defaultValue){
        this.select();
      }
      if(this.value != this.defaultValue){
        this.select();
      }
    });
    $('.editable').change(function() {
      $(this).removeClass("focusField");
      if (this.value == ''){
        this.value = (this.defaultValue ? this.defaultValue : '');
      }
   });

});
function editText(id) {
  CKEDITOR.replace(id + '_description', {
    filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
  });
}


function check(id) {
  document.getElementById(id + '_select').setAttribute('checked','checked');
}

function start_import(){
    $('.wait').show();
}



--></script>


<?php echo $footer; ?>
