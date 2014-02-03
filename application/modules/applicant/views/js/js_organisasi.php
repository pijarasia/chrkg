<?php 

?>
    $(document).ready(function() {
        load_organization();
        var $validator = $("#form_dataorganisasi").validate({
            rules: {
                organisasi: { required: true },
    		    bidang: { required: true},
    		    tahun_masuk: { required: true},
    		    tahun_lulus: { required: true},
                tahun_lulus: { greaterThan: "#tahun_masuk" },                  
    		    kota_organisasi: { required: true },
    		    posisi: { required: true}                                 
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
        * Organisasi
        ************/
        $("#simpan_organisasi").click(function() {
            var $valid = $("#form_dataorganisasi").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
      		} else {
                var form_data = {
                    id: $('#hiddenIDOrganisasi').val(),
                    organisasi: $('#organisasi').val(),
                    bidang: $('#bidang').val(),
                    tahun_masuk: $('#tahun_masuk').val(),
                    tahun_lulus: $('#tahun_lulus').val(),
                    kota_organisasi: $('#kota_organisasi').val(),
                    posisi: $('#posisi').val(),     
            		ajax:1
          		};
            	$.ajax({
                    url : "<?php echo base_url(); ?>applicant/add_organization",
                    type : 'POST',
                    data : form_data,
                    success: function(msg){
                        if (msg == 1)
                        {
                            $('#success_organization').show();
                            $('#hiddenIDOrgaisasi').val("");
                            $('#organisasi').val("");
                            $('#bidang').val("")
                            $('#tahun_masuk').val("");   
                            $('#tahun_lulus').val("");
                            $('#kota_organisasi').val("");
                            $('#posisi').val("");                     
                        } else
                            $('#error_organization').show();
                        $('#dialog-organisasi').modal('hide');
                        load_organization();
                    }
           		});
      		}       
            return false;
        });  
        
        $("#hapus_organisasi").click(function() {
            var form_data = {
                id: $('#hidden_del_organisasi').val(),
                ajax:1
      		}
            $.ajax({
                url : "<?php echo base_url(); ?>applicant/delete_organization",
                type : 'POST',
                data : form_data,
                success: function(msg){
                    if (msg == 1)
                    {
                        $('#success_organization').html("Data berhasil dihapus.");
                        $('#success_organization').show();
                    } else {
                        $('#error_organization').html("Data gagal dihapus.");                
                        $('#success_organization').show();                    
                    }
                    $('#dialog-delete-organization').modal('hide');
                    load_organization();
                    //alert(msg);
           	    }
            });
            return false;
        });             
        
        $(".close").click(function() { 
            $('#success_organization').hide();
            $('#error_organization').hide();
        });
    });  
    
    function organizationEdit(id)
    {
        var form_data = {
            id: id,
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/view_organization",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#hiddenIDOrganisasi').val(id);
                $('#res').html(msg);
       	    }
        });
        $('#success_organization').hide();
        $('#error_organization').hide();
        $('#dialog-organisasi').modal('show');
        return false;        
    }

    function organizationDelete(id, organisasi)
    {
        $('#hidden_del_organisasi').val(id);
        $('#body-delete-organization').html("Hapus data organisasi"+organisasi+"?");
    }
    
    function load_organization()
    {
        var form_data = {
            email: $('#email').val(),   
            no_identitas: $('#no_identitas').val(),   
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/load_organization",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#tblorganization').html(msg);
                
                var form_data = {
                    ajax:1
          		}
                $.ajax({
                    url : "<?php echo base_url(); ?>applicant/load_add_organization",
                    type : 'POST',
                    data : form_data,
                    success: function(msg){
                        $('#loadButtonOrganization').html(msg);
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