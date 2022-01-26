<?php

$current_date = current_datetime();
$row          = block_get_current_row();
$content      = block_escape_chars( format_url_utm_params( $row->custom_html, $current_date->format( 'Y-m-d' ) ) );
?>
<tr>
	<td style="font-family: 'UCF-Sans-Serif-Alt', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.5; text-align: left; padding-bottom: 40px;" align="left">
		<?php echo $content; ?>
	</td>
</tr>
