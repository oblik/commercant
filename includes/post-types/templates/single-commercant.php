<?php
get_header(); ?>

<div id="content">

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					
					<h2 class="entry-title"><?php the_title(); ?></h2>		
					<section class="entry-content clearfix" itemprop="articleBody">
						<div class="post-entry">
						
						<a class="blue button" href=""><?php _e('Retour','commercant'); ?></a>
									
						<?php echo $commercantobject->getCommercantInfos('photos',$titre=true); ?>
						<?php echo $commercantobject->getCommercantInfos('Identite',$titre=true); ?>
						<?php echo $commercantobject->getCommercantInfos('localisation',$titre=true); ?>
						<?php echo $commercantobject->getCommercantInfos('description',$titre=true); ?>
						<?php echo $commercantobject->getCommercantInfos('horaires',$titre=true); ?>
						<?php echo $commercantobject->getCommercantInfos('plus',$titre=true); ?>
						<?php echo $commercantobject->getCommercantInfos('terms',$titre=true); ?>	
						
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
