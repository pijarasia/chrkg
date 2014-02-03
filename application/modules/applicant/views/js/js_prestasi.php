<?php 

?>
    $(document).ready(function() {
        load_achievements();
        var $validator = $("#form_dataprestasi").validate({
            rules: {
                bidang: { required: true },
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
        
        $("#simpan_prestasi").click(function() {
            var $valid = $("#form_dataprestasi").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
      		} else {
                var form_data = {
                    id: $('#hiddenIDPrestasi').val(),
                    nama: $('#nama').val(),
                    email: $('#email').val(),                          
                    bidang: $('#bidang').val(),
                    keterangan: $('#keterangan').val(),
            		ajax:1
          		};
            	$.ajax({
                    url : "<?php echo base_url(); ?>applicant/add_achievements",
                    type : 'POST',
                    data : form_data,
                    success: function(msg){
                        if (msg == 1)
                        {
                            $('#success_achievements').html("Data berhasil disimpan.");
                            $('#success_achievements').show();
                            $('#hiddenIDPrestasi').val("");
                            $('#bidang').val("");
                            $('#keterangan').val("")
                        } else {
                            $('#error_achievements').html("Data gagal disimpan.");
                            $('#error_achievements').show();
                        }
                        $('#dialog-prestasi').modal('hide');
                        load_achievements();
                    }
           		});
      		}       
            return false;
        });        
        
        $("#hapus_prestasi").click(function() {
            var form_data = {
                id: $('#hidden_del_prestasi').val(),
                ajax:1
      		}
            $.ajax({
                url : "<?php echo base_url(); ?>applicant/delete_achievements",
                type : 'POST',
                data : form_data,
                success: function(msg){
                    if (msg == 1)
                    {
                        $('#success_achievements').html("Data berhasil dihapus.");
                        $('#success_achievements').show();
                    } else {
                        $('#error_achievements').html("Data gagal dihapus.");                
                        $('#success_achievements').show();                    
                    }
                    $('#dialog-delete-achievements').modal('hide');
                    load_achievements();
                    //alert(msg);
           	    }
            });
            return false;
        });             
        
        $(".close").click(function() { 
            $('#success_achievements').hide();
            $('#error_achievements').hide();
        });        
    }); 
    
    function achievementsEdit(id)
    {
        var form_data = {
            id: id,
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/view_achievements",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#hiddenIDPrestasi').val(id);
                $('#res').html(msg);
       	    }
        });
        $('#success_achievements').hide();
        $('#error_achievements').hide();
        $('#dialog-prestasi').modal('show');
        return false;        
    }

    function achievementsDelete(id, prestasi)
    {
        $('#hidden_del_prestasi').val(id);
        $('#body-delete-achievements').html("Hapus data prestasi "+prestasi+"?");
    }    
    
    function load_achievements()
    {
        var form_data = {
            email: $('#email').val(),   
            no_identitas: $('#no_identitas').val(),   
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/load_achievements",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#tblachievements').html(msg);
                
                var form_data = {
                    ajax:1
          		}
                $.ajax({
                    url : "<?php echo base_url(); ?>applicant/load_add_achievements",
                    type : 'POST',
                    data : form_data,
                    success: function(msg){
                        $('#loadButtonAchievements').html(msg);
               	    }
                });                
       	    }
        });
        return false;           
    }