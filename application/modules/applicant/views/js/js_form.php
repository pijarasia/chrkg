<?php 

?>
    $(document).ready(function() {
        $('#jur').hide(); 
       
        $.each($(".my-nav"), function(){
            var nav = '<?php echo $navigation?>';
            $("#" + this.id).removeClass('active');
            if (this.id == nav) {
                $("#" + this.id).addClass('active');
            };
            console.log(nav);
        });    
            
        var $validator = $("#form_data").validate({
            rules: {
                //data diri
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
                                
                
                //pendidikan
                jenjang: { required: true },
    		    institusi: { required: true},
    		    jurusan: { required: true},
    		    kota: { required: true },
                negara: { required: true },
    		    tahunMasuk: { required: true },
    		    tahunLulus: { required: true, greaterThan: "#tahunMasuk" }, 
    		    no_ijazah: { required: true },                
    		    nilai: { required: true },

                pelatihan: { required: true },
    		    penyelenggara: { required: true},
    		    kota_penyelenggara: { required: true},
                pelatihanAwal: { required: true },
                pelatihanAkhir: { required: true },
    		    tanggalPelatihanAwal: { required: true},
    		    bulanPelatihanAwal: { required: true},
    		    tahunPelatihanAwal: { required: true },
    		    tanggalPelatihanAkhir: { required: true},
                bulanPelatihanAkhir: { required: true },
    		    tahunPelatihanAkhir: { required: true },     
                tahunPelatihanAkhir: { greaterThan: "#tahunPelatihanAwal" },
                
                perusahaan: { required: true },
    		    alamat_perusahaan: { required: true},
    		    kota_perusahaan: { required: true},
                telp_perusahaan: { required: true},
    		    atasan: { required: true},
    		    posisi: { required: true},
    		    bulanKerjaAwal: { required: true },
    		    tahunKerjaAwal: { required: true},
                gaji_perusahaan: { required: true },
    		    deskripsi: { required: true },     
    		    alasan_keluar: { required: true },     

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

	  	$('#firstwizard').bootstrapWizard({
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
                
                if (index == 1)
                {
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
                            //alert(msg);
                        }
                    });                
                } 
                else if (index == 2)
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
                        last: true,
            			ajax:1
            		};
            		$.ajax({
            			url : "<?php echo base_url(); ?>applicant/add_education",
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
                    load_work();
                }
                else if (index == 5)
                {
                    /*var form_data = {
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
            		});*/                            
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
	  	});
        $('#firstwizard .finish').click(function() {
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
                    if (msg == true)
                    {
                        $('#body-notif').html("Terima kasih, data anda berhasil disimpan. Silakan melamar lowongan pekerjaan.")
                        <?php
                            if ($this->session->userdata('vacancy') == "")
                            {
                        ?>
                            $('#dialog-notif').modal('show');                        
                            //window.location = "<?php echo base_url(); ?>vacancy";
                        <?
                            } else {
                        ?>
                            window.location = "<?php echo base_url(); ?>vacancy/details/<?php echo $this->session->userdata('vacancy')?>";
                        <?
                            }
                        ?>
                    }
                }
      		});               
        });          	
		window.prettyPrint && prettyPrint()
	
        $('#jenjang').change(function() {
            if ($("#jenjang option:selected").text() == "" || $("#jenjang option:selected").text() == "SD" || $("#jenjang option:selected").text() == "SLTP")
            {
                $('#jur').hide();   
            } else {
                $('#jur').show();   
            }        
        });       
    
        /************
        * Pelatihan
        ************/
        $("#simpan_pelatihan").click(function() {
            courseStartDate();
            courseStartEnd();
                        
            var $valid = $("#form_data").valid();
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
                        nama: $('#nama').val(),
                        email: $('#email').val(),                          
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
        
        /******************
        * Pengalaman Kerja
        ******************/
        $("#simpan_pengalaman").click(function() {
            var $valid = $("#form_data").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
      		} else {
      		    var tanggal = "OK";
                
                if ($('#masih_bekerja').is(':checked') == false && ($('#bulanKerjaAkhir').val() == "" || $("#tahunKerjaAkhir").val() == ""))
                {
                    tanggal = "NO";
                    if ($('#bulanKerjaAkhir').val() == "")
                        $('#bulanKerjaAkhir').focus();
                    else
                        $('#tahunKerjaAkhir').focus();
                }
      		    else if ($("#tahunKerjaAkhir").val() < $("#tahunKerjaAwal").val() && $('#masih_bekerja').is(':checked') == false)
                {
                    tanggal = "NO";
                    $('#tahunKerjaAkhir').focus();
                } 
                else if ($("#tahunKerjaAkhir").val() == $("#tahunKerjaAwal").val() && $('#masih_bekerja').is(':checked') == false)
                {
                    tanggal = "NO";

                    if ($('#bulanKerjaAkhir').val() < $('#bulanKerjaAwal').val() && $('#masih_bekerja').is(':checked') == false) {
                        $('#bulanKerjaAkhir').focus();
                    } else 
                        tanggal = "OK";
                } 
                
                if (tanggal == "OK"){               
                    if ($('#masih_bekerja').is(':checked'))
                        var masih_bekerja = true;
                    else
                        var masih_bekerja = false;  		    
                    
                    var form_data = {
                        id: $('#hiddenIDPengalaman').val(),
                        nama: $('#nama').val(),
                        email: $('#email').val(),                          
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
            $('#success_course').hide();
            $('#error_course').hide();
            $('#success_work').hide();
            $('#error_work').hide();
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
        
        $("#gaji").keydown(function(event) {
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
    
    function courseStartDate()
    {
        $("#pelatihanAwal").val(new Date($("#tahunPelatihanAwal").val()+"-"+$("#bulanPelatihanAwal").val()+"-"+$("#tanggalPelatihanAwal").val()));
    }
    
    function courseStartEnd()
    {
        $("#pelatihanAkhir").val(new Date($("#tahunPelatihanAkhir").val()+"-"+$("#bulanPelatihanAkhir").val()+"-"+$("#tanggalPelatihanAkhir").val()));
    }            