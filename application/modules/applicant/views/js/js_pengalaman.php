<?php 

?>
    $(document).ready(function() {
        load_work();
        var $validator = $("#form_datapengalaman").validate({
            rules: {
                perusahaan: { required: true },
    		    alamat_perusahaan: { required: true},
    		    kota_perusahaan: { required: true},
    		    atasan: { required: true},
    		    posisi: { required: true},
    		    bulanKerjaAwal: { required: true },
    		    tahunKerjaAwal: { required: true},
                tahunKerjaAkhir: { greaterThan: "#tahunKerjaAwal" },                      
                gaji_perusahaan: { required: true },
    		    deskripsi: { required: true },     
    		    alasan_keluar: { required: true }                                   
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
        
        $("#simpan_pengalaman").click(function() {
            var $valid = $("#form_datapengalaman").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
      		} else {
      		    var tanggal = "OK";
      		    if ($("#tahunKerjaAkhir").val() == $("#tahunKerjaAwal").val())
                {
                    tanggal = "NO";

                    if ($('#bulanKerjaAkhir').val() < $('#bulanKerjaAwal').val()) {
                        $('#bulanKerjaAkhir').focus();
                    } else 
                        tanggal = "OK";
                } 

                if (tanggal == "OK"){               
                    if ($('#masih_bekerja').is(':checked'))
                        masih_bekerja = true;
                    else
                        masih_bekerja = false;  		    
                    var form_data = {
                        id: $('#hiddenIDPengalaman').val(),
                        perusahaan: $('#perusahaan').val(),
                        alamat_perusahaan: $('#alamat_perusahaan').val(),
                        kota_perusahaan: $('#kota_perusahaan').val(),
                        telp_perusahaan: $('#telp_perusahaan').val(),
                        atasan: $('#atasan').val(),
                        posisi: $('#posisi').val(),
                        bulanKerjaAwal: $('#bulanKerjaAwal').val(),
                        tahunKerjaAwal: $('#tahunKerjaAwal').val(),
                        bulanKerjaAkhir: $('#bulanKerjaAkhir').val(),
                        tahunKerjaAkhir: $('#tahunKerjaAkhir').val(),        
        
                        gaji_awal: $('#gaji_awal').val(),
                        gaji_akhir: $('#gaji_akhir').val(),
                        deskripsi: $('#deskripsi').val(),
                        alasan_keluar: $('#alasan_keluar').val(),
                        masih_bekerja: masih_bekerja,        
        
                		ajax:1
              		};
                    $.ajax({
                        url : "<?php echo base_url(); ?>applicant/add_work_experience",
                        type : 'POST',
                        data : form_data,
                        success: function(msg){
                            if (msg == 1)
                            {
                                $('#success_work').html("Data berhasil disimpan.");
                                $('#success_work').show();
                                $('#hiddenIDPengalaman').val("");
                                $('#perusahaan').val("");
                                $('#alamat_perusahaan').val("");
                                $('#kota_perusahaan').val("");
                                $('#telp_perusahaan').val("");
                                $('#atasan').val("");
                                $('#posisi').val("");
                                $('#bulanKerjaAwal').val("");
                                $('#tahunKerjaAwal').val("");
                                $('#bulanKerjaAkhir').val("");
                                $('#tahunKerjaAkhir').val("");      
                                $('#gaji_awal').val("");
                                $('#gaji_akhir').val("");
                                $('#deskripsi').val("");
                                $('#alasan_keluar').val("");
                                $('#masih_bekerja').prop("checked", false);
                            } else {
                                $('#error_work').html("Data gagal disimpan.");
                                $('#error_work').show();
                            }
                            $('#dialog-pengalaman').modal('hide');
                            load_work();
                        }
               		});
                }
      		}  
            return false;
        }); 
        
        $("#hapus_pengalaman").click(function() { 
            var form_data = {
                id: $('#hidden_del_pengalaman').val(),
                ajax:1
      		}
            $.ajax({
                url : "<?php echo base_url(); ?>applicant/delete_work_experience",
                type : 'POST',
                data : form_data,
                success: function(msg){
                    if (msg == 1)
                    {
                        $('#success_work').html("Data berhasil dihapus.");
                        $('#success_work').show();
                    } else {
                        $('#error_work').html("Data gagal dihapus.");                
                        $('#error_work').hide();
                    }
                    $('#dialog-delete-work').modal('hide');
                    load_work();
           	    }                
            });
            return false;
        });      
		
		$(".close").click(function() { 
            $('#success_work').hide();
            $('#error_work').hide();
        });       
        
        $(".hp").keydown(function(event) {
            // Allow: backspace, delete, tab, escape, and enter
            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
                 // Allow: Ctrl+A
                (event.keyCode == 65 && event.ctrlKey === true) || 
                 // Allow: home, end, left, right
                (event.keyCode >= 35 && event.keyCode <= 39) || event.keyCode == 187) {
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
    
    function load_work()
    {
        var form_data = {
            email: $('#email').val(),   
            no_identitas: $('#no_identitas').val(),               
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/load_work",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#tblwork').html(msg);
                
                var form_data = {
                    ajax:1
          		}
                $.ajax({
                    url : "<?php echo base_url(); ?>applicant/load_add_work",
                    type : 'POST',
                    data : form_data,
                    success: function(msg){
                        $('#loadButtonWork').html(msg);
               	    }
                });                
       	    }
        });
        return false;           
    }   
    
        
    function workExEdit(id)
    {
        var form_data = {
            id: id,
            ajax:1
  		}
        $.ajax({
            url : "<?php echo base_url(); ?>applicant/view_work",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#hiddenIDPengalaman').val(id);
                $('#res').html(msg);
       	    }
        });
        $('#success_work').hide();
        $('#error_work').hide();
        $('#dialog-pengalaman').modal('show');
        return false;        
    }

    function workExDelete(id, perusahaan)
    {
        $('#hidden_del_pengalaman').val(id);
        $('#body-delete-work').html("Hapus data pengalaman kerja di "+perusahaan+"?");
    }  
    
    jQuery.validator.addMethod("greaterThan", 
        function(value, element, params) {
        if (!/Invalid|NaN/.test(new Date(value))) {
            return new Date(value) >= new Date($(params).val());
        }
        return isNaN(value) && isNaN($(params).val()) || (Number(value) >= Number($(params).val())); 
    },'Must be greater than {0}.');          