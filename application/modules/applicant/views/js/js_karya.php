<?php 

?>
    $(document).ready(function() {
        load_publication();
        var $validator = $("#form_datapublikasi").validate({
            rules: {
                judul: { required: true },
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
        
        $("#simpan_publikasi").click(function() {
            var $valid = $("#form_datapublikasi").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
      		} else {
                var form_data = {
                    id: $('#hiddenIDPublikasi').val(),
                    nama: $('#nama').val(),
                    email: $('#email').val(),                          
                    judul: $('#judul').val(),
                    keterangan: $('#keterangan').val(),
            		ajax:1
          		};
            	$.ajax({
                    url : "<?php echo base_url(); ?>applicant/add_publication",
                    type : 'POST',
                    data : form_data,
                    success: function(msg){
                        if (msg == 1)
                        {
                            $('#success_publication').html("Data berhasil disimpan.");
                            $('#success_publication').show();
                            $('#hiddenIDPublikasi').val("");
                            $('#judul').val("");
                            $('#keterangan').val("")
                        } else {
                            $('#error_publication').html("Data gagal disimpan.");
                            $('#error_publication').show();
                        }
                        $('#dialog-publikasi').modal('hide');
                        load_publication();
                    }
           		});
      		}       
            return false;
        });        
        
        $("#hapus_publikasi").click(function() {
            var form_data = {
                id: $('#hidden_del_publikasi').val(),
                ajax:1
      		}
            $.ajax({
                url : "<?php echo base_url(); ?>applicant/delete_publication",
                type : 'POST',
                data : form_data,
                success: function(msg){
                    if (msg == 1)
                    {
                        $('#success_publication').html("Data berhasil dihapus.");
                        $('#success_publication').show();
                    } else {
                        $('#error_publication').html("Data gagal dihapus.");                
                        $('#success_publication').show();                    
                    }
                    $('#dialog-delete-publication').modal('hide');
                    load_publication();
                    //alert(msg);
           	    }
            });
            return false;
        });             
        
        $(".close").click(function() { 
            $('#success_publication').hide();
            $('#error_publication').hide();
        });        
    }); 
    
    function publicationEdit(id)
    {
        var form_data = {
            id: id,
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/view_publication",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#hiddenIDPublikasi').val(id);
                $('#res').html(msg);
       	    }
        });
        $('#success_publication').hide();
        $('#error_publication').hide();
        $('#dialog-publikasi').modal('show');
        return false;        
    }

    function publicationDelete(id, publikasi)
    {
        $('#hidden_del_publikasi').val(id);
        $('#body-delete-publication').html("Hapus data publikasi "+publikasi+"?");
    }    
    
    function load_publication()
    {
        var form_data = {
            email: $('#email').val(),   
            no_identitas: $('#no_identitas').val(),   
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/load_publication",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#tblpublication').html(msg);
                
                var form_data = {
                    ajax:1
          		}
                $.ajax({
                    url : "<?php echo base_url(); ?>applicant/load_add_publication",
                    type : 'POST',
                    data : form_data,
                    success: function(msg){
                        $('#loadButtonPublication').html(msg);
               	    }
                });                
       	    }
        });
        return false;           
    }