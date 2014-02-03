$(document).ready(function(){
	Document.refresh();

	$.each($(".my-nav"), function(){
		var nav = '<?php echo $navigation?>'
		$("#" + this.id).removeClass('active');
		if (this.id == nav) {
			$("#" + this.id).addClass('active');
		};
	});

	$.each($(".brea-nav"), function(){
		var bnav = '<?php echo $brea_nav;?>';
		$("#" + this.id).parent().removeClass('active');
		if (this.id == bnav) {
			$("#" + this.id).parent().addClass('active');
		};
	});
});