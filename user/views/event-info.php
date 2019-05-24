
<div class="nebula-event">
<?php
$loop = new WP_Query( array( 'post_type' => 'nebula-event',
        'post__in' => array($atts['id'])     )
            );
    while ( $loop->have_posts() ) : $loop->the_post(); ?>

    <p>
    	<?php
    		$user_side_data->LoadOptions();
            $user_table_data->LoadOptions();

    		?>
            <div class="short-title">
    		<?php the_title('<h3>', '</h3>');
            echo $user_table_data->GetMetaOption('venue_name'); ?>
            </div>
    <?php
    echo $user_side_data->GetMetaOption('event_date') .' - ';
    If (!($user_side_data->GetMetaOption('allday')))
    	{
    	If ($user_side_data->GetMetaOption('no_end'))
    		{
    			echo 'from ' . $user_side_data->GetMetaOption('time_start');
    		}	else
    		{
    			echo $user_side_data->GetMetaOption('time_start') . ' till ' .
    			$user_side_data->GetMetaOption('time_end');
    		}
    	}
     ?>
     <div class="short-image">
        <?php if ($atts['image'] != 'none')
            {
                the_post_thumbnail($atts['image']);
            } ?>
        </div>
    <p></p>
     <?php   endwhile; wp_reset_query();
     ?></div>
