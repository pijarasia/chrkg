<?php 

?>
    $(document).ready(function() {
        var $validator = $("#form_datalain").validate({
            rules: {
                //data diri
                gaji: { required: true },
            },
            errorPlacement: function (error, element) { 
                return false; //Suppress all messages 
            },
            highlight: function (element) { 
                $(element).closest('.control-group').removeClass('success').addClass('error'); 
            },
            unhighlight: function (element) { 
                $(element).closest('.control-group').removeClass('error').addClass('success'); 
            }          
        });
        
        /************
        * Data Diri
        ************/
        $("#simpan_lain").click(function() {
            var $valid = $("#form_datalain").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
      		} else {
                var form_data = {
                    gaji: $('#gaji').val(),
                	ajax:1
      		    };
                $.ajax({
                    url : "<?php echo base_url(); ?>applicant/addother_data",
                    type : 'POST',
                    data : form_data,
                    async : false,
                    success: function(msg){
                        if (msg == 1)
                        {
                            $('#success_other').show();
                            $('#error_other').hide();
                        } else {
                            $('#success_other').hide();
                            $('#error_other').show();
                        }                    
                    }
                });                       
      		}
            return false;
        });
        
        $("#gaji").keydown(function(event) {
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