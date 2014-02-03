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
  url: '<?php echo base_url()."setting/language_literacy";?>',
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

function deleteL(id, english)
{
    var form_data = {
        id: id,
        ajax:1
   	}
    $.ajax({
        url : "<?php echo base_url(); ?>setting/delete_language",
        type : 'POST',
        data : form_data,
        success: function(msg){
            if (msg == 1)
            {
                $("#language-success").html("Data "+english+" has been delete");
                $("#alert-success").show();
                $("#alert-error").hide();
            } else {
                $("#language-error").html("Failed to delete "+english);
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

function editL(id, kemampuan, english)
{
    $('#kode').val(id);
    $('#kemampuan').val(kemampuan);
    $('#english').val(english);
    $('#hiddenIDBahasa').val(id);
    $('#dialog-language').modal('show');
    $('#kode').attr("readonly","readonly");
    return false;
}


$(document).ready(function() {
    var $validator = $("#form_bahasa").validate({
        rules: {
            kode: { required: true },
            kemampuan: { required: true },
            english: { required: true }
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

    $("#simpan_bahasa").click(function() {
        var $valid = $("#form_bahasa").valid();
        if(!$valid) {
            $validator.focusInvalid();
            return false;
  		} else {
            if ($('#hiddenIDBahasa').val() != "")
                var ids = $('#hiddenIDBahasa').val();
            else
                var ids = $('#kode').val();
            var form_data = {
                id: ids,
    			kemampuan: $('#kemampuan').val(),
    			english: $('#english').val(),
    			ajax:1
            };
            $.ajax({
                url : "<?php echo base_url(); ?>setting/create_language",
                type : 'POST',
    			data : form_data,
    			success: function(msg){
                    if (msg == 1)
                    {
                        $('#alert-error').hide();
                        if ($('#hiddenIDBahasa').val() == "")
                            $("#language-success").html("Data "+$('#english').val()+" successfully added");
                        else
                            $("#language-success").html("Data "+$('#english').val()+" successfully changed");

                        $('#alert-success').show();
                        $('#hiddenIDBahasa').val("");
                        $('#kemampuan').val("");
                        $('#english').val("");
                        $('#dialog-language').modal('hide');
                        Document.search(10);
                        this.loadData();
                        this.loadPage();
                    }
                    else
                    {
                        $('#alert-success').hide();
                        if ($('#hiddenIDBahasa').val() == "")
                            $("#language-error").html("Failed to add data "+$('#english').val());
                        else
                            $("#language-error").html("Failed to change data "+$('#english').val());

                        $('#alert-error').show();
                        $('#dialog-language').modal('hide');
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