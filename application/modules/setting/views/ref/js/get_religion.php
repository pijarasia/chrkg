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
  url: '<?php echo base_url()."setting/religion";?>',
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
             '<td>' + dt.name + '</td>';
          <?
            if ($this->auth->_allowed('Dashboard.Reference.Religion.Change') || $this->auth->_allowed('Dashboard.Reference.Religion.Delete'))
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

function deleteA(id, religion)
{
    var form_data = {
        id: id,
        ajax:1
   	}
    $.ajax({
        url : "<?php echo base_url(); ?>setting/delete_religion",
        type : 'POST',
        data : form_data,
        success: function(msg){
            if (msg == 1)
            {
                $("#religion-success").html("Data "+religion+" has been delete");
                $("#alert-success").show();
                $("#alert-error").hide();
            } else {
                $("#religion-error").html("Failed to delete "+religion);
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

function editA(id, religion)
{
    $('#kode').val(id);
    $('#agama').val(religion);
    $('#hiddenIDAgama').val(id);
    $('#dialog-religion').modal('show');
    $('#kode').attr("readonly","readonly");
    return false;
}


$(document).ready(function() {
    var $validator = $("#form_agama").validate({
        rules: {
            kode: { required: true },
            agama: { required: true }
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

    $("#simpan_agama").click(function() {
        var $valid = $("#form_agama").valid();
        if(!$valid) {
            $validator.focusInvalid();
            return false;
  		} else {
            if ($('#hiddenIDAgama').val() != "")
                var ids = $('#hiddenIDAgama').val();
            else
                var ids = $('#kode').val();
            var form_data = {
                id: ids,
    			agama: $('#agama').val(),
    			ajax:1
            };
            $.ajax({
                url : "<?php echo base_url(); ?>setting/create_religion",
                type : 'POST',
    			data : form_data,
    			success: function(msg){
                    if (msg == 1)
                    {
                        $('#alert-error').hide();
                        if ($('#hiddenIDAgama').val() == "")
                            $("#religion-success").html("Data "+$('#agama').val()+" successfully added");
                        else
                            $("#religion-success").html("Data "+$('#agama').val()+" successfully changed");

                        $('#alert-success').show();
                        $('#hiddenIDAgama').val("");
                        $('#agama').val("");
                        $('#dialog-religion').modal('hide');
                        Document.search(10);
                        this.loadData();
                        this.loadPage();
                    }
                    else
                    {
                        $('#alert-success').hide();
                        if ($('#hiddenIDAgama').val() == "")
                            $("#religion-error").html("Failed to add data "+$('#agama').val());
                        else
                            $("#religion-error").html("Failed to change data "+$('#agama').val());

                        $('#alert-error').show();
                        $('#dialog-religion').modal('hide');
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