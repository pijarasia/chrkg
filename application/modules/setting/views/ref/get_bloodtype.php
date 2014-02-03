<?php

?>
var Document = {
  param: {
    dataperpage: 5, // jumlah data per halaman
    query: '',
    curpage: 0,
    numpage: 0,
    skey: '',
    stype: '',
    npage: 0
  },
  url: '<?php echo base_url()."setting/blood_type";?>',
  search: function(n) {
    var $form = $("#sform");
    this.param.query = $form.serializeFormJSON() || '';
    this.param.dataperpage = n || 5;
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
          maxVisible: 5,
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
          maxVisible: 5,
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
            if ($this->auth->_allowed('Dashboard.Reference.Blood.Change') || $this->auth->_allowed('Dashboard.Reference.Blood.Delete'))
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
          maxVisible: 5,
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

function deleteB(blood)
{
    var form_data = {
        id: blood,
        ajax:1
   	}
    $.ajax({
        url : "<?php echo base_url(); ?>setting/delete_blood",
        type : 'POST',
        data : form_data,
        success: function(msg){
            if (msg == 1)
            {
                $("#blood-success").html("Data "+blood+" has been delete");
                $("#alert-success").show();
                $("#alert-error").hide();
            } else {
                $("#blood-error").html("Failed to delete "+blood);
                $("#alert-error").show();
                $("#alert-success").hide();
            }
            Document.search(5);
            this.loadData();
            this.loadPage();
   	    }
    });
    return false;
}

function editB(blood)
{
    $('#gol_darah').val(blood);
    $('#hiddenIDGolDarah').val(blood);
    $('#dialog-goldarah').modal('show');
    return false;
}


$(document).ready(function() {
    var $validator = $("#form_goldarah").validate({
        rules: {
            gol_darah: { required: true }
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

    $("#simpan_darah").click(function() {
        var $valid = $("#form_goldarah").valid();
        if(!$valid) {
            $validator.focusInvalid();
            return false;
  		} else {
            var form_data = {
                id: $('#hiddenIDGolDarah').val(),
    			gol_darah: $('#gol_darah').val(),
    			ajax:1
            };
            $.ajax({
                url : "<?php echo base_url(); ?>setting/create_blood",
                type : 'POST',
    			data : form_data,
    			success: function(msg){
                    if (msg == 1)
                    {
                        $('#alert-error').hide();
                        if ($('#hiddenIDGolDarah').val() == "")
                            $("#blood-success").html("Data "+$('#gol_darah').val()+" successfully added");
                        else
                            $("#blood-success").html("Data "+$('#gol_darah').val()+" successfully changed");

                        $('#alert-success').show();
                        $('#hiddenIDGolDarah').val("");
                        $('#gol_darah').val("");
                        $('#dialog-goldarah').modal('hide');
                        Document.search(5);
                        this.loadData();
                        this.loadPage();
                    }
                    else
                    {
                        $('#alert-success').hide();
                        if ($('#hiddenIDGolDarah').val() == "")
                            $("#blood-error").html("Failed to add data "+$('#gol_darah').val());
                        else
                            $("#blood-error").html("Failed to change data "+$('#gol_darah').val());

                        $('#alert-error').show();
                        $('#dialog-goldarah').modal('hide');
                    }
                }
            });
 		}
        return false;
   });
});