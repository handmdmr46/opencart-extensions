<?php echo $header; ?>

<div id="content">

  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>

  <?php if ($error) { ?>
    <div class="warning"><?php echo $error; ?></div>
  <?php } ?>

  <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
  <?php } ?>

  <div class="box">

    <div class="heading">
      <h1><img src="view/image/download.png" alt="" /> <?php echo $heading_title; ?></h1>
      <h1 class="wait" style="margin-left:1700px; display: none;">Please Wait, this may take awhile..... &nbsp;<img src="view/image/loading.gif" alt="" width="20" height="20" /></h1>
      <div class="buttons">
        <a onclick="$('#form').attr('action', '<?php echo $edit; ?>'); $('#form').submit(); startLoadingSpinner();" class="button" title="edit the selected product link"><?php echo $button_edit; ?></a>
        <a onclick="$('#form').attr('action', '<?php echo $remove; ?>'); $('#form').submit(); startLoadingSpinner();" class="button" title="delete the selected product link"><?php echo $button_delete; ?></a>
        <a href="<?php echo $cancel; ?>" class="button" title="return to admin home"><?php echo $button_cancel; ?></a>
      </div>
    </div><!-- .heading -->

    <div class="content">
      <form action="" method="post" enctype="multipart/form-data" id="form">
          <table class="list" cellpadding="2">
              <thead>
                  <tr>
                    <td width="1" class="center">
                       <input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" />
                    </td>
                    <td class="left width200"><?php echo $text_ebay_item_id; ?></td>
                    <td class="center width75"><?php echo $text_product_id; ?></td>
                    <td><?php echo $text_product_title; ?></td>
                  </tr>
              </thead>
              <tbody>
                <?php if($linked_products) { ?>
                <?php foreach($linked_products as $product) { ?>
                <tr>
                  <td width="1" class="center">
                      <?php if ($product['selected']) { ?>
                        <input type="checkbox" name="selected[]" id="<?php echo $product['product_id']; ?>_select" value="<?php echo $product['product_id']; ?>" checked="checked">
                      <?php } else { ?>
                        <input type="checkbox" name="selected[]" id="<?php echo $product['product_id']; ?>_select" value="<?php echo $product['product_id']; ?>">
                      <?php } ?>
                  </td>
                  <td class="left width200"><input type="text" name="<?php echo $product['product_id']; ?>_ebay_item_id" value="<?php echo $product['ebay_item_id']; ?>" size="80" onclick="check(<?php echo $product['product_id']; ?>)"></td>
                  <td class="center width75"><?php echo $product['product_id']; ?></td>
                  <td><?php echo $product['title']; ?></td>
                </tr>
                <?php } ?>
                <?php } ?>
              </tbody>
            </table>
      </form>
    </div><!-- .content -->
    <div class="pagination"><?php echo $pagination; ?></div>
  </div><!-- .box -->
</div><!-- #content -->

<script type="text/javascript"><!--

  function startLoadingSpinner(){
    $('.wait').show();
  }

  function check(id) {
    document.getElementById(id + '_select').setAttribute('checked','checked');
  }

//--></script>

<?php echo $footer; ?>
