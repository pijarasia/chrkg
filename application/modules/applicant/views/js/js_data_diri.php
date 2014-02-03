<?php 

?>
    $(document).ready(function() {
        var $validator_datadiri = $("#form_datadiri").validate({
            rules: {
                nama: { required: true },
                jk: { required: true },                
    		    tmptlahir: { required: true},
        	    tanggal: { required: true },
            	bulan: { required: true },
            	tahun: { required: true },
            	no_identitas: { required: true},                
        	    tanggalberlaku: { required: true },
            	bulanberlaku: { required: true },
            	tahunberlaku: { required: true },
    		    statusMarital: { required: true },
                agama: { required: true },
    		    email: { required: true, email: true },              
    		    alternatif_email: { email: true },              
    		    nohp: { required: true, number: true },                    
    		    alternatif_nohp: { number: true },                                  
                tahunberlaku: { greaterThan: "#tahun" },
            },
            errorPlacement: function (error, element) { 
                return false;
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
        $("#simpan_datadiri").click(function() {
            var $valid = $("#form_datadiri").valid();
            if(!$valid) {
                $validator_datadiri.focusInvalid();
                return false;
      		} else {
                if ($("#jkl").is(':checked'))
                    var jk = "L";
                else if ($("#jkp").is(':checked'))
                    var jk = "P";
                    
                var form_data = {
                    nama: $('#nama').val(),
                    jk: jk,
                    tmptlahir: $('#tmptlahir').val(),
                    tanggal: $('#tanggal').val(),
                    bulan: $('#bulan').val(),
                    tahun: $('#tahun').val(),
                    no_identitas: $('#no_identitas').val(),
                    tanggalberlaku: $('#tanggalberlaku').val(),
                    bulanberlaku: $('#bulanberlaku').val(),
                    tahunberlaku: $('#tahunberlaku').val(),
                    statusMarital: $('#statusMarital').val(),
                    agama: $('#agama').val(),
                    email: $('#email').val(),              
                    alternatif_email: $('#alternatif_email').val(),              
                    nohp: $('#nohp').val(),
                    alternatif_nohp: $('#alternatif_nohp').val(),
                	ajax:1
      		    };
                $.ajax({
                    url : "<?php echo base_url(); ?>applicant/addfirst_personal",
                    type : 'POST',
                    data : form_data,
                    async : false,
                    success: function(msg){
                        if (msg == 1)
                        {
                            $('#success_personal').show();
                            $('#error_personal').hide();
                        } else {
                            $('#success_personal').hide();
                            $('#error_personal').show();
                        }
                    }
                });                       
      		}
            return false;
        });
        
        $(".hp").keydown(function(event) {
            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
                (event.keyCode == 65 && event.ctrlKey === true) || 
                (event.keyCode >= 35 && event.keyCode <= 39) || event.keyCode == 187) {
                     return;
            }
            else {
                if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                    event.preventDefault(); 
                }   
            }
        });                                       
    });        
    
    jQuery.validator.addMethod("greaterThan", 
        function(value, element, params) {
        if (!/Invalid|NaN/.test(new Date(value))) {
            return new Date(value) >= new Date($(params).val());
        }
        return isNaN(value) && isNaN($(params).val()) || (Number(value) >= Number($(params).val())); 
    },'Must be greater than {0}.');      