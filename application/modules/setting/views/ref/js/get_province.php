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
  url: '<?php echo base_url()."setting/province";?>',
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
            if ($this->auth->_allowed('Dashboard.Reference.Province.Change') || $this->auth->_allowed('Dashboard.Reference.Province.Delete'))
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

function deleteB(id, province)
{
    var form_data = {
        id: id,
        ajax:1
   	}
    $.ajax({
        url : "<?php echo base_url(); ?>setting/delete_province",
        type : 'POST',
        data : form_data,
        success: function(msg){
            if (msg == 1)
            {
                $("#province-success").html("Data "+province+" has been delete");
                $("#alert-success").show();
                $("#alert-error").hide();
            } else {
                $("#province-error").html("Failed to delete "+province);
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

function editB(id, province)
{
    $('#provinsi').val(province);
    $('#hiddenIDProvinsi').val(id);
    $('#dialog-province').modal('show');
    return false;
}


$(document).ready(function() {
    var $validator = $("#form_provinsi").validate({
        rules: {
            provinsi: { required: true }
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

    $("#simpan_provinsi").click(function() {
        var $valid = $("#form_provinsi").valid();
        if(!$valid) {
            $validator.focusInvalid();
            return false;
  		} else {
            var form_data = {
                id: $('#hiddenIDProvinsi').val(),
    			provinsi: $('#provinsi').val(),
    			ajax:1
            };
            $.ajax({
                url : "<?php echo base_url(); ?>setting/create_province",
                type : 'POST',
    			data : form_data,
    			success: function(msg){
                    if (msg == 1)
                    {
                        $('#alert-error').hide();
                        if ($('#hiddenIDProvinsi').val() == "")
                            $("#province-success").html("Data "+$('#provinsi').val()+" successfully added");
                        else
                            $("#province-success").html("Data "+$('#provinsi').val()+" successfully changed");

                        $('#alert-success').show();
                        $('#hiddenIDProvinsi').val("");
                        $('#provinsi').val("");
                        $('#dialog-province').modal('hide');
                        Document.search(10);
                        this.loadData();
                        this.loadPage();
                    }
                    else
                    {
                        $('#alert-success').hide();
                        if ($('#hiddenIDProvinsi').val() == "")
                            $("#province-error").html("Failed to add data "+$('#provinsi').val());
                        else
                            $("#province-error").html("Failed to change data "+$('#provinsi').val());

                        $('#alert-error').show();
                        $('#dialog-province').modal('hide');
                    }
                }
            });
 		}
        return false;
   });
});<?php

?>