<?php

$current_date = current_datetime();
$row          = block_get_current_row();
$thumbnail    = $row->image_file;
$alt          = esc_attr( $row->alt_text );
$utm_params   = block_get_utm_params();
$href         = format_url_utm_params( $row->links_to, $utm_params['source'], $utm_params['medium'], $utm_params['campaign'], $utm_params['content'] );

if ( $thumbnail ):
?>
<tr>
	<td style="padding-bottom: 40px;">
		<?php if ( $href ): ?>
		<a href="<?php echo $href; ?>">
		<?php endif; ?>
		<img class="img-fluid" width="580" src="<?php echo $thumbnail; ?>" alt="<?php echo $alt; ?>" style="max-width: 100%;">
		<?php if ( $href ): ?>
		</a>
		<?php endif; ?>
	</td>
</tr>
<?php endif; ?>
