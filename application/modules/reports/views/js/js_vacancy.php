<?php 

?>
    $(document).ready(function(){
        $('input[type=file]').bootstrapFileInput();     
        $("#form-detail").hide();
        $("#searchJob").click(function() {  
            var form_data = {
                cari: $("#cari2").val(),
                jenjang: $("#jenjang").val(),
                tipe_kerja: $("#tipe_kerja2").val(),
                bisnis: $("#bisnis2").val(),   
                kota: $("#kota2").val(),   
                hal: $("#hal").val(),
                tampil: $("#tampil").val(),                                             
                ajax:1
            };
            $.ajax({
                url : "<?php echo base_url(); ?>vacancy/load_data",
                type : 'POST',
                data : form_data,
                success: function(msg){
                    $("#tableJob").html(msg);     
                    //pagination();
                }
            });          
            return false;
        }); 
        
        $("#cancel_apply").click(function() {
            var form_data = {
                id: $("#hiddenJobApplyID").val(),
                ajax:1
            };
            $.ajax({
                url : "<?php echo base_url(); ?>vacancy/cancel_apply",
                type : 'POST',
                data : form_data,
                success: function(msg){
                    $('#dialog-cancel-apply').modal('hide');
                    $("#loadLamar").html(msg);                      
                }
            });
            
            //load person
            var form_data2 = {
                id: $("#hiddenID").val(),
                ajax:1
            };
            $.ajax({
                url : "<?php echo base_url(); ?>vacancy/load_person",
                type : 'POST',
                data : form_data2,
                success: function(msg){
                    $("#person").html(msg);                      
                }
            });              
        });                 
    });
    
    function vacancyDetails(id){
        //$(location).attr('href',"<?php echo base_url(); ?>vacancy/details/"+id);
        $("#form-search").hide();
        $("#form-detail").show();
        
        var form_data = {
                id: id,
                ajax:1
            };
            $.ajax({
                url : "<?php echo base_url(); ?>vacancy/details",
                type : 'POST',
                data : form_data,
                success: function(msg){
                    $("#form-detail").html(msg);     
                }
            });          
            return false;
    }
    
    function confirmApply(id){
        $("#hiddenJobApplyID").val(id);
        var form_data = {
            id: $("#hiddenID").val(),
            ajax:1
        };
        $.ajax({
            url : "<?php echo base_url(); ?>vacancy/check",
            type : 'POST',
            data : form_data,
            success: function(msg){
                if (msg == "OK")
                    $('#dialog-apply-job').modal('show');
                else
                    $("#resapply").html(msg);
            }
        });     
    }
    
    function cancelApply(id){
        $("#hiddenJobApplyID").val(id);
        var form_data = {
            ajax:1
        };
        $.ajax({
            url : "<?php echo base_url(); ?>vacancy/check",
            type : 'POST',
            data : form_data,
            success: function(msg){
                if (msg == "OK")
                    $('#dialog-cancel-apply').modal('show');
                else
                    $("#resapply").html(msg);
            }
        });     
    }

    $(':file').change(function(){
        var file = this.files[0];
        name = file.name;
        size = file.size;
        type = file.type;
        //your validation
    });        
        
    function load_data()
    {
        var form_data = {
            cari: $("#cari").val(),
            jenjang: $("#jenjang").val(),
            tipe_kerja: $("#tipe_kerja").val(),
            bisnis: $("#bisnis").val(),
            kota: $("#kota").val(),
            hal: $("#hal").val(),
            tampil: $("#tampil").val(),
            ajax:1
        };
        $.ajax({
            url : "<?php echo base_url(); ?>vacancy/load_data",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $("#tableJob").html(msg);                      
            }
        }); 
    }
    
    function pagination()
    {
        $('#pagination').bootpag({
           total: $('#total').val(),
           leaps: false,
           next: 'next',
           prev: 'prev'    
        }).on('page', function(event, num){
            $("#hal").val(num);
            load_data();           
        }); 
    }
        
    $(document).ready(function() {
        load_data();
        pagination();              
        
        $("#fileCoverLetter").click(function() {
            $("#notifCL").html("");
        });
    });

    
    function progressHandlingFunction(e){
        if(e.lengthComputable){
            $('progress').attr({value:e.loaded,max:e.total});
        }
    }    
    
    function fileUpload(form, action_url, div_id) {
        if ($("#fileCoverLetter").val() != "" && $("#fileCV").val() != "")
        {    
            // Create the iframe...
            var iframe = document.createElement("iframe");
            iframe.setAttribute("id", "upload_iframe");
            iframe.setAttribute("name", "upload_iframe");
            iframe.setAttribute("width", "0");
            iframe.setAttribute("height", "0");
            iframe.setAttribute("border", "0");
            iframe.setAttribute("style", "width: 0; height: 0; border: none;");
         
            // Add to document...
            form.parentNode.appendChild(iframe);
            window.frames['upload_iframe'].name = "upload_iframe";
         
            iframeId = document.getElementById("upload_iframe");
         
            // Add event...
            var eventHandler = function () {
                if (iframeId.detachEvent) 
                    iframeId.detachEvent("onload", eventHandler);
                else 
                    iframeId.removeEventListener("load", eventHandler, false);
         
                // Message from server...
                if (iframeId.contentDocument) {
                    content = iframeId.contentDocument.body.innerHTML;
                } else if (iframeId.contentWindow) {
                    content = iframeId.contentWindow.document.body.innerHTML;
                } else if (iframeId.document) {
                    content = iframeId.document.body.innerHTML;
                }
                
                document.getElementById(div_id).innerHTML = content;
                if (content.substring(0,2) == "OK")
                {
                    document.getElementById(div_id).innerHTML = "";
                    $('#dialog-apply-job').modal('hide');
                }
                // Del the iframe...
                setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
        
                //load bimbingan
                var form_data = {
                    id: $("#hiddenID").val(),
                    content: content.substring(0,2),
                    ajax:1
                };
                $.ajax({
                    url : "<?php echo base_url(); ?>vacancy/load_apply",
                    type : 'POST',
                    data : form_data,
                    success: function(msg){
                        $("#loadLamar").html(msg);                      
                    }
                });
                
                //load person
                var form_data = {
                    id: $("#hiddenID").val(),
                    ajax:1
                };
                $.ajax({
                    url : "<?php echo base_url(); ?>vacancy/load_person",
                    type : 'POST',
                    data : form_data,
                    success: function(msg){
                        $("#person").html(msg);                      
                    }
                });                
            }
         
            if (iframeId.addEventListener) 
                iframeId.addEventListener("load", eventHandler, true);
            if (iframeId.attachEvent) 
                iframeId.attachEvent("onload", eventHandler);
         
            // Set properties of form...
            form.setAttribute("target", "upload_iframe");
            form.setAttribute("action", action_url);
            form.setAttribute("method", "post");
            form.setAttribute("enctype", "multipart/form-data");
            form.setAttribute("encoding", "multipart/form-data");
         
            // Submit the form...
            form.submit();
         
            //document.getElementById(div_id).innerHTML = "Uploading...";
        } else if ($("#fileCoverLetter").val() == ""){
            //$("#fileCoverLetter").addClass("btn-danger");
            $("#upload").html("<span style='color: #800000;font-size: smaller;'><?php echo lang('cover_letter_warning');?></span>");
        } else if ($("#fileCV").val() == ""){
            //$("#fileCV").addClass("btn-danger");
            $("#uploadcv").html("<span style='color: #800000;font-size: smaller;'><?php echo lang('cv_warning');?></span>");
        }
    } 