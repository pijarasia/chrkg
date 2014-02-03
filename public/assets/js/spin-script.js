var spinner;
 
function FireSpinner() {
	var opts = {
  		lines: 12, // The number of lines to draw
		length: 12, // The length of each line
		width: 7, // The line thickness
		radius: 23, // The radius of the inner circle
		color: '#fff', // #rgb or #rrggbb
		speed: 1, // Rounds per second
		trail: 60, // Afterglow percentage
		shadow: true, // Whether to render a shadow
		hwaccel: false // Whether to use hardware acceleration
		},
		target = document.getElementById('loading');
	$('#loading').fadeIn();
	spinner = new Spinner(opts).spin(target);
}
 
// Ajax loader calls spinner
$('body').ajaxStop(function() {
	$('#loading').fadeOut();
	spinner.stop();
}).ajaxError(function(e, jqxhr, settings, exception) {
	console.log('An error occurer with the last ajax request. Exception:' + exception);
	$('#loading').fadeOut();
	spinner.stop();
});