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
  url: '<?php echo base_url()."setting/marital_status";?>',
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
          t += '<tr><td>' + dt.code + '</td>' +
             '<td>' + dt.name + '</td>' +
             '<td>' + dt.english + '</td>' +
             '<td>' + dt.order + '</td>';
          <?
            if ($this->auth->_allowed('Dashboard.Reference.Marital.Change') || $this->auth->_allowed('Dashboard.Reference.Marital.Delete'))
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

function deleteM(id, status)
{
    var form_data = {
        id: id,
        ajax:1
   	}
    $.ajax({
        url : "<?php echo base_url(); ?>setting/delete_marital",
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

function editM(id, status, english, urutan)
{
    $('#kode').val(id);
    $('#status').val(status);
    $('#english').val(english);
    $('#urutan').val(urutan);
    $('#hiddenIDStatus').val(id);
    $('#dialog-status').modal('show');
    $('#kode').attr("readonly","readonly");
    return false;
}


$(document).ready(function() {
    $("#urutan").keydown(function(event) {
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

    var $validator = $("#form_status").validate({
        rules: {
            kode: { required: true },
            status: { required: true },
            english: { required: true },
            urutan: { required: true, number: true }
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

    $("#simpan_status").click(function() {
        var $valid = $("#form_status").valid();
        if(!$valid) {
            $validator.focusInvalid();
            return false;
  		} else {
            if ($('#hiddenIDStatus').val() != "")
                var ids = $('#hiddenIDStatus').val();
            else
                var ids = $('#kode').val();
            var form_data = {
                id: ids,
    			status: $('#status').val(),
    			english: $('#english').val(),
    			order: $('#urutan').val(),
    			ajax:1
            };
            $.ajax({
                url : "<?php echo base_url(); ?>setting/create_marital",
                type : 'POST',
    			data : form_data,
    			success: function(msg){
                    if (msg == 1)
                    {
                        $('#alert-error').hide();
                        if ($('#hiddenIDStatus').val() == "")
                            $("#status-success").html("Data "+$('#english').val()+" successfully added");
                        else
                            $("#status-success").html("Data "+$('#english').val()+" successfully changed");

                        $('#alert-success').show();
                        $('#hiddenIDStatus').val("");
                        $('#status').val("");
                        $('#english').val("");
                        $('#urutan').val("");
                        $('#dialog-status').modal('hide');
                        Document.search(10);
                        this.loadData();
                        this.loadPage();
                    }
                    else
                    {
                        $('#alert-success').hide();
                        if ($('#hiddenIDStatus').val() == "")
                            $("#status-error").html("Failed to add data "+$('#english').val());
                        else
                            $("#status-error").html("Failed to change data "+$('#english').val());

                        $('#alert-error').show();
                        $('#dialog-status').modal('hide');
                    }
                }
            });
 		}

        $('#kode').val("");
        $('#kode').removeAttr("readonly","readonly");
        return false;
   });
});<?php

?>