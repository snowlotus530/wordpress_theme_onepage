<?php
/*
Template Name: Onepage
*/

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >

	<?php while(have_posts()): the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>

	<?php wp_footer(); ?>
</body>
</html>