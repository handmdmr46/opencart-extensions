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
              <a onclick="start_ebay_call(); $('#form').attr('action', '<?php echo $ebay_call; ?>'); $('#form').submit();" class="button"><?php echo $button_ebay_call; ?></a>
              <a onclick="$('#form').attr('action', '<?php echo $load_profile; ?>'); $('#form').submit();" class="button"><?php echo $button_load_profile; ?></a>
              <a onclick="$('#form').attr('action', '<?php echo $edit_profile; ?>'); $('#form').submit();" class="button"><?php echo $button_edit_profile; ?></a>
              <a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
            </div>
        </div><!-- .heading -->

        <div class="content">
        	<form action="" method="post" enctype="multipart/form-data" id="form">
        	<table class="form">
        	</table>
        	</form>
        </div><!-- .content -->

    </div><!-- .box -->

	

</div><!-- #content -->

<script type="text/javascript"><!--

  function start_ebay_call(){
    $('.wait').show();
    // dont need this timer because resets when page re-loads.
    // setTimeout(function(){$('.wait').hide();}, 999000);
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