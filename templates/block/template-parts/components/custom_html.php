<?php

$current_date = current_datetime();
$row          = block_get_current_row();
$utm_params   = block_get_utm_params();
$content      = block_escape_chars( format_url_utm_params( $row->custom_html, $utm_params['source'], $utm_params['medium'], $utm_params['campaign'], $utm_params['content'] );
?>
<tr>
	<td style="font-family: 'UCF-Sans-Serif-Alt', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.5; text-align: left; padding-bottom: 40px;" align="left">
		<?php echo $content; ?>
	</td>
</tr>
