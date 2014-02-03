<?php
	$total = ceil($total / 10);
?>
$(document).ready(function(){
	var bsSort = [],
    	lastSort;

	// Init Ajax Show Table
	<?php
		if($one){
			echo 'Document.search(1);';
		}elseif($two){

		}else{
			echo 'Document.search(10);';
		}
	?>

	// Sort
	$(document).on('click', 'table.sortable thead th', function (e) {
		var $this = $(this), $table = $this.parents('table.sortable');

		// update arrow icon
		if ($.browser.mozilla) {
			var moz_arrow = $table.find('div.mozilla');
			if (moz_arrow != null) {
				moz_arrow.parent().html(moz_arrow.text());
			}
			$this.wrapInner('<div class="mozilla"></div>');
			$this.children().eq(0).append('<span class="arrow"></span>');
		}
		else {
			$table.find('span.arrow').remove();
			$this.append('<span class="arrow"></span>');
		}

		// sort direction
		var nr = $this.attr('data-sortkey');
		var k = $this.attr('data-key');
		lastSort = nr;

		bsSort[nr] = bsSort[nr] == 'asc' ? 'desc' : 'asc';
		if (bsSort[nr] == 'asc') { $this.find('span.arrow').addClass('up'); }

		// sort rows
		if(k != 'control'){ Document.sort(k,bsSort[nr]); }
	});

	// jQuery 1.9 removed this object
	if (!$.browser) {
		$.browser = { chrome: false, mozilla: false, opera: false, msie: false, safari: false };
		var ua = navigator.userAgent;
		$.each($.browser, function (c, a) {
			$.browser[c] = ((new RegExp(c, 'i').test(ua))) ? true : false;
			if ($.browser.mozilla && c == 'mozilla') { $.browser.mozilla = ((new RegExp('firefox', 'i').test(ua))) ? true : false; };
			if ($.browser.chrome && c == 'safari') { $.browser.safari = false; };
		});
	};

	// Select All
	$('#idall').click(function() {
	    var checkboxes = $(this).closest('form').find(':checkbox');
        if($(this).prop('checked')) {
          checkboxes.prop('checked', true);
        } else {
          checkboxes.prop('checked', false);
        }
	});

	//
	$('.collapse').collapse({
    	toggle: false
	});

	$('#pagination').on('click', '.page_test a', function(e) {
	  e.preventDefault();
	  var link = $(this).attr("data-page")-1;
	  Document.setPage(link);
	  return false;
	});

	$.each($(".my-nav"), function(){
		var nav = '<?php echo $navigation?>'
		$("#" + this.id).removeClass('active');
		if (this.id == nav) {
			$("#" + this.id).addClass('active');
		};
	});

	//Box widget Head Buttons
	$('.box-widget-head .btn.btn-mini').on("click",function(){
		var cls = $(this).find('i')[0].className; //Get classname of icon in button
		//Based on classname determine the task to be executed
		console.log(cls=='icon-chevron-up');
		if( cls === 'icon-chevron-up' ){
			var bb = $(this).parent().parent().parent()[0],
				bbody = $(bb).find('.box-widget-body')[0],
				bfooter = $(bb).find('.box-widget-footer')[0];

			bb.classList.add('box-widget-hide');

			$(bbody).slideUp(300);
			$(bfooter).hide();
		}
		if ( cls == 'icon-chevron-down' ){
			var bb = $(this).parent().parent().parent()[0],
				bbody = $(bb).find('.box-widget-body')[0],
				bfooter = $(bb).find('.box-widget-footer')[0];
			bb.classList.remove('box-widget-hide');

			$(bbody).slideDown(300);
			$(bfooter).show();
		}
		if( cls == 'icon-remove' ){
			var bb = $(this).parent().parent().parent()[0];
			$(bb).fadeOut();
		}
	});


	/* Widget close */

	$('.wclose').click(function(e){
	  e.preventDefault();
	  var $wbox = $(this).parent().parent().parent();
	  $wbox.hide(100);
	});

	/* Widget minimize */

	  $('.wminimize').click(function(e){
	    e.preventDefault();
	    var $wcontent = $(this).parent().parent().next('.widget-content');
	    if($wcontent.is(':visible'))
	    {
	      $(this).children('i').removeClass('icon-chevron-up');
	      $(this).children('i').addClass('icon-chevron-down');
	    }
	    else
	    {
	      $(this).children('i').removeClass('icon-chevron-down');
	      $(this).children('i').addClass('icon-chevron-up');
	    }
	    $wcontent.toggle(500);
	  });
});