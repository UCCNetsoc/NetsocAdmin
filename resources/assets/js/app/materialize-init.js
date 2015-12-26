$(document).ready(function(){
	$('.button-collapse').sideNav({'edge': 'left'});
	$('.collapsible').collapsible({
	  accordion : true // A setting that changes the collapsible behavior to expandable instead of the default accordion style
	});
	$('.modal-trigger').leanModal();

	var active_id = location.pathname.substring(location.pathname.lastIndexOf("/") + 1);
	$("#" + active_id).addClass('active red lighten-2');
	$("#" + active_id + " a").addClass('white-text');
});
  