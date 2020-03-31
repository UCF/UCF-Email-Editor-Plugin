<?php
/*
 * Template Name: Blank Email Template
 * Template Post Type: ucf_email
 * Description: Blank template used to create an email.
 */
?>

<?php
  the_post();
?>

<?php include_once( 'header.php' ); ?>

<table class="tcollapse100" width="564" border="0" align="center">
  <tbody>
  <tr>
    <td style="padding-left: 0; padding-right: 0; font-family: 'UCF-Sans-Serif-Alt', Helvetica, Arial, sans-serif; font-size: 35px; font-weight: bold; padding-top: 20px; padding-bottom: 30px; line-height: 1.1; color: #000; text-align: left;" align="left">
      <?php the_title(); ?>
    </td>
  </tr>
  <tr>
    <td class="ccollapse100" style="width: 100%;">
    <table class="tcollapse100" align="center" style="width: 100%;">
      <tbody>
      <tr>
        <td class="ccollapse100" style="font-family: 'UCF-Sans-Serif-Alt', Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.5;">
          <?php the_content(); ?>
          <?php echo get_email_signature(); ?>
        </td>
      </tr>
      </tbody>
    </table>
    </td>
  </tr>
  </tbody>
</table>

<?php include_once( 'footer.php' ); ?>
