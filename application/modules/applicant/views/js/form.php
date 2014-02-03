<?php 

?>
    $(document).ready(function() {
        $('#tabForm a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        })              
        
        $('#jur').hide(); 
        
        var $validator = $("#form_data").validate({
            rules: {
    		    gaji: { required: true, number: true}                
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
            /*showErrors: function(errorMap, errorList) {
                $.each(this.successList, function(index, value) {
                    return $(value).closest('.control-group').removeClass('error').addClass('success');
                });
                return $.each(errorList, function(index, value) {
                    return $(value.element).closest('.control-group').removeClass('success').addClass('error'); 
                });
            } */             
        });        

	  	/*$('#firstwizard').bootstrapWizard({
	  		'tabClass': 'bwizard-steps',
            'onTabClick': function(tab, navigation, index){
                return false;
            },
	  		'onNext': function(tab, navigation, index) {
	  			var $valid = $("#form_data").valid();
                  if(!$valid) {
	  				$validator.focusInvalid();
  					return false;
	  			}
                
                if (index == 2)
                {
                    if ($("#letakd").is(':checked'))
                        var letak = "D";
                    else if ($("#letakb").is(':checked'))
                        var letak = "B";
                                    
                    var form_data = {
                        nama: $('#nama').val(),
                        email: $('#email').val(),              
                        jenjang: $('#jenjang').val(),
                        institusi: $('#institusi').val(),
                        jurusan: $('#jurusan').val(),
                        kota: $('#kota').val(),
                        negara: $('#negara').val(),
                        tahunMasuk: $('#tahunMasuk').val(),
                        tahunLulus: $('#tahunLulus').val(),              
                        nilai: $('#nilai').val(),                
                        no_ijazah: $('#no_ijazah').val(),                
                        lulus: $('#lulus').val(),                
                        gelar: $('#gelar').val(),                
                        letak: letak,                
            			ajax:1
            		};
            		$.ajax({
            			url : "<?php echo base_url(); ?>applicant/addfirst_education",
            			type : 'POST',
            			data : form_data,
            			success: function(msg){
                            //alert(msg)
            			}
            		});           
                    load_course();                       
                }
                else if (index == 3)
                {
                    
                }
                else if (index == 5)
                {
                    var form_data = {
                        nama: $('#nama').val(),
                        email: $('#email').val(),                                              
                        gaji: $('#gaji').val(),
            			ajax:1
            		};
            		$.ajax({
            			url : "<?php echo base_url(); ?>applicant/addother_data",
            			type : 'POST',
            			data : form_data,
            			success: function(msg){
                            //alert(msg)
            			}
            		});                             
                }
            },
            'onTabShow': function(tab, navigation, index) {
          		var $total = navigation.find('li').length;
            	var $current = index+1;
            	var $percent = ($current/$total) * 100;
            	$('#firstwizard').find('.bar').css({width:$percent+'%'});
            		
            	if ($current >= $total) {
                    $('#firstwizard').find('.pager .next').hide();
                    $('#firstwizard').find('.pager .finish').show();
                    $('#firstwizard').find('.pager .finish').removeClass('disabled');
            	} else {
                    $('#firstwizard').find('.pager .next').show();
            		$('#firstwizard').find('.pager .finish').hide();
           		}	
           	}            
	  	});*/          	
	
        $('#jenjang').change(function() {
            if ($('#jenjang').val() == "" || $('#jenjang').val() == "SD" || $('#jenjang').val() == "SLTP" || $('#jenjang').val() == "SLTA")
            {
                $('#jur').hide();   
            } else {
                $('#jur').show();   
            }        
        });       
        
        $("#nilai").keydown(function(event) {
            // Allow: backspace, delete, tab, escape, and enter
            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || event.keyCode == 188 || 
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
        
        $(".gaji").keydown(function(event) {
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
    
    function resizeIframe(obj) {
        alert("TEST");
        obj.style.height = obj.contentWindow.document.body.scrollHeight + 400 +'px';
    }