<?php 

?>
    $(document).ready(function() {
        $('#writingp').prop('checked', true);
        $('#speakingp').prop('checked', true);
        $('#readingp').prop('checked', true);
        $('#understandingp').prop('checked', true);

        load_language();
        $('#jkl').prop('checked', true);
        var $validator = $("#form_databahasa").validate({
            rules: {
                bahasa: { required: true },
    		    writing: { required: true},
    		    understanding: { required: true},
    		    speaking: { required: true},
        	    reading: { required: true },
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
        * bahasa
        ************/
        $("#simpan_bahasa").click(function() {
            var $valid = $("#form_databahasa").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
      		} else {
                if ($("#writingp").is(':checked'))
                    var writing = "P";
                else if ($("#writingf").is(':checked'))
                    var writing = "F";
                else if ($("#writingg").is(':checked'))
                    var writing = "G";
                else if ($("#writinge").is(':checked'))
                    var writing = "E";
                                    
                if ($("#understandingp").is(':checked'))
                    var understanding = "P";
                else if ($("#understandingf").is(':checked'))
                    var understanding = "F";
                else if ($("#understandingg").is(':checked'))
                    var understanding = "G";
                else if ($("#understandinge").is(':checked'))
                    var understanding = "E";

                if ($("#speakingp").is(':checked'))
                    var speaking = "P";
                else if ($("#speakingf").is(':checked'))
                    var speaking = "F";
                else if ($("#speakingg").is(':checked'))
                    var speaking = "G";
                else if ($("#speakinge").is(':checked'))
                    var speaking = "E";

                if ($("#readingp").is(':checked'))
                    var reading = "P";
                else if ($("#readingf").is(':checked'))
                    var reading = "F";
                else if ($("#readingg").is(':checked'))
                    var reading = "G";
                else if ($("#readinge").is(':checked'))
                    var reading = "E";

                //alert($('#nama').val()+" "+$('#email').val()+" "+$('#bahasa').val()+" "+writing+" "+understanding+" "+speaking+" "+reading);

				var form_data = {
                    id: $('#hiddenIDBahasa').val(),				    
					bahasa: $('#bahasa').val(),
					writing: writing,
					understanding: understanding,
					speaking: speaking,
					reading: reading,
					ajax:1
				};
				$.ajax({
					url : "<?php echo base_url(); ?>applicant/add_language",
					type : 'POST',
					data : form_data,
					success: function(msg){
                        if (msg == 1)
                        {
                            $('#success_language').html("Data berhasil disimpan.");
                            $('#success_language').show();
                            $('#hiddenIDBahasa').val("");
                            $('#bahasa').val("");
                            $('#writingp').prop('checked', true);
                            $('#speakingp').prop('checked', true);
                            $('#readingp').prop('checked', true);
                            $('#understandingp').prop('checked', true);
                        } else {
                            $('#error_language').html("Data gagal disimpan.");
                            $('#error_language').show();
                        }
                        $('#dialog-bahasa').modal('hide');
                        load_language();
					}
				});           
      		}       
            return false;
        });  
        
        $("#hapus_bahasa").click(function() {
            var form_data = {
                id: $('#hidden_del_bahasa').val(),
                ajax:1
      		}
            $.ajax({
                url : "<?php echo base_url(); ?>applicant/delete_language",
                type : 'POST',
                data : form_data,
                success: function(msg){
                    if (msg == 1)
                    {
                        $('#success_language').html("Data berhasil dihapus.");
                        $('#success_language').show();
                    } else {
                        $('#error_language').html("Data gagal dihapus.");                
                        $('#success_language').show();                    
                    }
                    $('#dialog-delete-language').modal('hide');
                    load_language();
                    //alert(msg);
           	    }
            });
            return false;
        });             
        
        $(".close").click(function() { 
            $('#success_language').hide();
            $('#error_language').hide();
        });		
    });      	
    
    function languageEdit(id)
    {
        var form_data = {
            id: id,
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/view_language",
            type : 'POST',
            data : form_data,
            success: function(msg){
                //alert(msg);
                $('#hiddenIDBahasa').val(id);
                $('#res').html(msg);
       	    }
        });
        $('#success_language').hide();
        $('#error_language').hide();
        $('#dialog-bahasa').modal('show');
        return false;        
    }

    function languageDelete(id, bahasa)
    {
        $('#hidden_del_bahasa').val(id);
        $('#body-delete-language').html("Hapus data bahasa "+bahasa+" ?");
    }
    
    function load_language()
    {
        var form_data = {
            email: $('#email').val(),   
            no_identitas: $('#no_identitas').val(),   
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/load_language",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#tbllanguage').html(msg);
                
                var form_data = {
                    ajax:1
          		}
                $.ajax({
                    url : "<?php echo base_url(); ?>applicant/load_add_language",
                    type : 'POST',
                    data : form_data,
                    success: function(msg){
                        $('#loadButtonLanguage').html(msg);
               	    }
                });                
       	    }
        });
        return false;           
    }     
	