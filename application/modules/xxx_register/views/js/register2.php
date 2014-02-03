<?php 

?>
    $(document).ready(function() {
        $('#info_password').hide();
        
        $('#password').on("keyup", function(){
            checkStrength($('#password').val());            
            $('#info_password').show();
        });        
        
        /*$('#recaptcha_response_field').on("keyup", function(){
            $("#errorCaptcha").html("");
        });*/       
        
        $('#captcha').on("keyup", function(){
            $("#errorCaptcha").html("");
        });                
        
        //"^(62|0)8(11|12|13|14|15|16|17|18|19|21|28|31|32|38|52|55|56|57|58|59|77|78|81|82|87|88|96|97|98|99)[0-9]{7,8}$";
        //@"^(\+62|0){1}8(11|12|13|52|53|21|14|15|16|55|56|57|58|17|18|19|59|77|78|31|32|38|28|81|82|87|88|96|97|98|99){1}(\d){6,8}$"
        
        
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
        
        $("#refresh").click(function() {                                          
            var form_data = {
            	ajax:1
  		    };  
              
            $.ajax({
                url : "<?php echo base_url(); ?>register/refresh",
                type : 'POST',
                data : form_data,
                success: function(msg){
                    $("#refresh-captcha").html(msg);
                }
            });
            return false;                    
        });
        
        var $validator = $("#form_register").validate({
            rules: {
                //data diri
                nama: { required: true },
            	email: { required: true, email: true },              
            	//alternatif_email: { email: true },              
            	no_hp: { required: true },
            	no_identitas: { required: true},                
            	password: { required: true, minlength: 6 },
                confirm_password: { required: true,
                                    equalTo: "#password"
                },
            	captcha: { required: true }   
                //recaptcha_response_field: { required: true }
            },
            messages:{
                required: "<?=lang('val_required')?>",
                email: {
                    email: "<?=lang('val_email')?>"
                },
                alternatif_email: {
                    email: "<?=lang('val_email')?>"
                },
                confirm_password: {
                    equalTo: "<?=lang('val_equalPassword')?>"
                }
            },
            /*errorPlacement: function (error, element) { 
                return false; //Suppress messages
            },
            highlight: function (element) { 
                $(element).closest('.control-group').removeClass('success').addClass('error'); 
            },
            unhighlight: function (element) { 
                $(element).closest('.control-group').removeClass('error').addClass('success'); 
            },*/
            showErrors: function(errorMap, errorList) {
                $.each(this.successList, function(index, value) {
                    //|| $(value).attr("id") == "alternatif_email"
                    if ($(value).attr("id") == "email" || $(value).attr("id") == "confirm_password")
                        $(value).popover("hide");
                    
                    return $(value).closest('.control-group').removeClass('error').addClass('success');
                });
                return $.each(errorList, function(index, value) {
                    //|| $(value.element).attr("id") == "alternatif_email")
                    if ((($(value.element).attr("id") == "email" || $(value.element).attr("id") == "alternatif_email") && value.message != "This field is required.") || ($(value.element).attr("id") == "confirm_password" && value.message != "This field is required.")) {
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
   
        $("#simpan").click(function() {
            if ($('#subscribe').is(':checked'))
                subscribe = true;
            else
                subscribe = false;
                                          
            var form_data = {
                nama: $('#nama').val(),
                email: $('#email').val(),              
                alternatif_email: $('#alternatif_email').val(),              
                no_hp: $('#no_hp').val(),              
                alternatif_no_hp: $('#alternatif_no_hp').val(),              
                no_identitas: $('#no_identitas').val(),                
                password: $('#password').val(),
                subscribe: subscribe,
            	ajax:1
  		    };
            
            /*var form_captcha= {
                recaptcha_challenge_field: $('#recaptcha_challenge_field').val(),
                recaptcha_response_field: $('#recaptcha_response_field').val(),
            	ajax:1
  		    };*/   
            var form_captcha= {
                captcha: $('#captcha').val(),
            	ajax:1
  		    };                           
            var valid = $("#form_register").valid();
            if(!valid)
            {
                $validator.focusInvalid(); 
            } else {    
                $.ajax({
                    url : "<?php echo base_url(); ?>register/error_captcha",
                    type : 'POST',
                    data : form_captcha,
                    success: function(msg){
                        if (msg == "success")
                        {
                            $.ajax({
                                url : "<?php echo base_url(); ?>register/register_applicant",
                                type : 'POST',
                                data : form_data,
                                async: false,
                                success: function(msg){
                                    $("#form_register").hide();
                                    $("#ket_registrasi").hide();
                                    $("#message").html(msg);
                                }
                            });
                        }
                        else
                            $("#errorCaptcha").html(msg);
                    }
                });
                return false;
            }            
        });           
    }); 
    
    function checkStrength(password){
        var strength = 0
        //if the password length is less than 6, return message.
        if (password.length < 6) {
            $('#short').show();
            $('#weak').hide();
            $('#good').hide();
            $('#strong').hide();
            $('#very-strong').hide();
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
            $('#short').hide();
            $('#weak').show();
            $('#good').hide();
            $('#strong').hide();
            $('#very-strong').hide();            
        } else if (password.length >= 6 && strength == 2 ) {
            $('#short').hide();
            $('#weak').hide();
            $('#good').show();
            $('#strong').hide();
            $('#very-strong').hide();                    
        } else if (password.length > 8 && strength > 2 ) {
            $('#short').hide();
            $('#weak').hide();
            $('#good').hide();
            $('#strong').hide();
            $('#very-strong').show();             
        } else if (password.length >= 6 && strength > 2 ) {
            $('#short').hide();
            $('#weak').hide();
            $('#good').hide();
            $('#strong').show();
            $('#very-strong').hide();                                   
        }
    } 