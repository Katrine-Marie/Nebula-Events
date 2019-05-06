<?php
/*
 * @since 0.10
 * Content for the options
 *
 */
?>




<div class="wrap admin-page nebula-options" >

    <h1 class="title"><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <form method="post" action="<?php echo esc_html(admin_url('admin-post.php')); ?>">




        <!-- <label for="user-checkbox" class="regular-number">Checkbox: </label>
        <input type="checkbox" name="user-checkbox" value="1" <?php // echo $this->GetCheckbox('user-checkbox'); ?> >
        <br/> -->
        <!-- <label for="plugin-serial" class="regular-number">Serial Code: </label>
        <input type="text" name="plugin-serial" value="<?php // echo $this->GetOption('plugin-serial'); ?>" >
<br/> -->
         <label for="single-layout">Single Page</label><select name="single-layout">
         <!-- <option <?php // echo $this->GetSelected('single-layout', 'shortcode'); ?> value="shortcode" >Shortcode</option> -->
         <option <?php echo $this->GetSelected('single-layout', 'template1'); ?> value="template1" >Simple Template</option>
         <option <?php echo $this->GetSelected('single-layout', 'content1'); ?> value="content1" >Replace Content Template</option>
         </select>



        <input type="hidden" name="action" value="<?php echo $this->myaction; ?>">
        <input type="hidden" name="version" value="<?php echo $this->GetOption('version'); ?>">
        <?php
            wp_nonce_field( $this->mynonce, $this->nonce_field );
            submit_button();
        ?>
    </form>

    <h5><a href="index.php?page=nebula-event-about">Return to the Welcome Page</a></h5>

</div>
