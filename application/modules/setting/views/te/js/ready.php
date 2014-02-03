<?php
	$total = ceil($total / 10);
?>


$(document).ready(function(){
    $.each($(".my-nav"), function(){
        var nav = '<?php echo $navigation?>';
        $("#" + this.id).removeClass('active');
        if (this.id == nav) {
            $("#" + this.id).addClass('active');
        };
        console.log(nav);
    });  
    
    var bsSort = [],
    	lastSort;

	// Init Ajax Show Table
	Document.search(10);
	
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
	
	$('#pagination').bootpag({
          total: <?php echo $total;?>,
          maxVisible: 10,
        }).on("page", function(event, num){
             Document.setPage(num-1);
             return false;
        });
        
    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
      } else {
        $('#voiceBtn').hide();
      }
	};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings();  
	$('#editor').wysiwyg();
    window.prettyPrint && prettyPrint();          
});
