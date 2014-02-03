<?php 

?>
    function vacancyDetails(id){
        $(location).attr('href',"<?php echo base_url(); ?>vacancy/details/"+id);
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
      
    
    function cancel_apply(){
        var form_data = {
            id: $("#hiddenJobApplyID").val(),
            ajax:1
        };
        $.ajax({
            url : "<?php echo base_url(); ?>jobapply/cancel_apply",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#dialog-cancel-apply').modal('hide');
                Document.search(5);
                this.loadData();
                this.loadPage();                         
            }
        });
        return false;  
    }
    
    /*function load_data()
    {
        var form_data = {
            hal: $("#hal").val(),
            tampil: $("#tampil").val(),
            ajax:1
        };
        $.ajax({
            url : "<?php echo base_url(); ?>jobapply/load_data",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $("#tableApply").html(msg);                      
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
    });*/
    
    function trackingApply(apply, jobOrder) {
        var form_data = {
            apply: apply,
            jobOrder: jobOrder,
            ajax:1
        };
        $.ajax({
            url : "<?php echo base_url(); ?>jobapply/tracking",
            type : 'POST',
            data : form_data,
            success: function(msg){
                $('#apply').html('<div style="padding: 10px;">'+msg+'</div>');
            }
        }); 
    }      
    
    function back()
    {        
        document.location.href = "<?php echo base_url(); ?>jobapply";
        return false; 
    }
    
   