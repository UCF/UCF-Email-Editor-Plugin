<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="initial-scale=1.0">

  <title>
    <?php wp_strip_all_tags( the_title() ); ?>
  </title>

  <?php include_once( 'css.php' ); ?>
</head>

<body>

  <table class="t640" width="640" align="center">
    <tbody>
      <tr>
        <td style="padding: 0;">
          <?php echo get_email_header(); ?>
        </td>
      </tr>
      <tr>
        <td>
          <table class="t564" width="564" align="center" style="padding-top: 15px;">
          <tbody>
            <tr>
              <td style="padding-bottom: 0;">
