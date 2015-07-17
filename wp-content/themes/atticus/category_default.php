<?php get_header(); 
global $pmc_data;
wp_enqueue_script('pmc_bxSlider');		?><script async>jQuery(document).ready(function($){	jQuery('.bxslider').bxSlider({	  auto: true,	  speed: 1000,	  controls: false,	  pager :false,	  easing : 'easeInOutQuint',	});});	</script>	<!-- main content start --><div class="mainwrap blog <?php if(is_front_page()) echo 'home' ?> <?php if(!isset($pmc_data['use_fullwidth'])) echo 'sidebar' ?>">	<div class="main clearfix">		<div class="pad"></div>					<div class="content blog">								<?php if (have_posts()) : ?>						<?php while (have_posts()) : the_post(); ?>
			<?php 
			$day = get_the_time('d');
			$month= get_the_time('m');
			$year= get_the_time('Y');
			?>						<?php if(is_sticky(get_the_id())) { ?>			<div class="pmc_sticky">			<?php } ?>			<?php			$postmeta = get_post_custom(get_the_id()); ?>
				
			
			<?php			if ( has_post_format( 'gallery' , get_the_id())) { 			?>			<div class="slider-category">								<div class="blogpostcategory">					<div class="topBlog">	
						 
						<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class = "post-author">
								<a class="post-meta-author" href="<?php echo  the_author_meta( 'user_url' ) ?>"><?php _e('by ','pmc-themes'); echo get_the_author(); ?></a>
						</div>
						<div class = "post-time">
							<a class="post-meta-time" href="<?php echo get_day_link( $year, $month, $day ) ?>">on <?php the_time('F j, Y') ?></a>
						</div>
					</div>	
				<?php					global $post;					$attachments = '';					$post_subtitrare = get_post( get_the_id() );					$content = $post_subtitrare->post_content;					$pattern = get_shortcode_regex();					preg_match( "/$pattern/s", $content, $match );					if( isset( $match[2] ) && ( "gallery" == $match[2] ) ) {						$atts = shortcode_parse_atts( $match[3] );						$attachments = isset( $atts['ids'] ) ? explode( ',', $atts['ids'] ) : get_children( 'post_type=attachment&post_mime_type=image&post_parent=' . get_the_id() .'&order=ASC&orderby=menu_order ID' );					}					if ($attachments) {?>					<div id="slider-category" class="slider-category">					<div class="loading"></div>						<ul id="slider" class="bxslider">							<?php								foreach ($attachments as $attachment) {
								if(!is_object($attachment)){$attachment = $attachment;} else {
								if(!array_key_exists('ID',$attachment)){$attachment = $attachment;} else {$attachment = $attachment->ID;}}																		$image =  wp_get_attachment_image_src( $attachment, 'blog' ); ?>											<li>											<img src="<?php echo esc_url($image[0]) ?>"/>																	</li>										<?php } ?>						</ul>											</div>			  <?php } ?>			  <div class="bottomborder"></div>				<?php get_template_part('includes/boxes/loopBlog'); ?>
				<div class="blog_social"> <?php pmc_socialLinkSingle(get_the_permalink(),get_the_title())  ?></div>				</div>			</div>			<?php } 			if ( has_post_format( 'video' , get_the_id())) { ?>			<div class="slider-category">							<div class="blogpostcategory">				<div class="topBlog">	
						 
						<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class = "post-author">
							<a class="post-meta-author" href="<?php echo  the_author_meta( 'user_url' ) ?>"><?php _e('by ','pmc-themes');?> <span> <?php echo get_the_author(); ?></span></a>
						</div>
						<div class = "post-time">
							<a class="post-meta-time" href="<?php echo get_day_link( $year, $month, $day ) ?>">on <?php the_time('F j, Y') ?></a>
						</div>
					</div>	
				<?php								if(!empty($postmeta["video_post_url"][0])) {?>				<?php  					$video_arg  = '';					$video = wp_oembed_get( esc_url($postmeta["video_post_url"][0]), $video_arg );							$video = preg_replace('/width=\"(\d)*\"/', 'width="800"', $video);								$video = preg_replace('/height=\"(\d)*\"/', 'height="490"', $video);						echo $video;
				}				else{ 					  $image = 'http://placehold.it/1180x650'; 					  				?>					  <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php echo pmc_getImage(get_the_id(),'blog'); ?></a>									<?php } ?>					<div class="bottomborder"></div>				<?php get_template_part('includes/boxes/loopBlog'); ?>				<div class="blog_social"> <?php pmc_socialLinkSingle(get_the_permalink(),get_the_title())  ?></div>
				</div>
							</div>			<?php } 			if ( has_post_format( 'link' , get_the_id())) {			$postmeta = get_post_custom(get_the_id()); 
			if(isset($postmeta["link_post_url"][0])){
				$link = $postmeta["link_post_url"][0];
			} else {
				$link = "#";
			}			
			?>
			<div class="link-category">
				<div class="blogpostcategory">
					<div class="topBlog">	
						<div class="blog-category"><?php echo '<em>' . get_the_category_list( __( ', ', 'pmc-themes' ) ) . '</em>'; ?> </div>
						<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					</div>			
					<?php if(pmc_getImage(get_the_id(), 'blog') != '') { ?>	

					<a class="overdefultlink" href="<?php echo esc_url($link) ?>">
					<div class="overdefult">
					</div>
					</a>

					<div class="blogimage">	
						<div class="loading"></div>		
						<a href="<?php echo esc_url($link) ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php echo pmc_getImage(get_the_id(), 'blog'); ?></a>
					</div>
					<?php } ?>					
					<?php get_template_part('includes/boxes/loopBlogLink'); ?>								
				</div>
			</div>						<?php 			} 				
			if ( has_post_format( 'quote' , get_the_id())) {?>
			<div class="quote-category">
				<div class="blogpostcategory">				
					<?php get_template_part('includes/boxes/loopBlogQuote'); ?>								
				</div>
			</div>
			
			<?php 
			} 						 if ( has_post_format( 'audio' , get_the_id())) {?>			<div class="blogpostcategory">				<div class="audioPlayerWrap">					<div class="loading"></div>					<div class="audioPlayer">						<?php						if(isset($postmeta["audio_post_url"][0]))							echo do_shortcode('[audio file="'. esc_url($postmeta["audio_post_url"][0]) .'"]') ?>					</div>				</div>				<?php get_template_part('includes/boxes/loopBlog'); ?>					</div>				<?php			}			?>														<?php			if ( !get_post_format() ) {?>		
			<div class="blogpostcategory">				<div class="topBlog">	
						 
						<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class = "post-author">
								<a class="post-meta-author" href="<?php echo  the_author_meta( 'user_url' ) ?>"><?php _e('by ','pmc-themes');?> <span> <?php echo get_the_author(); ?></span></a>
						</div>
						<div class = "post-time">
							<a class="post-meta-time" href="<?php echo get_day_link( $year, $month, $day ) ?>">on <?php the_time('F j, Y') ?></a>
						</div>
					</div>					<?php if(pmc_getImage(get_the_id(), 'blog') != '') { ?>	
					<a class="overdefultlink" href="<?php the_permalink() ?>">					<div class="overdefult">					</div>					</a>
					<div class="blogimage">							<div class="loading"></div>								<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php echo pmc_getImage(get_the_id(), 'blog'); ?></a>					</div>					
					<div class="bottomborder"></div>					<?php } ?>					<?php get_template_part('includes/boxes/loopBlog'); ?>
								</div>
						<?php } ?>					<?php if(is_sticky()) { ?>				</div>			<?php } ?>
			<?php 
			if((int)$pmc_data['block_count'] == $count_posts && isset($pmc_data['use_advertise'])) { ?>
				<div class="block_advertising">
					<h3><?php echo esc_html($pmc_data['block_advertising_title']) ?></h3>
					<a target="_blank" href="<?php echo esc_url($pmc_data['block_advertising_link']) ?>"><img src="<?php echo esc_url($pmc_data['block_advertising_image']) ?>"></a>
				</div>
			<?php } ?>							<?php endwhile; ?>								<div class="pmc-navigation">
					<div class="alignleft"><?php previous_posts_link( '&laquo; Newer Posts' ); ?></div>
					<div class="alignright"><?php next_posts_link( 'Older Posts &raquo;', '' ); ?></div>
				</div>										<?php else : ?>											<div class="postcontent">							<h1><?php pmc_security($pmc_data['errorpagetitle']) ?></h1>							<div class="posttext">								<?php pmc_security($pmc_data['errorpage']) ?>							</div>						</div>											<?php endif; ?>						</div>		<!-- sidebar -->
		<?php if(!isset($pmc_data['use_fullwidth'])) { ?>			<div class="sidebar">					<?php dynamic_sidebar( 'sidebar' ); ?>			</div>
		<?php } ?>	</div>	</div>											<?php get_footer(); ?>