<!DOCTYPE html><html <?php language_attributes(); ?> class="no-js" ><!-- start --><head>	<?php global $pmc_data; ?>	<meta charset="<?php bloginfo( 'charset' ); ?>" />	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />    <meta name="format-detection" content="telephone=no">	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	<link rel="icon" type="image/png" href="<?php echo esc_url($pmc_data['favicon']) ?>">	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />	<?php if ( is_singular() && get_option( 'thread_comments' ) ) {wp_enqueue_script( 'comment-reply' ); }?>	<?php wp_head();?></head>		<!-- start body --><body <?php body_class(); ?> >	<!-- start header -->			<!-- fixed menu -->					<?php 			global $pmc_data;				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );			?>				<div class="pagenav fixedmenu">										<div class="holder-fixedmenu">												<div class="logo-fixedmenu">													<?php 					if(isset($pmc_data['scroll_logo'])){						$logo = $pmc_data['scroll_logo']; 					} else {						$logo = $pmc_data['logo']; 					} ?>												<a href="<?php echo home_url(); ?>"><img src="<?php if ($logo != '') {?><?php echo esc_url($logo) ?><?php } else {?><?php get_template_directory_uri(); ?>/images/logo.png<?php }?>" alt="<?php bloginfo('name'); ?> - <?php bloginfo('description') ?>" ></a>					</div>						<div class="menu-fixedmenu home">						<?php						if ( has_nav_menu( 'pmcscrollmenu' ) ) {						wp_nav_menu( array(						'container' =>false,						'container_class' => 'menu-scroll',						'theme_location' => 'pmcscrollmenu',						'echo' => true,						'fallback_cb' => 'opus_fallback_menu',						'before' => '',						'after' => '',						'link_before' => '',						'link_after' => '',						'depth' => 0,						'walker' => new pmc_Walker_Main_Menu())						);						}						?>						</div>				</div>				</div>			<?php 				?>				<header>					<?php if(isset($pmc_data['use_topbar'])){ ?>										<div id = "upperheader">							<div id = "upperinnerheader">								<div class = "upper-header-text">									<?php echo pmc_security($pmc_data['upper_header_text']) ?>								</div>								<div class = "top-search-form">									<?php get_search_form(true); ?>								</div>																<div class="social_icons">									<div><?php pmc_socialLink() ?></div>								</div>															</div>						</div>					<?php } ?>					<div id="headerwrap">									<!-- logo and main menu -->						<div id="header">							<!-- respoonsive menu main-->							<!-- respoonsive menu no scrool bar -->							<div class="respMenu noscroll">								<div class="resp_menu_button"><i class="fa fa-list-ul fa-2x"></i></div>								<?php 								if ( has_nav_menu( 'pmcrespmenu' ) ) {									$menuParameters =  array(									  'theme_location' => 'pmcrespmenu', 									  'walker'         => new pmc_Walker_Responsive_Menu(),									  'echo'            => false,									  'items_wrap'     => '<div class="event-type-selector-dropdown">%3$s</div>',									);									echo strip_tags(wp_nav_menu( $menuParameters ), '<a>,<br>,<div>,<i>,<strong>' );								}								?>								</div>										<!-- main menu -->							<div class="pagenav"> 							<div id="logo">								<?php $logo = $pmc_data['logo']; ?>								<a href="<?php echo home_url(); ?>"><img src="<?php if ($logo != '') {?>								<?php echo esc_url($logo); ?><?php } else {?><?php get_template_directory_uri(); ?>/images/logo.png<?php }?>" alt="<?php bloginfo('name'); ?> - <?php bloginfo('description') ?>" /></a>							</div>							<?php								if ( has_nav_menu( 'pmcmainmenu' ) ) {										wp_nav_menu( array(									'container' =>false,									'container_class' => 'menu-header home',									'theme_location' => 'pmcmainmenu',									'echo' => true,									'fallback_cb' => 'opus_fallback_menu',									'before' => '',									'after' => '',									'link_before' => '',									'link_after' => '',									'depth' => 0,									'walker' => new pmc_Walker_Main_Menu()));																} ?>															</div>  														</div>											</div>						 						<?php 					if(isset($pmc_data['use_block1'])){ ?>						<div class="block1">							<div class="block1_img">								<img src="<?php echo esc_url($pmc_data['block1_img1']) ?>" alt="<?php echo esc_html($pmc_data['block1_text1']) ?>">							</div>							<div class="block1_all_text">																<div class="block1_text">									<?php if(!is_category() && !is_tag()) { ?>										<p><?php echo esc_html($pmc_data['block1_text1']) ?></p>									<?php } 									if(is_category() || is_tag()) { ?>											<p><?php _e('You are browsing ','pmc-themes'); ?>										<?php 										if(is_category()) {															$cat = get_query_var('cat');											$cat = get_category($cat); 											echo '<span>'.esc_attr($cat->cat_name).'</span>'; 										}										if(is_tag()) {											$tag = get_query_var('tag');											$tag = str_replace('-',' ',$tag);											echo '<span>'.esc_attr($tag).'</span>';										}										?>																															</p>									<?php } ?>									</div>															</div>																			</div>					<?php } ?>						<?php 					include_once( ABSPATH . 'wp-admin/includes/plugin.php' );					if(is_plugin_active( 'revslider/revslider.php')){												if(isset($pmc_data['rev_slider']) && $pmc_data['rev_slider'] != ''){ ?>							<div id="atticusSlider">								<?php putRevSlider($pmc_data['rev_slider'],"homepage") ?>							</div>						<?php } ?>					<?php } ?>										<?php if(is_front_page() && isset($pmc_data['use_recent'])) { ?>						<div class="sidebar-home">								<?php dynamic_sidebar( 'sidebar-home' ); ?>						</div>					<?php } ?>										<?php if(is_front_page() && isset($pmc_data['use_block2'])){ ?>							<div class="block2">							<div class="block2_content">																																<div class="block2_img">									<img class="block2_img_big" src="<?php echo esc_url($pmc_data['block2_img']) ?>">									<div class="block2_text">										<p><?php pmc_security($pmc_data['block2_text']) ?></p>									</div>									<div class="social_icons">										<div><?php pmc_socialLink() ?></div>									</div>																									</div>							</div>						</div>					<?php } ?>				</header>					<?php			?>