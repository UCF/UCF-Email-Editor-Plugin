<?php
//Enter code here to get the title and header image information
$object_id      = get_queried_object_id();
$fields         = (object)get_fields( $object_id );
$title          = $fields->title;
$header_img_url = $fields->header_image;
$header_img_alt = $fields->header_image_alt;
?>

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

	<table style="text-align: center; background-color: #eee; min-width: 100%; table-layout: fixed; width: 100%;" width="100%" bgcolor="#eee" align="center">
		<tbody>
			<tr>
				<td style="text-align: left;" align="left">
					<table class="container-outer" style="text-align: center; background-color: #fff; margin: auto; min-width: 640px; width: 640px;" width="640" bgcolor="#fff" align="center">
						<tbody>
							<?php if ( $header_img_url ): ?>
							<tr>
								<td style="text-align: left;" align="left">
									<?php if ( $header_img_url ): ?>
									<a href="<?php echo $header_img_url; ?>">
									<?php endif; ?>
										<img class="img-fluid" width="640" src="<?php echo $header_img_url; ?>" alt="<?php echo esc_attr( $header_image_alt ); ?>" style="max-width: 100%;">
									<?php if ( $header_img_url ): ?>
									</a>
									<?php endif; ?>
								</td>
							</tr>
							<?php endif; ?>
							<tr>
								<td style="text-align: left;" align="left">
									<table class="container-inner" style="text-align: center; margin: auto; min-width: 580px; width: 580px;" width="580" align="center">
										<tbody>
											<tr>
												<td style="font-family: 'UCF-Sans-Serif-Alt', Helvetica, Arial, sans-serif; text-align: left; padding-top: 25px; padding-bottom: 25px; font-size: 27px; letter-spacing: -0.025em; line-height: 1.3;" align="left">
													<?php echo $title; ?>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
