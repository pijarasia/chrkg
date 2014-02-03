<?php 

?>
    $(document).ready(function() {
        load_course();
        var $validator = $("#form_datapelatihan").validate({
            rules: {
                pelatihan: { required: true },
    		    penyelenggara: { required: true},
    		    kota_penyelenggara: { required: true},
    		    tanggalPelatihanAwal: { required: true},
    		    bulanPelatihanAwal: { required: true},
    		    tahunPelatihanAwal: { required: true },
    		    tanggalPelatihanAkhir: { required: true},
                bulanPelatihanAkhir: { required: true },
    		    tahunPelatihanAkhir: { required: true }, 
                tahunPelatihanAkhir: { greaterThan: "#tahunPelatihanAwal" },                                                 
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
        * Pelatihan
        ************/
        $("#simpan_pelatihan").click(function() {
            var $valid = $("#form_datapelatihan").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
      		} else {
      		    var tanggal = "OK";
      		    if ($("#tahunPelatihanAwal").val() == $("#tahunPelatihanAkhir").val())
                {
                    tanggal = "NO";

                    if ($('#bulanPelatihanAkhir').val() < $('#bulanPelatihanAwal').val()) {
                        $('#bulanPelatihanAkhir').focus();
                    } else if (parseInt($('#tanggalPelatihanAkhir').val(),10) < parseInt($('#tanggalPelatihanAwal').val(),10)) {
                        $('#tanggalPelatihanAkhir').focus();
                    } else 
                        tanggal = "OK";
                } 

                if (tanggal == "OK"){               
                    var form_data = {
                        id: $('#hiddenIDPelatihan').val(),
                        pelatihan: $('#pelatihan').val(),
                        penyelenggara: $('#penyelenggara').val(),
                        kota_penyelenggara: $('#kota_penyelenggara').val(),
                        sertifikat: $('#sertifikat').val(),
                        tanggalPelatihanAwal: $('#tanggalPelatihanAwal').val(),
                        bulanPelatihanAwal: $('#bulanPelatihanAwal').val(),
                        tahunPelatihanAwal: $('#tahunPelatihanAwal').val(),
                        tanggalPelatihanAkhir: $('#tanggalPelatihanAkhir').val(),
                        bulanPelatihanAkhir: $('#bulanPelatihanAkhir').val(),
                        tahunPelatihanAkhir: $('#tahunPelatihanAkhir').val(),        
                		ajax:1
              		};
                	$.ajax({
                        url : "<?php echo base_url(); ?>applicant/add_course",
                        type : 'POST',
                        data : form_data,
                        success: function(msg){
                            if (msg == 1)
                            {
                                $('#success_course').html("Data berhasil disimpan.");
                                $('#success_course').show();
                                $('#hiddenIDPelatihan').val("");
                                $('#pelatihan').val("");
                                $('#penyelenggara').val("")
                                $('#kota_penyelenggara').val("");   
                                $('#tanggalPelatihanAwal').val("");
                                $('#bulanPelatihanAwal').val("");
                                $('#tahunPelatihanAwal').val("");
                                $('#tanggalPelatihanAkhir').val("");
                                $('#bulanPelatihanAkhir').val("");
                                $('#tahunPelatihanAkhir').val("");                        
                            } else {
                                $('#error_course').html("Data gagal disimpan.");
                                $('#error_course').show();
                            }
                            $('#dialog-non-pendidikan').modal('hide');
                            load_course();
                        }
               		});
                 }
      		}       
            return false;
        });  
        
        $("#hapus_pelatihan").click(function() {
            var form_data = {
                id: $('#hidden_del_pelatihan').val(),
                ajax:1
      		}
            $.ajax({
                url : "<?php echo base_url(); ?>applicant/delete_course",
                type : 'POST',
                data : form_data,
                success: function(msg){
                    if (msg == 1)
                    {
                        $('#success_course').html("Data berhasil dihapus.");
                        $('#success_course').show();
                    } else {
                        $('#error_course').html("Data gagal dihapus.");                
                        $('#success_course').show();                    
                    }
                    $('#dialog-delete-course').modal('hide');
                    load_course();
                    //alert(msg);
           	    }
            });
            return false;
        });             
        
        $(".close").click(function() { 
            $('#success_course').hide();
            $('#error_course').hide();
        });
    });  
    
    function courseEdit(id)
    {
        var form_data = {
            id: id,
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/view_course",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#hiddenIDPelatihan').val(id);
                $('#res').html(msg);
       	    }
        });
        $('#success_course').hide();
        $('#error_course').hide();
        $('#dialog-non-pendidikan').modal('show');
        return false;        
    }

    function courseDelete(id, pelatihan)
    {
        $('#hidden_del_pelatihan').val(id);
        $('#body-delete-course').html("Hapus data pelatihan "+pelatihan+"?");
    }
    
    function load_course()
    {
        var form_data = {
            email: $('#email').val(),   
            no_identitas: $('#no_identitas').val(),   
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/load_course",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#tblcourse').html(msg);
                
                var form_data = {
                    ajax:1
          		}
                $.ajax({
                    url : "<?php echo base_url(); ?>applicant/load_add_course",
                    type : 'POST',
                    data : form_data,
                    success: function(msg){
                        $('#loadButtonCourse').html(msg);
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