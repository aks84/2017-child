<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<div class="breadcrumb" ><?php get_breadcrumb(); ?></div>
		<main id="main" class="site-main" role="main">

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/post/content', 'single' ); 
				?>

					<!-- // amazon ads section -->
				<?php echo "amazon ads goes here"; ?>
				
				<?php 

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				the_post_navigation( array(
					'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'twentyseventeen' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'twentyseventeen' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
				) );

			endwhile; // End of the loop.
			?>
			<!-- related posts goes here -->
<div class="cross-promo">
			<div class="related_posts">
				<h2>Related Posts</h2>
				<?php
    
    $max_articles = 7;  // How many articles to display
    
    echo '<div id="related-articles" class="sidebox"><ul class="recent_related">';
    
    $cnt = 0;
    
    $article_tags = get_the_tags();
    $tags_string = '';
    if ($article_tags) {
        foreach ($article_tags as $article_tag) {
            $tags_string .= $article_tag->slug . ',';
        }
    }

    $tag_related_posts = get_posts('exclude=' . $post->ID . '&numberposts=' . $max_articles . '&tag=' . $tags_string);
    
    if ($tag_related_posts) {
        foreach ($tag_related_posts as $related_post) {
            $cnt++; 
            echo '<li class="child-' . $cnt . '">';
            echo '<a href="' . get_permalink($related_post->ID) . '">';
            echo $related_post->post_title . '</a></li>';
        }
    }


    // Only if there's not enough tag related articles,
    // we add some from the same category
    
    if ($cnt < $max_articles) {
        
        $article_categories = get_the_category($post->ID);
        $category_string = '';
        foreach($article_categories as $category) { 
            $category_string .= $category->cat_ID . ',';
        }
        
        $cat_related_posts = get_posts('exclude=' . $post->ID . '&numberposts=' . $max_articles . '&category=' . $category_string);
        
        if ($cat_related_posts) {
            foreach ($cat_related_posts as $related_post) {
                $cnt++; 
                if ($cnt > $max_articles) break;
                echo '<li class="child-' . $cnt . '">';
                echo '<a href="' . get_permalink($related_post->ID) . '">';
                echo $related_post->post_title . '</a></li>';
            }
        }
    }
    
    echo '</ul></div>';
     
?>
				

					
			</div>
<div class="recent_posts">
<h2>Recent Posts</h2>
<ul class="recent_related">
<?php
	$args = array( 'numberposts' => '7' );
	$recent_posts = wp_get_recent_posts( $args );
	foreach( $recent_posts as $recent ){
		echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
	}
	wp_reset_query();
?>
</ul>
</div>
</div> 
<!-- Cross promo -->

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
