<?php

namespace nebula\events;
global $post;

echo get_post_type_archive_link('nebula-event');

$my_table_data = new custom_meta_data('meta-array-options','apcdem_','meta');
$my_side_data = new custom_meta_data('meta-side-options','apcdem_','meta');
$my_data_options = new custom_meta_data('nebula-events-options','apcev_','options');
$my_table_data->LoadOptions();
$my_side_data->LoadOptions();

?>

<div id="event-title" class="event-title">
    <h2><?php echo get_the_title(); ?></h2>
<h3><?php echo $my_side_data->GetMetaOption('event_date') . ' From '. $my_side_data->GetMetaOption('time_start'). ' to '.$my_side_data->GetMetaOption('time_end');?>
<?php
// check for location, display if exists
if ( $my_table_data->GetMetaOption('location_plysical')  != 1 ) {
    ?>
    <br/>@ <a href='#event-location'><?php echo $my_table_data->GetMetaOption('venue_name'); ?></a>
<?php
}
?>
</h3>


</div>
<?php
// TODO: featured image
// the_post_thumbnail( 'medium', array( 'class' => 'event-thumb' ) );
?>
<div class="event-content">

<h3>Event Information</h3>
<?php echo $content; ?>

<?php
if ( $my_table_data->GetMetaOption('location_plysical')  != 1 ) {
    ?>
<div id="event-location" class='event-location'>
    <h3>Event Location:</h3>
    <p><?php echo $my_table_data->GetMetaOption('venue_name');?>
        <br/><?php echo $my_table_data->GetMetaOption('venue_address'); ?>
        <br/><?php echo $my_table_data->GetMetaOption('venue_town'). ' '.$my_table_data->GetMetaOption('venue_postcode'); ?>
        <br/><a href="<?php echo $my_table_data->GetMetaOption('venue_web_site'); ?>"><?php echo $my_table_data->GetMetaOption('venue_web_site'); ?></a></p>
    <?php echo $my_table_data->GetMetaOption('venue_map'); ?>
</div>
<?php
}
// end of event locaiton information
?>
<?php
if ( $my_table_data->GetMetaOption('organiser_show')  == 0 ) {
    ?>
<div class='event-organiser'>
    <h3>Event Organiser:</h3>
    <p><?php echo $my_table_data->ShowOption('organiser'); ?>
        <?php echo $my_table_data->ShowOption('organiser_company'); ?>
        <?php echo $my_table_data->ShowOption('organiser_address'); ?>
        <?php echo $my_table_data->ShowOption('organiser_town'). ' '.$my_table_data->ShowOption('organiser_Number'); ?>
        <?php if ($my_table_data->Optionhasvalue('organiser_Web')) { ?>
        <a href="<?php echo $my_table_data->GetMetaOption('organiser_Web'); ?>"><?php echo $my_table_data->GetMetaOption('organiser_Web'); ?></a></p>
        <?php } ?>
</div>
<?php
}
?>


</div>
