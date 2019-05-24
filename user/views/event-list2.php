
<h2>Events</h2>
<div>
<?php
$loop = new WP_Query( array( 'post_type' => 'nebula-event',
        'posts_per_page' => 100 )
            );
    while ( $loop->have_posts() ) : $loop->the_post(); ?>

    <p>
    	<?php
    		$user_side_data->LoadOptions();
            echo $user_side_data->GetMetaOption('event_date') .' - ';
    		?>
    		<?php the_title(); ?>

    <?php
    If (!($user_side_data->GetMetaOption('allday')))
    	{
    	If ($user_side_data->GetMetaOption('no_end'))
    		{
    			echo '<br/>from ' . $user_side_data->GetMetaOption('time_start');
    		}	else
    		{
    			echo '<br/>' .$user_side_data->GetMetaOption('time_start') . ' till ' .
    			$user_side_data->GetMetaOption('time_end');
    		}
    	}
     ?>
     <p>
     <?php   endwhile; wp_reset_query();
     ?></div>
