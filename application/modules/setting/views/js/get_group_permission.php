<?php 

?>
$(document).ready(function(){
	// Select All
	$('#idall').click(function() {
	    var checkboxes = $(this).closest('form').find(':checkbox');
        if($(this).prop('checked')) {
          checkboxes.prop('checked', true);
        } else {
          checkboxes.prop('checked', false);
        }
	});

	$("#save").click(function() {
	    var $form = $("#fform");
        $.ajax({
          url: '<?php echo base_url()."setting/group_permission" ?>',
          type: 'POST',
          dataType: 'json',
          data: $form.serializeFormJSON(),
          beforeSend: function(){
            NProgress.start();
          },
          success: function(d){
            $.pnotify({
                title: 'Notification',
                text: d.message,
                type: d.status
            });
            location.href = d.redirect;
          },
          error: function(){

          },
          complete: function(){
            NProgress.done();
          }
        });
      return false;
    });
    $.each($(".my-nav"), function(){
      var nav = '<?php echo $navigation?>';
      $("#" + this.id).removeClass('active');
      if (this.id == nav) {
        $("#" + this.id).addClass('active');
      };
    });
});


$.fn.serializeFormJSON = function() {
   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {
       if (o[this.name]) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   return o;
};

$.fn.resetFormCustom = function()
{
    var $form = $(this);

    $form.find('input:text, input:hidden, input:password, input:file, textarea').val('');
    $form.find('select option:selected').removeAttr('selected');
    $form.find('input:checkbox, input:radio').removeAttr('checked');

    return this;
};