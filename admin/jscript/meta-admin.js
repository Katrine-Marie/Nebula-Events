jQuery(document).ready(function () {
  jQuery( "#event_datepicker" ).datepicker({ minDate: -20, maxDate: "+1M +10D", dateFormat: "d MM, yy",
      altField: "#date_sort",       altFormat: "yy/mm/dd"});
  jQuery('#event_start').timepicker();
  jQuery('#event_end').timepicker();

  } );
// the alternative approach would be to make this fields become hidden?
jQuery(document).ready(function () {
 function allday_options () {

      if (jQuery( "#allday" ).is(':checked'))
     {
         jQuery(".times").addClass("hide");
     } else {
         jQuery(".times").removeClass("hide");
          no_end_options ();    // akkday could undo our setting so reset
     }
  }
  jQuery( "#allday" ).on( "click", function() {
     allday_options ();

    } );
  allday_options ();

 function no_end_options () {

      if (jQuery( "#no_end" ).is(':checked'))
     {
         jQuery(".endtime").addClass("hide");
     } else {
         jQuery(".endtime").removeClass("hide");
     }
  }
  jQuery( "#no_end" ).on( "click", function() {
     no_end_options ();
    } );
  no_end_options ();
} );

// setup accordiatn on
jQuery( function() {
  jQuery( ".accordion" ).accordion();
} );



// for the locaiton section
jQuery(document).ready(function () {
  function location_set() {
      if (jQuery( "#location_plysical" ).is(':checked'))
     {
         jQuery("#location").addClass("hide");
     } else {
         jQuery("#location").removeClass("hide");
     }
  }
  location_set();
  jQuery( "#location_plysical" ).on( "click", function() {
       // jQuery( "#location_plysical" ).is(':checked').addClass("hide");
       location_set();
      });

      

  function organiser_set() {
      if (jQuery( "#organiser_show" ).is(':checked'))
     {
         jQuery("#organiser").addClass("hide");
     } else {
         jQuery("#organiser").removeClass("hide");
     }
 }
  organiser_set();
  jQuery( "#organiser_show" ).on( "click", function() {
       // jQuery( "#location_plysical" ).is(':checked').addClass("hide");
       organiser_set();
      });



});
