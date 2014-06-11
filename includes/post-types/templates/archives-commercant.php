<?php
get_header(); ?>

<div id="content">

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="post-entry">
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>		
					<section class="entry-content clearfix" itemprop="articleBody">
								<?php echo $commercantobject->getCommercantInfos('photos'); ?>
								<?php echo $commercantobject->getCommercantInfos('Identite',0); ?>
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
