<?php

?>

$(document).ready(function(){
  // Validator
  var $d_validator = $("#d_form").validate({
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
  var $dc_validator = $("#dc_form").validate({
    rules: {
        jobid: { required: true },
        description: { required: true },
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
  var $s_validator = $("#s_form").validate({
    rules: {
        type: { required: true },
        step: { required: true },
        status: { required: true }
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
  var $r_validator = $("#r_form").validate({
    rules: {
        opening: { required: true },
        from_date: { required: true },
        from_month: { required: true },
        from_year: { required: true },
        to_date: { required: true },
        to_month: { required: true },
        to_year: { required: true },
        minedu: { required: true }
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
  var $o_validator = $("#o_form").validate({
    rules: {
        exsalarymax: { required: true }
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
  // Wizard
  $('#rootwizard').bootstrapWizard({
		'tabClass': 'bwizard-steps',
		'onTabClick': function(tab, navigation, index){
          return false;
      },
		'onNext': function(tab, navigation, index) {
      if (index == 1){
        var $valid = $("#d_form").valid();
        if(!$valid) {
          $d_validator.focusInvalid();
          return false;
        }else {
        	var $form = $("#d_form");
			    form_data = $form.serializeFormJSON() || '';
          url = "<?php echo base_url(); ?>joborder/form_wizard1/<?php echo $jin;?>";
          if (wizardAjaxValidation(url,form_data) == 0){ return false;}
        }
      }else if (index == 2){
        var $valid = $("#dc_form").valid();
        if(!$valid) {
          $d_validator.focusInvalid();
          return false;
        }else {
          var $form = $("#dc_form");
          form_data = $form.serializeFormJSON() || '';
          url = "<?php echo base_url(); ?>joborder/form_wizard2/<?php echo $jin;?>";
          if (wizardAjaxValidation(url,form_data) == 0){ return false;}
        }
      }
      else if (index == 3){
        var $valid = $("#r_form").valid();
        if(!$valid) {
          $d_validator.focusInvalid();
          return false;
        }else {
          var $form = $("#r_form");
          form_data = $form.serializeFormJSON() || '';
          url = "<?php echo base_url(); ?>joborder/form_wizard3/<?php echo $jin;?>";
          if (wizardAjaxValidation(url,form_data) == 0){ return false;}
        }
      }
      else if (index == 4){
        var $valid = $("#s_form").valid();
        if(!$valid) {
          $d_validator.focusInvalid();
          return false;
        }else {
          var $form = $("#s_form");
          form_data = $form.serializeFormJSON() || '';
          url = "<?php echo base_url(); ?>joborder/form_wizard4/<?php echo $jin;?>";
          if (wizardAjaxValidation(url,form_data) == 0){ return false;}
        }
      }
		},
    'onTabShow': function(tab, navigation, index) {
  		var $total = navigation.find('li').length;
    	var $current = index+1;
    	var $percent = ($current/$total) * 100;
    	$('#rootwizard').find('.bar').css({width:$percent+'%'});

    	if ($current >= $total) {
            $('#rootwizard').find('.pager .next').hide();
            $('#rootwizard').find('.pager .finish').show();
            $('#rootwizard').find('.pager .finish').removeClass('disabled');
    	} else {
            $('#rootwizard').find('.pager .next').show();
    		$('#rootwizard').find('.pager .finish').hide();
   		}
   	}
	});
  $('#rootwizard .finish').click(function() {
    var $valid = $("#o_form").valid();
      if(!$valid) {
        $d_validator.focusInvalid();
        return false;
      }else {
        var $form = $("#o_form");
        form_data = $form.serializeFormJSON() || '';
        url = "<?php echo base_url(); ?>joborder/form_wizard5/<?php echo $jin;?>";
        if (wizardAjaxValidation(url,form_data) == 0){
          return false;
        }else{
          window.location.href="<?php echo base_url(); ?>joborder";
        }
      }
  });

  // Extetended Form
	// $('.selectpicker').selectpicker();
	$('.tokenfield').tokenfield();

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


var wizardAjaxValidation = function(url, form_data) {
  flag  = 0;
  $.ajax({
    url : url,
    type : 'POST',
    dataType: 'json',
    data : form_data,
    async : false,
    beforeSend: function(){
      NProgress.start();
    },
    success: function(d){
      $.pnotify({
          title: 'Notification',
          text: d.message,
          type: d.status
        });
      if(d.status == 'success'){
        flag = 1;
      }
    },
    error: function(){

    },
    complete: function(){
      NProgress.done();
    }
  });
  return flag;
};