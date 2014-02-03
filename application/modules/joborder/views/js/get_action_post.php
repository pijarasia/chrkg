$(document).ready(function() {
  var $validator_prev = $("#prevModal").find("#fform").validate({
      rules: {
        action: { required: true },
      },
      messages:{
        required: "field is required"
      },
      highlight: function (element) {
          $(element).closest('.control-user').removeClass('success').addClass('error');
      },
      unhighlight: function (element) {
          $(element).closest('.control-user').removeClass('error').addClass('success');
      }
  });

  var $validator_next = $("#nextModal").find("#fform").validate({
    rules: {
      process_title: { required: true },
      process_body: { required: true },
      from_date: { required: true},
      from_month: { required: true},
      from_year: { required: true},
      process_place: { required: true}
    },
    messages:{
      required: "field is required"
    },
    highlight: function (element) {
        $(element).closest('.control-user').removeClass('success').addClass('error');
    },
    unhighlight: function (element) {
        $(element).closest('.control-user').removeClass('error').addClass('success');
    }
  });

  $("#prevModal").find("#fform").find("#action").change(function(){
    var action = $("#prevModal").find("#fform").find("#action").val();
    if(action == 'email'){
      $("#prevModal").find('#from_date').parent().parent().show();
      $("#prevModal").find('#from_hour').parent().parent().show();
      $("#prevModal").find('#email').parent().parent().show();
      $("#prevModal").find('#process_place').parent().parent().show();
      $("#prevModal").find('#process_subject').parent().parent().show();
      $("#prevModal").find('#process_body').parent().parent().show();

      $("#prevModal").find('#process_comment').parent().parent().hide();
      $("#prevModal").find("#star-rate").parent().parent().hide();
    }else if(action == 'process'){
      $("#prevModal").find('#process_comment').parent().parent().show();
      $("#prevModal").find("#star-rate").parent().parent().show();
      $("#prevModal").find('#from_date').parent().parent().hide();
      $("#prevModal").find('#from_hour').parent().parent().hide();
      $("#prevModal").find('#process_place').parent().parent().hide();
      $("#prevModal").find('#process_subject').parent().parent().hide();
      $("#prevModal").find('#process_body').parent().parent().hide();
      $("#prevModal").find('#email').parent().parent().hide();
    }else{
      $("#prevModal").find('#process_comment').parent().parent().hide();
      $("#prevModal").find("#star-rate").parent().parent().hide();
      $("#prevModal").find('#from_date').parent().parent().hide();
      $("#prevModal").find('#from_hour').parent().parent().hide();
      $("#prevModal").find('#process_place').parent().parent().hide();
      $("#prevModal").find('#process_subject').parent().parent().hide();
      $("#prevModal").find('#process_body').parent().parent().hide();
      $("#prevModal").find('#email').parent().parent().hide();
    }
  });


  $("#prevModal").find("#fform").find("#email").change(function(){
      var template = $(this).val();
      $.ajax({
        url: '<?php echo base_url()."joborder/action_template" ?>',
        type: 'POST',
        dataType: 'json',
        data: {'email_id' : template},
        beforeSend: function(){
          NProgress.start();
          $("#prevModal").find("#fform").find("#process_subject").val();
          $("#prevModal").find("#fform").find("#process_body").html();
        },
        success: function(d){
          $("#prevModal").find("#fform").find("#process_subject").val(d.subject);
          $("#prevModal").find("#fform").find("#process_body").html(d.content);
        },
        error: function(){

        },
        complete: function(){
          NProgress.done();
        }
      });
    return false;
  });

  $("#prevModal").find("#save").click(function() {
    var $form = $("#prevModal").find("#fform");
    var $valid = $form.valid();
    $form_data = {
      action: 'process',
      id: '',
      jobid: '',
      body: $("#prevModal").find("#fform").find("#process_body").html(),
      form: $form.serializeFormJSON()
    };
      if(!$valid) {
          $validator_prev.focusInvalid();
          return false;
      } else {
        $.ajax({
          url: '<?php echo base_url()."joborder/action_prev" ?>',
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
            $("#prevModal").modal('hide');
            Document.search();
          }
        });
      }
      return false;
    });

  $("#nextModal").find("#save").click(function() {
    var $form = $("#nextModal").find("#fform");
    var $valid = $form.valid();
    $form_data = {
      id: '',
      jobid: '',
      body: $("#nextModal").find("#fform").find("#process_body").html(),
      action: 'process',
      form: $form.serializeFormJSON()
    };
      if(!$valid) {
          $validator_prev.focusInvalid();
          return false;
      } else {
        $.ajax({
          url: '<?php echo base_url()."joborder/action_next" ?>',
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
            $("#nextModal").modal('hide');
            Document.search();
          }
        });
      }
      return false;
    });
  $("#nextModal").find("#fform").find("#email").change(function(){
      var template = $(this).val();
      $.ajax({
        url: '<?php echo base_url()."joborder/action_template" ?>',
        type: 'POST',
        dataType: 'json',
        data: {'email_id' : template},
        beforeSend: function(){
          NProgress.start();
          $("#nextModal").find("#fform").find("#process_subject").val();
          $("#nextModal").find("#fform").find("#process_body").html();
        },
        success: function(d){
          $("#nextModal").find("#fform").find("#process_subject").val(d.subject);
          $("#nextModal").find("#fform").find("#process_body").html(d.content);
        },
        error: function(){

        },
        complete: function(){
          NProgress.done();
        }
      });
    return false;
  });

  $("#stopModal").find("#save").click(function() {
    var $form = $("#stopModal").find("#fform");
    var $valid = $form.valid();
    $form_data = {
      action: 'process',
      id: '',
      jobid: '',
      form: $form.serializeFormJSON()
    };
      if(!$valid) {
          $validator_prev.focusInvalid();
          return false;
      } else {
        $.ajax({
          url: '<?php echo base_url()."joborder/action_stop" ?>',
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
            $("#stopModal").modal('hide');
            Document.search();
          }
        });
      }
      return false;
    });

  $("#deleteModal").find("#save").click(function() {
    var $form = $("#deleteModal").find("#fform");
    var $valid = $form.valid();
    $form_data = {
      action: 'process',
      id: '',
      jobid: '',
      form: $form.serializeFormJSON()
    };
      if(!$valid) {
          $validator_prev.focusInvalid();
          return false;
      } else {
        $.ajax({
          url: '<?php echo base_url()."joborder/action_delete" ?>',
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
            if (d.message == success) {
              $("#deleteModal").modal('hide');
            }
          },
          error: function(){

          },
          complete: function(){
            NProgress.done();
            $("#deleteModal").modal('hide');
            Document.search();
          }
        });
      }
      return false;
    });
  $.fn.raty.defaults.path = '<?php echo img_path();?>images/raty';
    $.each($('.star-rate'), function() {
      $("#star-rate").raty({
        score: function() {
          return $(this).attr('data-score');
        },
        click: function(score, evt) {
            var p_app_id = $(this).attr('data-apply');
        }
      });
    });
  $("#prevModal").find("#fform").find("#process_body").wysiwyg();
  $("#nextModal").find("#fform").find("#process_body").wysiwyg();
  $("#prevModal").find("#fform").find("#process_body").cleanHtml();
  $("#nextModal").find("#fform").find("#process_body").cleanHtml();
});