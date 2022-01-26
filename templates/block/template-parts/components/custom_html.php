<?php

$row          = block_get_current_row();
$utm_params   = block_get_utm_params();
$content      = block_escape_chars( $row->custom_html );
?>
<tr>
	<td style="font-family: 'UCF-Sans-Serif-Alt', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.5; text-align: left; padding-bottom: 40px;" align="left">
		<?php echo $content; ?>
	</td>
</tr>
