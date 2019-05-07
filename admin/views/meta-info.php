<?php namespace nebula\events; ?>

<div class="nebula-options">

    <div id="accordion" class="accordion">
        <h3>Location</h3>

        <div>
            <div id="log"></div>
            <input type="checkbox" name="location_plysical" id="location_plysical" value="1" <?php echo $this->GetMetaRadio("location_plysical", "1"); ?> /><label>Event does not have a physical location</label>
            <div id="location">
            <br/><label for="venue_name">Venue name</label><input type="text" name="venue_name" id="venue_name" value="<?php echo $this->GetMetaOption('venue_name'); ?>"/>
            <br/><label for="venue_address">Address</label><input type="text" name="venue_address" id="venue_address" value="<?php echo $this->GetMetaOption('venue_address'); ?>"/>
            <br/><label for="venue_town">Town</label><input type="text" name="venue_town" id="venue_town" value="<?php echo $this->GetMetaOption('venue_town'); ?>"/>
            <br/><label for="venue_postcode">Postcode</label><input type="text" name="venue_postcode" id="venue_postcode" value="<?php echo $this->GetMetaOption('venue_postcode'); ?>"/>
            <br/><label for="venue_phone">Contact Number</label><input type="text" name="venue_phone" id="venue_phone" value="<?php echo $this->GetMetaOption('venue_phone'); ?>"/>
            <br/><label for="venue_web_site">Website</label><input type="text" name="venue_web_site" id="venue_web_site" value="<?php echo $this->GetMetaOption('venue_web_site'); ?>"/>
            <br/><label for="venue_map">Google Map Code</label><textarea name="venue_map" id="map" rows="5" cols="40"><?php echo $this->GetMetaOption('venue_map'); ?></textarea>
          </div>
        </div>

        <h3>Organiser Information</h3>
        <div>
            <input type="checkbox" name="organiser_show" id="organiser_show" value="1" <?php echo $this->GetMetaRadio("organiser_show", "1"); ?> /><label>Do not display Organiser Information</label>
            <div id="organiser"><p>Empty fields will be omitted.</p>
            <label for="organiser">Name</label><input type="text" name="organiser" id="organiser" value="<?php echo $this->GetMetaOption('organiser'); ?>"/>
            <br/><label for="organiser_company">Company</label><input type="text" name="organiser_company" id="organiser" value="<?php echo $this->GetMetaOption('organiser_company'); ?>"/>
            <br/><label for="organiser_address">Address</label><input type="text" name="organiser_address" id="organiser_address" value="<?php echo $this->GetMetaOption('organiser_address'); ?>"/>
            <br/><label for="organiser_town">Town</label><input type="text" name="organiser_town" id="organiser_town" value="<?php echo $this->GetMetaOption('organiser_town'); ?>"/>
            <br/><label for="organiser_Email">Email</label><input type="text" name="organiser_Email" id="organiser_Email" value="<?php echo $this->GetMetaOption('organiser_Email'); ?>"/>
            <br/><label for="organiser_Number">Contact Number</label><input type="text" name="organiser_Number" id="organiser_Number" value="<?php echo $this->GetMetaOption('organiser_Number'); ?>"/>
            <br/><label for="organiser_Web">Web Site</label><input type="text" name="organiser_Web" id="organiser_Web" value="<?php echo $this->GetMetaOption('organiser_Web'); ?>"/>
            </div>
        </div>

        <?php
          do_action('nebula_action');
        ?>
    </div>
</div>
