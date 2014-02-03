<?php

?>
var Document = {
  url: '<?php echo base_url()."setting/locations";?>',
  refresh: function() {
    this.loadData();
    return false;
  },
  loadData: function() {
    $.ajax({
      url: Document.url,
      type: 'POST',
      dataType: 'json',
      beforeSend: function() {
        NProgress.start();
      },
      success: function(d) {
        var t = '', str = '', values = {} , dt = {};
        str = "<div class='accordion-group'><div class='accordion-heading'><a class='accordion-toggle' data-toggle='collapse' data-parent='#document-data' data-target='#collapse{{id}}' id='#collapse{{id}}'><i class='icon-money'></i> {{name}} </a></div><div class='default accordion-body'><div class='accordion-inner'><div class='row'><div class='span12 setting-span'><div class='span4'><p>Address</p><p>{{kota}}</p><p>{{provinsi}} {{negara}}</p></div> \
        <div class='span4'><p>Users</p><p>Internal staff: 37</p><p>Agency Staff: 0</p><p>Candidate Source: 3</p></div> \
        <div class='span4'><p>Jobs: </p><p>Total: 0</p><p>Active: 0</p></div></div></div></div></div> \
        <div id='collapse{{id}}' class='accordion-body collapse'><div class='accordion-inner'><div class='row'><div class='span12 setting-span'><div class='pull-right fixed-left'>{{action}}</div><div class='span6'><p><label class='small-label' >Change in requistion will require new approval process<input type='checkbox'></label></p><p><i class='icon-building'></i> Verticals</p><p>{{verticals}}</p><p><i class='icon-globe'></i> Locations</p><p>{{locations}}</p></div><div class='span5'><p><i class='icon-male'></i> Users</p><p>Signatories:6</p><p>{{users}}</p></div></div></div></div></div></div>";
        for (var i=0; i < d.data.length; i++){
          dt = d.data[i];
          values = {'name': dt.name, 'id': dt.id, 'action': dt.action};
          t += S(str).template(values).s;
        }
        $('#document-data').html(t);
      },
      error: function() {

      },
      complete: function(){
        NProgress.done();
        var $togglers = $('[data-toggle="collapse"]');
        $togglers.each(function() {
            var $this = $(this);
            var $collapsible = $($this.data('target'));
            $collapsible.on('hidden', function() {
                $collapsible.parent().find('.default').show();
            }).on('shown', function() {
                $collapsible.parent().find('.default').hide();
            });
        });
      }
    });
  },
}

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

var deleteG = function(id){
  var form_data = {
    id:id
  };
  $.ajax({
      url : "<?php echo base_url(); ?>setting/locations_delete",
      type : 'POST',
      data : form_data,
      success: function(d){
        $.pnotify({
          title: 'Notification',
          text: d.message,
          type: d.status
        });
      },
      complete: function(){
        Document.refresh();
      }
  });
  return false;
}

var editG = function(id,js)
{
  var obj=JSON.parse(js);
  $('#dialog').modal('show');
  $('#dialog').find('#hidden_id').val(id);
  $('#dialog').find('#name').val(obj.name);
  return false;
}

$(document).ready(function() {
  var $validator = $("#fform").validate({
    rules: {
        name: { required: true },
    },
    errorPlacement: function (error, element) {
        //return false; //Suppress all messages
    },
    highlight: function (element) {
        $(element).closest('.control-group').removeClass('success').addClass('error');
    },
    unhighlight: function (element) {
        $(element).closest('.control-group').removeClass('error').addClass('success');
    }
  });
  $("#add").click(function(){
    $('#fform').resetFormCustom();
  });

  $("#save").click(function() {
    var $form = $("#fform");
    var $valid = $form.valid();
    if(!$valid) {
        $validator.focusInvalid();
        return false;
    } else {
      $.ajax({
        url: '<?php echo base_url()."setting/locations_form" ?>',
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
        },
        error: function(){

        },
        complete: function(){
          $("#dialog").modal('hide');
          NProgress.done();
          Document.refresh();
        }
      });
    }
    return false;
  });
});
