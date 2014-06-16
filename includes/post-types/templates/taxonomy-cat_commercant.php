<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>

<div id="taxonomy-archive" >
	
	<h2><?php _e('Cat&eacute;gorie','commercant');?> <?php single_term_title(); ?></h2>
	
	<?php echo category_description(); ?> 
	
	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="post-entry cf <?php if( has_post_thumbnail() ) { echo "post-entry-with-image"; } ?> ">
				
					<!-- Thumbnail -->
					<?php if( has_post_thumbnail() ) : ?>
					<div class="commercant-listing-image">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail( 'thumbnail' ); ?>
						</a>
					</div>
					<?php endif; ?>
					
					<!-- Body -->
					<div class="commercant-listing-body">
						<h3 class="commercant-listing-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
						<div class="commercant-listing-categories"> <?php echo get_the_term_list( $post->ID, 'cat_commercant', '', ', ', '' ); ?></div> 				
						<div class="commercant-listing-text"><?php echo get_the_excerpt(); ?></div>
						<div class="commercant-listing-more"><a href="<?php the_permalink(); ?>" class="button">En savoir plus</a></div>
					</div>
					
				</div>
				<!-- end of .post-entry -->

			</div><!-- end of #post-<?php the_ID(); ?> -->

		<?php
		endwhile;

	endif;
	?>

</div><!-- end of #content-archive -->

<?php get_footer(); ?>
