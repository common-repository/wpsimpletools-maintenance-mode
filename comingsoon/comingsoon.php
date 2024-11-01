<!doctype html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,600&display=swap" rel="stylesheet">
<link rel='stylesheet' href='<?php echo esc_url( plugins_url( 'main.css', __FILE__ ) ) ;  ?>' type="text/css" media='all' />
<title><?php bloginfo('name') ?></title>
</head>
<body>
	<article>
		<h1><?php echo esc_attr(get_option('pageTitle'))  ?></h1>
		<div>
			<p><?php echo esc_attr(get_option('pageText'))  ?></p>
			<p><?php bloginfo('name') ?></p>
		</div>
	</article>
</body>
</html>
