<?php

$row = block_get_current_row();
?>
<tr>
	<td>
		<table class="container-inner" style="text-align: center; margin: auto; min-width: 580px; width: 580px;" width="580" align="center">
			<tbody>
				<?php echo block_display_component( $row, 'one_column_row' ); ?>
			</tbody>
		</table>
	</td>
</tr>
