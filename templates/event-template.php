<?php

namespace nebula\events;

$template_table_data = new custom_meta_data('meta-array-options','apcdem_','meta');
$template_side_data = new custom_meta_data('meta-side-options','apcdem_','meta');
$template_data_options = new custom_meta_data('nebula-events-options','apcev_','options');


get_header();
?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

    <p>
    	<?php
    		$template_side_data->LoadOptions();
            $template_table_data->LoadOptions();

    		?>
            <div class="short-title">
    		<?php the_title('<h1>', '</h1>'); ?>

            </div>
    <?php
    echo $template_side_data->GetMetaOption('event_date') .' - ';
    If (!($template_side_data->GetMetaOption('allday')))
    	{
    	If ($template_side_data->GetMetaOption('no_end'))
    		{
    			echo 'from ' . $template_side_data->GetMetaOption('time_start');
    		}	else
    		{
    			echo $template_side_data->GetMetaOption('time_start') . ' till ' .
    			$template_side_data->GetMetaOption('time_end');
    		}
    	}
     ?>
    <p>


        <div>
            <div id="log"></div>
            <?php
            if (!$template_table_data->GetMetaOption("location_plysical"))
            {
            ?>
            <div id="location">
            <h3><?php echo $template_table_data->GetMetaOption('venue_name'); ?></h3>
            <br/><label for="venue_address">Address</label>
            <?php echo $template_table_data->GetMetaOption('venue_address'); ?>
            <br/><?php echo $template_table_data->GetMetaOption('venue_town'); ?>
            <br/><?php echo $template_table_data->GetMetaOption('venue_postcode'); ?>
            <br/><label for="venue_phone">Contact Number</label><?php echo $template_table_data->GetMetaOption('venue_phone'); ?>
            <br/><a href="<?php echo $template_table_data->GetMetaOption('venue_web_site'); ?>"><?php echo $template_table_data->GetMetaOption('venue_web_site');
            }
            ?>
        </div>
    </div>
<p>This is a custom template that you can change.  </p>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
