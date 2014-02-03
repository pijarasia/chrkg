<?php 

?>
    $(document).ready(function() {
        $.each($(".my-nav"), function(){
            var nav = '<?php echo $navigation?>';
            $("#" + this.id).removeClass('active');
            if (this.id == nav) {
                $("#" + this.id).addClass('active');
            };
            console.log(nav);
        });           
        
        /*$('#tabForm a').click(function (e) {
            $("#data").html(" :: "+$(this).text());
            e.preventDefault();
            $(this).tab('show');         
        })*/
        
        $('#tabForm a').click(function (e) {
            $("#data").html(" :: "+$(this).text());
            paneID = $(e.target).attr('href');
            src = $(paneID).attr('data-src');
            
            if($(paneID+" iframe").attr("src")=="")
            {
                $(paneID+" iframe").attr("src",src);
            }
            e.preventDefault();
            $(this).tab('show');            
        })                                       
                                                       
        $('input[type=file]').bootstrapFileInput(); 
    });	
    
    function resizeIframe(obj, tambah) {
        obj.style.height = obj.contentWindow.document.body.scrollHeight + tambah +'px';
    }
    
    function fileUpload(form, action_url, div_id) {
        if ($("#fileFoto").val() != "")
        {    
            var iframe = document.createElement("iframe");
            iframe.setAttribute("id", "upload_iframe");
            iframe.setAttribute("name", "upload_iframe");
            iframe.setAttribute("width", "0");
            iframe.setAttribute("height", "0");
            iframe.setAttribute("border", "0");
            iframe.setAttribute("style", "width: 0; height: 0; border: none;");
         
            form.parentNode.appendChild(iframe);
            window.frames['upload_iframe'].name = "upload_iframe";
         
            iframeId = document.getElementById("upload_iframe");
         
            var eventHandler = function () {
                if (iframeId.detachEvent) 
                    iframeId.detachEvent("onload", eventHandler);
                else 
                    iframeId.removeEventListener("load", eventHandler, false);
         
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
                    $('#dialog-foto').modal('hide');
                }
                setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
        
                var form_data = {
                    id: $("#hiddenID").val(),
                    ajax:1
                };
                $.ajax({
                    url : "<?php echo base_url(); ?>applicant/load_photo",
                    type : 'POST',
                    data : form_data,
                    success: function(msg){
                        $("#divphoto").html(msg);                      
                    }
                });                
            }
         
            if (iframeId.addEventListener) 
                iframeId.addEventListener("load", eventHandler, true);
            if (iframeId.attachEvent) 
                iframeId.attachEvent("onload", eventHandler);
         
            form.setAttribute("target", "upload_iframe");
            form.setAttribute("action", action_url);
            form.setAttribute("method", "post");
            form.setAttribute("enctype", "multipart/form-data");
            form.setAttribute("encoding", "multipart/form-data");
         
            form.submit();
         
        } else{
            $("#upload").html("<span style='color: red;font-size: smaller;'>File Foto Harus Dipilih</span>");
        } 
    }          