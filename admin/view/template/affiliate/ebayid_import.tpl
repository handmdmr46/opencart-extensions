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
        <a onclick="start_import(); $('#form').attr('action', '<?php echo $import_ids; ?>'); $('#form').submit();" class="button" title="start the eBay ItemID import"><?php echo $button_import; ?></a>
        <a onclick="$('#form').attr('action', '<?php echo $set_ebay_profile; ?>'); $('#form').submit();" class="button" title="save the eBay developer profile settings"><?php echo $button_set_ebay_profile; ?></a>
        <a href="<?php echo $cancel; ?>" class="button" title="return to admin home"><?php echo $button_cancel; ?></a>
      </div>
    </div><!-- .heading -->

    <div class="content">
    <form action="" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td width="10%"><span class="required">* </span><?php echo $text_ebay_start_from; ?><span class="help"><?php echo $text_ebay_start_from_help; ?></span></td>
          <td>
            <input name="start_date" id="start-date" type="text" value="<?php if(!empty($start_date)) { echo $start_date; } ?>" required>
            <?php if ($error_start_date) { ?>
            <span class="error"><?php echo $error_start_date; ?></span>
            <?php } ?>
          </td>

        </tr>
        <tr>
          <td><span class="required">* </span><?php echo $text_ebay_start_to; ?><br><span class="help"><span class="help"><?php echo $text_ebay_start_to_help; ?></span></td>
          <td width="10%">
            <input name="end_date" id="end-date" type="text" value="<?php if(!empty($end_date)) { echo $end_date; } ?>" required>
            <?php if ($error_end_date) { ?>
            <span class="error"><?php echo $error_end_date; ?></span>
            <?php } ?>
          </td>
          <td></td>
        </tr>
        </table>
        <table class="form">
        <tr>
          <td><span class="required">* </span><?php echo $text_user_token; ?></td>
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
        </tr>
      </table>
    </form>
    </div><!-- .content -->

  </div><!-- .box -->

  <div class="box">

    <div class="heading">
      <h1><img src="view/image/review.png" alt="" /> <?php echo $text_start_dates; ?></h1>
      <div class="buttons">
        <a href="<?php echo $clear_dates; ?>" class="button" title="clear all eBay Import start to and start from dates"><?php echo $button_clear_dates; ?></a>
        <a href="<?php echo $reload; ?>" class="button" title="reload the webpage"><?php echo $button_reload; ?></a>
      </div>
    </div>

    <div class="content">
      <span class="help" style="padding-top: 13px; "><?php echo $text_start_dates_help; ?></span>
      <div id="scheduler_here" class="dhx_cal_container" style='width:90%;height:400px; padding: 35px; margin: 20px;'>
        <div class="dhx_cal_navline" style="padding-left:5px;">
          <div class="dhx_cal_prev_button">&nbsp;</div>
          <div class="dhx_cal_next_button">&nbsp;</div>
          <div class="dhx_cal_date"></div>
        </div>
        <div class="dhx_cal_header"></div>
        <div class="dhx_cal_data"></div>
      </div>
    </div><!-- .content -->
  </div><!-- .box -->

</div><!-- #container -->

<script type="text/javascript"><!--

  $(document).ready(function() {
    $('#start-date').datepicker({dateFormat: 'yy-mm-dd'});
    $('#end-date').datepicker({dateFormat: 'yy-mm-dd'});

    // Confirm Clear Dates
    $('a').click(function(){
        if ($(this).attr('href') != null && $(this).attr('href').indexOf('clearDates', 1) != -1) {
            if (!confirm('<?php echo $text_confirm_clear_dates; ?>')) {
                return false;
            }
        }
    });
  });

  function start_import(){
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