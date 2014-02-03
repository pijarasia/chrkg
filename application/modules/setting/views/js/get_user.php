<?php
?>
var Document = {
  param: {
    dataperpage: 10, // jumlah data per halaman
    query: '',
    curpage: 0,
    numpage: 0,
    skey: '',
    stype: '',
    npage: 0
  },
  url: '<?php echo base_url()."setting/user";?>',
  search: function(n) {
    var $form = $("#sform");
    this.param.query = $form.serializeFormJSON() || '';
    this.param.dataperpage = n || 10;
    this.param.curpage = 0;
    this.loadData();
    return false;
  },
  setPage: function(n) {
    this.param.curpage = n;
    this.loadData();
    return false;
  },
  sort: function(skey,stype) {
    this.param.skey = skey || '_name';
    this.param.stype = stype || 'asc';
    this.loadData();
    return false;
  },
  loadData: function() {
    $.ajax({
      url: Document.url,
      type: 'POST',
      dataType: 'json',
      data: jQuery.param(Document.param),
      beforeSend: function(){
        NProgress.start();
      },
      success: function(d) {
        Document.param.numpage = d.numpage;
        Document.param.npage = d.npage;
        var t = '', dt = {};
        for (var i = 0; i < d.data.length; i++) {
          dt = d.data[i];
          t += '<tr><td>' + dt.name + '</td>' +
              '<td>' + dt.email + '</td>' +
              '<td>' + dt.groups + '</td>' +
              '<td>' + dt.join + '</td>' +
              '<td>' + dt.change + '</td>' +
              '<td>' + dt.level_change + '</td>' +
             '<td>' + dt.action + '</td></tr>';
        }
        $('#document-data').html(t);
        $('#pagination').html(d.pagination)
      },
      complete: function(){
        NProgress.done();
      }
    });
  }
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

var activateG = function(id){
    var form_data = {
      id:id
    };
    $.ajax({
        url : "<?php echo base_url(); ?>setting/user_activate",
        type : 'POST',
        data : form_data,
        dataType: 'json',
        success: function(d){
          $.pnotify({
            title: 'Notification',
            text: d.message,
            type: d.status
          });
        },
        complete: function(){
          Document.search();
        }
    });
    return false;
}

var deactivateG = function(id){
    var form_data = {
      id:id
    };
    $.ajax({
        url : "<?php echo base_url(); ?>setting/user_deactivate",
        type : 'POST',
        data : form_data,
        dataType: json,
        success: function(d){
          $.pnotify({
            title: 'Notification',
            text: d.message,
            type: d.status
          });
        },
        complete: function(){
          Document.search();
        }
    });
    return false;
}

var deleteG = function(id){
    var form_data = {
      id:id
    };
    $.ajax({
        url : "<?php echo base_url(); ?>setting/user_delete",
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
          Document.search();
        }
    });
    return false;
}

var changeP = function(id)
{
    $('#dialog-password').modal('show');
    $('#dialog-password').find('#hidden_id').val(id);
    $("#dialog-password").find('#short').show();
    $("#dialog-password").find('#weak').hide();
    $("#dialog-password").find('#good').hide();
    $("#dialog-password").find('#strong').hide();
    $("#dialog-password").find('#very-strong').hide();
    return false;
}

var changeL = function(id)
{
    $('#dialog-level').modal('show');
    $('#dialog-level').find('#hidden_id').val(id);
    $.ajax({
      url: '<?php echo base_url()."setting/user_modal_change_level_init"?>',
      type: 'POST',
      dataType: 'json',
      data: {'id': id},
      beforeSend: function(){
        $("#dialog-level").find("#fform").find("#level-form").html('Waiting ....');
      },
      success: function(t) {
        $("#dialog-level").find("#fform").find("#level-form").html(t.translate);
      }
    });
    return false;
}

var editG = function(id,js)
{
    var obj=JSON.parse(js);
    $('#dialog').modal('show');
    $('#dialog').find('#hidden_id').val(id);
    $('#dialog').find('#user_id').val(obj.id);
    $('#dialog').find('#name').val(obj.name);
    $('#dialog').find('#refname').val(obj.refname);
    return false;
}

var checkStrength = function(password, $parent){
  var strength = 0
  //if the password length is less than 6, return message.
  if (password.length < 6) {
      $parent.find('#short').show();
      $parent.find('#weak').hide();
      $parent.find('#good').hide();
      $parent.find('#strong').hide();
      $parent.find('#very-strong').hide();
  }

  //if length is 8 characters or more, increase strength value
  if (password.length > 7)
      strength += 1
  //if password contains both lower and uppercase characters, increase strength value
  if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))
      strength += 1
  //if it has numbers and characters, increase strength value
  if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))
      strength += 1
  //if it has one special character, increase strength value
  if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))
      strength += 1
  //if it has two special characters, increase strength value
  if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,",%,&,@,#,$,^,*,?,_,~])/))
      strength += 1
  if (password.length >= 6 && strength < 2 ) {
      $parent.find('#short').hide();
      $parent.find('#weak').show();
      $parent.find('#good').hide();
      $parent.find('#strong').hide();
      $parent.find('#very-strong').hide();
  } else if (password.length >= 6 && strength == 2 ) {
      $parent.find('#short').hide();
      $parent.find('#weak').hide();
      $parent.find('#good').show();
      $parent.find('#strong').hide();
      $parent.find('#very-strong').hide();
  } else if (password.length > 8 && strength > 2 ) {
      $parent.find('#short').hide();
      $parent.find('#weak').hide();
      $parent.find('#good').hide();
      $parent.find('#strong').hide();
      $parent.find('#very-strong').show();
  } else if (password.length >= 6 && strength > 2 ) {
      $parent.find('#short').hide();
      $parent.find('#weak').hide();
      $parent.find('#good').hide();
      $parent.find('#strong').show();
      $parent.find('#very-strong').hide();
  }
}

var level_init = function(){
  $("#dialog-level").find("#fform").find("#level-form").on('click','a', function(e){
    var jqEl = $(e.currentTarget);
    var tag = jqEl.parent().parent();
    switch (jqEl.attr("data-action")) {
      case "add":
          tag.after(tag.clone().find("input").val("").end());
          break;
      case "remove":
          tag.remove();
          break;
      }
    return false;
  });
};

$(document).ready(function() {
  var $validator = $("#dialog").find("#fform").validate({
      rules: {
        full_name: { required: true },
        mobile_phone: { required: true }
      },
      messages:{
        required: "field is required"
      },
      // errorPlacement: function (error, element) {
      //     return false; //Suppress all messages
      // },
      highlight: function (element) {
          $(element).closest('.control-user').removeClass('success').addClass('error');
      },
      unhighlight: function (element) {
          $(element).closest('.control-user').removeClass('error').addClass('success');
      }
  });

  var $validator_add = $("#dialog-add").find("#fform").validate({
      rules: {
        full_name: { required: true },
        email: { required: true, email: true },
        mobile_phone: { required: true },
        password: { required: true, minlength: 6 },
          confirm_password: { required: true,
                              equalTo: "#password"
          },
      },
      messages:{
        required: "field is required",
        email: {
          email: "field is not valid email"
        },
        confirm_password: {
          equalTo: "password do not match"
        }
      },
      // errorPlacement: function (error, element) {
      //     return false; //Suppress all messages
      // },
      highlight: function (element) {
          $(element).closest('.control-user').removeClass('success').addClass('error');
      },
      unhighlight: function (element) {
          $(element).closest('.control-user').removeClass('error').addClass('success');
      },
      showErrors: function(errorMap, errorList) {
        $.each(this.successList, function(index, value) {
            if ($(value).attr("id") == "email" || $(value).attr("id") == "confirm_password")
                $(value).popover("hide");

            return $(value).closest('.control-group').removeClass('error').addClass('success');
        });
        return $.each(errorList, function(index, value) {
            if ((($(value.element).attr("id") == "email") && value.message != "This field is required.") || ($(value.element).attr("id") == "confirm_password" && value.message != "This field is required.")) {
                var _popover;
                    _popover = $(value.element).popover({
                    trigger: "manual",
                    placement: "right",
                    content: value.message,
                    template: "<div class=\"popover\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content\"><p></p></div></div></div>"
                });
                _popover.data("popover").options.content = value.message;
                $(value.element).popover("show");
            }
            return $(value.element).closest('.control-group').removeClass('success').addClass('error');
        });
      }
  });

  var $validator_password = $("#dialog-password").find("#fform").validate({
      rules: {
        old_password: { required: true, minlength: 6 },
        password: { required: true, minlength: 6 },
          confirm_password: { required: true,
                              equalTo: "#password"
          },
      },
      messages:{
        confirm_password: {
          equalTo: "password do not match"
        }
      },
      // errorPlacement: function (error, element) {
      //     return false; //Suppress all messages
      // },
      highlight: function (element) {
          $(element).closest('.control-user').removeClass('success').addClass('error');
      },
      unhighlight: function (element) {
          $(element).closest('.control-user').removeClass('error').addClass('success');
      },
      showErrors: function(errorMap, errorList) {
        $.each(this.successList, function(index, value) {
            if ($(value).attr("id") == "email" || $(value).attr("id") == "confirm_password")
                $(value).popover("hide");

            return $(value).closest('.control-group').removeClass('error').addClass('success');
        });
        return $.each(errorList, function(index, value) {
            if ((($(value.element).attr("id") == "email") && value.message != "This field is required.") || ($(value.element).attr("id") == "confirm_password" && value.message != "This field is required.")) {
                var _popover;
                    _popover = $(value.element).popover({
                    trigger: "manual",
                    placement: "right",
                    content: value.message,
                    template: "<div class=\"popover\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content\"><p></p></div></div></div>"
                });
                _popover.data("popover").options.content = value.message;
                $(value.element).popover("show");
            }
            return $(value.element).closest('.control-group').removeClass('success').addClass('error');
        });
      }
  });

  $("#add").click(function(){
    $("#dialog-add").find('#fform').resetFormCustom();
    $("#dialog-add").find('#short').show();
    $("#dialog-add").find('#weak').hide();
    $("#dialog-add").find('#good').hide();
    $("#dialog-add").find('#strong').hide();
    $("#dialog-add").find('#very-strong').hide();
  });

  $("#dialog").find("#save").click(function() {
    var $form = $("#dialog").find("#fform");
    var $valid = $form.valid();
    if(!$valid) {
        $validator.focusInvalid();
        return false;
		} else {
      $.ajax({
        url: '<?php echo base_url()."setting/user_modal" ?>',
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
          Document.search();
        }
      });
 		}
    return false;
  });

  $("#dialog-add").find("#save").click(function() {
    var $form = $("#dialog-add").find("#fform");
    var $valid = $form.valid();
    if(!$valid) {
        $validator_add.focusInvalid();
        return false;
    } else {
      $.ajax({
        url: '<?php echo base_url()."setting/user_modal_add" ?>',
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
          $("#dialog-add").modal('hide');
          NProgress.done();
          Document.search();
        }
      });
    }
    return false;
  });

  $("#dialog-password").find("#save").click(function() {
    var $form = $("#dialog-password").find("#fform");
    var $valid = $form.valid();
    if(!$valid) {
        $validator_password.focusInvalid();
        return false;
    } else {
      $.ajax({
        url: '<?php echo base_url()."setting/user_modal_change_password" ?>',
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
          $("#dialog-password").modal('hide');
          NProgress.done();
          Document.search();
        }
      });
    }
    return false;
  });

  $("#dialog-level").find("#save").click(function() {
    var $form = $("#dialog-level").find("#fform");
    var $valid = $form.valid();
    if(!$valid) {
        $validator_level.focusInvalid();
        return false;
    } else {
      $.ajax({
        url: '<?php echo base_url()."setting/user_modal_change_level" ?>',
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
          $("#dialog-level").modal('hide');
          NProgress.done();
          Document.search();
        }
      });
    }
    return false;
  });

  level_init();

  $("#dialog-add").find('#password').on("keyup", function(){
      checkStrength($("#dialog-add").find('#password').val(), $("#dialog-add"));
  });
  $("#dialog-password").find('#password').on("keyup", function(){
      checkStrength($("#dialog-password").find('#password').val(),$("#dialog-password"));
  });
  $(".hp").keydown(function(event) {
      // Allow: backspace, delete, tab, escape, and enter
      if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
         // Allow: Ctrl+A
        (event.keyCode == 65 && event.ctrlKey === true) ||
         // Allow: home, end, left, right
        (event.keyCode >= 35 && event.keyCode <= 39)) {
             // let it happen, don't do anything
             return;
      }
      else {
        // Ensure that it is a number and stop the keypress
        if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            event.preventDefault();
        }
      }
    });


});
