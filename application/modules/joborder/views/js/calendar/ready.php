<?php
	$total = ceil($total / 10);
?>
$(document).ready(function(){

	options = {
		events_source: '<?php echo base_url()."joborder/calendar"?>',
		view: 'month',
		tmpl_path: '<?php echo js_path()?>tmpls/',
		holidays: {
			'08-03': 'International Women\'s Day',
			'25-12': 'Christmas\'s',
			'01-05': "International labor day"
		},
		first_day: 2,
		onAfterEventsLoad: function(events) {
			if(!events) {
				return;
			}
		},
		onAfterViewLoad: function(view) {
			$('.page-header h3').text(this.getTitle());
			$('.btn-group button').removeClass('active');
			$('button[data-calendar-view="' + view + '"]').addClass('active');
		},
		classes: {
			months: {
				general: 'label'
			}
		}
	};

	calendar = $('#calendar').calendar(options);

	$('.btn-group button[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
		});
	});

	$('.btn-group button[data-calendar-view]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.view($this.data('calendar-view'));
		});
	});

	$.each($(".my-nav"), function(){
		var nav = '<?php echo $navigation?>';
		$("#" + this.id).removeClass('active');
		if (this.id == nav) {
			$("#" + this.id).addClass('active');
		};
	});

});


