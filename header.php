<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Demo
 * @since Demo 1.0
 */

 $googleFont = get_option('google_font');

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css" >
    <?php if ($googleFont!='') {?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=<?=urlencode($googleFont)?>:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: "<?=$googleFont?>", arial, sans;
        }
    </style>
    <?php } ?>
	<?php wp_head(); ?>
</head>
<?php
	$logo=get_custom_logo();
	$menuLocations = get_nav_menu_locations(); 
	$menuID = $menuLocations['primary']; 
	$primaryNav = wp_get_nav_menu_items($menuID);
	$menuID2 = $menuLocations['secondary']; 
	$secondaryNav = wp_get_nav_menu_items($menuID2);
	$categories = get_categories();
	$tags = get_tags();

    $show_desc = get_option('mainheader_desc') === true;
    $showMenuHome = get_option('mainheader_home') === true;
    $showMenuCategories = get_option('mainheader_categories') === true;
    $showMenuTags = get_option('mainheader_tags') === true;
    $showMenuSearch = get_option('mainheader_search') === true;

    // print_r($wp_query);
    $isSingle=$wp_query->is_singular;
    $sidebar = '';
    if (!$isSingle){
        ob_start();
        get_sidebar();
        $sidebar = ob_get_contents();
        ob_end_clean();    
    }
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$logourl = wp_get_attachment_url( $custom_logo_id );
    $extraheader = get_option('extraheader1','').get_option('extraheader2','').get_option('extraheader3','');
?>
<body <?php body_class(); ?>>

	<nav class="navbar navbar-container navbar-expand-md navbar-dark sticky-top bg-dark">
        <?php if ($extraheader!=''){?>
        <div class="navbar navbar-top">
            <div class="navbar-top-left"><?php echo get_option('extraheader1',''); ?></div>
            <div class="navbar-top-center flex-grow-1"><?php echo get_option('extraheader2',''); ?></div>
            <div class="navbar-top-right"><?php echo get_option('extraheader3',''); ?></div>
        </div>
        <? } ?>
		<div class="navbar navbar-dark col-md-auto ">
			<a class="navbar-brand" href="<?php echo esc_url( home_url() ); ?>" rel="home">
			<div class="row">
                <?php if ($logourl) { ?>
				<div class="col-xs-auto">
					<img class="custom-logo" src="<?php echo esc_url($logourl) ?>" height=80 >
				</div>
                <?php } ?>
				<div class="col-xs-auto ml-2 navbar-title">
					<h1><?php bloginfo( 'name' ); ?></h1>
                    <?php if ($show_desc) { ?>
					<small><?php echo get_bloginfo( 'description', 'display' ); ?></small>
                    <?php } ?>
				</div>
			</div>
			</a>
		</div>
		<div class="navbar-menu col-md">
			<div class="row navbar navbar-dark  navbar-expand ">
				<ul class="navbar-nav mx-auto">
                    <?php 
						if (@$showMenuHome) {?>
					<li class="nav-item active">
						<a class="nav-link" href="<?php echo esc_url( home_url() ); ?>">Home <span class="sr-only">(current)</span></a>
					</li>
                    <?php } ?>
					<?php 
						if ($primaryNav) foreach( $primaryNav as $idx => $link) {?>
						<li class="nav-item text-nowrap primary-menu">
							<a class="nav-link" href="<?php echo $link->url ?>"><?php echo $link->title ?></a>
						</li>
					<?php } ?>
					<?php 
						if ($secondaryNav) foreach( $secondaryNav as $idx => $link) {?>
						<li class="nav-item text-nowrap secondary-menu">
							<a class="nav-link" href="<?php echo $link->url ?>"><?php echo $link->title ?></a>
						</li>
					<?php } ?>
					<?php 
						if ($categories && @$showMenuCategories) {?>
					<li class="nav-item dropdown text-nowrap">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
						<div class="dropdown-menu" aria-labelledby="dropdown01">
							<?php foreach( $categories as $item) {?>
							<a class="dropdown-item" href="<?php echo get_category_link($item->term_id); ?>"><?php echo $item->name ?></a>
							<?php } ?>
						</div>
					</li>
					<?php } ?>
					<?php 
						if ($tags && @$showMenuTags) {?>
					<li class="nav-item dropdown text-nowrap">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tags</a>
						<div class="dropdown-menu" aria-labelledby="dropdown01">
							<?php foreach( $tags as $item) {?>
							<a class="dropdown-item" href="<?php echo get_tag_link($item->term_id); ?>"><?php echo $item->name ?></a>
							<?php } ?>
						</div>
					</li>
					<?php } ?>
				</ul>
				<?php if (@$showMenuSearch) {?>
                    <div class="header-search">
				    <?php get_search_form(["header"=>false]) ?>
                    </div>
				<?php } ?>
			</div>
		</div>
	</nav>
 <main role="main">
	 <div class="container">
			<div class="row p-0">
                <?php if ($sidebar!='') { ?>
				<div class="col-md-4 p-3 bg-light">
					<div id="sidebar" class="sidebar">
						<?php echo $sidebar ?>
					</div>
				</div>
				<div class="col-md-8 order-first">
					<div id="content" class="site-content">
                <?php } else { ?>
                <div class="col-md order-first">
					<div id="content" class="site-content">
                <?php } ?>

						


