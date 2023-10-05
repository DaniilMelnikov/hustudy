<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/vendor/slick.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/vendor/slick-theme.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/plugins/sal.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/plugins/feather.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/plugins/fontawesome.min.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/plugins/euclid-circulara.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/plugins/swiper.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/plugins/magnify.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/plugins/odometer.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/plugins/animation.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/plugins/bootstrap-select.min.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/plugins/jquery-ui.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/plugins/magnigy-popup.min.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/assets/css/plugins/plyr.css">
    <link rel="stylesheet" href="http://kursy.existparts.ru/wp-content/themes/histudy/style.css">
    <!-- jQuery JS -->
    <script src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/js/vendor/jquery.js"></script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<?php get_template_part( 'template-parts/header/site-header' ); ?>
    <?php get_template_part( 'template-parts/header/popup-mobile' ); ?>
	<main class="rbt-main-wrapper">
