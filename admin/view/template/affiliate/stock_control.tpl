<?php echo $header; ?>

<div id="content">
<?php

// for($i=2; $i <= 20; $i++) {
// 	echo $i . "<br>";
// }

?>
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
            <h1><img src="view/image/download.png" alt="" /> <?php echo $heading_title_ebay_profile; ?></h1>
            <h1 class="wait" style="margin-left:1700px; display: none;">Please Wait, this may take awhile..... &nbsp;<img src="view/image/loading.gif" alt="" width="20" height="20" /></h1>
            <div class="buttons">      
              <a onclick="$('#form').attr('action', '<?php echo $set_ebay_profile; ?>'); $('#form').submit();" class="button"><?php echo $button_set_ebay_profile; ?></a>
              <a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
            </div>
        </div><!-- .heading -->

        <div class="content">
        	<form action="" method="post" enctype="multipart/form-data" id="form">
		      <table class="form">
		        <tr>
		          <td><span class="required">* </span><?php echo $text_ebay_user_token; ?></td>
		          <td>
		            <input name="user_token" value="<?php echo $user_token; ?>" type="text" size="100" required>
		            <?php if ($error_user_token) { ?>
		            <span class="error"><?php echo $error_user_token; ?></span>
		            <?php } ?>
		          </td>
		          <td></td>
        		</tr>
        		<tr>
		          <td><span class="required">* </span><?php echo $text_developer_id; ?></td>
		          <td>
		            <input name="developer_id" value="<?php echo $developer_id; ?>" type="text" size="100" required>
		            <?php if ($error_developer_id) { ?>
		            <span class="error"><?php echo $error_developer_id; ?></span>
		            <?php } ?>
		          </td>
		          <td></td>
		        </tr>
		        <tr>
		          <td><span class="required">* </span><?php echo $text_application_id; ?></td>
		          <td>
		            <input name="application_id" value="<?php echo $application_id; ?>" type="text" size="100" required>
		            <?php if ($error_application_id) { ?>
		            <span class="error"><?php echo $error_application_id; ?></span>
		            <?php } ?>
		          </td>
		          <td></td>
		        </tr>
		        <tr>
		          <td><span class="required">* </span><?php echo $text_certification_id; ?></td>
		          <td>
		            <input name="certification_id" value="<?php echo $certification_id; ?>" type="text" size="100" required>
		            <?php if ($error_certification_id) { ?>
		            	<span class="error"><?php echo $error_certification_id; ?></span>
		            <?php } ?>
		          </td>
		          <td></td>
		        </tr>
		        <tr>
		          <td><span class="required">* </span><?php echo $text_site_id; ?></td>
		          <td>
		            <select name="site_id">
			            <option value="999"><?php echo $text_select; ?></option>
			            <?php foreach($ebay_sites as $site) { ?>
				            <?php if (isset($site_id) && $site_id == $site['site_id'] ) { ?>
				            	<option value="<?php echo $site['site_id']; ?>" selected><?php echo $site['site_name']; ?></option>
				            <?php } else { ?>
				            	<option value="<?php echo $site['site_id']; ?>"><?php echo $site['site_name']; ?></option>
				            <?php } ?>
			            <?php } ?>
		            </select>
		            <?php if ($error_site_id) { ?>
		            	<span class="error"><?php echo $error_site_id; ?></span>
		            <?php } ?>
		          </td>
		        </tr>
		        <tr>
		          <td><span class="required">* </span><?php echo $text_compat_level; ?><span class="help"><?php echo $text_compat_help; ?></span></td>
		          <td>
		            <select name="compatability_level">
			            <option value="999"><?php echo $text_select; ?></option>
			            <?php foreach ($compat_levels as $level) { ?>
				            <?php if (isset($compat) && $compat == $level['level'] ) { ?>
				            	<option value="<?php echo $level['level']; ?>" selected><?php echo $level['level']; ?></option>		            
				            <?php } else { ?>
				            	<option value="<?php echo $level['level']; ?>"><?php echo $level['level']; ?></option>
				            <?php } ?>
			            <?php } ?>
		            </select>
		            <?php if ($error_compatability_level) { ?>
		            	<span class="error"><?php echo $error_compatability_level; ?></span>
		            <?php } ?>
		          </td>
		          <td></td>
		          <td></td>
		        </tr>
		      </table>
        </div><!-- .content -->

    </div><!-- .box -->
    <div class="box">

        <div class="heading">
            <h1><img src="view/image/download.png" alt="" /> <?php echo $heading_title_ebay_call; ?></h1>
            <h1 class="wait2" style="margin-left:1700px; display: none;">Please Wait, this may take awhile..... &nbsp;<img src="view/image/loading.gif" alt="" width="20" height="20" /></h1>
            <div class="buttons">
              <a onclick="$('#form').attr('action', '<?php echo $ebay_call; ?>'); $('#form').submit(); startProgressBar2();" class="button"><?php echo $button_ebay_call; ?></a>
              <a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
            </div>
        </div><!-- .heading -->

        <div class="content">        	
		      <table class="form">
		        <tr>
		          <td><span class="required">* </span><?php echo $text_ebay_call_name; ?></td>
		          <td>
		            <select name="ebay_call_name">
			            <option value="999"><?php echo $text_select; ?></option>
			            <?php foreach($ebay_call_names as $call) { ?>
			            	<option value="<?php echo $call; ?>"><?php echo $call; ?></option>
			            <?php } ?>
		            </select>
		            <?php if ($error_ebay_call_name) { ?>
		            <span class="error"><?php echo $error_ebay_call_name; ?></span>
		            <?php } ?>
		          </td>
		        </tr>
		        <tr>
		          <td><?php echo $text_item_id; ?></td>
		          <td>
		            <input name="item_id" value="<?php echo $item_id; ?>" type="text" size="100" required>		           
		          </td>
		          <td></td>
		        </tr>
		        <tr>
		          <td><?php echo 'New Quantity' ?></td>
		          <td>
		            <input name="new_quantity" value="<?php echo $new_quantity; ?>" type="text" size="20" required>		           
		          </td>
		          <td></td>
		        </tr>
		        
		        <?php if ($getOrders) { ?>
		        	<tr><td style="width:500px;">
		 			<?php 
		 				$ebay_item_id = array();
		 				$purchase_qty 	 = array();
			 			foreach(array_combine($getOrders['id'], $getOrders['qty_purchased']) as $item_id => $qty) { 
			 				$ebay_item_id[] = $item_id;
			 				$purchase_qty[] = $qty;
			 			}
			 			$data = array_combine($ebay_item_id,$purchase_qty);
			 			foreach($data as $k => $v) {
			 				echo 'ItemID: ' . $k . ' QuantityPurchased: ' . $v . '<br>';
			 			}
		 			 ?>
		 			 </td></tr>
		        <?php } ?>

		        <?php //if ($getItem) { ?>
		        	<tr><td style="width:500px;">
		        	<?php 
		        		// foreach($getItem as $item) { 
		        		// 	echo $item . '<br>';
		        		// }
		        		// echo $getItemTitle;
		        		// echo $getItemId;
		        		echo $getItemQuantity;
		        		echo $reviseInventoryStatus;
		        	?>
		        	</td></tr>
				<?php //} ?>		      
		      </table>
		  </form>
        </div><!-- .content -->

    </div><!-- .box -->

</div><!-- #content -->

<script type="text/javascript"><!--

  function startProgressBar(){
    $('.wait').show();
    // dont need this timer because resets when page re-loads.
    // setTimeout(function(){$('.wait').hide();}, 999000);
  }

  function startProgressBar2(){
    $('.wait2').show();
  }

  function check(id) {
    document.getElementById(id + '_select').setAttribute('checked','checked');
  }

//--></script>

<script type="text/javascript" charset="utf-8">

  window.onload=function(){
    scheduler.config.xml_date="%Y-%m-%d";
    scheduler.config.year_x = 6; //2 months in a row
    scheduler.config.year_y = 2; //3 months in a column
    scheduler.init('scheduler_here', new Date(), 'year');
    scheduler.parse('<?php echo $dates; ?>', 'json');
  };

</script>

<script type="text/javascript"><!--

  $('#tabs a').tabs();

//--></script>

<?php echo $footer; ?>