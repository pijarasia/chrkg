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
  url: '<?php echo base_url()."setting/process_status";?>',
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
          t += '<tr><td>' + dt.name + '</td>';
          <?
            if ($this->auth->_allowed('Dashboard.Reference.JobProcess.Change') || $this->auth->_allowed('Dashboard.Reference.JobProcess.Delete'))
            {
          ?>
             t += '<td>' + dt.action + '</td>';
          <?
            }
          ?>
          t += '</tr>';
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

function deleteB(id, status)
{
    var form_data = {
        id: id,
        ajax:1
   	}
    $.ajax({
        url : "<?php echo base_url(); ?>setting/delete_process_status",
        type : 'POST',
        data : form_data,
        success: function(msg){
            if (msg == 1)
            {
                $("#status-success").html("Data "+status+" has been delete");
                $("#alert-success").show();
                $("#alert-error").hide();
            } else {
                $("#status-error").html("Failed to delete "+status);
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

function editB(id, status)
{
    $('#status').val(status);
    $('#hiddenIDStatus').val(id);
    $('#dialog-status').modal('show');
    return false;
}


$(document).ready(function() {
    var $validator = $("#form_status").validate({
        rules: {
            status: { required: true }
        },
        errorPlacement: function (error, element) {
            return false; //Suppress all messages
        },
        highlight: function (element) {
            $(element).closest('.control-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.control-group').removeClass('has-error').addClass('has-success');
        }
    });

    $("#simpan_status").click(function() {
        var $valid = $("#form_status").valid();
        if(!$valid) {
            $validator.focusInvalid();
            return false;
  		} else {
            var form_data = {
                id: $('#hiddenIDStatus').val(),
    			status: $('#status').val(),
    			ajax:1
            };
            $.ajax({
                url : "<?php echo base_url(); ?>setting/create_process_status",
                type : 'POST',
    			data : form_data,
    			success: function(msg){
                    if (msg == 1)
                    {
                        $('#alert-error').hide();
                        if ($('#hiddenIDStatus').val() == "")
                            $("#status-success").html("Data "+$('#status').val()+" successfully added");
                        else
                            $("#status-success").html("Data "+$('#status').val()+" successfully changed");

                        $('#alert-success').show();
                        $('#hiddenIDStatus').val("");
                        $('#status').val("");
                        $('#dialog-status').modal('hide');
                        Document.search(10);
                        this.loadData();
                        this.loadPage();
                    }
                    else
                    {
                        $('#alert-success').hide();
                        if ($('#hiddenIDStatus').val() == "")
                            $("#status-error").html("Failed to add data "+$('#status').val());
                        else
                            $("#status-error").html("Failed to change data "+$('#status').val());

                        $('#alert-error').show();
                        $('#dialog-status').modal('hide');
                    }
                }
            });
 		}
        return false;
   });
});<?php

?>