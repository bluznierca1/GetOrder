$(document).ready(function(){
	$('.parallax').parallax();
	$('.button-collapse').sideNav({
		edge: 'left',
	});
	 $('.slider').slider({
	 	height: 150,
	 	width: 150,
	 });
	 $('.button-collapse').sideNav({
	 	closeOnClick: true,
	 });
	 $('.timepicker').pickatime({
	    default: 'now', // Set default time: 'now', '1:30AM', '16:30'
	    fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
	    twelvehour: false, // Use AM/PM or 24-hour format
	    donetext: 'OK', // text for done-button
	    cleartext: 'Clear', // text for clear-button
	    canceltext: 'Cancel', // Text for cancel-button
	    autoclose: false, // automatic close timepicker
	    ampmclickable: true, // make AM PM clickable
	    aftershow: function(){} //Function for after opening timepicker
  	});
	 $('select').material_select();
	 $('#edit-tables-button').click(function() {
	 	if( $('#edit-tables-container').hasClass('edit-tables-form-hidden') ){
	 		$('#edit-tables-container').removeClass('edit-tables-form-hidden');	
	 	} else {
	 		$('#edit-tables-container').addClass('edit-tables-form-hidden');
	 	}
	 	
	 });
});