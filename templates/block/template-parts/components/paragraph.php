<?php

$row     = block_get_current_row();
$content = block_format_paragraph_content( $row->paragraph );
?>
<tr>
	<td style="font-family: 'UCF-Sans-Serif-Alt', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.5; text-align: left; padding-bottom: 24px;" align="left">
		<?php echo $content; ?>
	</td>
</tr>
