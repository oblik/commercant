<?php
get_header(); ?>

<div id="content">

<?php
$custom_terms = get_terms('cat_commercant');

foreach($custom_terms as $custom_term) {
    wp_reset_query();
    $args = array('post_type' => 'commercant',
        'tax_query' => array(
            array(
                'taxonomy' => 'cat_commercant',
                'field' => 'slug',
                'terms' => $custom_term->slug,
            ),
        ),
     );

     $loop = new WP_Query($args);
     if($loop->have_posts()) {
		$commercant_tax_bgcolor = get_tax_meta($custom_term->term_id,'commercant_tax_color');
		echo '<div class="commercant-tax-category" >';
		echo '<div class="commercant-tax-category-inner" >';
		if (!empty($commercant_tax_bgcolor)) {
			echo '<div class="commercant-tax-category-inner-title" style="background-color:' . $commercant_tax_bgcolor . '">';
		} else { 
			echo '<div class="commercant-tax-category-inner-title" >';		
		}
			echo '<div class="commercant-tax-category-count">' . $loop->post_count . '</div>';
			echo '<h2>'.$custom_term->name.'</h2>';			
			echo '</div>';
			echo term_description($custom_term->term_id,'cat_commercant'); 			
			echo '<ul>';
			while($loop->have_posts()) : $loop->the_post();
				echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
			endwhile;
			echo '</ul>';
			echo '</div>';
		echo '</div>';
     }
}
?>	



</div><!-- end of #content -->

<?php get_footer(); ?>
