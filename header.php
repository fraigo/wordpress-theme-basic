<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage BasicTheme
 * @since BasicTheme 1.0
 */

 $googleFont = get_option('google_font');
 $googleFontSizes = get_option('google_font_sizes');

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
    <link href="https://fonts.googleapis.com/css2?family=<?=urlencode($googleFont)?>:wght@<?=urlencode($googleFontSizes?:'400;600')?>&display=swap" rel="stylesheet">
    <style>
        body, td, input, select, textarea {
            font-family: "<?=$googleFont?>", arial, sans !important;
        }
    </style>
    <?php } ?>
	<?php wp_head(); ?>
    <script>
        window.addEventListener("scroll", function(){
            var top = document.documentElement.scrollTop || document.body.scrollTop;
            if (top>2){
                document.body.setAttribute("scrolling","1");
            }else{
                document.body.setAttribute("scrolling","0");
            }
        })
    </script>
</head>
<?php
	$logo=get_custom_logo();
	$menuLocations = get_nav_menu_locations(); 
	$menuID = $menuLocations['primary']; 
	$primaryNav = wp_get_nav_menu_items($menuID);
	$menuID2 = $menuLocations['social']; 
	$socialNav = wp_get_nav_menu_items($menuID2);
	$categories = get_categories();
	$tags = get_tags();
    
    $show_title = get_option('show_title') == 1;
    $show_desc = get_option('show_desc') == 1;
    $showMenuHome = get_option('show_home') == 1;
    $showMenuCategories = get_option('show_categories') == 1;
    $showMenuTags = get_option('show_tags') == 1;
    $showMenuSearch = get_option('show_search') == 1;

    //print_r($wp_query);
    $thumbnail_url_lg = get_the_post_thumbnail_url($wp_query->post->ID, '1920');
    $thumbnail_url_sm = get_the_post_thumbnail_url($wp_query->post->ID, '1024');
    $show_header_image = get_option('show_header_image') == 1 && ($thumbnail_url_lg != '');
    $show_header_full = get_option('show_header_full') == 1;
    $header_default_height = get_option('header_default_height');

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

    $mainNav = [];
    $allNav = [];
    foreach($primaryNav as $nav){
        if ($nav->menu_item_parent>0) {
            $allNav["m".$nav->menu_item_parent]->items["m".$nav->ID] = $nav;
        } else {
            $nav->items = [];
            $mainNav["m".$nav->ID] = $nav;
            $allNav["m".$nav->ID] = $nav;
        }
    }
    $secNav = [];
    $allNav = [];
    foreach($socialNav as $nav){
        if ($nav->menu_item_parent>0) {
            $secNav["m".$nav->menu_item_parent]->items["m".$nav->ID] = $nav;
        } else {
            $nav->items = [];
            $secNav["m".$nav->ID] = $nav;
            $allNav["m".$nav->ID] = $nav;
        }
    }
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
		<div class="navbar col-md-auto navbar-site">
			<a class="navbar-brand" href="<?php echo esc_url( home_url() ); ?>" rel="home">
			<div class="row">
                <?php if ($logourl) { ?>
				<div class="col-xs-auto">
					<img class="custom-logo" src="<?php echo esc_url($logourl) ?>" height=80 >
				</div>
                <?php } ?>
				<div class="col-xs-auto ml-2 navbar-title">
                    <?php if ($show_title) { ?>
					<h1><?php bloginfo( 'name' ); ?></h1>
                    <?php } ?>
                    <?php if ($show_desc) { ?>
					<small><?php echo get_bloginfo( 'description', 'display' ); ?></small>
                    <?php } ?>
				</div>
			</div>
			</a>
		</div>
		<div class="navbar-menu col-md">
			<div class="row navbar navbar-dark  navbar-expand ">
				<ul class="navbar-nav mx-auto navbar-main">
                    <?php 
						if (@$showMenuHome) {?>
					<li class="nav-item active">
						<a class="nav-link" href="<?php echo esc_url( home_url() ); ?>">Home <span class="sr-only">(current)</span></a>
					</li>
                    <?php } ?>
					<?php 
						if ($primaryNav) foreach( $mainNav as $idx => $link) {?>
						<li class="nav-item text-nowrap primary-menu" name="<?=$link->post_name?>">
                            <?php if (count($link->items)) { ?>
                                <a class="nav-link dropdown-toggle" id="menu<?php echo $link->ID?>" href="<?php echo $link->url ?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $link->title ?></a>
                                <div class="dropdown-menu" aria-labelledby="menu<?php echo $link->ID?>" >
                                <?php foreach( $link->items as $idx1 => $link1) {?>
							        <a class="dropdown-item" href="<?php echo $link1->url ?>"><?php echo $link1->title ?></a>
                                <?php } ?>
                                </div>
                            <?php } else { ?>
                                <a class="nav-link" href="<?php echo $link->url ?>"><?php echo $link->title ?></a>
                            <?php } ?>
						</li>
					<?php } ?>
                    </ul>
                    <ul class="navbar-nav mx-auto navbar-social">
					<?php 
						if ($socialNav) foreach( $secNav as $idx => $link) {?>
						<li class="nav-item text-nowrap social-menu" name="<?=$link->post_name?>">
                            <?php if (count($link->items)) { ?>
                                <a class="nav-link dropdown-toggle" id="menu<?php echo $link->ID?>" href="<?php echo $link->url ?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $link->title ?></a>
                                <div class="dropdown-menu" aria-labelledby="menu<?php echo $link->ID?>" >
                                <?php foreach( $link->items as $idx1 => $link1) {?>
							        <a class="dropdown-item" target="_blank" href="<?php echo $link1->url ?>"><?php echo $link1->title ?></a>
                                <?php } ?>
                                </div>
                            <?php } else { ?>
                                <a class="nav-link" target="_blank" test="1" href="<?php echo $link->url ?>"><?php echo $link->title ?></a>
                            <?php } ?>
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
        <?php if ($show_header_image && $show_header_full) { ?>
            <div class="header-image" style="background-image:url('<?=$thumbnail_url_lg?>'); height:<?=($header_default_height*1)?:"auto"?>px;" >
                <!--<h1></h1>-->
            </div>
        <?php  } ?>
        <div class="container">
             <?php if ($show_header_image && !$show_header_full) { ?>
            <div class="header-image" style="background-image:url('<?=$thumbnail_url_lg?>'); height:<?=($header_default_height*1)?:"auto"?>px;" >
                <!--<h1></h1>-->
            </div>
            <?php  } ?>
			<div class="row p-0">
                <?php if ($sidebar!='') { ?>
				<div class="col-md-4 p-3 bg-light sidebar-container">
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

						


