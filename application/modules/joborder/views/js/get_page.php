var action_delete = function(id,url){
  var $selector = $("#action_note-" + id),
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

$.fn.resetFormCustom = function()
{
  var $form = $(this);

  $form.find('input:text, input:hidden, input:password, input:file, textarea').val('');
  $form.find('select option:selected').removeAttr('selected');
  $form.find('input:checkbox, input:radio').removeAttr('checked');

  return this;
};


$( function() {
    $("button[data-href]").click( function() {
        location.href = $(this).attr("data-href");
    });
});