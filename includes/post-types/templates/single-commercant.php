<?php
get_header(); ?>

<div id="content">

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
					<section class="entry-content clearfix" itemprop="articleBody">
					
						<div class="post-entry <?php if( has_post_thumbnail() ) { echo "post-entry-with-image"; } ?>">
						
							<div class="commercant-col8">
								
								<?php echo $commercantobject->getCommercantInfos('photos'); ?>
								
								<div class="commercant-single-container cf">
								
									<div class="commercant-single-thumb">
										<?php echo $commercantobject->getCommercantInfos('thumb'); ?>
									</div>
									
									<div class="commercant-single-identite">
										<h2 class="entry-title"><?php the_title(); ?></h2>
									
										<div class="commercant-listing-categories"> <?php echo get_the_term_list( $post->ID, 'cat_commercant', '', ', ', '' ); ?></div> 
										<?php echo $commercantobject->getCommercantInfos('Identite',$titre=false); ?>
									</div>
									
								</div>
								
								<div class="commercant-col12">
									<?php echo $commercantobject->getCommercantInfos('description',$titre=true); ?>
									<?php echo $commercantobject->getCommercantInfos('tags',$titre=true); ?>
								</div>
								
							</div>
							
							<div class="commercant-col4 last">
							<?php echo $commercantobject->getCommercantInfos('localisation',$titre=true); ?>						
							<?php echo $commercantobject->getCommercantInfos('horaires',$titre=true); ?>
							<?php echo $commercantobject->getCommercantInfos('plus',$titre=true); ?>
							</div>
													
							
							
							<a class="blue button" href="<?php echo get_post_type_archive_link( 'commercant' ); ?>"><?php _e('Retour','commercant'); ?></a>
						
						</div>
						
					</section> <!-- end article section -->
				</div>
				<!-- end of .post-entry -->

				<!-- end of .navigation -->

			</div><!-- end of #post-<?php the_ID(); ?> -->

			<?php
		endwhile;
	endif;
	?>

</div><!-- end of #content -->

<?php get_footer(); ?>
