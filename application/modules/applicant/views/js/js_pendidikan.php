<?php 

?>
    $(document).ready(function() {
        load_education();
        var $validator = $("#form_datapendidikan").validate({
            rules: {
                jenjang: { required: true },
    		    institusi: { required: true},
    		    jurusan: { required: true},
    		    kota: { required: true },
                negara: { required: true },
    		    tahunMasuk: { required: true },
    		    tahunLulus: { required: true }, 
                tahunLulus: { greaterThan: "#tahunMasuk" },     
    		    nilai: { required: true },
    		    no_ijazah: { required: true}                              
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
        * pendidikan
        ************/
        $("#simpan_pendidikan").click(function() {
            var $valid = $("#form_datapendidikan").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
      		} else {
				if ($("#letakd").is(':checked'))
					var letak = "D";
				else if ($("#letakb").is(':checked'))
					var letak = "B";
                                    
				var form_data = {
                    id: $('#hiddenIDPendidikan').val(),	          
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
                    last: false,          
					ajax:1
				};
				$.ajax({
					url : "<?php echo base_url(); ?>applicant/add_education",
					type : 'POST',
					data : form_data,
					success: function(msg){
                        if (msg == 1)
                        {
                            $('#success_education').html("Data berhasil disimpan.");
                            $('#success_education').show();
                            $('#hiddenIDPendidikan').val("");
                            $('#jenjang').val("");
                            $('#institusi').val("")
                            $('#jurusan').val("");   
                            $('#kota').val("");
                            $('#negara').val("");
                            $('#tahunMasuk').val("");
                            $('#tahunLulus').val("");
                            $('#nilai').val("");
                            $('#no_ijazah').val("");                        
                            $('#lulus').val("");
                            $('#gelar').val("");                        
                        } else {
                            $('#success_education').html("Data gagal sdisimpan.");
                            $('#error_education').show();
                        }
                        $('#dialog-pendidikan').modal('hide');
                        load_education();
					}
				});           
      		}       
            return false;
        });  
        
        $("#hapus_pendidikan").click(function() {
            var form_data = {
                id: $('#hidden_del_pendidikan').val(),
                ajax:1
      		}
            $.ajax({
                url : "<?php echo base_url(); ?>applicant/delete_education",
                type : 'POST',
                data : form_data,
                success: function(msg){
                    if (msg == 1)
                    {
                        $('#success_education').html("Data berhasil dihapus.");
                        $('#success_education').show();
                    } else {
                        $('#error_education').html("Data gagal dihapus.");                
                        $('#success_education').show();                    
                    }
                    $('#dialog-delete-education').modal('hide');
                    load_education();
                    /*alert(msg);*/
           	    }
            });
            return false;
        });             
        
        $(".close").click(function() { 
            $('#success_education').hide();
            $('#error_education').hide();
        });
		
        $('#jenjang').change(function() {
            if ($('#jenjang').val() == "" || $('#jenjang').val() == "SD" || $('#jenjang').val() == "SLTP" || $('#jenjang').val() == "SLTA")
            {
                $('#jur').hide();   
            } else {
                $('#jur').show();   
            }        
        });       
        
        $("#nilai").keydown(function(event) {
            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || event.keyCode == 188 || 
                (event.keyCode == 65 && event.ctrlKey === true) || 
                (event.keyCode >= 35 && event.keyCode <= 39)) {
                     return;
            }
            else {
                if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                    event.preventDefault(); 
                }   
            }
        });    		
    });  
    
    function educationEdit(id)
    {
        var form_data = {
            id: id,
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/view_education",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#hiddenIDPendidikan').val(id);
                $('#res').html(msg);
       	    }
        });
        $('#success_education').hide();
        $('#error_education').hide();
        $('#dialog-pendidikan').modal('show');
        return false;        
    }

    function educationDelete(id, level, jurusan, institusi)
    {
        $('#hidden_del_pendidikan').val(id);
        $('#body-delete-education').html("Hapus data pendidikan "+level+" "+jurusan+" di "+institusi+" ?");
    }
    
    function load_education()
    {
        var form_data = {
            email: $('#email').val(),   
            no_identitas: $('#no_identitas').val(),   
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/load_education",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#tbleducation').html(msg);
                
                var form_data = {
                    ajax:1
          		}
                $.ajax({
                    url : "<?php echo base_url(); ?>applicant/load_add_education",
                    type : 'POST',
                    data : form_data,
                    success: function(msg){
                        $('#loadButtonEducation').html(msg);
               	    }
                });                
       	    }
        });
        return false;           
    } 
    
    jQuery.validator.addMethod("greaterThan", 
        function(value, element, params) {
        if (!/Invalid|NaN/.test(new Date(value))) {
            return new Date(value) >= new Date($(params).val());
        }
        return isNaN(value) && isNaN($(params).val()) || (Number(value) >= Number($(params).val())); 
    },'Must be greater than {0}.');    