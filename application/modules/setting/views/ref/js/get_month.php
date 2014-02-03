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
  url: '<?php echo base_url()."setting/month";?>',
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
          t += '<tr><td>' + dt.month+ '</td>' +
             '<td>' + dt.english + '</td>';
          <?
            if ($this->auth->_allowed('Dashboard.Reference.Month.Change') || $this->auth->_allowed('Dashboard.Reference.Month.Delete'))
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

function deleteM(id, bulan)
{
    var form_data = {
        id: id,
        ajax:1
   	}
    $.ajax({
        url : "<?php echo base_url(); ?>setting/delete_month",
        type : 'POST',
        data : form_data,
        success: function(msg){
            if (msg == 1)
            {
                $("#bulan-success").html("Data "+bulan+" has been delete");
                $("#alert-success").show();
                $("#alert-error").hide();
            } else {
                $("#bulan-error").html("Failed to delete "+bulan);
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

function editM(id, bulan, english)
{
    $('#bulan').val(bulan);
    $('#english').val(english);
    $('#hiddenIDBulan').val(id);
    $('#dialog-bulan').modal('show');
    return false;
}


$(document).ready(function() {
    var $validator = $("#form_bulan").validate({
        rules: {
            id: { required: true },
            bulan: { required: true },
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

    $("#simpan_bulan").click(function() {
        var $valid = $("#form_bulan").valid();
        if(!$valid) {
            $validator.focusInvalid();
            return false;
  		} else {
            var form_data = {
                id: $('#hiddenIDBulan').val(),
    			bulan: $('#bulan').val(),
    			english: $('#english').val(),
    			ajax:1
            };
            $.ajax({
                url : "<?php echo base_url(); ?>setting/create_month",
                type : 'POST',
    			data : form_data,
    			success: function(msg){
    			    if (msg == 1)
                    {
                        $('#alert-error').hide();
                        if ($('#hiddenIDBulan').val() == "")
                            $("#bulan-success").html("Data "+$('#english').val()+" successfully added");
                        else
                            $("#bulan-success").html("Data "+$('#english').val()+" successfully changed");

                        $('#alert-success').show();
                        $('#hiddenIDBulan').val("");
                        $('#bulan').val("");
                        $('#english').val("");
                        $('#dialog-bulan').modal('hide');
                        Document.search(10);
                        this.loadData();
                        this.loadPage();
                    }
                    else
                    {
                        $('#alert-success').hide();
                        if ($('#hiddenIDBulan').val() == "")
                            $("#bulan-error").html("Failed to add data "+$('#english').val());
                        else
                            $("#bulan-error").html("Failed to change data "+$('#english').val());

                        $('#alert-error').show();
                        $('#dialog-bulan').modal('hide');
                    }
                }
            });
 		}
        return false;
   });
});<?php

?>