<?php

?>
var Document = {
  param: {
    dataperpage: 10, // jumlah data per halaman
    query: '',
    curpage: 0,
    numpage: 0,
    skey: '',
    stype: '',
    npage: 0
  },
  url: '<?php echo base_url()."setting/temail";?>',
  search: function(n) {
    var $form = $("#sform");
    this.param.query = $form.serializeFormJSON() || '';
    this.param.dataperpage = n || 10;
    this.param.curpage = 0;
    this.loadData();
    this.loadPage();
    return false;
  },
  setPage: function(n) {
    this.param.curpage = n;
    this.loadData();
    return false;
  },
  firstPage: function() {
    var npage = this.param.npage;
    $('#pagination').bootpag({
          total: npage,
          maxVisible: 10,
          page: 1,
        }).on("page", function(event, num){
             Document.setPage(num-1);
             return false;
        });
    $('ul.bootpag>li').not('.prev').first().trigger('click');
    return false;
  },
  lastPage: function() {
    var npage = this.param.npage;
    $('#pagination').bootpag({
          total: npage,
          maxVisible: 10,
          page: npage,
        }).on("page", function(event, num){
             Document.setPage(num-1);
             return false;
        });
    return false;
    $('ul.bootpag>li[data-lp="'+npage+'"]').trigger('click');
  },
  sort: function(skey,stype) {
    this.param.skey = skey || '_name';
    this.param.stype = stype || 'asc';
    this.loadData();
    return false;
  },
  loadData: function() {
    $.ajax({
      url: Document.url,
      type: 'POST',
      dataType: 'json',
      data: jQuery.param(Document.param),
      success: function(d) {
        Document.param.numpage = d.numpage;
        Document.param.npage = d.npage;
        var t = '', dt = {};
        for (var i = 0; i < d.data.length; i++) {
          dt = d.data[i];
          t += '<tr><td>' + dt.groupname + '</td>' + 
                '<td>' + dt.subject+ '</td>' +
                '<td>' + dt.action + '</td></tr>';
        }
        $('#document-data').html(t);
      }
    });
  },
  loadPage: function() {
    $.ajax({
      url: Document.url,
      type: 'POST',
      dataType: 'json',
      data: jQuery.param(Document.param),
      success: function(d) {
        Document.param.numpage = d.numpage;
        Document.param.npage = d.npage;
          $('#pagination').bootpag({
          total: d.npage,
          maxVisible: 10,
          }).on("page", function(event, num){
               Document.setPage(num-1);
               return false;
          });
        }
    });
  }
}

$.fn.serializeFormJSON = function() {
   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {
       if (o[this.name]) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   return o;
};

function deleteE(id, group, subject)
{
    var form_data = {
        id: id,
        group: group,
        subject: subject,
        ajax:1
   	}
    $.ajax({
        url : "<?php echo base_url(); ?>setting/delete_email",
        type : 'POST',
        data : form_data,
        success: function(msg){
            if (msg == 1)
            {
                $("#alert-success").html("Data group "+group+" with subject email "+subject+" has been delete");
                $("#alert-success").show();
                $("#alert-error").hide(); 
            } else {
                $("#alert-error").html("Failed to delete group "+group+" with subject email "+subject);
                $("#alert-error").show();            
                $("#alert-success").hide(); 
            }
            Document.search(10);
            this.loadData();
            this.loadPage();    
   	    }
    });
    return false;    
}

function editE(id)
{
    var form_data = {
        id: id,	          
        ajax:1
    };
    $.ajax({
        url : "<?php echo base_url(); ?>setting/check_email",
        type : 'POST',
    	data : form_data,
        dataType: 'json',
    	success: function(msg){    
            $('#group').val(msg["group"]);
            $('#subject').val(msg["subject"]);
            $('#editor').html(msg["editor"]);
            $('#hiddenIDEmail').val(id);
            $('#dialog-email').modal('show');
        }
    });
    return false;
}

function detailE(id)
{
    var form_data = {
        id: id,	          
        ajax:1
    };
    $.ajax({
        url : "<?php echo base_url(); ?>setting/check_email",
        type : 'POST',
    	data : form_data,
        dataType: 'json',
    	success: function(msg){    
            if (msg["group"] == 0)
                msg["groupname"] = "All";
            $('#groupD').html(msg["groupname"]);
            $('#subjectD').html(msg["subject"]);
            $('#editorD').html(msg["editor"]);
            $('#dialog-email-detail').modal('show');
        }
    });
    return false;
}


$(document).ready(function() {
    var $validator = $("#form_email").validate({
        rules: {
            group: { required: true },
            subject: { required: true }
        },
        errorPlacement: function (error, element) { 
            //return false; //Suppress all messages 
        },
        highlight: function (element) { 
            $(element).closest('.control-group').removeClass('success').addClass('error'); 
        },
        unhighlight: function (element) { 
            $(element).closest('.control-group').removeClass('error').addClass('success'); 
        }          
    });
        
    $("#simpan_email").click(function() {
        var $valid = $("#form_email").valid();
        if(!$valid) {
            $validator.focusInvalid();
            return false;
  		} else {
  		    var form_data = {
                id: $('#hiddenIDEmail').val(),	          
    			group: $('#group').val(),        
    			subject: $('#subject').val(),        
    			editor: $('#editor').html(),        
    			ajax:1
            };
            $.ajax({
                url : "<?php echo base_url(); ?>setting/create_email",
                type : 'POST',
    			data : form_data,
    			success: function(msg){
                    if (msg == 1)
                    {
                        $('#alert-error').hide();
                        if ($('#hiddenIDEmail').val() == "")
                            $("#alert-success").html("Data "+$('#subject').val()+" successfully added");
                        else
                            $("#alert-success").html("Data "+$('#subject').val()+" successfully changed");

                        $('#alert-success').show();
                        $('#hiddenIDEmail').val("");
                        $('#subject').val("");     
                        $('#dialog-email').modal('hide');  
                        Document.search(10);
                        this.loadData();
                        this.loadPage();   
                        
                        $('#group').val("");
                        $('#subject').val("");
                        $('#editor').html("");
                        $('#hiddenIDEmail').val("");
                    } 
                    else
                    {
                        $('#alert-success').hide();
                        if ($('#hiddenIDEmail').val() == "")
                            $("#email-error").html("Failed to add data group "+$('#group').val()+" with subject "+$('#subject').val());
                        else
                            $("#email-error").html("Failed to change data group "+$('#group').val()+" with subject "+$('#subject').val());
                        
                        $('#alert-error').show();
                        $('#dialog-email').modal('hide');
                    }
                }
            });      
 		}       
        return false;
   }); 
});