<?php

?>

var action_acc = function(id,url){
  var $selector = $("#action_acc-" + id),
    $target = $($selector.attr('data-target')),
    $form = $target.find('form').first(),
    $form_data = {
      id: id,
    };
  $target.modal('show');
  $.ajax({
    url : url,
    type : 'POST',
    data : $form_data,
    dataType: 'json',
    beforeSend: function() {
      NProgress.start();
    },
    success: function(d){
      var t = '', dt = {};
      if(d.status == 'success'){
        for (var i = 0; i < d.data.length; i++) {
          dt = d.data[i];
          t += '<p>' + dt.order + '. ' + dt.name + ':' + dt.comment + '</p>';
        }
      }
      $target.find('.modal-body').html(t);
    },
    error: function(){

    },
    complete: function(){
      NProgress.done();
    }
  });
  return false;
}

$(document).ready(function(){
  $("#accModal").find("#save").click(function() {
    var $form = $("#accModal").find("#fform");
    $form_data = {
      form: $form.serializeFormJSON()
    };
    $.ajax({
      url: '<?php echo base_url()."joborder/action_acc" ?>',
      type: 'POST',
      dataType: 'json',
      data: $form_data,
      beforeSend: function(){
        NProgress.start();
      },
      success: function(d){
        $.pnotify({
            title: 'Notification',
            text: d.message,
            type: d.status
        });
      },
      error: function(){

      },
      complete: function(){
        NProgress.done();
        $("#accModal").modal('hide');
      }
    });
    return false;
  });

});