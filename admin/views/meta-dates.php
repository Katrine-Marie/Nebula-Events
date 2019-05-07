<div class="nebula-dates">
  <label for="event_datepicker">Date: </label>
  <input type="text" id="event_datepicker" name="event_date" value="<?php echo $this->GetMetaOption('event_date');?>">
  @<input type="text" class="times time" name="time_start" id="event_start" value="<?php echo $this->GetMetaOption('time_start');?>"><div style="display: inline-block;" class="times endtime"> till
  <input type="text" class="times endtime time" name="time_end" id="event_end" value="<?php echo $this->GetMetaOption('time_end');?>"></div>
<br /><input type="checkbox" name="allday" class="allday" id="allday" value=1 <?php echo $this->GetMetaCheckbox('allday');?>/><label for="allday">All Day Event</label> <br/>
 <input type="checkbox" name="no_end" class="times" id="no_end" value=1 <?php echo $this->GetMetaCheckbox('no_end');?> /><label for="no_end" class="times">No End Time</label>
  <input type="hidden" name="date_sort" id="date_sort"  value="<?php echo $this->GetMetaOption('date_sort');?>">
</div>
