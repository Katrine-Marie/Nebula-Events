
<h2>Events</h2>
<div>
<?php
$loop = new WP_Query( array( 'post_type' => 'post',
        'posts_per_page' => 100 )
            );
        while ( $loop->have_posts() ) : $loop->the_post(); ?>

    		<?php the_title(); ?><br/>

     <?php   endwhile; wp_reset_query();
     ?></div>
