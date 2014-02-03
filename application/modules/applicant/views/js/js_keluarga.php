<?php 

?>
    $(document).ready(function() {
        load_family();
        $('#jkl').prop('checked', true);
        var $validator = $("#form_datakeluarga").validate({
            rules: {
                hubungan: { required: true },
    		    namaKeluarga: { required: true},
    		    jk: { required: true},
    		    tmptlahir: { required: true},
        	    tanggal: { required: true },
            	bulan: { required: true },
            	tahun: { required: true },
                pendidikan: { required: true },
    		    pekerjaan: { required: true }
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
        
        $("#simpan_keluarga").click(function() {
            var $valid = $("#form_datakeluarga").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
      		} else {
                if ($("#jkl").is(':checked'))
                    var jk = "L";
                else if ($("#jkp").is(':checked'))
                    var jk = "P";
                                    
				var form_data = {
                    id: $('#hiddenIDKeluarga').val(),				    
					hubungan: $('#hubungan').val(),
					namaKeluarga: $('#namaKeluarga').val(),
					jk: jk,
					tmptlahir: $('#tmptlahir').val(),
					tanggal: $('#tanggal').val(),
					bulan: $('#bulan').val(),
					tahun: $('#tahun').val(),              
					pendidikan: $('#pendidikan').val(),                
					pekerjaan: $('#pekerjaan').val(),
					ajax:1
				};
				$.ajax({
					url : "<?php echo base_url(); ?>applicant/add_family",
					type : 'POST',
					data : form_data,
					success: function(msg){
                        if (msg == 1)
                        {
                            $('#hiddenIDKeluarga').val("");
                            $('#hubungan').val("");
                            $('#namaKeluarga').val("")
                            $('#jkl').prop('checked', true);
                            $('#tmptlahir').val("");   
                            $('#tanggal').val("");
                            $('#bulan').val("");
                            $('#tahun').val("");
                            $('#pendidikan').val("");
                            $('#pekerjaan').val("");                            
                            $('#success_family').show();
                        } else
                            $('#error_family').show();
                        $('#dialog-keluarga').modal('hide');
                        load_family();
					}
				});           
      		}       
            return false;
        });  
        
        $("#hapus_keluarga").click(function() {
            var form_data = {
                id: $('#hidden_del_keluarga').val(),
                ajax:1
      		}
            $.ajax({
                url : "<?php echo base_url(); ?>applicant/delete_family",
                type : 'POST',
                data : form_data,
                success: function(msg){
                    if (msg == 1)
                    {
                        $('#success_family').html("Data berhasil dihapus.");
                        $('#success_family').show();
                    } else {
                        $('#error_family').html("Data gagal dihapus.");                
                        $('#success_family').show();                    
                    }
                    $('#dialog-delete-family').modal('hide');
                    load_family();
           	    }
            });
            return false;
        });             
        
        $(".close").click(function() { 
            $('#success_family').hide();
            $('#error_family').hide();
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
    
    function familyEdit(id)
    {
        var form_data = {
            id: id,
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/view_family",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#hiddenIDKeluarga').val(id);
                if(msg != 1)
                    $('#res').html(msg);
       	    }
        });
        $('#success_family').hide();
        $('#error_family').hide();
        $('#dialog-keluarga').modal('show');
        return false;        
    }

    function familyDelete(id, relasi, nama)
    {
        $('#hidden_del_keluarga').val(id);
        $('#body-delete-family').html("Hapus data keluarga "+relasi+" "+nama+" "+" ?");
    }
    
    function load_family()
    {
        var form_data = {
            email: $('#email').val(),   
            no_identitas: $('#no_identitas').val(),   
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/load_family",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#tblfamily').html(msg);
       	    }
        });
        return false;           
    }     
	