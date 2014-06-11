<?php
get_header(); ?>

<div id="content">

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="post-entry">
					<h2 class="entry-title"><?php the_title(); ?></h2>		
					<section class="entry-content clearfix" itemprop="articleBody">						
						<?php echo $commercantobject->getCommercantInfos('photos'); ?>
						<?php echo $commercantobject->getCommercantInfos('Identite'); ?>
						<?php echo $commercantobject->getCommercantInfos('localisation'); ?>
						<?php echo $commercantobject->getCommercantInfos('description'); ?>
						<?php echo $commercantobject->getCommercantInfos('horaires'); ?>
						<?php echo $commercantobject->getCommercantInfos('plus'); ?>				
						
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
