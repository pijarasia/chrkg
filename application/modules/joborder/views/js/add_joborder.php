<?php

?>

$(document).ready(function(){
  // Validator
  var $a_validator = $("#a_form").validate({
    rules: {
        title: { required: true },
        ba: { required: true },
        company: { required: true },
        owner: { required: true },
        country: { required: true },
        province: { required: true },
        address: { required: true },
        city: { required: true },
        zipcode: { required: true },
    },
    errorPlacement: function (error, element) {
        return false; //Suppress all messages
    },
    highlight: function (element) {
        $(element).closest('.control-group').removeClass('success').addClass('error');
    },
    unhighlight: function (element) {
        $(element).closest('.control-group').removeClass('error').addClass('success');
    },
    showErrors: function(errorMap, errorList) {
        $.each(this.successList, function(index, value) {
            return $(value).closest('.control-group').removeClass('error').addClass('success');
        });
        return $.each(errorList, function(index, value) {
            return $(value.element).closest('.control-group').removeClass('success').addClass('error');
        });
    }
  });
  // Select Event
  $('#ba').change(function(){
    url = "<?php echo base_url(); ?>joborder/select_ba";
    $target = $("#company");
    selectAjax(url,$(this),$target);
  });

  // Submit Ajax
  $('#a_form').submit(function() {
    var $valid = $("#a_form").valid();
    if(!$valid) {
      $d_validator.focusInvalid();
      return false;
    }else {
      var $form = $("#a_form");
      form_data = $form.serializeFormJSON() || '';
      url = "<?php echo base_url(); ?>joborder/add";
      ajaxValidation(url,form_data);
    }
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

var ajaxValidation = function(url, form_data) {
  $.ajax({
    url : url,
    type : 'POST',
    dataType: 'json',
    data : form_data,
    beforeSend: function(){
      NProgress.start();
    },
    success: function(d){
      $.pnotify({
          title: 'Notification',
          text: d.message,
          type: d.status
        });
      if(d.id != null){
        window.location.href="<?php echo base_url(); ?>joborder/form/"+d.id;
      }else{
        return false;
      }
    },
    error: function(){

    },
    complete: function(){
      NProgress.done();
    }
  });
};


var selectAjax = function(url,$sel,$target){
  var txt = $sel.val();
  console.log($target);
  $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data : { 'id':txt},
      beforeSend: function(){
        NProgress.start();
      },
      success: function(data) {
        $target.children().remove();
        $('<option />').attr('value','').html('Please select ...').appendTo($target);
        for (var i=0;i<data.length;i++){
          $('<option />').attr('value',data[i].id).html(data[i].name).appendTo($target);
        }
      },
      error: function(){
      },
      complete: function(){
        NProgress.done();
      }
  });
}